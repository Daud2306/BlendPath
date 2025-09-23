<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quizzes';
    protected $fillable = ['tutorial_id', 'judul_quiz', 'urutan','passing_score'];

    public function tutorial()
    {
        return $this->belongsTo(Tutorial::class);
    }
}
