<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Modul;
use App\Models\Submodul;
use App\Models\Question;
use App\Models\Resource;
use App\Services\QuizService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuizController extends Controller
{
    public function __construct(protected QuizService $quizService) {}

    public function create(Modul $modul, Submodul $submodul)
    {
        $this->authorizeSubmodul($modul, $submodul);

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
            'gambar.*'        => 'nullable|image|max:2048',
            'pilihan_a.*'     => 'required|string',
            'pilihan_b.*'     => 'required|string',
            'pilihan_c.*'     => 'required|string',
            'pilihan_d.*'     => 'required|string',
            'jawaban_benar.*' => 'required|in:A,B,C,D',
            'poin.*'          => 'nullable',
        ], [
            'gambar.*.max' => 'Ukuran gambar maksimal 2MB. File yang Anda upload melebihi batas.',
            'gambar.*.image' => 'File harus berupa gambar (jpg, png, dll).',
        ]);

        // Urutan otomatis (max sort_order + 1)
        $maxOrder = Quiz::where('submodul_id', $submodul->id)->max('sort_order') ?? 0;
        $quiz = Quiz::create([
            'submodul_id'   => $submodul->id,
            'judul_quiz'    => $request->judul_quiz,
            'deskripsi'     => $request->deskripsi,
            'passing_score' => $request->passing_score,
            'sort_order'    => $maxOrder + 1,
        ]);

        $jumlahSoal = count($request->pertanyaan);
        $poinPerSoal = round(100 / $jumlahSoal, 2); // desimal 2 angka

        foreach ($request->pertanyaan as $index => $pertanyaan) {
            $question = Question::create([
                'quiz_id'         => $quiz->id,
                'pertanyaan'      => $pertanyaan,
                'pilihan_jawaban' => [
                    'A' => $request->pilihan_a[$index],
                    'B' => $request->pilihan_b[$index],
                    'C' => $request->pilihan_c[$index],
                    'D' => $request->pilihan_d[$index],
                ],
                'jawaban_benar'   => $request->jawaban_benar[$index],
                'poin'            => $poinPerSoal, // poin otomatis
                'urutan'          => $index + 1,
            ]);

            if ($request->hasFile("gambar.{$index}")) {
                $file = $request->file("gambar.{$index}");
                $path = $file->store('quiz-images', 'public');
                $question->resources()->create([
                    'path'          => $path,
                    'type'          => 'image',
                    'mime_type'     => $file->getMimeType(),
                    'size'          => $file->getSize(),
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->route('admin.moduls.submoduls.show', [$modul, $submodul])
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
            'gambar.*'        => 'nullable|image|max:2048',
            'pilihan_a.*'     => 'required|string',
            'pilihan_b.*'     => 'required|string',
            'pilihan_c.*'     => 'required|string',
            'pilihan_d.*'     => 'required|string',
            'jawaban_benar.*' => 'required|in:A,B,C,D',
            'poin.*'          => 'required|integer|min:1',
        ], [
            'gambar.*.max' => 'Ukuran gambar maksimal 2MB. File yang Anda upload melebihi batas.',
            'gambar.*.image' => 'File harus berupa gambar (jpg, png, dll).',
        ]);

        $quiz->update([
            'judul_quiz'    => $request->judul_quiz,
            'deskripsi'     => $request->deskripsi,
            'passing_score' => $request->passing_score,
        ]);

        // Hapus soal lama dan resource-nya
        foreach ($quiz->questions as $oldQuestion) {
            foreach ($oldQuestion->resources as $res) {
                if ($res->path && !str_starts_with($res->path, 'http')) {
                    Storage::disk('public')->delete($res->path);
                }
                $res->delete();
            }
            $oldQuestion->delete();
        }

        // Buat soal baru
        foreach ($request->pertanyaan as $index => $pertanyaan) {
            $question = Question::create([
                'quiz_id'         => $quiz->id,
                'pertanyaan'      => $pertanyaan,
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

            if ($request->hasFile("gambar.{$index}")) {
                $file = $request->file("gambar.{$index}");
                $path = $file->store('quiz-images', 'public');
                $question->resources()->create([
                    'path'          => $path,
                    'type'          => 'image',
                    'mime_type'     => $file->getMimeType(),
                    'size'          => $file->getSize(),
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
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
