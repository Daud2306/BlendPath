<?php

namespace App\Http\Controllers;

use App\Models\Tanya;
use App\Models\Resource;
use App\Models\Submodul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\HandlesMediaFromHtml;

class TanyaController extends Controller
{
    use HandlesMediaFromHtml;

    public function store(Request $request)
    {
        $request->validate([
            'submodul_id' => 'required|exists:submoduls,id',
            'pertanyaan'  => 'required|min:5',
            'gambar.*'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $tanya = Tanya::create([
            'user_id'     => Auth::id(),
            'submodul_id' => $request->submodul_id,
            'pertanyaan'  => $request->pertanyaan,
        ]);

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $gambar) {
                if ($gambar->isValid()) {
                    $path = $gambar->store('resources', 'public');
                    Resource::create([
                        'user_id'          => Auth::id(),
                        'path'             => $path,
                        'type'             => 'image',
                        'resourceable_id'  => $tanya->id,
                        'resourceable_type' => Tanya::class,
                    ]);
                }
            }
        }

        $this->attachMediaFromHtml($request->pertanyaan, $tanya);

        return redirect()->back()
            ->with('success', 'Pertanyaan berhasil dikirim!')
            ->with('scroll_to', 'qna-section');
    }

    public function edit($id)
    {
        $tanya = Tanya::findOrFail($id);

        $this->authorize('update', $tanya);

        return view('tanyas.edit', compact('tanya'));
    }

    public function update(Request $request, Tanya $tanya)
    {
        $this->authorize('update', $tanya);

        $request->validate([
            'pertanyaan' => 'required|min:5',
        ]);

        $tanya->update([
            'pertanyaan' => $request->pertanyaan,
        ]);

        $submodul = $tanya->submodul;

        return redirect()->route('learn.submoduls.show', [
            'modul'      => $submodul->modul_id,
            'sort_order' => $submodul->sort_order,
        ]);
    }

    public function destroy(Tanya $tanya)
    {
        $this->authorize('delete', $tanya);

        $tanya->delete();

        return back()->with('success', 'Pertanyaan berhasil dihapus!');
    }
}
