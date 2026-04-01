<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use App\Models\Submodul;
use App\Models\Modul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function markAsCompleted(Modul $modul, int $sort_order)
    {
        $submodul = Submodul::where('modul_id', $modul->id)
            ->where('sort_order', $sort_order)
            ->firstOrFail();

        $submodul->markAsCompleted(Auth::id());

        return redirect()->back()->with('success', 'Submodul berhasil ditandai selesai!');
    }

    public function markAsIncomplete(Modul $modul, int $sort_order)
    {
        $submodul = Submodul::where('modul_id', $modul->id)
            ->where('sort_order', $sort_order)
            ->firstOrFail();

        $submodul->markAsIncomplete(Auth::id());

        return redirect()->back()->with('success', 'Submodul ditandai belum selesai.');
    }

    /**
     * Progress keseluruhan user (semua submodul di semua modul).
     * Dipakai di dashboard user.
     */
    public function getUserOverallProgress(): int
    {
        $totalSubmoduls = Submodul::count();
        if ($totalSubmoduls === 0) return 0;

        $completedSubmoduls = Progress::where('user_id', Auth::id())
            ->where('is_completed', true)
            ->count();

        return (int) round(($completedSubmoduls / $totalSubmoduls) * 100);
    }

    /**
     * Cek apakah modul berikutnya bisa diakses.
     * Syarat: semua submodul selesai + quiz lulus (jika ada quiz).
     */
    public function canAccessNextModul(Modul $modul): bool
    {
        return $modul->isCompletedByUser(Auth::id());
    }
}
