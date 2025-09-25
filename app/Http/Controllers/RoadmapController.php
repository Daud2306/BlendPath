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
        // Urut berdasarkan sort_order (lebih kecil = lebih atas)
        $roadmaps = Roadmap::orderBy('sort_order')->paginate(12);
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
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image',
            'sort_order' => 'nullable|integer',
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

        // pencarian sederhana
        if ($q = $request->query('q')) {
            $query->where(function ($w) use ($q) {
                $w->where('judul', 'like', "%{$q}%")
                    ->orWhere('deskripsi', 'like', "%{$q}%")
                    ->orWhere('konten', 'like', "%{$q}%");
            });
        }

        // sorting
        $sort = $request->query('sort', 'default');
        switch ($sort) {
            case 'new':
                $query->orderBy('created_at', 'desc');
                break;
            case 'old':
                $query->orderBy('created_at', 'asc');
                break;
            case 'sort_desc':
                $query->orderBy('sort_order', 'desc');
                break;
            case 'sort_asc':
            default:
                $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
                break;
        }

        // paginate supaya halaman tetap ringan (ubah angka sesuai kebutuhan)
        $tutorials = $query->paginate(12);

        return view('user.roadmaps.detail', compact('roadmap', 'tutorials'));
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
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        // kalau upload gambar baru: hapus file lama (jika ada) lalu simpan file baru
        if ($request->hasFile('gambar')) {
            // hapus gambar lama jika ada
            if ($roadmap->gambar) {
                Storage::disk('public')->delete($roadmap->gambar);
            }
            $path = $request->file('gambar')->store('roadmaps', 'public');
            $data['gambar'] = $path;
        }

        $roadmap->update($data);

        return redirect()->route('admin.roadmaps.index')->with('success', 'Roadmap berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Roadmap $roadmap)
    {
        // hapus gambar jika ada
        if ($roadmap->gambar) {
            Storage::disk('public')->delete($roadmap->gambar);
        }

        $roadmap->delete();

        return redirect()->route('admin.roadmaps.index')->with('success', 'Roadmap berhasil dihapus.');
    }

    public function adminIndex()
    {
        $roadmaps = Roadmap::orderBy('sort_order')->paginate(20);
        return view('admin.roadmaps.index', compact('roadmaps'));
    }
}
