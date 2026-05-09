<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';
    protected $fillable = ['asesmen_id', 'pertemuan_ke', 'tanggal', 'status', 'dikonfirmasi_oleh'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function asesmen()
    {
        return $this->belongsTo(Asesmen::class);
    }
}
