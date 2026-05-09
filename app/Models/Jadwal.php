<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $fillable = ['skema_id', 'tanggal', 'waktu', 'lokasi', 'asesor', 'kuota', 'status'];

    public function skema()
    {
        return $this->belongsTo(Skema::class);
    }

    public function hasil()
    {
        return $this->hasMany(Hasil::class);
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function peserta_terdaftar()
    {
        return $this->hasMany(Pendaftaran::class)->where('status', 'paid');
    }
}