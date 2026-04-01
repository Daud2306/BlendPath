<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quiz_id',
        'pertanyaan',
        'gambar_soal',
        'pilihan_jawaban',
        'jawaban_benar',
        'poin',
        'urutan',
    ];

    protected $casts = [
        // pilihan_jawaban disimpan sebagai JSON: {'A':'...','B':'...','C':'...','D':'...'}
        'pilihan_jawaban' => 'array',
        'poin'            => 'integer',
        'urutan'          => 'integer',
    ];

    // -------------------------------------------------------------------------
    // Relasi
    // -------------------------------------------------------------------------

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function attemptAnswers()
    {
        return $this->hasMany(AttemptAnswer::class);
    }

    // -------------------------------------------------------------------------
    // Helper
    // -------------------------------------------------------------------------

    /** Cek apakah jawaban yang diberikan benar (case-insensitive) */
    public function isCorrect(string $jawaban): bool
    {
        return strtoupper(trim($jawaban)) === strtoupper(trim($this->jawaban_benar));
    }

    /** Teks pilihan untuk key tertentu, misal 'A' */
    public function getPilihan(string $key): ?string
    {
        return $this->pilihan_jawaban[strtoupper($key)] ?? null;
    }

    /** Apakah soal ini punya gambar */
    public function hasGambar(): bool
    {
        return !empty($this->gambar_soal);
    }
}
