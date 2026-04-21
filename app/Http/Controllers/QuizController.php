<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Modul;
use App\Models\Submodul;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Services\QuizService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function __construct(protected QuizService $quizService) {}

    public function take(Modul $modul, Submodul $submodul, Quiz $quiz)
    {
        // Validasi relasi
        if ($quiz->submodul_id !== $submodul->id || $submodul->modul_id !== $modul->id) {
            abort(404);
        }

        if (!$this->quizService->canAttempt($quiz, Auth::id())) {
            return redirect()
                ->route('learn.submoduls.show', [
                    'modul'      => $modul->id,
                    'sort_order' => $submodul->sort_order,
                ])
                ->with('error', 'Selesaikan submodul ini terlebih dahulu.');
        }

        $quiz->load('questions');
        $latestAttempt = $this->quizService->getLatestAttempt($quiz, Auth::id());
        $alreadyPassed = $quiz->isPassedByUser(Auth::id());

        return view('user.quizzes.take', compact('modul', 'submodul', 'quiz', 'latestAttempt', 'alreadyPassed'));
    }

    public function submit(Request $request, Modul $modul, Submodul $submodul, Quiz $quiz)
    {
        if ($quiz->submodul_id !== $submodul->id || $submodul->modul_id !== $modul->id) {
            abort(404);
        }

        if (!$this->quizService->canAttempt($quiz, Auth::id())) {
            abort(403, 'Belum boleh mengerjakan quiz.');
        }

        $request->validate([
            'jawaban'   => 'required|array',
            'jawaban.*' => 'required|string|in:A,B,C,D',
        ]);

        $attempt = $this->quizService->submitAttempt($quiz, $request->jawaban, Auth::id());

        return redirect()->route('learn.quizzes.result', [
            'modul'   => $modul->id,
            'submodul' => $submodul->id,
            'quiz'    => $quiz->id,
            'attempt' => $attempt->id,
        ]);
    }

    public function result(Modul $modul, Submodul $submodul, Quiz $quiz, QuizAttempt $attempt)
    {
        if ($quiz->submodul_id !== $submodul->id || $submodul->modul_id !== $modul->id) {
            abort(404);
        }

        if ($attempt->user_id !== Auth::id() || $attempt->quiz_id !== $quiz->id) {
            abort(403);
        }

        $quiz->load('questions');
        $attempt->load('answers.question');

        $jumlahBenar = $attempt->jumlah_benar;
        $totalSoal   = $attempt->total_soal;
        $totalPoin   = $attempt->total_poin;
        $persentase  = $attempt->persentase;
        $lulus       = $attempt->lulus;

        return view('user.quizzes.result', compact(
            'modul',
            'submodul',
            'quiz',
            'attempt',
            'jumlahBenar',
            'totalSoal',
            'totalPoin',
            'persentase',
            'lulus'
        ));
    }
}
