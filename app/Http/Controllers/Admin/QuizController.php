<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Modul;
use App\Models\Submodul;
use App\Models\Question;
use App\Services\QuizService;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function __construct(protected QuizService $quizService) {}

    // -------------------------------------------------------------------------
    // Quiz — sekarang terikat ke Submodul (bukan Modul)
    // -------------------------------------------------------------------------

    public function create(Modul $modul, Submodul $submodul)
    {
        $this->authorizeSubmodul($modul, $submodul);

        // Satu submodul hanya boleh punya satu quiz
        if ($submodul->quiz()->exists()) {
            return redirect()
                ->route('admin.moduls.submoduls.show', [$modul, $submodul])
                ->with('error', 'Submodul ini sudah punya quiz. Edit quiz yang ada.');
        }

        return view('admin.quizzes.create', compact('modul', 'submodul'));
    }

    public function store(Request $request, Modul $modul, Submodul $submodul)
    {
        $this->authorizeSubmodul($modul, $submodul);

        $request->validate([
            'judul_quiz'      => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'passing_score'   => 'required|integer|min:0|max:100',
            'pertanyaan'      => 'required|array|min:1',
            'pertanyaan.*'    => 'required|string',
            'gambar_soal'     => 'nullable|array',
            'gambar_soal.*'   => 'nullable|image|max:2048',
            'pilihan_a.*'     => 'required|string',
            'pilihan_b.*'     => 'required|string',
            'pilihan_c.*'     => 'required|string',
            'pilihan_d.*'     => 'required|string',
            'jawaban_benar.*' => 'required|in:A,B,C,D',
            'poin.*'          => 'required|integer|min:1',
        ]);

        $quiz = Quiz::create([
            'submodul_id'   => $submodul->id,
            'judul_quiz'    => $request->judul_quiz,
            'deskripsi'     => $request->deskripsi,
            'passing_score' => $request->passing_score,
        ]);

        foreach ($request->pertanyaan as $index => $pertanyaan) {
            $gambarPath = null;
            if ($request->hasFile("gambar_soal.{$index}")) {
                $gambarPath = $request->file("gambar_soal.{$index}")
                    ->store('quiz-images', 'public');
            }

            Question::create([
                'quiz_id'         => $quiz->id,
                'pertanyaan'      => $pertanyaan,
                'gambar_soal'     => $gambarPath,
                'pilihan_jawaban' => [
                    'A' => $request->pilihan_a[$index],
                    'B' => $request->pilihan_b[$index],
                    'C' => $request->pilihan_c[$index],
                    'D' => $request->pilihan_d[$index],
                ],
                'jawaban_benar'   => $request->jawaban_benar[$index],
                'poin'            => $request->poin[$index],
                'urutan'          => $index + 1,
            ]);
        }

        return redirect()
            ->route('admin.moduls.submoduls.show', [$modul, $submodul])
            ->with('success', 'Quiz berhasil dibuat!');
    }

    public function edit(Modul $modul, Submodul $submodul, Quiz $quiz)
    {
        $this->authorizeSubmodul($modul, $submodul);
        $this->authorizeQuiz($submodul, $quiz);
        $quiz->load('questions');

        return view('admin.quizzes.edit', compact('modul', 'submodul', 'quiz'));
    }

    public function update(Request $request, Modul $modul, Submodul $submodul, Quiz $quiz)
    {
        $this->authorizeSubmodul($modul, $submodul);
        $this->authorizeQuiz($submodul, $quiz);

        $request->validate([
            'judul_quiz'      => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'passing_score'   => 'required|integer|min:0|max:100',
            'pertanyaan'      => 'required|array|min:1',
            'pertanyaan.*'    => 'required|string',
            'gambar_soal.*'   => 'nullable|image|max:2048',
            'pilihan_a.*'     => 'required|string',
            'pilihan_b.*'     => 'required|string',
            'pilihan_c.*'     => 'required|string',
            'pilihan_d.*'     => 'required|string',
            'jawaban_benar.*' => 'required|in:A,B,C,D',
            'poin.*'          => 'required|integer|min:1',
        ]);

        $quiz->update([
            'judul_quiz'    => $request->judul_quiz,
            'deskripsi'     => $request->deskripsi,
            'passing_score' => $request->passing_score,
        ]);

        // Hapus soal lama, buat ulang
        $quiz->questions()->delete();

        foreach ($request->pertanyaan as $index => $pertanyaan) {
            $gambarPath = null;
            if ($request->hasFile("gambar_soal.{$index}")) {
                $gambarPath = $request->file("gambar_soal.{$index}")
                    ->store('quiz-images', 'public');
            }

            Question::create([
                'quiz_id'         => $quiz->id,
                'pertanyaan'      => $pertanyaan,
                'gambar_soal'     => $gambarPath,
                'pilihan_jawaban' => [
                    'A' => $request->pilihan_a[$index],
                    'B' => $request->pilihan_b[$index],
                    'C' => $request->pilihan_c[$index],
                    'D' => $request->pilihan_d[$index],
                ],
                'jawaban_benar'   => $request->jawaban_benar[$index],
                'poin'            => $request->poin[$index],
                'urutan'          => $index + 1,
            ]);
        }

        return redirect()
            ->route('admin.moduls.submoduls.show', [$modul, $submodul])
            ->with('success', 'Quiz berhasil diperbarui!');
    }

    public function show(Modul $modul, Submodul $submodul, Quiz $quiz)
    {
        $this->authorizeSubmodul($modul, $submodul);
        $this->authorizeQuiz($submodul, $quiz);
        $quiz->load('questions');

        $stats = $this->quizService->getStats($quiz);

        return view('admin.quizzes.show', compact('modul', 'submodul', 'quiz', 'stats'));
    }

    public function destroy(Modul $modul, Submodul $submodul, Quiz $quiz)
    {
        $this->authorizeSubmodul($modul, $submodul);
        $this->authorizeQuiz($submodul, $quiz);
        $quiz->delete();

        return redirect()
            ->route('admin.moduls.submoduls.show', [$modul, $submodul])
            ->with('success', 'Quiz berhasil dihapus!');
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    private function authorizeSubmodul(Modul $modul, Submodul $submodul): void
    {
        if ($submodul->modul_id !== $modul->id) {
            abort(404);
        }
    }

    private function authorizeQuiz(Submodul $submodul, Quiz $quiz): void
    {
        if ($quiz->submodul_id !== $submodul->id) {
            abort(404);
        }
    }
}
