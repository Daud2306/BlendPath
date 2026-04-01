<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Showcase;
use App\Models\ShowcaseKomentar;
use Illuminate\Http\Request;

class ShowcaseController extends Controller
{
    public function index()
    {
        $showcases = Showcase::with(['user', 'resources', 'komentars'])
            ->latest()
            ->paginate(15);

        return view('admin.showcase.index', compact('showcases'));
    }

    public function show(Showcase $showcase)
    {
        $showcase->load([
            'user',
            'resources',
            'komentars'      => fn($q) => $q->latest(),
            'komentars.user',
        ]);

        return view('admin.showcase.show', compact('showcase'));
    }

    public function destroy(Showcase $showcase)
    {
        $showcase->delete();

        return redirect()->route('admin.showcase.index')
            ->with('success', 'Showcase "' . $showcase->judul . '" berhasil dihapus.');
    }

    public function destroyKomentar(ShowcaseKomentar $komentar)
    {
        $showcase = $komentar->showcase;
        $komentar->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
