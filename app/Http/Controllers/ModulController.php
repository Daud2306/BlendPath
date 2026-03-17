<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use App\Models\Submodul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ModulController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $moduls = Modul::with(['submoduls' => function ($query) use ($user) {
            $query->orderBy('sort_order')
                ->with(['progress' => function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                }]);
        }])
            ->orderBy('sort_order')
            ->paginate(5);

        $moduls->each(function ($modul) {
            $target = null;
            foreach ($modul->submoduls as $sub) {
                $completed = $sub->progress->isNotEmpty() ? $sub->progress->first()->is_completed : false;
                if (!$completed) {
                    $target = $sub->sort_order;
                    break;
                }
            }

            if (!$target && $modul->submoduls->isNotEmpty()) {
                $target = $modul->submoduls->first()->sort_order;
            }
            $modul->target_sort_order = $target;
        });

        return view('user.moduls.index', compact('moduls'));
    }

    public function show(Modul $modul, Request $request)
    {
        $query = Submodul::where('modul_id', $modul->id);

        $submoduls = $query->paginate(10);

        $progress = $modul->getUserProgress();

        return view('user.moduls.show', compact('modul', 'submoduls', 'progress'));
    }

}
