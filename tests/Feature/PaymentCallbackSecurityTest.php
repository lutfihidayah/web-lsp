<?php

namespace Tests\Feature;

use App\Models\Pendaftaran;
use App\Models\Skema;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Menguji keamanan callback pembayaran Midtrans.
 *
 * Test-test ini memastikan:
 * 1. Penyerang tidak bisa memalsukan status pembayaran lewat query parameter
 *    saat API Midtrans sedang tidak tersedia.
 * 2. Webhook menolak request dengan signature tidak valid.
 * 3. Webhook menolak request jika server key tidak dikonfigurasi.
 */
class PaymentCallbackSecurityTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Skema $skema;
    private Pendaftaran $pendaftaran;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'user', 'status' => 'aktif']);

        $this->skema = Skema::create([
            'nama'            => 'Skema Security Test',
            'kategori'        => 'IT',
            'durasi'          => '1 Hari',
            'unit_kompetensi' => 3,
            'status'          => 'Aktif',
            'harga'           => 500000,
        ]);

        $this->pendaftaran = Pendaftaran::create([
            'user_id'  => $this->user->id,
            'skema_id' => $this->skema->id,
            'order_id' => 'LSP-SEC-TEST-001',
            'amount'   => 500000,
            'status'   => 'pending',
        ]);
    }

    /**
     * Callback dengan transaction_status=settlement di URL harus TIDAK langsung
     * diproses. Sistem harus terlebih dahulu memverifikasi ke Midtrans API.
     *
     * Jika Midtrans API tidak bisa dijangkau (exception), pendaftaran harus
     * tetap 'pending' — BUKAN berubah menjadi 'paid'.
     */
    public function test_callback_tidak_bisa_bypass_dengan_query_parameter_palsu(): void
    {
        // Simulasikan bahwa Midtrans\Transaction::status() melempar exception
        // dengan cara menggunakan server key yang tidak valid (tidak ada API key asli di testing)
        // Dalam kondisi ini, sistem HARUS menolak request dan tidak mengubah status

        $response = $this->actingAs($this->user)
            ->get(route('pembayaran.callback', [
                'order_id'           => $this->pendaftaran->order_id,
                'transaction_status' => 'settlement', // Parameter palsu dari penyerang
                'status_code'        => '200',
                'gross_amount'       => '500000.00',
            ]));

        // Pendaftaran harus tetap 'pending' karena API Midtrans gagal dan fallback diblokir
        $this->pendaftaran->refresh();
        $this->assertEquals('pending', $this->pendaftaran->status,
            'Status pendaftaran berubah menjadi paid padahal API Midtrans tidak bisa diverifikasi!');

        // Respon harus redirect (bukan success) karena proses dihentikan
        $response->assertRedirect();
    }

    /**
     * Webhook dengan signature tidak valid harus ditolak dengan HTTP 403.
     */
    public function test_webhook_menolak_signature_tidak_valid(): void
    {
        $response = $this->postJson(route('midtrans.webhook'), [
            'order_id'          => $this->pendaftaran->order_id,
            'status_code'       => '200',
            'gross_amount'      => '500000.00',
            'transaction_status'=> 'settlement',
            'signature_key'     => 'tanda_tangan_palsu_tidak_valid',
        ]);

        $response->assertStatus(403);

        // Pendaftaran tetap pending
        $this->pendaftaran->refresh();
        $this->assertEquals('pending', $this->pendaftaran->status);
    }

    /**
     * Webhook dengan server key kosong (tidak dikonfigurasi) harus ditolak.
     */
    public function test_webhook_ditolak_jika_server_key_tidak_dikonfigurasi(): void
    {
        // Override konfigurasi: kosongkan server key
        config(['midtrans.server_key' => '']);

        $response = $this->postJson(route('midtrans.webhook'), [
            'order_id'           => $this->pendaftaran->order_id,
            'status_code'        => '200',
            'gross_amount'       => '500000.00',
            'transaction_status' => 'settlement',
            'signature_key'      => '', // Penyerang mengosongkan signature juga
        ]);

        // Harus ditolak dengan status 500 (konfigurasi error)
        $response->assertStatus(500);

        // Pendaftaran tetap pending
        $this->pendaftaran->refresh();
        $this->assertEquals('pending', $this->pendaftaran->status);
    }

    /**
     * Webhook yang valid dengan signature benar harus diterima dan status diperbarui.
     */
    public function test_webhook_valid_mengubah_status_pendaftaran(): void
    {
        $serverKey   = 'test-server-key-for-unit-test';
        $orderId     = $this->pendaftaran->order_id;
        $statusCode  = '200';
        $grossAmount = '500000.00';

        // Set konfigurasi server key
        config(['midtrans.server_key' => $serverKey]);

        // Hitung signature yang valid
        $validSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        $response = $this->postJson(route('midtrans.webhook'), [
            'order_id'           => $orderId,
            'status_code'        => $statusCode,
            'gross_amount'       => $grossAmount,
            'transaction_status' => 'settlement',
            'payment_type'       => 'bank_transfer',
            'fraud_status'       => 'accept',
            'signature_key'      => $validSignature,
        ]);

        $response->assertStatus(200)->assertJson(['message' => 'OK']);

        // Status pendaftaran harus berubah menjadi 'paid'
        $this->pendaftaran->refresh();
        $this->assertEquals('paid', $this->pendaftaran->status);
    }
}
