<?php

namespace App\Http\Controllers;

use App\Models\Roadmap;
use Illuminate\Http\Request;

class RoadmapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roadmaps = Roadmap::with('tutorials')->orderBy('sort_order')->get();
        return view('admin.roadmap.index', compact('roadmaps'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'sort_order' => 'required|integer',
        ]);

        Roadmap::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'sort_order' => $request->sort_order,
        ]);

        return redirect()->route('admin.roadmap.index')->with('success', 'Roadmap berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $roadmap = Roadmap::findOrFail($id);

        return view('admin.roadmap.show', compact('roadmap'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
