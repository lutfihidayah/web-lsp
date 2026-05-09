<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asesmen extends Model
{
    protected $table = 'asesmen';
    protected $fillable = ['pendaftaran_id', 'status', 'nilai_quiz', 'no_sertifikat', 'sertifikat_dibuat_at'];

    protected $casts = [
        'sertifikat_dibuat_at' => 'datetime',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class)->orderBy('pertemuan_ke');
    }

    public function quizJawaban()
    {
        return $this->hasMany(QuizJawaban::class);
    }

    public function getAbsensiSelesaiAttribute()
    {
        return $this->absensi()->where('status', 'hadir')->count();
    }

    public function getAbsensiLengkapAttribute()
    {
        $total = $this->absensi()->count();
        return $total > 0 && $this->absensi_selesai >= $total;
    }
}
