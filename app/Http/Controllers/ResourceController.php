<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Submodul;
use Illuminate\Http\Request;

class ResourceController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $modulId)
    {
        $validated = $request->validate([
            'judul'          => 'required|string|max:255',
            'konten'         => 'nullable|string',
            'sort_order'     => 'nullable|integer',
            'resource_link' => 'nullable|array',
            'resource_link.*' => 'nullable|string|max:255',
        ]);

        $submodul = Submodul::create([
            'modul_id' => $modulId,
            'judul'      => $validated['judul'],
            'konten'     => $validated['konten'] ?? '',
            'sort_order' => $validated['sort_order'] ?? 1,
        ]);

        if ($request->filled('resource_links')) {
            foreach ($request->resource_links as $link) {
                if (!empty($link)) {
                    Resource::create([
                        'submodul_id'   => $submodul->id,
                        'resource_link' => $link,
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.moduls.submoduls.index', $modulId)
            ->with('success', 'Submodul berhasil dibuat beserta resources.');
    }

}
