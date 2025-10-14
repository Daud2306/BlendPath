<?php

namespace App\Http\Controllers;

use App\Models\Jawab;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class JawabController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

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
                        'jawab_id' => $jawab->id,
                        'resource' => $path
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Jawaban berhasil dikirim!');
    }

    public function destroy(Jawab $jawab)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($jawab->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $jawab->delete();
        return redirect()->back()->with('success', 'Jawaban berhasil dihapus!');
    }
}
