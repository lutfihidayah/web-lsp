<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'peserta';
    protected $fillable = ['nama', 'email', 'no_telepon', 'alamat', 'skema_id', 'status'];

    public function skema()
    {
        return $this->belongsTo(Skema::class);
    }

    public function hasil()
    {
        return $this->hasMany(Hasil::class);
    }
}