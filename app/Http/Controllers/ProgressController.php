<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use App\Models\Tutorial;
use App\Models\Roadmap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{

    public function markAsCompleted(Roadmap $roadmap, $sort_order)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $tutorial = Tutorial::where('roadmap_id', $roadmap->id)
            ->where('sort_order', $sort_order)
            ->firstOrFail();

        $tutorial->markAsCompleted();

        return redirect()->back()->with('success', 'Tutorial berhasil ditandai sebagai selesai!');
    }

    public function markAsIncomplete(Roadmap $roadmap, $sort_order)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $tutorial = Tutorial::where('roadmap_id', $roadmap->id)
            ->where('sort_order', $sort_order)
            ->firstOrFail();

        $progress = Progress::where('user_id', Auth::id())
            ->where('tutorial_id', $tutorial->id)
            ->first();

        if ($progress) {
            $progress->delete();
        }

        return redirect()->back()->with('success', 'Tutorial berhasil ditandai sebagai belum selesai!');
    }

    public function getUserOverallProgress()
    {
        if (!Auth::check()) {
            return 0;
        }

        $totalTutorials = Tutorial::count();
        $completedTutorials = Progress::where('user_id', Auth::id())
            ->where('is_completed', true)
            ->count();

        if ($totalTutorials == 0) {
            return 0;
        }

        return round(($completedTutorials / $totalTutorials) * 100);
    }
}
