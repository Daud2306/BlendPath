<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanQuiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'pertanyaan',
        'pilihan_jawaban',
        'jawaban_benar',
        'poin'
    ];

    protected $casts = [
        'pilihan_jawaban' => 'array',
        'jawaban_benar' => 'integer',
        'poin' => 'integer'
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
