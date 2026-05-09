<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizJawaban extends Model
{
    protected $table = 'quiz_jawaban';
    protected $fillable = ['asesmen_id', 'soal_id', 'jawaban_user', 'is_benar'];

    public function asesmen()
    {
        return $this->belongsTo(Asesmen::class);
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }
}
