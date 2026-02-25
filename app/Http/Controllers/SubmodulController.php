<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Submodul;
use App\Models\Modul;
use App\Models\Resource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SubmodulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function userIndex(Modul $modul)
    {
        $submoduls = Submodul::where('modul_id', $modul->id)
            ->orderBy('sort_order')
            ->paginate(12);

        return view('user.submoduls.index', compact('modul', 'submoduls'));
    }

    public function userShow(Modul $modul, $sort_order)
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
                return redirect()
                    ->route('moduls.submoduls.show', [
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

        return view('user.submoduls.show', compact(
            'modul',
            'submodul',
            'prevSubmodul',
            'nextSubmodul',
            'modulProgress'
        ));
    }

    public function adminIndex(Modul $modul)
    {
        $submoduls = Submodul::where('modul_id', $modul->id)
            ->orderBy('sort_order')
            ->paginate(20);

        return view('admin.submoduls.index', compact('modul', 'submoduls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Modul $modul)
    {
        return view('admin.submoduls.create', compact('modul'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
                        'submodul_id' => $submodul->id,
                        'resource'    => $path,
                    ]);
                }
            }
        }

        if ($request->filled('resource')) {
            Resource::create([
                'submodul_id' => $submodul->id,
                'resource'    => trim($request->input('resource')),
            ]);
        }

        return redirect()
            ->route('admin.moduls.submoduls.index', $modulId)
            ->with('success', 'Submodul berhasil dibuat.');
    }

    public function adminShow(Modul $modul, Submodul $submodul)
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modul $modul, Submodul $submodul)
    {
        if ($submodul->modul_id !== $modul->id) {
            abort(404);
        }

        return view('admin.submoduls.edit', compact('modul', 'submodul'));
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modul $modul, Submodul $submodul)
    {
        if ($submodul->modul_id !== $modul->id) {
            abort(404);
        }

        foreach ($submodul->resources as $resource) {

            if (!Str::startsWith($resource->resource, ['http://', 'https://'])) {
                Storage::disk('public')->delete($resource->resource);
            }
        }
        $submodul->resources()->delete();

        $submodul->delete();

        return redirect()
            ->route('admin.moduls.submoduls.index', $modul->id)
            ->with('success', 'Submodul dan semua media berhasil dihapus.');
    }

    public function updateResources(Request $request, Modul $modul, Submodul $submodul)
    {
        $request->validate([
            'resources.*'   => 'nullable|file|max:20480|mimes:jpg,jpeg,png,gif,mp4,mov,webm,zip,pdf',
            'resource'      => 'nullable|url|max:1000',
            'resource_id'   => 'nullable|integer|exists:resources,id',
        ]);

        $messages = [];

        if ($request->hasFile('resources')) {
            foreach ($request->file('resources') as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('submoduls/resources', 'public');
                    Resource::create([
                        'submodul_id' => $submodul->id,
                        'resource'    => $path,
                    ]);
                    $messages[] = 'File uploaded: ' . basename($path);
                }
            }
        }

        if ($request->filled('resource')) {
            $resourceUrl = trim($request->input('resource'));

            if ($request->filled('resource_id')) {
                $res = Resource::find($request->input('resource_id'));

                if (! $res || $res->submodul_id !== $submodul->id) {
                    return back()->withErrors('Invalid resource selected for update.');
                }

                if (! Str::startsWith($res->resource, ['http://', 'https://'])) {
                    if (Storage::disk('public')->exists($res->resource)) {
                        Storage::disk('public')->delete($res->resource);
                    }
                }

                $res->update(['resource' => $resourceUrl]);
                $messages[] = 'Resource link updated.';
            } else {
                Resource::create([
                    'submodul_id' => $submodul->id,
                    'resource'    => $resourceUrl,
                ]);
                $messages[] = 'Resource link added.';
            }
        }

        if (empty($messages)) {
            $messages[] = 'No resources were changed.';
        }

        return back()->with('success', implode(' ', $messages));
    }

    public function destroyResource(Modul $modul, Submodul $submodul, Resource $resource)
    {

        if ($resource->submodul_id !== $submodul->id) {
            abort(403, 'Unauthorized action.');
        }

        if (!str_contains($resource->resource, 'http') && Storage::disk('public')->exists($resource->resource)) {
            Storage::disk('public')->delete($resource->resource);
        }

        $resource->delete();

        return back()->with('success', 'Resource berhasil dihapus!');
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

    public function complete(Modul $modul, $sort_order)
    {
        $submodul = Submodul::where('modul_id', $modul->id)
            ->where('sort_order', $sort_order)
            ->firstOrFail();

        $submodul->markAsCompleted();

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
