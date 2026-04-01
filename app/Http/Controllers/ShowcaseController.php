<?php

namespace App\Http\Controllers;

use App\Models\Showcase;
use App\Models\ShowcaseKomentar;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowcaseController extends Controller
{
    public function index()
    {
        $showcases = Showcase::with(['user', 'resources', 'komentars'])
            ->latest()
            ->paginate(12);

        return view('user.showcase.index', compact('showcases'));
    }

    public function show(Showcase $showcase)
    {
        $showcase->load([
            'user',
            'resources',
            'komentars' => fn($q) => $q->latest(),
            'komentars.user',
        ]);

        return view('user.showcase.show', compact('showcase'));
    }

    public function create()
    {
        return view('user.showcase.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:2000',
            'media'     => 'required|array|min:1|max:5',
            'media.*'   => 'file|mimes:jpg,jpeg,png,gif,webp,mp4,mov|max:102400',
        ]);

        $showcase = Showcase::create([
            'user_id'   => Auth::id(),
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
        ]);

        foreach ($request->file('media') as $file) {
            $path = $file->store('showcases', 'public');

            Resource::create([
                'user_id'           => Auth::id(),
                'resourceable_id'   => $showcase->id,
                'resourceable_type' => Showcase::class,
                'path'              => $path,
                'type'              => str_starts_with($file->getMimeType(), 'video/') ? 'video' : 'image',
                'mime_type'         => $file->getMimeType(),
                'size'              => $file->getSize(),
                'original_name'     => $file->getClientOriginalName(),
            ]);
        }

        return redirect()->route('learn.showcase.show', $showcase)
            ->with('success', 'Karya berhasil diupload!');
    }

    public function destroy(Showcase $showcase)
    {
        abort_unless(Auth::id() === $showcase->user_id, 403);
        $showcase->delete();

        return redirect()->route('learn.showcase.index')
            ->with('success', 'Karya berhasil dihapus.');
    }

    public function storeKomentar(Request $request, Showcase $showcase)
    {
        $request->validate([
            'komentar' => 'required|string|max:1000',
        ]);

        $showcase->komentars()->create([
            'user_id'  => Auth::id(),
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Komentar ditambahkan!');
    }

    public function destroyKomentar(ShowcaseKomentar $komentar)
    {
        abort_unless(Auth::id() === $komentar->user_id || Auth::user()->isAdmin(), 403);
        $komentar->delete();

        return back()->with('success', 'Komentar dihapus.');
    }
}
