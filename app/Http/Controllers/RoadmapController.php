<?php

namespace App\Http\Controllers;

use App\Models\Roadmap;
use App\Models\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoadmapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roadmaps = Roadmap::orderBy('sort_order')->paginate(5);
        return view('user.roadmaps.index', compact('roadmaps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roadmaps.create');
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
            $path = $request->file('gambar')->store('roadmaps', 'public');
            $data['gambar'] = $path;
        }

        Roadmap::create($data);

        return redirect()->route('admin.roadmaps.index')->with('success', 'Roadmap berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Roadmap $roadmap, Request $request)
    {
        $query = Tutorial::where('roadmap_id', $roadmap->id);

        $tutorials = $query->paginate(10);

        $progress = $roadmap->getUserProgress();

        return view('user.roadmaps.show', compact('roadmap', 'tutorials', 'progress'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Roadmap $roadmap)
    {
        return view('admin.roadmaps.edit', compact('roadmap'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Roadmap $roadmap)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'sort_order' => 'required|integer',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['judul', 'deskripsi', 'sort_order']);

        if ($request->hasFile('gambar')) {
            if ($roadmap->gambar) {
                Storage::disk('public')->delete($roadmap->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('roadmaps', 'public');
        }

        $roadmap->update($data);

        return redirect()->route('admin.roadmaps.index')
            ->with('success', 'Roadmap updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Roadmap $roadmap)
    {
        if ($roadmap->gambar) {
            Storage::disk('public')->delete($roadmap->gambar);
        }

        $roadmap->delete();

        return redirect()->route('admin.roadmaps.index')->with('success', 'Roadmap berhasil dihapus.');
    }

    public function adminIndex()
    {
        $roadmaps = Roadmap::orderBy('sort_order')->paginate(10);
        return view('admin.roadmaps.index', compact('roadmaps'));
    }

    public function adminShow(Roadmap $roadmap)
    {
        $tutorials = $roadmap->tutorials()->orderBy('sort_order')->get();
        return view('admin.tutorials.index', compact('roadmap', 'tutorials'));
    }
}
