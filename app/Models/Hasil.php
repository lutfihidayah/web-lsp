<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    protected $table = 'hasil';
    protected $fillable = ['peserta_id', 'jadwal_id', 'asesor', 'nilai', 'hasil', 'no_sertifikat'];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }
}