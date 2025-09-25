<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use App\Models\Roadmap;
use App\Models\Resource;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function userIndex(Roadmap $roadmap)
    {
        // Ambil tutorial yang punya roadmap_id sesuai parameter
        $tutorials = Tutorial::where('roadmap_id', $roadmap->id)
            ->orderBy('sort_order')
            ->paginate(12);

        return view('user.tutorials.index', compact('roadmap', 'tutorials'));
    }

    public function userShow(Roadmap $roadmap, Tutorial $tutorial)
    {
        // Pastikan tutorial memang milik roadmap ini
        if ($tutorial->roadmap_id !== $roadmap->id) {
            abort(404);
        }

        return view('user.tutorials.show', compact('roadmap', 'tutorial'));
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
        // validasi sederhana
        $request->validate([
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'konten'          => 'nullable|string',
            'sort_order'      => 'nullable|integer',
            'resources.*'     => 'nullable|file|max:20480',   // file uploads
            'resource'        => 'nullable|string|max:1000',  // single link / iframe
            'resource_links'  => 'nullable',                  // textarea atau array
            'resource_links.*' => 'nullable|string|max:1000',
        ]);

        // 1) Simpan tutorial
        $tutorial = \App\Models\Tutorial::create([
            'roadmap_id' => $roadmapId,
            'judul'      => $request->input('judul'),
            'deskripsi'  => $request->input('deskripsi', ''),
            'konten'     => $request->input('konten', ''),
            'sort_order' => $request->input('sort_order', 0),
        ]);

        // 2) Simpan file uploads (resources[])
        if ($request->hasFile('resources')) {
            foreach ($request->file('resources') as $file) {
                if ($file && $file->isValid()) {
                    // simpan file di storage/app/public/resources
                    $path = $file->store('resources', 'public');

                    \App\Models\Resource::create([
                        'tutorial_id'   => $tutorial->id,
                        'resource_link' => $path,
                    ]);
                }
            }
        }

        // 3) Simpan single resource (input name="resource")
        if ($request->filled('resource')) {
            $link = trim($request->input('resource'));
            if ($link !== '') {
                \App\Models\Resource::create([
                    'tutorial_id'   => $tutorial->id,
                    'resource_link' => $link,
                ]);
            }
        }

        // 4) Simpan resource_links (textarea multiline atau array)
        $rawLinks = $request->input('resource_links');
        if ($rawLinks) {
            // jika bukan array, pecah per baris (meng-handle textarea multiline)
            if (!is_array($rawLinks)) {
                $rawLinks = preg_split("/\r\n|\n|\r/", (string) $rawLinks);
            }

            foreach ($rawLinks as $link) {
                $link = trim((string)$link);
                if ($link === '') continue;

                \App\Models\Resource::create([
                    'tutorial_id'   => $tutorial->id,
                    'resource_link' => $link,
                ]);
            }
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

        return view('admin.tutorials.show', compact('roadmap', 'tutorial'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Tutorial $tutorial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Roadmap $roadmap, Tutorial $tutorial)
    {
        if ($tutorial->roadmap_id !== $roadmap->id) {
            abort(404);
        }

        return view('admin.roadmaps.tutorials.edit', compact('roadmap', 'tutorial'));
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
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'konten' => 'required|string',
            'sort_order' => 'nullable|integer',
        ]);

        $tutorial->update($data);

        return redirect()->route('admin.roadmaps.tutorials.index', $roadmap)
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

        $tutorial->delete();

        return redirect()->route('admin.roadmaps.tutorials.index', $roadmap)
            ->with('success', 'Tutorial berhasil dihapus.');
    }
}
