<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use App\Models\Submodul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ModulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.moduls.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image',
            'sort_order' => 'required|integer',
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('moduls', 'public');
            $data['gambar'] = $path;
        }

        Modul::create($data);

        return redirect()->route('admin.moduls.index')->with('success', 'Modul berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Modul $modul, Request $request)
    {
        $query = Submodul::where('modul_id', $modul->id);

        $submoduls = $query->paginate(10);

        $progress = $modul->getUserProgress();

        return view('user.moduls.show', compact('modul', 'submoduls', 'progress'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modul $modul)
    {
        return view('admin.moduls.edit', compact('modul'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Modul $modul)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'sort_order' => 'required|integer',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['judul', 'deskripsi', 'sort_order']);

        if ($request->hasFile('gambar')) {
            if ($modul->gambar) {
                Storage::disk('public')->delete($modul->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('moduls', 'public');
        }

        $modul->update($data);

        return redirect()->route('admin.moduls.index')
            ->with('success', 'Modul updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Modul $modul)
    {
        if ($modul->gambar) {
            Storage::disk('public')->delete($modul->gambar);
        }

        $modul->delete();

        return redirect()->route('admin.moduls.index')->with('success', 'Modul berhasil dihapus.');
    }

    public function adminIndex()
    {
        $moduls = Modul::orderBy('sort_order')->paginate(10);
        return view('admin.moduls.index', compact('moduls'));
    }

    public function adminShow(Modul $modul)
    {
        $submoduls = $modul->submoduls()->orderBy('sort_order')->get();
        return view('admin.submoduls.index', compact('modul', 'submoduls'));
    }
}
