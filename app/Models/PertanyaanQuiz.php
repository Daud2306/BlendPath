<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PertanyaanQuiz extends Model
{
    protected $fillable = ['quiz_id', 'pertanyaan', 'jawaban_benar', 'poin'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function responquizzes()
    {
        return $this->hasMany(ResponQuiz::class, 'pertanyaan_id');
    }
}
