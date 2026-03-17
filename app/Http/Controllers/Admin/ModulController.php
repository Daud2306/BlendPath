<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modul;
use App\Models\Submodul;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ModulController extends Controller
{
    public function index()
    {
        $moduls = Modul::orderBy('sort_order')->paginate(10);
        return view('admin.moduls.index', compact('moduls'));
    }

    public function create()
    {
        return view('admin.moduls.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image',
            'sort_order' => 'required|integer',
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('moduls', 'public');
            $data['gambar'] = $path;
        }

        Modul::create($data);

        return redirect()->route('admin.moduls.index')->with('success', 'Modul berhasil dibuat.');
    }

    public function show(Modul $modul)
    {
        $submoduls = $modul->submoduls()->orderBy('sort_order')->get();
        return view('admin.submoduls.index', compact('modul', 'submoduls'));
    }

    public function edit(Modul $modul)
    {
        return view('admin.moduls.edit', compact('modul'));
    }

    public function update(Request $request, Modul $modul)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'sort_order' => 'required|integer',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['judul', 'deskripsi', 'sort_order']);

        if ($request->hasFile('gambar')) {
            if ($modul->gambar) {
                Storage::disk('public')->delete($modul->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('moduls', 'public');
        }

        $modul->update($data);

        return redirect()->route('admin.moduls.index')
            ->with('success', 'Modul updated successfully!');
    }

    public function destroy(Request $request, Modul $modul)
    {
        if ($modul->gambar) {
            Storage::disk('public')->delete($modul->gambar);
        }

        $modul->delete();

        return redirect()->route('admin.moduls.index')->with('success', 'Modul berhasil dihapus.');
    }
}
