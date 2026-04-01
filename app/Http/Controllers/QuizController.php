<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Modul;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Services\QuizService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function __construct(protected QuizService $quizService) {}

    /**
     * Halaman pengerjaan quiz.
     * Hanya bisa diakses jika semua submodul modul sudah selesai.
     */
    public function take(Modul $modul, Quiz $quiz)
    {
        $this->authorizeQuiz($modul, $quiz);

        // Cek apakah semua submodul sudah selesai
        if (!$this->quizService->canAttempt($quiz, Auth::id())) {
            return redirect()
                ->route('learn.submoduls.show', [
                    'modul'      => $modul->id,
                    'sort_order' => 1,
                ])
                ->with('error', 'Selesaikan semua submodul terlebih dahulu sebelum mengerjakan quiz.');
        }

        $quiz->load('questions');
        $latestAttempt = $this->quizService->getLatestAttempt($quiz, Auth::id());
        $alreadyPassed = $quiz->isPassedByUser(Auth::id());

        return view('user.quizzes.take', compact(
            'modul',
            'quiz',
            'latestAttempt',
            'alreadyPassed',
        ));
    }

    /**
     * Proses submit jawaban quiz.
     */
    public function submit(Request $request, Modul $modul, Quiz $quiz)
    {
        $this->authorizeQuiz($modul, $quiz);

        if (!$this->quizService->canAttempt($quiz, Auth::id())) {
            abort(403, 'Belum boleh mengerjakan quiz.');
        }

        $request->validate([
            'jawaban'   => 'required|array',
            'jawaban.*' => 'required|string|in:A,B,C,D',
        ]);

        $attempt = $this->quizService->submitAttempt(
            $quiz,
            $request->jawaban,
            Auth::id()
        );

        return redirect()->route('learn.quizzes.result', [
            'modul' => $modul,
            'quiz'  => $quiz,
            'attempt' => $attempt->id,
        ]);
    }

    /**
     * Halaman hasil quiz setelah submit.
     */
    public function result(Modul $modul, Quiz $quiz, QuizAttempt $attempt)
    {
        $this->authorizeQuiz($modul, $quiz);

        // Pastikan attempt ini milik user yang login dan untuk quiz ini
        if ($attempt->user_id !== Auth::id() || $attempt->quiz_id !== $quiz->id) {
            abort(403);
        }

        $quiz->load('questions');
        $attempt->load('answers.question');

        $bestAttempt = $this->quizService->getBestAttempt($quiz, Auth::id());

        return view('user.quizzes.result', compact(
            'modul',
            'quiz',
            'attempt',
            'bestAttempt',
        ));
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    private function authorizeQuiz(Modul $modul, Quiz $quiz): void
    {
        if ($quiz->modul_id !== $modul->id) {
            abort(404);
        }
    }
}
