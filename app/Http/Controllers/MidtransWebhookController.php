<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Http\Controllers\User\PembayaranController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $serverKey   = config('midtrans.server_key');
        $hashed      = hash('sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        // Verifikasi signature key
        if ($hashed !== $request->signature_key) {
            Log::warning('Midtrans webhook: invalid signature for order ' . $request->order_id);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $pendaftaran = Pendaftaran::where('order_id', $request->order_id)
            ->with(['user', 'skema'])
            ->first();

        if (!$pendaftaran) {
            Log::warning('Midtrans webhook: order not found ' . $request->order_id);
            return response()->json(['message' => 'Order not found'], 404);
        }

        $transactionStatus = $request->transaction_status;
        $fraudStatus       = $request->fraud_status ?? 'accept';

        Log::info("Midtrans webhook: order={$request->order_id}, status={$transactionStatus}, fraud={$fraudStatus}");

        // Simpan raw response Midtrans
        $pendaftaran->update([
            'midtrans_response' => $request->all(),
        ]);

        if ($transactionStatus === 'capture') {
            if ($fraudStatus === 'accept') {
                PembayaranController::handlePaymentSuccess($pendaftaran, [
                    'payment_type' => $request->payment_type,
                ]);
            } else {
                $pendaftaran->update(['status' => 'failed']);
            }
        } elseif ($transactionStatus === 'settlement') {
            PembayaranController::handlePaymentSuccess($pendaftaran, [
                'payment_type' => $request->payment_type,
            ]);
        } elseif (in_array($transactionStatus, ['cancel', 'deny'])) {
            $pendaftaran->update(['status' => 'failed']);
        } elseif ($transactionStatus === 'expire') {
            $pendaftaran->update(['status' => 'expired']);
        } elseif ($transactionStatus === 'pending') {
            // Tetap pending, tidak ada aksi
        }

        return response()->json(['message' => 'OK']);
    }
}
