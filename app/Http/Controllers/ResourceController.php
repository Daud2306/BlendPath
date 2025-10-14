<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Tutorial;
use Illuminate\Http\Request;

class ResourceController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $roadmapId)
    {
        $validated = $request->validate([
            'judul'          => 'required|string|max:255',
            'konten'         => 'nullable|string',
            'sort_order'     => 'nullable|integer',
            'resource_link' => 'nullable|array',
            'resource_link.*' => 'nullable|string|max:255',
        ]);

        $tutorial = Tutorial::create([
            'roadmap_id' => $roadmapId,
            'judul'      => $validated['judul'],
            'konten'     => $validated['konten'] ?? '',
            'sort_order' => $validated['sort_order'] ?? 1,
        ]);

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

}
