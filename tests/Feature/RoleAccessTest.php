<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Menguji RBAC (Role-Based Access Control) — setiap role hanya boleh
 * mengakses URL yang sesuai dengan haknya.
 */
class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(string $role, string $status = 'aktif'): User
    {
        return User::factory()->create(['role' => $role, 'status' => $status]);
    }

    // =======================================================================
    // TAMU (belum login) harus diarahkan ke halaman login
    // =======================================================================

    public function test_tamu_diarahkan_ke_login_saat_akses_dashboard(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_tamu_diarahkan_ke_login_saat_akses_skema_crud(): void
    {
        $this->get(route('skema.create'))->assertRedirect(route('login'));
        $this->get(route('skema.index'))->assertRedirect(route('login'));
    }

    public function test_tamu_diarahkan_ke_login_saat_akses_soal_atau_laporan(): void
    {
        $this->get(route('soal.index'))->assertRedirect(route('login'));
        $this->get(route('laporan.index'))->assertRedirect(route('login'));
    }

    // =======================================================================
    // USER biasa tidak boleh akses halaman admin
    // =======================================================================

    public function test_user_biasa_tidak_bisa_akses_manajemen_user(): void
    {
        $this->actingAs($this->createUser('user'))
             ->get(route('users.index'))
             ->assertStatus(403);
    }

    public function test_user_biasa_tidak_bisa_akses_skema_create(): void
    {
        $this->actingAs($this->createUser('user'))
             ->get(route('skema.create'))
             ->assertStatus(403);
    }

    public function test_user_biasa_tidak_bisa_akses_peserta_index(): void
    {
        $this->actingAs($this->createUser('user'))
             ->get(route('peserta.index'))
             ->assertStatus(403);
    }

    public function test_user_biasa_tidak_bisa_akses_soal_atau_laporan(): void
    {
        $this->actingAs($this->createUser('user'))
             ->get(route('soal.index'))
             ->assertStatus(403);

        $this->actingAs($this->createUser('user'))
             ->get(route('laporan.index'))
             ->assertStatus(403);
    }

    // =======================================================================
    // ADMIN bisa akses halaman CRUD-nya
    // =======================================================================

    public function test_admin_bisa_akses_skema_create(): void
    {
        $this->actingAs($this->createUser('admin'))
             ->get(route('skema.create'))
             ->assertStatus(200);
    }

    public function test_admin_bisa_akses_peserta_index(): void
    {
        $this->actingAs($this->createUser('admin'))
             ->get(route('peserta.index'))
             ->assertStatus(200);
    }

    public function test_admin_bisa_akses_soal_dan_laporan(): void
    {
        $this->actingAs($this->createUser('admin'))
             ->get(route('soal.index'))
             ->assertStatus(200);

        $this->actingAs($this->createUser('admin'))
             ->get(route('laporan.index'))
             ->assertStatus(200);
    }

    public function test_admin_bisa_akses_dashboard(): void
    {
        $this->actingAs($this->createUser('admin'))
             ->get(route('dashboard'))
             ->assertStatus(200);
    }

    public function test_admin_tidak_bisa_akses_manajemen_user_superadmin_only(): void
    {
        // User management sekarang hanya untuk superadmin
        $this->actingAs($this->createUser('admin'))
             ->get(route('users.index'))
             ->assertStatus(403);
    }

    // =======================================================================
    // SUPERADMIN bisa akses semua
    // =======================================================================

    public function test_superadmin_bisa_akses_manajemen_user(): void
    {
        $this->actingAs($this->createUser('superadmin'))
             ->get(route('users.index'))
             ->assertStatus(200);
    }

    public function test_superadmin_bisa_akses_skema_create(): void
    {
        $this->actingAs($this->createUser('superadmin'))
             ->get(route('skema.create'))
             ->assertStatus(200);
    }

    // =======================================================================
    // ASESOR hanya bisa konfirmasi kehadiran, tidak bisa CRUD skema
    // =======================================================================

    public function test_asesor_tidak_bisa_akses_skema_create(): void
    {
        $this->actingAs($this->createUser('asesor'))
             ->get(route('skema.create'))
             ->assertStatus(403);
    }

    public function test_asesor_tidak_bisa_akses_manajemen_user(): void
    {
        $this->actingAs($this->createUser('asesor'))
             ->get(route('users.index'))
             ->assertStatus(403);
    }

    public function test_asesor_bisa_akses_dashboard(): void
    {
        $this->actingAs($this->createUser('asesor'))
             ->get(route('dashboard'))
             ->assertStatus(200);
    }

    // =======================================================================
    // User nonaktif diarahkan ke login meskipun mencoba akses
    // =======================================================================

    public function test_user_nonaktif_tidak_bisa_akses_dashboard(): void
    {
        $this->actingAs($this->createUser('user', 'nonaktif'))
             ->get(route('pembayaran.index'))
             ->assertRedirect(route('login'));
    }

    // =======================================================================
    // Sidebar visibility checks for each role
    // =======================================================================

    public function test_sidebar_links_visibility_for_user(): void
    {
        $response = $this->actingAs($this->createUser('user'))
             ->get(route('dashboard'));

        $response->assertStatus(200);
        // Candidate features
        $response->assertSee(route('pembayaran.index'));
        $response->assertSee(route('setting.index'));
        // Administrative/Staff features should not be visible
        $response->assertDontSee(route('peserta.index'));
        $response->assertDontSee(route('informasi.index'));
        $response->assertDontSee(route('users.index'));
        $response->assertDontSee(route('soal.index'));
        $response->assertDontSee(route('laporan.index'));
    }

    public function test_sidebar_links_visibility_for_asesor(): void
    {
        $response = $this->actingAs($this->createUser('asesor'))
             ->get(route('dashboard'));

        $response->assertStatus(200);
        // Staff features (shared)
        $response->assertSee(route('skema.index'));
        $response->assertSee(route('jadwal.index'));
        $response->assertSee(route('hasil.index'));
        $response->assertSee(route('asesmen.index'));
        // Excluded from asesor
        $response->assertDontSee(route('peserta.index'));
        $response->assertDontSee(route('informasi.index'));
        $response->assertDontSee(route('users.index'));
        $response->assertDontSee(route('soal.index'));
        $response->assertDontSee(route('laporan.index'));
        // Excluded candidate features
        $response->assertDontSee(route('pembayaran.index'));
        $response->assertDontSee(route('setting.index'));
    }

    public function test_sidebar_links_visibility_for_admin(): void
    {
        $response = $this->actingAs($this->createUser('admin'))
             ->get(route('dashboard'));

        $response->assertStatus(200);
        // Staff features (shared)
        $response->assertSee(route('skema.index'));
        $response->assertSee(route('jadwal.index'));
        $response->assertSee(route('hasil.index'));
        $response->assertSee(route('asesmen.index'));
        // Admin-only (shared with superadmin)
        $response->assertSee(route('peserta.index'));
        $response->assertSee(route('informasi.index'));
        $response->assertSee(route('soal.index'));
        $response->assertSee(route('laporan.index'));
        // Excluded from admin (superadmin-only)
        $response->assertDontSee(route('users.index'));
        // Excluded candidate features
        $response->assertDontSee(route('pembayaran.index'));
        $response->assertDontSee(route('setting.index'));
    }

    public function test_sidebar_links_visibility_for_superadmin(): void
    {
        $response = $this->actingAs($this->createUser('superadmin'))
             ->get(route('dashboard'));

        $response->assertStatus(200);
        // Staff features (shared)
        $response->assertSee(route('skema.index'));
        $response->assertSee(route('jadwal.index'));
        $response->assertSee(route('hasil.index'));
        $response->assertSee(route('asesmen.index'));
        // Admin-only (shared with superadmin)
        $response->assertSee(route('peserta.index'));
        $response->assertSee(route('informasi.index'));
        $response->assertSee(route('soal.index'));
        $response->assertSee(route('laporan.index'));
        // Superadmin-only
        $response->assertSee(route('users.index'));
        // Excluded candidate features
        $response->assertDontSee(route('pembayaran.index'));
        $response->assertDontSee(route('setting.index'));
    }
}
