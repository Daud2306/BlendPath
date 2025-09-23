<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponQuiz extends Model
{
    protected $fillable = ['user_id', 'quiz_id', 'pertanyaan_id', 'jawaban_user', 'is_correct', 'poin'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pertanyaanquiz()
    {
        return $this->belongsTo(Quiz::class, 'pertanyaanquiz_id');
    }
}
