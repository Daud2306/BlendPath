<?php

namespace App\Services;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\AttemptAnswer;
use App\Models\Progress;
use Illuminate\Support\Facades\DB;

class QuizService
{
    /**
     * Proses jawaban user, hitung skor, simpan attempt + detail jawaban.
     */
    public function submitAttempt(Quiz $quiz, array $jawaban, int $userId): QuizAttempt
    {
        $questions = $quiz->questions()->get();

        $totalPoin   = 0;
        $jumlahBenar = 0;
        $totalSoal   = $questions->count();
        $answerData  = [];

        foreach ($questions as $question) {
            $jawabanUser = strtoupper(trim($jawaban[$question->id] ?? ''));
            $isCorrect   = $question->isCorrect($jawabanUser);
            $poinDidapat = $isCorrect ? $question->poin : 0;

            $totalPoin   += $poinDidapat;
            $jumlahBenar += $isCorrect ? 1 : 0;

            $answerData[] = [
                'question_id'  => $question->id,
                'jawaban_user' => $jawabanUser,
                'is_correct'   => $isCorrect,
                'poin_didapat' => $poinDidapat,
            ];
        }

        $persentase = $totalSoal > 0
            ? round(($jumlahBenar / $totalSoal) * 100, 2)
            : 0;

        $lulus = $persentase >= $quiz->passing_score;

        return DB::transaction(function () use (
            $quiz,
            $userId,
            $totalPoin,
            $totalSoal,
            $jumlahBenar,
            $persentase,
            $lulus,
            $answerData
        ) {
            $attempt = QuizAttempt::create([
                'user_id'      => $userId,
                'quiz_id'      => $quiz->id,
                'total_poin'   => $totalPoin,
                'total_soal'   => $totalSoal,
                'jumlah_benar' => $jumlahBenar,
                'persentase'   => $persentase,
                'lulus'        => $lulus,
                'selesai_at'   => now(),
            ]);

            foreach ($answerData as $data) {
                AttemptAnswer::create([
                    'quiz_attempt_id' => $attempt->id,
                    ...$data,
                ]);
            }

            return $attempt;
        });
    }

    /**
     * Cek apakah user boleh mengakses quiz ini.
     * Syarat: submodul sudah di-complete oleh user.
     */
    public function canAttempt(Quiz $quiz, int $userId): bool
    {
        $submodul = $quiz->submodul;

        return Progress::where('user_id', $userId)
            ->where('submodul_id', $submodul->id)
            ->where('is_completed', true)
            ->exists();
    }

    public function getBestAttempt(Quiz $quiz, int $userId): ?QuizAttempt
    {
        return QuizAttempt::where('user_id', $userId)
            ->where('quiz_id', $quiz->id)
            ->orderByDesc('persentase')
            ->first();
    }

    public function getLatestAttempt(Quiz $quiz, int $userId): ?QuizAttempt
    {
        return QuizAttempt::where('user_id', $userId)
            ->where('quiz_id', $quiz->id)
            ->latest()
            ->first();
    }

    public function getStats(Quiz $quiz): array
    {
        $attempts = QuizAttempt::where('quiz_id', $quiz->id);

        $total   = $attempts->count();
        $lulus   = $attempts->clone()->where('lulus', true)->count();
        $avgSkor = $attempts->clone()->avg('persentase') ?? 0;

        return [
            'total_peserta' => $total,
            'total_lulus'   => $lulus,
            'total_gagal'   => $total - $lulus,
            'pass_rate'     => $total > 0 ? round(($lulus / $total) * 100, 1) : 0,
            'rata_skor'     => round($avgSkor, 1),
        ];
    }

    public function upsertFromBuilder(array $data): Quiz
    {
        return DB::transaction(function () use ($data) {

            // --- Upsert quiz ---
            if (isset($data['quiz_id'])) {
                $quiz = Quiz::findOrFail($data['quiz_id']);
                $quiz->update([
                    'judul_quiz'    => $data['judul_quiz'],
                    'deskripsi'     => $data['deskripsi'] ?? null,
                    'passing_score' => $data['passing_score'] ?? 70,
                ]);
            } else {
                $quiz = Quiz::create([
                    'submodul_id'   => $data['submodul_id'],
                    'judul_quiz'    => $data['judul_quiz'],
                    'deskripsi'     => $data['deskripsi'] ?? null,
                    'passing_score' => $data['passing_score'] ?? 70,
                ]);
            }

            // --- Upsert soal (jika dikirim) ---
            if (!empty($data['questions'])) {
                $quiz->questions()->delete(); // hapus lama, insert ulang

                foreach ($data['questions'] as $urutan => $q) {
                    $options    = $q['options'];
                    $correctIdx = (int) $q['correct_index'];
                    $jawaban    = $options[$correctIdx] ?? 'A'; // simpan teks jawaban benar
                    // Kalau mau simpan huruf: chr(65 + $correctIdx)

                    $quiz->questions()->create([
                        'pertanyaan'      => $q['text'],
                        'pilihan_jawaban' => $options,  // di-cast as array di model
                        'jawaban_benar'   => $jawaban,
                        'poin'            => $q['poin'] ?? 10,
                        'urutan'          => $urutan,
                    ]);
                }
            }

            return $quiz->load('questions');
        });
    }
}
