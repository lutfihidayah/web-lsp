<?php

namespace Tests\Feature;

use App\Models\Asesmen;
use App\Models\Absensi;
use App\Models\Pendaftaran;
use App\Models\Skema;
use App\Models\Soal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Menguji alur quiz asesmen:
 * - Kalkulasi skor benar
 * - Status lulus/tidak_lulus diperbarui dengan benar
 * - Sertifikat dibuat otomatis jika lulus
 * - Double submit dicegah
 * - Peserta tidak bisa quiz sebelum absensi dikonfirmasi admin
 */
class QuizEvaluationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Skema $skema;
    private Pendaftaran $pendaftaran;
    private Asesmen $asesmen;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'user', 'status' => 'aktif']);

        $this->skema = Skema::create([
            'nama'            => 'Skema Test',
            'kategori'        => 'IT',
            'durasi'          => '1 Hari',
            'unit_kompetensi' => 5,
            'status'          => 'Aktif',
            'harga'           => 500000,
        ]);

        $this->pendaftaran = Pendaftaran::create([
            'user_id'  => $this->user->id,
            'skema_id' => $this->skema->id,
            'order_id' => 'LSP-TEST-001',
            'amount'   => 500000,
            'status'   => 'paid',
        ]);

        $this->asesmen = Asesmen::create([
            'pendaftaran_id' => $this->pendaftaran->id,
            'status'         => 'berlangsung',
        ]);

        // Buat 1 pertemuan absensi & konfirmasi admin
        $absensi = Absensi::create([
            'asesmen_id'        => $this->asesmen->id,
            'pertemuan_ke'      => 1,
            'tanggal'           => now()->subDay(),
            'status'            => 'hadir',
            'dikonfirmasi_oleh' => 'admin',
        ]);
    }

    private function buatSoal(int $jumlah = 10): array
    {
        $soals   = [];
        $jawaban = [];

        for ($i = 1; $i <= $jumlah; $i++) {
            $soal = Soal::create([
                'skema_id'      => $this->skema->id,
                'pertanyaan'    => 'Pertanyaan nomor ' . $i . '?',
                'pilihan_a'     => 'Opsi A yang benar',
                'pilihan_b'     => 'Opsi B yang salah',
                'pilihan_c'     => 'Opsi C yang salah',
                'pilihan_d'     => 'Opsi D yang salah',
                'jawaban_benar' => 'a',
            ]);
            $soals[]            = $soal;
            $jawaban[$soal->id] = 'a'; // semua benar
        }

        return [$soals, $jawaban];
    }

    /**
     * Submit quiz dengan semua jawaban benar → status lulus.
     */
    public function test_submit_quiz_semua_benar_menghasilkan_status_lulus(): void
    {
        [, $jawaban] = $this->buatSoal(10);

        $this->actingAs($this->user)
             ->post(route('asesmen.quiz.submit', $this->asesmen->id), [
                 'jawaban' => $jawaban,
             ]);

        $this->asesmen->refresh();

        $this->assertEquals('lulus', $this->asesmen->status);
        $this->assertEquals(100, $this->asesmen->nilai_quiz);
        $this->assertNotNull($this->asesmen->no_sertifikat);
        $this->assertNotNull($this->asesmen->sertifikat_dibuat_at);
    }

    /**
     * Submit quiz dengan semua jawaban salah → status tidak_lulus.
     */
    public function test_submit_quiz_semua_salah_menghasilkan_tidak_lulus(): void
    {
        [$soals] = $this->buatSoal(10);

        // Kirim jawaban salah semua
        $jawaban = collect($soals)->mapWithKeys(fn($s) => [$s->id => 'b'])->toArray();

        $this->actingAs($this->user)
             ->post(route('asesmen.quiz.submit', $this->asesmen->id), [
                 'jawaban' => $jawaban,
             ]);

        $this->asesmen->refresh();

        $this->assertEquals('tidak_lulus', $this->asesmen->status);
        $this->assertEquals(0, $this->asesmen->nilai_quiz);
        $this->assertNull($this->asesmen->no_sertifikat);
    }

    /**
     * Skor pas passing grade (60%) → status lulus.
     */
    public function test_skor_tepat_passing_grade_60_persen_menghasilkan_lulus(): void
    {
        [$soals] = $this->buatSoal(10);

        // 6 jawaban benar dari 10
        $jawaban = [];
        foreach ($soals as $i => $soal) {
            $jawaban[$soal->id] = ($i < 6) ? 'a' : 'b'; // 6 benar (a), 4 salah (b)
        }

        $this->actingAs($this->user)
             ->post(route('asesmen.quiz.submit', $this->asesmen->id), [
                 'jawaban' => $jawaban,
             ]);

        $this->asesmen->refresh();

        $this->assertEquals('lulus', $this->asesmen->status);
        $this->assertEquals(60.0, $this->asesmen->nilai_quiz);
    }

    /**
     * Skor di bawah dynamic passing grade (misal passing grade 80%, skor 70%) -> tidak lulus.
     */
    public function test_submit_quiz_dibawah_dynamic_passing_grade_menghasilkan_tidak_lulus(): void
    {
        $this->skema->update(['passing_grade' => 80]);

        [$soals] = $this->buatSoal(10);

        // 7 benar, 3 salah (Skor 70% < KKM 80%)
        $jawaban = [];
        foreach ($soals as $i => $soal) {
            $jawaban[$soal->id] = ($i < 7) ? 'a' : 'b';
        }

        $this->actingAs($this->user)
             ->post(route('asesmen.quiz.submit', $this->asesmen->id), [
                 'jawaban' => $jawaban,
             ]);

        $this->asesmen->refresh();

        $this->assertEquals('tidak_lulus', $this->asesmen->status);
        $this->assertEquals(70.0, $this->asesmen->nilai_quiz);
    }

    /**
     * Skor pas dynamic passing grade (misal passing grade 80%, skor 80%) -> lulus.
     */
    public function test_submit_quiz_pas_dynamic_passing_grade_menghasilkan_lulus(): void
    {
        $this->skema->update(['passing_grade' => 80]);

        [$soals] = $this->buatSoal(10);

        // 8 benar, 2 salah (Skor 80% == KKM 80%)
        $jawaban = [];
        foreach ($soals as $i => $soal) {
            $jawaban[$soal->id] = ($i < 8) ? 'a' : 'b';
        }

        $this->actingAs($this->user)
             ->post(route('asesmen.quiz.submit', $this->asesmen->id), [
                 'jawaban' => $jawaban,
             ]);

        $this->asesmen->refresh();

        $this->assertEquals('lulus', $this->asesmen->status);
        $this->assertEquals(80.0, $this->asesmen->nilai_quiz);
    }

    /**
     * Double submit dicegah — tidak bisa submit quiz yang sudah dikerjakan.
     */
    public function test_peserta_tidak_bisa_submit_quiz_dua_kali(): void
    {
        [, $jawaban] = $this->buatSoal(10);

        // Submit pertama
        $this->actingAs($this->user)
             ->post(route('asesmen.quiz.submit', $this->asesmen->id), [
                 'jawaban' => $jawaban,
             ]);

        // Submit kedua harus diarahkan dengan error
        $response = $this->actingAs($this->user)
             ->post(route('asesmen.quiz.submit', $this->asesmen->id), [
                 'jawaban' => $jawaban,
             ]);

        $response->assertRedirect(route('asesmen.show', $this->asesmen->id));
        $response->assertSessionHas('error');
    }

    /**
     * Format nomor sertifikat harus mengikuti pola LSP-YYYYMM-XXXX.
     */
    public function test_format_nomor_sertifikat_mengikuti_standar_lsp(): void
    {
        [, $jawaban] = $this->buatSoal(10);

        $this->actingAs($this->user)
             ->post(route('asesmen.quiz.submit', $this->asesmen->id), [
                 'jawaban' => $jawaban,
             ]);

        $this->asesmen->refresh();

        // Format: LSP-YYYYMM-XXXX
        $this->assertMatchesRegularExpression(
            '/^LSP-\d{6}-\d{4}$/',
            $this->asesmen->no_sertifikat
        );
    }
}
