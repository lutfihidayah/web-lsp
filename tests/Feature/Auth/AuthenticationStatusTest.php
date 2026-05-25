<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Menguji bahwa user dengan status 'nonaktif' tidak bisa login ke sistem
 * meskipun password mereka benar.
 *
 * Ini memvalidasi perbaikan yang diterapkan pada LoginRequest.php
 * dan CheckRole middleware.
 */
class AuthenticationStatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     * User aktif bisa login normal.
     */
    public function test_user_aktif_dapat_login(): void
    {
        $user = User::factory()->create([
            'role'   => 'user',
            'status' => 'aktif',
        ]);

        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * User nonaktif tidak bisa login meskipun password benar.
     */
    public function test_user_nonaktif_tidak_dapat_login(): void
    {
        $user = User::factory()->create([
            'role'   => 'user',
            'status' => 'nonaktif',
        ]);

        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        // Harus ada error validasi pada field email
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Admin nonaktif juga tidak bisa login.
     */
    public function test_admin_nonaktif_tidak_dapat_login(): void
    {
        $admin = User::factory()->create([
            'role'   => 'admin',
            'status' => 'nonaktif',
        ]);

        $response = $this->post('/login', [
            'email'    => $admin->email,
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Pesan error mengandung informasi tentang akun dinonaktifkan.
     */
    public function test_pesan_error_login_informatif_untuk_akun_nonaktif(): void
    {
        $user = User::factory()->create([
            'role'   => 'user',
            'status' => 'nonaktif',
        ]);

        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');

        // Verifikasi pesan error mengandung kata yang menginformasikan akun nonaktif
        $errors  = session('errors');
        $message = $errors ? strtolower($errors->first('email')) : '';
        $this->assertTrue(
            str_contains($message, 'nonaktif') ||
            str_contains($message, 'dinonaktifkan') ||
            str_contains($message, 'administrator'),
            "Pesan error tidak informatif tentang akun nonaktif. Pesan: {$message}"
        );
    }

    /**
     * User yang sudah login kemudian dinonaktifkan admin harus di-logout
     * oleh middleware CheckRole saat mengakses rute berikutnya.
     */
    public function test_user_yang_dinonaktifkan_saat_login_aktif_diarahkan_ke_login(): void
    {
        $user = User::factory()->create([
            'role'   => 'user',
            'status' => 'aktif',
        ]);

        // Login dulu
        $this->actingAs($user);

        // Kemudian admin menonaktifkan user ini
        $user->update(['status' => 'nonaktif']);

        // Akses rute yang dilindungi middleware role
        $response = $this->get(route('pembayaran.index'));

        // Harus diarahkan ke login
        $response->assertRedirect(route('login'));
    }
}
