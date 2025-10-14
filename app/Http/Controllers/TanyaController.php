<?php

namespace App\Http\Controllers;

use App\Models\Tanya;
use App\Models\Resource;
use App\Models\Tutorial;
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
        $tanyas = Tanya::with(['user', 'tutorial.roadmap'])->latest()->get();
        return view('admin.tanyas.index', compact('tanyas'));
    }

    public function adminDestroy(Tanya $tanya)
{
    $tutorial = $tanya->tutorial;
    $roadmap = $tutorial->roadmap;

    $tanya->delete();

    return redirect()->route('admin.roadmaps.tutorials.show', [$roadmap->id, $tutorial->id])
                     ->with('success', 'Pertanyaan berhasil dihapus!');
}

    /**
     * Show the form for creating a new resource.
     */
    public function create($tutorial_id)
    {
        $tutorial = Tutorial::findOrFail($tutorial_id);
        return view('user.tutorials.show', compact('tutorial'))
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
            'tutorial_id' => 'required|exists:tutorials,id',
            'pertanyaan' => 'required|min:5',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $tanya = Tanya::create([
            'user_id' => Auth::id(),
            'tutorial_id' => $request->tutorial_id,
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

        return redirect()->back()->with('success', 'Pertanyaan berhasil dikirim!');
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

        $tutorial = $tanya->tutorial;

        return redirect()->route('roadmaps.tutorials.show', [
            $tutorial->roadmap_id,
            $tutorial->id
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
        $tanyas = Tanya::with('user', 'tutorial')->latest()->get();
        return view('admin.qna.index', compact('tanyas'));
    }

    public function indexUser($tutorialId)
    {
        $tutorial = Tutorial::findOrFail($tutorialId);
        $tanyas = $tutorial->tanyas()->with('user')->latest()->get();

        return view('user.qna.index', compact('tutorial', 'tanyas'));
    }

    public function show($id)
    {
        $tanya = Tanya::with(['user', 'tutorial', 'jawabs.user'])->findOrFail($id);
        return view('user.qna.show', compact('tanya'));
    }
}
