<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Tutorial;
use App\Models\Roadmap;
use App\Models\PertanyaanQuiz;
use App\Models\ResponQuiz;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function create(Roadmap $roadmap, Tutorial $tutorial)
    {
        if ($tutorial->roadmap_id !== $roadmap->id) {
            abort(404);
        }

        return view('admin.quizzes.create', compact('roadmap', 'tutorial'));
    }

    public function store(Request $request, Roadmap $roadmap, Tutorial $tutorial)
    {
        if ($tutorial->roadmap_id !== $roadmap->id) {
            abort(404);
        }

        $request->validate([
            'judul_quiz' => 'required|string|max:255',
            'urutan' => 'required|integer',
            'passing_score' => 'required|integer|min:0|max:100',
            'pertanyaan' => 'required|array',
            'pertanyaan.*' => 'required|string',
            'pilihan_a' => 'required|array',
            'pilihan_a.*' => 'required|string',
            'pilihan_b' => 'required|array',
            'pilihan_b.*' => 'required|string',
            'pilihan_c' => 'required|array',
            'pilihan_c.*' => 'required|string',
            'pilihan_d' => 'required|array',
            'pilihan_d.*' => 'required|string',
            'jawaban_benar' => 'required|array',
            'jawaban_benar.*' => 'required|in:A,B,C,D',
            'poin' => 'required|array',
            'poin.*' => 'required|integer|min:1',
        ]);

        $quiz = Quiz::create([
            'tutorial_id' => $tutorial->id,
            'judul_quiz' => $request->judul_quiz,
            'urutan' => $request->urutan,
            'passing_score' => $request->passing_score,
        ]);

        foreach ($request->pertanyaan as $index => $pertanyaan) {
            $pilihanJawaban = [
                'A' => $request->pilihan_a[$index],
                'B' => $request->pilihan_b[$index],
                'C' => $request->pilihan_c[$index],
                'D' => $request->pilihan_d[$index],
            ];

            PertanyaanQuiz::create([
                'quiz_id' => $quiz->id,
                'pertanyaan' => $pertanyaan,
                'pilihan_jawaban' => $pilihanJawaban,
                'jawaban_benar' => $request->jawaban_benar[$index],
                'poin' => $request->poin[$index],
            ]);
        }

        return redirect()->route('admin.roadmaps.tutorials.show', [
            'roadmap' => $roadmap,
            'tutorial' => $tutorial
        ])->with('success', 'Quiz berhasil dibuat!');
    }

    public function edit(Roadmap $roadmap, Tutorial $tutorial, Quiz $quiz)
    {
        if ($tutorial->roadmap_id !== $roadmap->id || $quiz->tutorial_id !== $tutorial->id) {
            abort(404);
        }

        $quiz->load('pertanyaan');
        return view('admin.quizzes.edit', compact('roadmap', 'tutorial', 'quiz'));
    }

    public function update(Request $request, Roadmap $roadmap, Tutorial $tutorial, Quiz $quiz)
    {
        if ($tutorial->roadmap_id !== $roadmap->id || $quiz->tutorial_id !== $tutorial->id) {
            abort(404);
        }

        $request->validate([
            'judul_quiz' => 'required|string|max:255',
            'urutan' => 'required|integer',
            'passing_score' => 'required|integer|min:0|max:100',
            'pertanyaan' => 'required|array',
            'pertanyaan.*' => 'required|string',
            'pilihan_a' => 'required|array',
            'pilihan_a.*' => 'required|string',
            'pilihan_b' => 'required|array',
            'pilihan_b.*' => 'required|string',
            'pilihan_c' => 'required|array',
            'pilihan_c.*' => 'required|string',
            'pilihan_d' => 'required|array',
            'pilihan_d.*' => 'required|string',
            'jawaban_benar' => 'required|array',
            'jawaban_benar.*' => 'required|in:A,B,C,D',
            'poin' => 'required|array',
            'poin.*' => 'required|integer|min:1',
        ]);

        $quiz->update([
            'judul_quiz' => $request->judul_quiz,
            'urutan' => $request->urutan,
            'passing_score' => $request->passing_score,
        ]);

        $quiz->pertanyaan()->delete();

        foreach ($request->pertanyaan as $index => $pertanyaan) {
            $pilihanJawaban = [
                'A' => $request->pilihan_a[$index],
                'B' => $request->pilihan_b[$index],
                'C' => $request->pilihan_c[$index],
                'D' => $request->pilihan_d[$index],
            ];

            PertanyaanQuiz::create([
                'quiz_id' => $quiz->id,
                'pertanyaan' => $pertanyaan,
                'pilihan_jawaban' => $pilihanJawaban,
                'jawaban_benar' => $request->jawaban_benar[$index],
                'poin' => $request->poin[$index],
            ]);
        }

        return redirect()->route('admin.roadmaps.tutorials.show', [
            'roadmap' => $roadmap,
            'tutorial' => $tutorial
        ])->with('success', 'Quiz berhasil diperbarui!');
    }

    public function destroy(Roadmap $roadmap, Tutorial $tutorial, Quiz $quiz)
    {
        if ($tutorial->roadmap_id !== $roadmap->id || $quiz->tutorial_id !== $tutorial->id) {
            abort(404);
        }

        $quiz->delete();

        return redirect()->route('admin.roadmaps.tutorials.show', [
            'roadmap' => $roadmap,
            'tutorial' => $tutorial
        ])->with('success', 'Quiz berhasil dihapus!');
    }

    public function show(Roadmap $roadmap, $sort_order)
    {
        $tutorial = Tutorial::where('roadmap_id', $roadmap->id)
            ->where('sort_order', $sort_order)
            ->firstOrFail();

        $tutorial->load('quizzes.pertanyaan');

        $userRespon = [];
        if (Auth::check()) {
            $userRespon = ResponQuiz::where('user_id', Auth::id())
                ->whereIn('quiz_id', $tutorial->quizzes->pluck('id'))
                ->get()
                ->keyBy('quiz_id');
        }

        return view('user.quizzes.show', compact('roadmap', 'tutorial', 'userRespon'));
    }

    public function showQuiz(Roadmap $roadmap, $sort_order, Quiz $quiz)
    {
        $tutorial = Tutorial::where('roadmap_id', $roadmap->id)
            ->where('sort_order', $sort_order)
            ->firstOrFail();

        if ($quiz->tutorial_id !== $tutorial->id) {
            abort(404);
        }

        $quiz->load('pertanyaan');

        $userRespon = null;
        if (Auth::check()) {
            $userRespon = ResponQuiz::where('user_id', Auth::id())
                ->where('quiz_id', $quiz->id)
                ->first();
        }

        return view('user.quizzes.take', compact('roadmap', 'tutorial', 'quiz', 'userRespon'));
    }

    public function submit(Request $request, Roadmap $roadmap, $sort_order)
    {
        $tutorial = Tutorial::where('roadmap_id', $roadmap->id)
            ->where('sort_order', $sort_order)
            ->firstOrFail();

        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'jawaban' => 'required|array',
            'jawaban.*' => 'required|string',
        ]);

        $quiz = Quiz::findOrFail($request->quiz_id);

        if ($quiz->tutorial_id !== $tutorial->id) {
            abort(404);
        }

        $totalPoin = 0;
        $jumlahBenar = 0;

        foreach ($quiz->pertanyaan as $pertanyaan) {
            $jawabanUser = $request->jawaban[$pertanyaan->id] ?? '';
            if (strtoupper(trim($jawabanUser)) === strtoupper(trim($pertanyaan->jawaban_benar))) {
                $totalPoin += $pertanyaan->poin;
                $jumlahBenar++;
            }
        }

        $totalSoal = $quiz->pertanyaan->count();
        $persentase = $totalSoal > 0 ? ($jumlahBenar / $totalSoal) * 100 : 0;
        $lulus = $persentase >= $quiz->passing_score;

        $respon = ResponQuiz::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'quiz_id' => $quiz->id,
            ],
            [
                'total_poin' => $totalPoin,
                'lulus' => $lulus,
            ]
        );

        return view('user.quizzes.result', compact(
            'roadmap',
            'tutorial',
            'quiz',
            'totalPoin',
            'jumlahBenar',
            'totalSoal',
            'persentase',
            'lulus',
            'respon'
        ));
    }

    public function result(Roadmap $roadmap, $sort_order, Quiz $quiz)
    {
        $tutorial = Tutorial::where('roadmap_id', $roadmap->id)
            ->where('sort_order', $sort_order)
            ->firstOrFail();

        if ($quiz->tutorial_id !== $tutorial->id) {
            abort(404);
        }

        $respon = ResponQuiz::where('user_id', Auth::id())
            ->where('quiz_id', $quiz->id)
            ->firstOrFail();

        $totalSoal = $quiz->pertanyaan->count();
        $jumlahBenar = 0;

        $poinPerSoal = $totalSoal > 0 ? $quiz->pertanyaan->first()->poin : 0;
        if ($poinPerSoal > 0) {
            $jumlahBenar = $respon->total_poin / $poinPerSoal;
        }

        $persentase = $totalSoal > 0 ? ($jumlahBenar / $totalSoal) * 100 : 0;
        $lulus = $persentase >= $quiz->passing_score;

        return view('user.quizzes.result', compact(
            'roadmap',
            'tutorial',
            'quiz',
            'respon',
            'totalSoal',
            'jumlahBenar',
            'persentase',
            'lulus'
        ));
    }
}
