<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Submodul;
use App\Models\Modul;
use App\Models\Resource;
use Illuminate\Http\Request;

class SubmodulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Modul $modul)
    {
        $submoduls = Submodul::where('modul_id', $modul->id)
            ->orderBy('sort_order')
            ->paginate(12);

        return view('user.submoduls.index', compact('modul', 'submoduls'));
    }

    public function show(Modul $modul, $sort_order)
    {
        $submodul = Submodul::where('modul_id', $modul->id)
            ->where('sort_order', $sort_order)
            ->firstOrFail();

        if (Auth::check()) {
            $previousSubmodul = Submodul::where('modul_id', $modul->id)
                ->where('sort_order', '<', $submodul->sort_order)
                ->whereDoesntHave('progress', function ($query) {
                    $query->where('user_id', Auth::id())
                        ->where('is_completed', true);
                })
                ->orderBy('sort_order', 'desc')
                ->first();

            if ($previousSubmodul && $submodul->sort_order > 1) {
                return redirect()->route('learn.submoduls.show', [
                    'modul' => $modul->id,
                    'sort_order' => $previousSubmodul->sort_order
                ])
                    ->with('error', 'Silakan selesaikan submodul sebelumnya terlebih dahulu: ' . $previousSubmodul->judul);
            }
        }

        $submodul->load([
            'resources',
            'tanya' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'tanya.user',
            'tanya.jawabs' => function ($query) {
                $query->orderBy('created_at', 'asc');
            },
            'tanya.jawabs.user',
            'tanya.resources',
            'tanya.jawabs.resources'
        ]);

        $modulProgress = $modul->getUserProgress();

        $prevSubmodul = Submodul::where('modul_id', $modul->id)
            ->where('sort_order', '<', $submodul->sort_order)
            ->orderBy('sort_order', 'desc')
            ->first();

        $nextSubmodul = Submodul::where('modul_id', $modul->id)
            ->where('sort_order', '>', $submodul->sort_order)
            ->orderBy('sort_order', 'asc')
            ->first();

        $isNextAccessible = Auth::check() && $submodul->isCompletedByUser();

        return view('user.submoduls.show', compact(
            'modul',
            'submodul',
            'prevSubmodul',
            'nextSubmodul',
            'modulProgress',
            'isNextAccessible'
        ));
    }

    public function complete(Modul $modul, $sort_order)
    {
        $submodul = Submodul::where('modul_id', $modul->id)
            ->where('sort_order', $sort_order)
            ->firstOrFail();

        $submodul->markAsCompleted(Auth::id());

        return back()->with('success', 'Submodul berhasil ditandai sebagai selesai!');
    }

    public function incomplete(Modul $modul, $sort_order)
    {
        $submodul = Submodul::where('modul_id', $modul->id)
            ->where('sort_order', $sort_order)
            ->firstOrFail();

        $submodul->markAsIncomplete();

        return back()->with('success', 'Submodul berhasil ditandai sebagai belum selesai.');
    }
}
