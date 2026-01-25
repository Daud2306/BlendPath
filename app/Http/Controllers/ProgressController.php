<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use App\Models\Submodul;
use App\Models\Modul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{

    public function markAsCompleted(Modul $modul, $sort_order)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $submodul = Submodul::where('modul_id', $modul->id)
            ->where('sort_order', $sort_order)
            ->firstOrFail();

        $submodul->markAsCompleted();
        return redirect()->back()->with('success', 'Submodul berhasil ditandai sebagai selesai!');
    }

    public function markAsIncomplete(Modul $modul, $sort_order)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $submodul = Submodul::where('modul_id', $modul->id)
            ->where('sort_order', $sort_order)
            ->firstOrFail();

        $progress = Progress::where('user_id', Auth::id())
            ->where('submodul_id', $submodul->id)
            ->first();

        if ($progress) {
            $progress->delete();
        }

        return redirect()->back()->with('success', 'Submodul berhasil ditandai sebagai belum selesai!');
    }

    public function getUserOverallProgress()
    {
        if (!Auth::check()) {
            return 0;
        }

        $totalSubmoduls = Submodul::count();
        $completedSubmoduls = Progress::where('user_id', Auth::id())
            ->where('is_completed', true)
            ->count();

        if ($totalSubmoduls == 0) {
            return 0;
        }

        return round(($completedSubmoduls / $totalSubmoduls) * 100);
    }
}
