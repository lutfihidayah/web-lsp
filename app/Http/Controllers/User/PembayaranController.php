<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Peserta;
use App\Models\Skema;
use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{
    public function __construct()
    {
        // Setup Midtrans configuration
        \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        \Midtrans\Config::$clientKey    = config('midtrans.client_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized  = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds        = config('midtrans.is_3ds');
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

        return view('user.pembayaran', compact('pendaftarans'));
    }

    /**
     * Buat order pembayaran dan ambil Snap Token dari Midtrans
     */
    public function checkout($skemaId)
    {
        // Cek apakah package Midtrans sudah terinstall
        if (!class_exists('\Midtrans\Config')) {
            return redirect()->route('user.skema.show', $skemaId)
                ->with('error', 'Package Midtrans belum terinstall. Jalankan: composer require midtrans/midtrans-php');
        }

        // Cek apakah Midtrans key sudah dikonfigurasi
        if (empty(config('midtrans.server_key')) || str_contains(config('midtrans.server_key'), 'GANTI')) {
            return redirect()->route('user.skema.show', $skemaId)
                ->with('error', 'Midtrans Server Key belum dikonfigurasi. Isi MIDTRANS_SERVER_KEY di file .env');
        }

        $skema = Skema::findOrFail($skemaId);
        $user  = auth()->user();


        // Cek apakah user sudah punya pendaftaran PAID untuk skema ini
        $existing = Pendaftaran::where('user_id', $user->id)
            ->where('skema_id', $skema->id)
            ->where('status', 'paid')
            ->first();

        if ($existing) {
            return redirect()->route('user.pembayaran.invoice', $existing->id)
                ->with('info', 'Anda sudah mendaftar dan membayar skema ini.');
        }

        // Cek apakah ada pendaftaran pending
        $pendingOrder = Pendaftaran::where('user_id', $user->id)
            ->where('skema_id', $skema->id)
            ->where('status', 'pending')
            ->first();

        if ($pendingOrder) {
            // Refresh snap token jika sudah ada pending
            try {
                $snapToken = $this->createSnapToken($pendingOrder, $user, $skema);
                $pendingOrder->update(['snap_token' => $snapToken]);
                return view('user.checkout', compact('skema', 'pendingOrder', 'snapToken'));
            } catch (\Exception $e) {
                Log::error('Midtrans Snap Error: ' . $e->getMessage());
            }
        }

        // Buat order baru
        DB::beginTransaction();
        try {
            $orderId = Pendaftaran::generateOrderId($user->id);

            $pendaftaran = Pendaftaran::create([
                'user_id'  => $user->id,
                'skema_id' => $skema->id,
                'order_id' => $orderId,
                'amount'   => $skema->harga ?? 1500000,
                'status'   => 'pending',
            ]);

            $snapToken = $this->createSnapToken($pendaftaran, $user, $skema);
            $pendaftaran->update(['snap_token' => $snapToken]);

            DB::commit();

            return view('user.checkout', [
                'skema'        => $skema,
                'pendingOrder' => $pendaftaran,
                'snapToken'    => $snapToken,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error: ' . $e->getMessage());
            return redirect()->route('user.skema.show', $skemaId)
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

        return view('user.pembayaran-sukses', compact('pendaftaran'));
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

        return view('user.invoice', compact('pendaftaran'));
    }

    /**
     * Handle callback dari Midtrans (redirect setelah payment)
     */
    public function callback(Request $request)
    {
        $orderId           = $request->order_id;
        $transactionStatus = $request->transaction_status;

        $pendaftaran = Pendaftaran::where('order_id', $orderId)
            ->where('user_id', auth()->id())
            ->first();

        if (!$pendaftaran) {
            return redirect()->route('user.skema')->with('error', 'Transaksi tidak ditemukan.');
        }

        // Verifikasi status ke Midtrans API
        try {
            $status = \Midtrans\Transaction::status($orderId);
            $transactionStatus = $status->transaction_status ?? $transactionStatus;
            $paymentType       = $status->payment_type ?? null;
        } catch (\Exception $e) {
            Log::warning('Midtrans status check failed: ' . $e->getMessage());
            $paymentType = $request->payment_type;
        }

        // Handle berdasarkan status
        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            $this->handlePaymentSuccess($pendaftaran, ['payment_type' => $paymentType]);
            return redirect()->route('user.pembayaran.sukses', $pendaftaran->id)
                ->with('success', 'Pembayaran berhasil! Anda telah terdaftar dalam jadwal asesmen.');
        }

        if (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $pendaftaran->update(['status' => $transactionStatus === 'expire' ? 'expired' : 'failed']);
            return redirect()->route('user.skema.show', $pendaftaran->skema_id)
                ->with('error', 'Pembayaran ' . $transactionStatus . '. Silakan coba lagi.');
        }

        // Pending atau status lain → ke halaman sukses (akan update via webhook)
        return redirect()->route('user.pembayaran.sukses', $pendaftaran->id);
    }

    /**
     * SIMULASI pembayaran sukses (hanya untuk mode development/sandbox)
     * Tanpa perlu bayar sungguhan
     */
    public function simulateSuccess($pendaftaranId)
    {
        // Hanya boleh dijalankan di mode non-production
        if (config('midtrans.is_production')) {
            abort(403, 'Simulasi tidak tersedia di mode production.');
        }

        $pendaftaran = Pendaftaran::where('id', $pendaftaranId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $this->handlePaymentSuccess($pendaftaran, ['payment_type' => 'simulation']);

        return redirect()->route('user.pembayaran.sukses', $pendaftaran->id)
            ->with('success', '✅ Simulasi pembayaran berhasil! Anda telah terdaftar.');
    }

    /**
     * Proses setelah pembayaran berhasil: update status, buat peserta, assign jadwal
     */
    public static function handlePaymentSuccess(Pendaftaran $pendaftaran, array $data = []): void
    {
        if ($pendaftaran->status === 'paid') return; // Idempotent check

        DB::transaction(function () use ($pendaftaran, $data) {
            // 1. Update status pendaftaran
            $pendaftaran->update([
                'status'       => 'paid',
                'payment_type' => $data['payment_type'] ?? null,
                'paid_at'      => now(),
            ]);

            // 2. Auto-assign jadwal asesmen terdekat yang masih ada kuota
            // Ambil semua jadwal kandidat, lalu filter kuota di PHP (SQLite-compatible)
            $jadwal = Jadwal::where('skema_id', $pendaftaran->skema_id)
                ->where('status', 'Terjadwal')
                ->where('tanggal', '>=', now()->toDateString())
                ->orderBy('tanggal', 'asc')
                ->get()
                ->filter(function ($j) {
                    // Hitung peserta yang sudah bayar dan terdaftar di jadwal ini
                    $terdaftar = Pendaftaran::where('jadwal_id', $j->id)
                        ->where('status', 'paid')
                        ->count();
                    return $terdaftar < $j->kuota;
                })
                ->first();

            if ($jadwal) {
                $pendaftaran->update(['jadwal_id' => $jadwal->id]);
            }

            // 3. Buat record peserta jika belum ada
            $user = $pendaftaran->user;
            $existingPeserta = Peserta::where('email', $user->email)
                ->where('skema_id', $pendaftaran->skema_id)
                ->first();

            if (!$existingPeserta) {
                Peserta::create([
                    'nama'       => $user->name,
                    'email'      => $user->email,
                    'no_telepon' => $user->no_telepon ?? '-',
                    'alamat'     => '-',
                    'skema_id'   => $pendaftaran->skema_id,
                    'status'     => 'Dalam Proses',
                ]);
            }

            // 4. Auto-create Asesmen + Absensi sesuai durasi skema
            $skema = $pendaftaran->skema;
            // Parse durasi: "2-3 Hari" → ambil angka pertama, "5 Hari" → 5
            preg_match('/(\d+)/', $skema->durasi ?? '1', $matches);
            $jumlahPertemuan = (int) ($matches[1] ?? 1);
            if ($jumlahPertemuan < 1) $jumlahPertemuan = 1;

            $asesmen = \App\Models\Asesmen::create([
                'pendaftaran_id' => $pendaftaran->id,
                'status' => 'berlangsung',
            ]);

            // Buat absensi sesuai durasi (per hari)
            $startDate = $jadwal ? \Carbon\Carbon::parse($jadwal->tanggal) : now()->addDays(7);
            for ($i = 1; $i <= $jumlahPertemuan; $i++) {
                \App\Models\Absensi::create([
                    'asesmen_id' => $asesmen->id,
                    'pertemuan_ke' => $i,
                    'tanggal' => $startDate->copy()->addDays($i - 1),
                    'status' => 'belum',
                ]);
            }
        });
    }

    /**
     * Buat Snap Token ke Midtrans
     */
    private function createSnapToken(Pendaftaran $pendaftaran, $user, Skema $skema): string
    {
        $params = [
            'transaction_details' => [
                'order_id'     => $pendaftaran->order_id,
                'gross_amount' => (int) $pendaftaran->amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email'      => $user->email,
                'phone'      => $user->no_telepon ?? '',
            ],
            'item_details' => [
                [
                    'id'       => 'SKEMA-' . $skema->id,
                    'price'    => (int) $pendaftaran->amount,
                    'quantity' => 1,
                    'name'     => 'Sertifikasi: ' . $skema->nama,
                ],
            ],
            'callbacks' => [
                'finish' => route('user.pembayaran.callback'),
            ],
        ];

        return \Midtrans\Snap::getSnapToken($params);
    }
}
