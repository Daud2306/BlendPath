<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Tutorial;
use App\Models\Roadmap;
use App\Models\Resource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function userIndex(Roadmap $roadmap)
    {
        $tutorials = Tutorial::where('roadmap_id', $roadmap->id)
            ->orderBy('sort_order')
            ->paginate(12);

        return view('user.tutorials.index', compact('roadmap', 'tutorials'));
    }

    public function userShow(Roadmap $roadmap, $sort_order)
    {
        $tutorial = Tutorial::where('roadmap_id', $roadmap->id)
            ->where('sort_order', $sort_order)
            ->firstOrFail();

        // CEK TUTORIAL SEBELUMNYA YANG BELUM SELESAI
        if (Auth::check()) {
            $previousTutorial = Tutorial::where('roadmap_id', $roadmap->id)
                ->where('sort_order', '<', $tutorial->sort_order)
                ->whereDoesntHave('progress', function ($query) {
                    $query->where('user_id', Auth::id())
                        ->where('is_completed', true);
                })
                ->orderBy('sort_order', 'desc')
                ->first();

            if ($previousTutorial && $tutorial->sort_order > 1) {
                return redirect()
                    ->route('roadmaps.tutorials.show', [
                        'roadmap' => $roadmap->id,
                        'sort_order' => $previousTutorial->sort_order
                    ])
                    ->with('error', 'Silakan selesaikan tutorial sebelumnya terlebih dahulu: ' . $previousTutorial->judul);
            }
        }

        // Load relations dengan urutan yang benar - PERTANYAAN TERBARU DI ATAS
        $tutorial->load([
            'resources',
            'tanya' => function ($query) {
                $query->orderBy('created_at', 'desc'); // Pertanyaan terbaru di atas
            },
            'tanya.user',
            'tanya.jawabs' => function ($query) {
                $query->orderBy('created_at', 'asc'); // Jawaban terlama di atas (chronological)
            },
            'tanya.jawabs.user',
            'tanya.resources',
            'tanya.jawabs.resources'
        ]);

        $roadmapProgress = $roadmap->getUserProgress();

        $prevTutorial = Tutorial::where('roadmap_id', $roadmap->id)
            ->where('sort_order', '<', $tutorial->sort_order)
            ->orderBy('sort_order', 'desc')
            ->first();

        $nextTutorial = Tutorial::where('roadmap_id', $roadmap->id)
            ->where('sort_order', '>', $tutorial->sort_order)
            ->orderBy('sort_order', 'asc')
            ->first();

        return view('user.tutorials.show', compact(
            'roadmap',
            'tutorial',
            'prevTutorial',
            'nextTutorial',
            'roadmapProgress'
        ));
    }

    public function adminIndex(Roadmap $roadmap)
    {
        $tutorials = Tutorial::where('roadmap_id', $roadmap->id)
            ->orderBy('sort_order')
            ->paginate(20);

        return view('admin.tutorials.index', compact('roadmap', 'tutorials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Roadmap $roadmap)
    {
        return view('admin.tutorials.create', compact('roadmap'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $roadmapId)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'konten'          => 'nullable|string',
            'sort_order'      => 'nullable|integer|min:0',
            'resources.*'     => 'nullable|file|max:20480|mimes:jpg,jpeg,png,gif,mp4,mov,webm,zip,pdf', // aman
            'resource'        => 'nullable|url|max:1000',
            'resource_links'  => 'nullable|string',
        ]);

        $tutorial = Tutorial::create([
            'roadmap_id' => $roadmapId,
            'judul'      => $request->input('judul'),
            'konten'     => $request->input('konten', ''),
            'sort_order' => $request->input('sort_order', 0),
        ]);

        if ($request->hasFile('resources')) {
            foreach ($request->file('resources') as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('resources', 'public');
                    Resource::create([
                        'tutorial_id' => $tutorial->id,
                        'resource'    => $path,
                    ]);
                }
            }
        }

        if ($request->filled('resource')) {
            Resource::create([
                'tutorial_id' => $tutorial->id,
                'resource'    => trim($request->input('resource')),
            ]);
        }

        return redirect()
            ->route('admin.roadmaps.tutorials.index', $roadmapId)
            ->with('success', 'Tutorial berhasil dibuat.');
    }

    public function adminShow(Roadmap $roadmap, Tutorial $tutorial)
    {
        if ($tutorial->roadmap_id !== $roadmap->id) {
            abort(404);
        }

        $tutorial->load([
            'resources',
            'tanya.user',
            'tanya.jawabs.user',
            'tanya.resources',
            'tanya.jawabs.resources',
            'quizzes.pertanyaan'
        ]);

        $prevTutorial = Tutorial::where('roadmap_id', $roadmap->id)
            ->where('sort_order', '<', $tutorial->sort_order)
            ->orderBy('sort_order', 'desc')
            ->first();

        $nextTutorial = Tutorial::where('roadmap_id', $roadmap->id)
            ->where('sort_order', '>', $tutorial->sort_order)
            ->orderBy('sort_order', 'asc')
            ->first();

        return view('admin.tutorials.show', compact(
            'roadmap',
            'tutorial',
            'prevTutorial',
            'nextTutorial'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Roadmap $roadmap, Tutorial $tutorial)
    {
        if ($tutorial->roadmap_id !== $roadmap->id) {
            abort(404);
        }

        return view('admin.tutorials.edit', compact('roadmap', 'tutorial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Roadmap $roadmap, Tutorial $tutorial)
    {
        if ($tutorial->roadmap_id !== $roadmap->id) {
            abort(404);
        }

        $data = $request->validate([
            'judul'      => 'required|string|max:255',
            'konten'     => 'required|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $tutorial->update($request->only(['judul', 'deskripsi', 'konten', 'sort_order']));

        return redirect()
            ->route('admin.roadmaps.tutorials.index', $roadmap)
            ->with('success', 'Tutorial berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Roadmap $roadmap, Tutorial $tutorial)
    {
        if ($tutorial->roadmap_id !== $roadmap->id) {
            abort(404);
        }

        foreach ($tutorial->resources as $resource) {

            if (!Str::startsWith($resource->resource, ['http://', 'https://'])) {
                Storage::disk('public')->delete($resource->resource);
            }
        }
        $tutorial->resources()->delete();

        $tutorial->delete();

        return redirect()
            ->route('admin.roadmaps.tutorials.index', $roadmap->id)
            ->with('success', 'Tutorial dan semua media berhasil dihapus.');
    }

    public function updateResources(Request $request, Roadmap $roadmap, Tutorial $tutorial)
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
                    $path = $file->store('tutorials/resources', 'public');
                    Resource::create([
                        'tutorial_id' => $tutorial->id,
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

                if (! $res || $res->tutorial_id !== $tutorial->id) {
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
                    'tutorial_id' => $tutorial->id,
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

    public function destroyResource(Roadmap $roadmap, Tutorial $tutorial, Resource $resource)
    {

        if ($resource->tutorial_id !== $tutorial->id) {
            abort(403, 'Unauthorized action.');
        }

        if (!str_contains($resource->resource, 'http') && Storage::disk('public')->exists($resource->resource)) {
            Storage::disk('public')->delete($resource->resource);
        }

        $resource->delete();

        return back()->with('success', 'Resource berhasil dihapus!');
    }

    private function resetSortOrder($roadmapId)
    {
        $tutorials = Tutorial::where('roadmap_id', $roadmapId)
            ->orderBy('sort_order')
            ->orderBy('created_at')
            ->get();

        $order = 1;
        foreach ($tutorials as $tutorial) {
            $tutorial->update(['sort_order' => $order++]);
        }
    }

    public function complete(Roadmap $roadmap, $sort_order)
    {
        $tutorial = Tutorial::where('roadmap_id', $roadmap->id)
            ->where('sort_order', $sort_order)
            ->firstOrFail();

        $tutorial->markAsCompleted();

        return back()->with('success', 'Tutorial berhasil ditandai sebagai selesai!');
    }

    public function incomplete(Roadmap $roadmap, $sort_order)
    {
        $tutorial = Tutorial::where('roadmap_id', $roadmap->id)
            ->where('sort_order', $sort_order)
            ->firstOrFail();

        $tutorial->markAsIncomplete();

        return back()->with('success', 'Tutorial berhasil ditandai sebagai belum selesai.');
    }
}
