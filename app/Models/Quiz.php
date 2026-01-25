<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quizzes';
    protected $fillable = ['submodul_id', 'judul_quiz', 'urutan', 'passing_score'];

    public function submodul()
    {
        return $this->belongsTo(Submodul::class);
    }

    public function pertanyaan()
    {
        return $this->hasMany(PertanyaanQuiz::class);
    }

    public function responQuizzes()
    {
        return $this->hasMany(ResponQuiz::class);
    }
}
