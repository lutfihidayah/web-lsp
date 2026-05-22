<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'peserta';
    protected $fillable = ['user_id', 'alamat', 'skema_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skema()
    {
        return $this->belongsTo(Skema::class);
    }

    public function hasil()
    {
        return $this->hasMany(Hasil::class);
    }

    // Accessors to delegate fields to related User model
    public function getNamaAttribute()
    {
        return $this->user ? $this->user->name : null;
    }

    public function getEmailAttribute()
    {
        return $this->user ? $this->user->email : null;
    }

    public function getNoTeleponAttribute()
    {
        return $this->user ? $this->user->no_telepon : null;
    }
}