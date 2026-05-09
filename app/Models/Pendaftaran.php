<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';

    protected $fillable = [
        'user_id',
        'skema_id',
        'jadwal_id',
        'order_id',
        'snap_token',
        'amount',
        'status',
        'payment_type',
        'paid_at',
        'midtrans_response',
    ];

    protected $casts = [
        'paid_at'           => 'datetime',
        'midtrans_response' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skema()
    {
        return $this->belongsTo(Skema::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function asesmen()
    {
        return $this->hasOne(Asesmen::class);
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public static function generateOrderId(int $userId): string
    {
        return 'LSP-' . time() . '-' . $userId;
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'paid'    => 'Lunas',
            'pending' => 'Menunggu Pembayaran',
            'failed'  => 'Gagal',
            'expired' => 'Kadaluarsa',
            default   => 'Unknown',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'paid'    => 'bg-green-100 text-green-700',
            'pending' => 'bg-yellow-100 text-yellow-700',
            'failed'  => 'bg-red-100 text-red-700',
            'expired' => 'bg-gray-100 text-gray-600',
            default   => 'bg-gray-100 text-gray-600',
        };
    }
}
