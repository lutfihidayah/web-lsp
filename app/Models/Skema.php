<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skema extends Model
{
    protected $table = 'skema';
    protected $fillable = ['nama', 'kategori', 'durasi', 'unit_kompetensi', 'status', 'deskripsi', 'harga'];

    public function getFormattedHargaAttribute(): string
    {
        return 'Rp ' . number_format($this->harga ?? 0, 0, ',', '.');
    }

    public function peserta()
    {
        return $this->hasMany(Peserta::class);
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}