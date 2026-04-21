<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tanya;
use App\Models\Jawab;
use App\Models\Modul;
use Illuminate\Http\Request;

class DiskusiController extends Controller
{
    public function index(Request $request)
    {
        $moduls = Modul::with('submoduls')->orderBy('sort_order')->get();

        $baseQuery = Tanya::query();
        if ($request->filled('submodul_id')) {
            $baseQuery->where('submodul_id', $request->submodul_id);
        } elseif ($request->filled('modul_id')) {
            $baseQuery->whereHas('submodul', fn($q) => $q->where('modul_id', $request->modul_id));
        }

        $totalPertanyaan = (clone $baseQuery)->count();
        $totalJawaban    = (clone $baseQuery)->withCount('jawabs')->get()->sum('jawabs_count');
        $belumDijawab    = (clone $baseQuery)->doesntHave('jawabs')->count();

        $tanyas = $baseQuery
            ->with(['user', 'submodul.modul'])
            ->withCount('jawabs')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.diskusi.index', compact('tanyas', 'moduls', 'totalPertanyaan', 'totalJawaban', 'belumDijawab'));
    }

    public function show(Tanya $tanya)
    {
        $tanya->load([
            'user',
            'submodul.modul',
            'resources',
            'jawabs' => fn($q) => $q->orderBy('created_at'),
            'jawabs.user',
            'jawabs.resources',
        ]);

        return view('admin.diskusi.show', compact('tanya'));
    }

    public function destroyTanya(Tanya $tanya)
    {
        $tanya->delete();
        return redirect()->route('admin.diskusi.index')->with('success', 'Pertanyaan berhasil dihapus.');
    }

    public function destroyJawab(Jawab $jawab)
    {
        $tanyaId = $jawab->tanya_id;
        $jawab->delete();
        return back()->with('success', 'Jawaban berhasil dihapus.');
    }
}
