<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'quizzes';

    protected $fillable = [
        'submodul_id',   // ← diubah dari modul_id
        'judul_quiz',
        'deskripsi',
        'passing_score',
    ];

    protected $casts = [
        'passing_score' => 'integer',
    ];

    // -------------------------------------------------------------------------
    // Relasi
    // -------------------------------------------------------------------------

    public function submodul()
    {
        return $this->belongsTo(Submodul::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('urutan');
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    // -------------------------------------------------------------------------
    // Helper
    // -------------------------------------------------------------------------

    public function latestAttemptByUser(int $userId): ?QuizAttempt
    {
        return $this->attempts()
            ->where('user_id', $userId)
            ->latest()
            ->first();
    }

    public function isPassedByUser(int $userId = null): bool
    {
        $userId = $userId ?? Auth::id();
        if (!$userId) return false;

        return $this->attempts()
            ->where('user_id', $userId)
            ->where('lulus', true)
            ->exists();
    }

    public function totalPoinMaksimum(): int
    {
        return $this->questions()->sum('poin');
    }
}
