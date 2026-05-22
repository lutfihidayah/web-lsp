<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Skema;
use App\Models\Soal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SoalManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $user;
    private Skema $skema;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
        $this->user = User::factory()->create(['role' => 'user', 'status' => 'aktif']);

        $this->skema = Skema::create([
            'nama'            => 'Skema IT Support',
            'kategori'        => 'IT',
            'durasi'          => '3 Hari',
            'unit_kompetensi' => 10,
            'status'          => 'Aktif',
            'harga'           => 1200000,
            'passing_grade'   => 70,
        ]);
    }

    /**
     * Admin can view the soal list.
     */
    public function test_admin_can_view_soal_index(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('soal.index'));

        $response->assertStatus(200);
        $response->assertViewIs('soal.index');
    }

    /**
     * User cannot view the soal list.
     */
    public function test_user_cannot_view_soal_index(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('soal.index'));

        $response->assertStatus(403);
    }

    /**
     * Admin can create a new question.
     */
    public function test_admin_can_create_soal(): void
    {
        $soalData = [
            'skema_id'      => $this->skema->id,
            'pertanyaan'    => 'Apa singkatan dari IP Address?',
            'pilihan_a'     => 'Internet Protocol',
            'pilihan_b'     => 'Intranet Protocol',
            'pilihan_c'     => 'Internet Page',
            'pilihan_d'     => 'Instant Protocol',
            'jawaban_benar' => 'a',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('soal.store'), $soalData);

        $response->assertRedirect(route('soal.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('soal', [
            'pertanyaan' => 'Apa singkatan dari IP Address?',
            'jawaban_benar' => 'a',
        ]);
    }

    /**
     * Admin cannot create a question with invalid validation.
     */
    public function test_admin_cannot_create_soal_with_invalid_data(): void
    {
        $invalidData = [
            'skema_id'      => $this->skema->id,
            'pertanyaan'    => '',
            'pilihan_a'     => 'Opsi A',
            'pilihan_b'     => 'Opsi B',
            'pilihan_c'     => 'Opsi C',
            'pilihan_d'     => 'Opsi D',
            'jawaban_benar' => 'z', // Invalid correct answer option
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('soal.store'), $invalidData);

        $response->assertSessionHasErrors(['pertanyaan', 'jawaban_benar']);
    }

    /**
     * Admin can edit and update a question.
     */
    public function test_admin_can_update_soal(): void
    {
        $soal = Soal::create([
            'skema_id'      => $this->skema->id,
            'pertanyaan'    => 'Pertanyaan Lama?',
            'pilihan_a'     => 'A',
            'pilihan_b'     => 'B',
            'pilihan_c'     => 'C',
            'pilihan_d'     => 'D',
            'jawaban_benar' => 'b',
        ]);

        $updatedData = [
            'skema_id'      => $this->skema->id,
            'pertanyaan'    => 'Pertanyaan Baru?',
            'pilihan_a'     => 'A Baru',
            'pilihan_b'     => 'B Baru',
            'pilihan_c'     => 'C Baru',
            'pilihan_d'     => 'D Baru',
            'jawaban_benar' => 'c',
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('soal.update', $soal->id), $updatedData);

        $response->assertRedirect(route('soal.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('soal', [
            'id'            => $soal->id,
            'pertanyaan'    => 'Pertanyaan Baru?',
            'jawaban_benar' => 'c',
        ]);
    }

    /**
     * Admin can delete a question.
     */
    public function test_admin_can_delete_soal(): void
    {
        $soal = Soal::create([
            'skema_id'      => $this->skema->id,
            'pertanyaan'    => 'Pertanyaan untuk dihapus',
            'pilihan_a'     => 'A',
            'pilihan_b'     => 'B',
            'pilihan_c'     => 'C',
            'pilihan_d'     => 'D',
            'jawaban_benar' => 'a',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('soal.destroy', $soal->id));

        $response->assertRedirect(route('soal.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('soal', [
            'id' => $soal->id,
        ]);
    }
}
