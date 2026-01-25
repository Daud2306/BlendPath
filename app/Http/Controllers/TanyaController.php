<?php

namespace App\Http\Controllers;

use App\Models\Tanya;
use App\Models\Resource;
use App\Models\Submodul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TanyaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tanyas = Tanya::with(['user', 'submodul.modul'])->latest()->get();
        return view('admin.tanyas.index', compact('tanyas'));
    }

    public function adminDestroy(Tanya $tanya)
    {
        $submodul = $tanya->submodul;
        $modul = $submodul->modul;

        $tanya->delete();

        return redirect()->route('admin.moduls.submoduls.show', [$modul->id, $submodul->id])
            ->with('success', 'Pertanyaan berhasil dihapus!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($submodul_id)
    {
        $submodul = Submodul::findOrFail($submodul_id);
        return view('user.submoduls.show', compact('submodul'))
            ->with('user', Auth::user());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'submodul_id' => 'required|exists:submoduls,id',
            'pertanyaan' => 'required|min:5',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $tanya = Tanya::create([
            'user_id' => Auth::id(),
            'submodul_id' => $request->submodul_id,
            'pertanyaan' => $request->pertanyaan
        ]);

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $gambar) {
                if ($gambar->isValid()) {
                    $path = $gambar->store('resources', 'public');

                    Resource::create([
                        'tanya_id' => $tanya->id,
                        'resource' => $path
                    ]);
                }
            }
        }

        // Redirect biasa tanpa JavaScript
        return redirect()->back()
            ->with('success', 'Pertanyaan berhasil dikirim!')
            ->with('scroll_to', 'qna-section');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tanya = Tanya::findOrFail($id);

        if ($tanya->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak dapat mengedit pertanyaan ini.');
        }

        return view('tanyas.edit', compact('tanya'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tanya = Tanya::findOrFail($id);

        if ($tanya->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'pertanyaan' => 'required|min:5',
        ]);

        $tanya->update([
            'pertanyaan' => $request->pertanyaan,
        ]);

        $submodul = $tanya->submodul;

        return redirect()->route('moduls.submoduls.show', [
            $submodul->modul_id,
            $submodul->id
        ])->with('success', 'Pertanyaan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tanya $tanya)
    {
        if ($tanya->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda hanya bisa menghapus pertanyaan sendiri.');
        }

        $tanya->delete();
        return redirect()->back()->with('success', 'Pertanyaan berhasil dihapus!');
    }

    public function indexAdmin()
    {
        $tanyas = Tanya::with('user', 'submodul')->latest()->get();
        return view('admin.qna.index', compact('tanyas'));
    }

    public function indexUser($submodulId)
    {
        $submodul = Submodul::findOrFail($submodulId);
        $tanyas = $submodul->tanyas()->with('user')->latest()->get();

        return view('user.qna.index', compact('submodul', 'tanyas'));
    }

    public function show($id)
    {
        $tanya = Tanya::with(['user', 'submodul', 'jawabs.user'])->findOrFail($id);
        return view('user.qna.show', compact('tanya'));
    }

    private function containsMedia($html)
    {
        return (strpos($html, '<img') !== false) ||
            (strpos($html, '<iframe') !== false);
    }

    /**
     * Track media usage dalam konten
     */
    private function trackMediaUsage($html, $contentId, $contentType)
    {
        // Ekstrak semua media URLs dari HTML
        preg_match_all('/src="([^"]+)"/', $html, $matches);

        foreach ($matches[1] as $url) {
            // Cari resource berdasarkan URL
            $path = $this->extractPathFromUrl($url);
            if ($path) {
                // Update resource record untuk tracking
                Resource::where('resource', 'like', '%' . $path . '%')
                    ->update([
                        'used_in_content_id' => $contentId,
                        'used_in_content_type' => $contentType
                    ]);
            }
        }
    }

    /**
     * Ekstrak path dari URL
     */
    private function extractPathFromUrl($url)
    {
        $parsed = parse_url($url);
        if (isset($parsed['path'])) {
            // Hilangkan /storage/ dari path
            return str_replace('/storage/', '', $parsed['path']);
        }
        return null;
    }
}
