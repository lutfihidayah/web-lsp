<?php

namespace App\Services;

use App\Models\Pendaftaran;
use App\Models\Peserta;
use App\Models\Skema;
use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public function __construct()
    {
        // Setup Midtrans configuration from config files
        \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        \Midtrans\Config::$clientKey    = config('midtrans.client_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized  = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds        = config('midtrans.is_3ds');
    }

    /**
     * Get or create order and retrieve Snap Token from Midtrans.
     *
     * @param Skema $skema
     * @param \App\Models\User $user
     * @return array
     * @throws \Exception
     */
    public function checkout(Skema $skema, $user): array
    {
        if (!class_exists('\Midtrans\Config')) {
            throw new \Exception('Package Midtrans belum terinstall. Jalankan: composer require midtrans/midtrans-php');
        }

        if (empty(config('midtrans.server_key')) || str_contains(config('midtrans.server_key'), 'GANTI')) {
            throw new \Exception('Midtrans Server Key belum dikonfigurasi. Isi MIDTRANS_SERVER_KEY di file .env');
        }

        // Check if there is an existing paid registration
        $existing = Pendaftaran::where('user_id', $user->id)
            ->where('skema_id', $skema->id)
            ->where('status', 'paid')
            ->first();

        if ($existing) {
            return [
                'type' => 'existing_paid',
                'pendaftaran' => $existing,
            ];
        }

        // Check for an existing pending registration
        $pendingOrder = Pendaftaran::where('user_id', $user->id)
            ->where('skema_id', $skema->id)
            ->where('status', 'pending')
            ->first();

        if ($pendingOrder) {
            $snapToken = $this->createSnapToken($pendingOrder, $user, $skema);
            $pendingOrder->update(['snap_token' => $snapToken]);
            return [
                'type' => 'checkout',
                'pendingOrder' => $pendingOrder,
                'snapToken' => $snapToken,
            ];
        }

        // Create new registration and get snap token under db transaction
        return DB::transaction(function () use ($skema, $user) {
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

            return [
                'type' => 'checkout',
                'pendingOrder' => $pendaftaran,
                'snapToken' => $snapToken,
            ];
        });
    }

    /**
     * Verify payment status using Midtrans API and process accordingly.
     *
     * @param Pendaftaran $pendaftaran
     * @return array
     * @throws \Exception
     */
    public function verifyAndProcessCallback(Pendaftaran $pendaftaran): array
    {
        try {
            $status            = \Midtrans\Transaction::status($pendaftaran->order_id);
            $transactionStatus = $status->transaction_status;
            $paymentType       = $status->payment_type ?? null;
        } catch (\Exception $e) {
            // Log & rethrow to prevent fallback to client parameters
            Log::error('Midtrans status check failed for Order ' . $pendaftaran->order_id . ': ' . $e->getMessage());
            throw $e;
        }

        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            $this->handlePaymentSuccess($pendaftaran, ['payment_type' => $paymentType]);
            return [
                'status'  => 'success',
                'message' => 'Pembayaran berhasil! Anda telah terdaftar dalam jadwal asesmen.',
            ];
        }

        if (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $pendaftaran->update(['status' => $transactionStatus === 'expire' ? 'expired' : 'failed']);
            return [
                'status'  => 'failed',
                'message' => 'Pembayaran ' . $transactionStatus . '. Silakan coba lagi.',
            ];
        }

        return [
            'status'  => 'other',
            'message' => 'Status transaksi: ' . $transactionStatus,
        ];
    }

    /**
     * Process logic after successful payment: allocate schedule, register participant, create assessment & schedule meetings.
     *
     * @param Pendaftaran $pendaftaran
     * @param array $data
     */
    public function handlePaymentSuccess(Pendaftaran $pendaftaran, array $data = []): void
    {
        if ($pendaftaran->status === 'paid') {
            return;
        }

        DB::transaction(function () use ($pendaftaran, $data) {
            $pendaftaran->update([
                'status'       => 'paid',
                'payment_type' => $data['payment_type'] ?? null,
                'paid_at'      => now(),
            ]);

            // Allocate available schedule
            $jadwal = Jadwal::where('skema_id', $pendaftaran->skema_id)
                ->where('status', 'Terjadwal')
                ->where('tanggal', '>=', now()->toDateString())
                ->withCount(['pendaftaran as peserta_terdaftar_count' => function ($q) {
                    $q->where('status', 'paid');
                }])
                ->orderBy('tanggal', 'asc')
                ->get()
                ->filter(function ($j) {
                    return $j->peserta_terdaftar_count < $j->kuota;
                })
                ->first();

            if ($jadwal) {
                $pendaftaran->update(['jadwal_id' => $jadwal->id]);
            }

            // Create profile in Peserta table if it does not exist
            $user            = $pendaftaran->user;
            $existingPeserta = Peserta::where('user_id', $user->id)
                ->where('skema_id', $pendaftaran->skema_id)
                ->first();

            if (!$existingPeserta) {
                Peserta::create([
                    'user_id'  => $user->id,
                    'alamat'   => '-',
                    'skema_id' => $pendaftaran->skema_id,
                    'status'   => 'Dalam Proses',
                ]);
            }

            // Parse schedule meeting quantity from scheme duration
            $skema = $pendaftaran->skema;
            preg_match('/(\d+)/', $skema->durasi ?? '1', $matches);
            $jumlahPertemuan = (int) ($matches[1] ?? 1);
            if ($jumlahPertemuan < 1) {
                $jumlahPertemuan = 1;
            }

            $asesmen = \App\Models\Asesmen::create([
                'pendaftaran_id' => $pendaftaran->id,
                'status'         => 'berlangsung',
            ]);

            $startDate = $jadwal ? Carbon::parse($jadwal->tanggal) : now()->addDays(7);
            for ($i = 1; $i <= $jumlahPertemuan; $i++) {
                \App\Models\Absensi::create([
                    'asesmen_id'   => $asesmen->id,
                    'pertemuan_ke' => $i,
                    'tanggal'      => $startDate->copy()->addDays($i - 1),
                    'status'       => 'belum',
                ]);
            }
        });
    }

    /**
     * Request snap token from Midtrans snap API.
     *
     * @param Pendaftaran $pendaftaran
     * @param \App\Models\User $user
     * @param Skema $skema
     * @return string
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
                'finish' => route('pembayaran.callback'),
            ],
        ];

        return \Midtrans\Snap::getSnapToken($params);
    }
}
