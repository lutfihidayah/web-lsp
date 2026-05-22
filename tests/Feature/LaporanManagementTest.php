<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Skema;
use App\Models\Pendaftaran;
use App\Models\Asesmen;
use App\Models\Jadwal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanManagementTest extends TestCase
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
     * Admin can view reports page.
     */
    public function test_admin_can_view_laporan_index(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('laporan.index'));

        $response->assertStatus(200);
        $response->assertViewIs('laporan.index');
    }

    /**
     * User cannot view reports page.
     */
    public function test_user_cannot_view_laporan_index(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('laporan.index'));

        $response->assertStatus(403);
    }

    /**
     * Admin can filter reports by type and see relevant data structure.
     */
    public function test_admin_can_filter_laporan_by_various_types(): void
    {
        // 1. Peserta Report
        $response = $this->actingAs($this->admin)
            ->get(route('laporan.index', ['type' => 'peserta']));
        $response->assertStatus(200);
        $response->assertSee('Nama Lengkap');

        // 2. Pembayaran Report
        $response = $this->actingAs($this->admin)
            ->get(route('laporan.index', ['type' => 'pembayaran']));
        $response->assertStatus(200);
        $response->assertSee('Tipe Pembayaran');

        // 3. Hasil Report
        $response = $this->actingAs($this->admin)
            ->get(route('laporan.index', ['type' => 'hasil']));
        $response->assertStatus(200);
        $response->assertSee('Nilai Quiz');

        // 4. Jadwal Report
        $response = $this->actingAs($this->admin)
            ->get(route('laporan.index', ['type' => 'jadwal']));
        $response->assertStatus(200);
        $response->assertSee('Kuota Peserta');
    }
}
