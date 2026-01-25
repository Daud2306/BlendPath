<?php

namespace App\Http\Controllers;

use App\Models\Tanya;
use App\Models\Jawab;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use HTMLPurifier;
use HTMLPurifier_Config;


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

    private function containsMedia($html)
    {
        return (strpos($html, '<img') !== false) ||
            (strpos($html, '<video') !== false) ||
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
