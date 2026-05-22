<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Peserta;
use App\Models\Skema;
use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Services\PaymentService;

class PembayaranController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Daftar riwayat pembayaran user
     */
    public function index()
    {
        $pendaftarans = Pendaftaran::where('user_id', auth()->id())
            ->with(['skema', 'jadwal.skema'])
            ->latest()
            ->get();

        return view('pembayaran.index', compact('pendaftarans'));
    }

    /**
     * Buat order pembayaran dan ambil Snap Token dari Midtrans
     */
    public function checkout($skemaId)
    {
        if (!class_exists('\Midtrans\Config')) {
            return redirect()->route('skema.show', $skemaId)
                ->with('error', 'Package Midtrans belum terinstall. Jalankan: composer require midtrans/midtrans-php');
        }

        if (empty(config('midtrans.server_key')) || str_contains(config('midtrans.server_key'), 'GANTI')) {
            return redirect()->route('skema.show', $skemaId)
                ->with('error', 'Midtrans Server Key belum dikonfigurasi. Isi MIDTRANS_SERVER_KEY di file .env');
        }

        $skema = Skema::findOrFail($skemaId);
        $user  = auth()->user();

        try {
            $result = $this->paymentService->checkout($skema, $user);

            if ($result['type'] === 'existing_paid') {
                return redirect()->route('pembayaran.invoice', $result['pendaftaran']->id)
                    ->with('info', 'Anda sudah mendaftar dan membayar skema ini.');
            }

            $pendingOrder = $result['pendingOrder'];
            $snapToken    = $result['snapToken'];

            return view('pembayaran.checkout', compact('skema', 'pendingOrder', 'snapToken'));
        } catch (\Exception $e) {
            Log::error('Checkout Error: ' . $e->getMessage());
            return redirect()->route('skema.show', $skemaId)
                ->with('error', 'Gagal membuat transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Halaman sukses setelah pembayaran berhasil
     */
    public function sukses($pendaftaranId)
    {
        $pendaftaran = Pendaftaran::where('id', $pendaftaranId)
            ->where('user_id', auth()->id())
            ->with(['skema', 'jadwal'])
            ->firstOrFail();

        return view('pembayaran.sukses', compact('pendaftaran'));
    }

    /**
     * Halaman invoice pembayaran
     */
    public function invoice($pendaftaranId)
    {
        $pendaftaran = Pendaftaran::where('id', $pendaftaranId)
            ->where('user_id', auth()->id())
            ->with(['skema', 'jadwal', 'user'])
            ->firstOrFail();

        return view('pembayaran.invoice', compact('pendaftaran'));
    }

    /**
     * Handle callback dari Midtrans (redirect setelah payment)
     */
    public function callback(Request $request)
    {
        $orderId = $request->order_id;

        $pendaftaran = Pendaftaran::where('order_id', $orderId)
            ->where('user_id', auth()->id())
            ->first();

        if (!$pendaftaran) {
            return redirect()->route('skema.index')->with('error', 'Transaksi tidak ditemukan.');
        }

        try {
            $result = $this->paymentService->verifyAndProcessCallback($pendaftaran);

            if ($result['status'] === 'success') {
                return redirect()->route('pembayaran.sukses', $pendaftaran->id)
                    ->with('success', $result['message']);
            }

            if ($result['status'] === 'failed') {
                return redirect()->route('skema.show', $pendaftaran->skema_id)
                    ->with('error', $result['message']);
            }

            return redirect()->route('pembayaran.sukses', $pendaftaran->id);
        } catch (\Exception $e) {
            return redirect()->route('skema.show', $pendaftaran->skema_id)
                ->with('error', 'Gagal memverifikasi status pembayaran dengan Midtrans. Silakan tunggu beberapa saat atau hubungi admin jika pembayaran sudah berhasil.');
        }
    }

    /**
     * SIMULASI pembayaran sukses (hanya untuk mode development/sandbox)
     */
    public function simulateSuccess($pendaftaranId)
    {
        if (config('midtrans.is_production')) {
            abort(403, 'Simulasi tidak tersedia di mode production.');
        }

        $pendaftaran = Pendaftaran::where('id', $pendaftaranId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $this->paymentService->handlePaymentSuccess($pendaftaran, ['payment_type' => 'simulation']);

        return redirect()->route('pembayaran.sukses', $pendaftaran->id)
            ->with('success', '✅ Simulasi pembayaran berhasil! Anda telah terdaftar.');
    }

    /**
     * Proses setelah pembayaran berhasil (Static Proxy backward compatibility)
     */
    public static function handlePaymentSuccess(Pendaftaran $pendaftaran, array $data = []): void
    {
        (new PaymentService())->handlePaymentSuccess($pendaftaran, $data);
    }
}
