<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Tutorial;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $roadmapId)
    {
        dd($request->all(), $request->file('resources'));
        // Validasi input
        $validated = $request->validate([
            'judul'          => 'required|string|max:255',
            'deskripsi'      => 'nullable|string',
            'konten'         => 'nullable|string',
            'sort_order'     => 'nullable|integer',
            'resource_link' => 'nullable|array',
            'resource_link.*' => 'nullable|string|max:255',
        ]);

        // Simpan tutorial
        $tutorial = Tutorial::create([
            'roadmap_id' => $roadmapId,
            'judul'      => $validated['judul'],
            'deskripsi'  => $validated['deskripsi'] ?? '',
            'konten'     => $validated['konten'] ?? '',
            'sort_order' => $validated['sort_order'] ?? 1,
        ]);

        // Simpan resources (jika ada)
        if ($request->filled('resource_links')) {
            foreach ($request->resource_links as $link) {
                if (!empty($link)) {
                    Resource::create([
                        'tutorial_id'   => $tutorial->id,
                        'resource_link' => $link,
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.roadmaps.tutorials.index', $roadmapId)
            ->with('success', 'Tutorial berhasil dibuat beserta resources.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Resource $resource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resource $resource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resource $resource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        //
    }
}
