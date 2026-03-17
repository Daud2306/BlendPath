<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Submodul;
use App\Models\Modul;
use App\Models\Resource;
use Illuminate\Http\Request;

class SubmodulController extends Controller
{
    public function index(Modul $modul)
    {
        $submoduls = Submodul::where('modul_id', $modul->id)
            ->orderBy('sort_order')
            ->paginate(20);

        return view('admin.submoduls.index', compact('modul', 'submoduls'));
    }

    public function create(Modul $modul)
    {
        return view('admin.submoduls.create', compact('modul'));
    }

    public function store(Request $request, $modulId)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'konten'          => 'nullable|string',
            'sort_order'      => 'nullable|integer|min:0',
            'resources.*'     => 'nullable|file|max:20480|mimes:jpg,jpeg,png,gif,mp4,mov,webm,zip,pdf', // aman
            'resource'        => 'nullable|url|max:1000',
            'resource_links'  => 'nullable|string',
        ]);

        $submodul = Submodul::create([
            'modul_id' => $modulId,
            'judul'      => $request->input('judul'),
            'konten'     => $request->input('konten', ''),
            'sort_order' => $request->input('sort_order', 0),
        ]);

        if ($request->hasFile('resources')) {
            foreach ($request->file('resources') as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('resources', 'public');
                    Resource::create([
                        'resourceable_id'   => $submodul->id,
                        'resourceable_type' => Submodul::class,
                        'path'              => $path,
                        'type'              => 'image',
                    ]);
                }
            }
        }

        if ($request->filled('resource')) {
            Resource::create([
                'resourceable_id'   => $submodul->id,
                'resourceable_type' => Submodul::class,
                'path'              => trim($request->input('resource')),
                'type'              => 'video_link',
            ]);
        }

        return redirect()
            ->route('admin.moduls.submoduls.index', $modulId)
            ->with('success', 'Submodul berhasil dibuat.');
    }

    public function show(Modul $modul, Submodul $submodul)
    {
        if ($submodul->modul_id !== $modul->id) {
            abort(404);
        }

        $submodul->load([
            'resources',
            'tanya.user',
            'tanya.jawabs.user',
            'tanya.resources',
            'tanya.jawabs.resources',
            'quizzes.pertanyaan'
        ]);

        $prevSubmodul = Submodul::where('modul_id', $modul->id)
            ->where('sort_order', '<', $submodul->sort_order)
            ->orderBy('sort_order', 'desc')
            ->first();

        $nextSubmodul = Submodul::where('modul_id', $modul->id)
            ->where('sort_order', '>', $submodul->sort_order)
            ->orderBy('sort_order', 'asc')
            ->first();

        return view('admin.submoduls.show', compact(
            'modul',
            'submodul',
            'prevSubmodul',
            'nextSubmodul'
        ));
    }

    public function edit(Modul $modul, Submodul $submodul)
    {
        if ($submodul->modul_id !== $modul->id) {
            abort(404);
        }

        return view('admin.submoduls.edit', compact('modul', 'submodul'));
    }

    public function update(Request $request, Modul $modul, Submodul $submodul)
    {
        if ($submodul->modul_id !== $modul->id) {
            abort(404);
        }

        $data = $request->validate([
            'judul'      => 'required|string|max:255',
            'konten'     => 'required|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $submodul->update($request->only(['judul', 'deskripsi', 'konten', 'sort_order']));

        return redirect()
            ->route('admin.moduls.submoduls.index', $modul)
            ->with('success', 'Submodul berhasil diperbarui.');
    }

    public function destroy(Modul $modul, Submodul $submodul)
    {
        if ($submodul->modul_id !== $modul->id) {
            abort(404);
        }

        $submodul->delete();

        return redirect()
            ->route('admin.moduls.submoduls.index', $modul->id)
            ->with('success', 'Submodul dan semua media berhasil dihapus.');
    }

    private function resetSortOrder($modulId)
    {
        $submoduls = Submodul::where('modul_id', $modulId)
            ->orderBy('sort_order')
            ->orderBy('created_at')
            ->get();

        $order = 1;
        foreach ($submoduls as $submodul) {
            $submodul->update(['sort_order' => $order++]);
        }
    }
}
