<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizAttempt extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'total_poin',
        'total_soal',
        'jumlah_benar',
        'persentase',
        'lulus',
        'completed_at',
    ];

    protected $casts = [
        'total_poin'   => 'integer',
        'total_soal'   => 'integer',
        'jumlah_benar' => 'integer',
        'persentase'   => 'decimal:2',
        'lulus'        => 'boolean',
        'completed_at'   => 'datetime',
    ];

    // -------------------------------------------------------------------------
    // Relasi
    // -------------------------------------------------------------------------

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(AttemptAnswer::class);
    }

    // -------------------------------------------------------------------------
    // Helper
    // -------------------------------------------------------------------------

    /** Ambil jawaban user untuk question tertentu */
    public function getAnswerFor(int $questionId): ?AttemptAnswer
    {
        return $this->answers->firstWhere('question_id', $questionId);
    }

    /** Label persentase yang rapi */
    public function persentaseLabel(): string
    {
        return number_format($this->persentase, 1) . '%';
    }
}
