<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Submodul;
use App\Models\Modul;
use App\Models\Resource;
use Illuminate\Http\Request;

class SubmodulController extends Controller
{
    public function show(Modul $modul, int $sort_order)
    {
        $submodul = Submodul::where('modul_id', $modul->id)
            ->where('sort_order', $sort_order)
            ->firstOrFail();

        // Gate: submodul sebelumnya harus sudah selesai
        if (Auth::check() && $submodul->sort_order > 1) {
            $previousIncomplete = Submodul::where('modul_id', $modul->id)
                ->where('sort_order', '<', $submodul->sort_order)
                ->whereDoesntHave('progress', function ($query) {
                    $query->where('user_id', Auth::id())
                        ->where('is_completed', true);
                })
                ->orderBy('sort_order', 'desc')
                ->first();

            if ($previousIncomplete) {
                return redirect()
                    ->route('learn.submoduls.show', [
                        'modul'      => $modul->id,
                        'sort_order' => $previousIncomplete->sort_order,
                    ])
                    ->with('error', 'Selesaikan submodul sebelumnya: ' . $previousIncomplete->judul);
            }
        }

        $submodul->load([
            'resources',
            'tanya'             => fn($q) => $q->orderBy('created_at', 'desc'),
            'tanya.user',
            'tanya.jawabs'      => fn($q) => $q->orderBy('created_at', 'asc'),
            'tanya.jawabs.user',
            'tanya.resources',
            'tanya.jawabs.resources',
            'quizzes.questions',
            'miniProjects.resources',
        ]);

        $modulProgress = $modul->getUserProgress(Auth::id());

        $prevSubmodul = Submodul::where('modul_id', $modul->id)
            ->where('sort_order', '<', $submodul->sort_order)
            ->orderBy('sort_order', 'desc')
            ->first();

        $nextSubmodul = Submodul::where('modul_id', $modul->id)
            ->where('sort_order', '>', $submodul->sort_order)
            ->orderBy('sort_order', 'asc')
            ->first();

        $isCurrentCompleted = Auth::check() && $submodul->isCompletedByUser(Auth::id());
        $quizzes = $submodul->quizzes;
        $allQuizzesPassed = $quizzes->isNotEmpty() && $quizzes->every(fn($q) => $q->isPassedByUser(Auth::id()));
        $quizRequirementPassed = $quizzes->isEmpty() || $allQuizzesPassed;
        $isLastSubmodul = $submodul->isLastInModul();
        $isNextAccessible = $isCurrentCompleted && $quizRequirementPassed;

        return view('user.submoduls.show', compact(
            'modul',
            'submodul',
            'prevSubmodul',
            'nextSubmodul',
            'modulProgress',
            'isNextAccessible',
            'isCurrentCompleted',
            'isLastSubmodul',
            'quizzes',
            'quizRequirementPassed',
        ));
    }
}
