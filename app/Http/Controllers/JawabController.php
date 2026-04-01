<?php

namespace App\Http\Controllers;

use App\Models\Jawab;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class JawabController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tanya_id' => 'required|exists:tanyas,id',
            'jawaban' => 'required',
            'gambar_jawaban.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $jawab = Jawab::create([
            'user_id' => Auth::id(),
            'tanya_id' => $request->tanya_id,
            'jawaban' => $request->jawaban
        ]);

        if ($request->hasFile('gambar_jawaban')) {
            foreach ($request->file('gambar_jawaban') as $gambar) {
                if ($gambar->isValid()) {
                    $path = $gambar->store('resources', 'public');

                    Resource::create([
                        'user_id'          => Auth::id(),
                        'path'             => $path,
                        'type'             => 'image',
                        'resourceable_id'  => $jawab->id,
                        'resourceable_type' => Jawab::class,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Jawaban berhasil dikirim!');
    }

    public function edit(Jawab $jawab)
    {
        $this->authorize('update', $jawab);
        return view('jawabs.edit', compact('jawab'));
    }

    public function update(Request $request, Jawab $jawab)
    {
        $this->authorize('update', $jawab);

        $request->validate([
            'jawaban' => 'required|min:5',
        ]);

        $jawab->update([
            'jawaban' => $request->jawaban,
        ]);

        return redirect()->back()->with('success', 'Jawaban berhasil diperbarui!');
    }

    public function destroy(Jawab $jawab)
    {
        $this->authorize('delete', $jawab);

        $jawab->delete();
        return redirect()->back()->with('success', 'Jawaban berhasil dihapus!');
    }
}
