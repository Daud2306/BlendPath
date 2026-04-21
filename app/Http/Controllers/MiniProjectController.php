<?php

namespace App\Http\Controllers;

use App\Models\MiniProject;
use App\Models\MiniProjectSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MiniProjectController extends Controller
{
    public function store(Request $request, MiniProject $miniProject)
    {
        // Validasi: files harus ada minimal 1 file
        $request->validate([
            'catatan' => 'nullable|string',
            'files' => 'required|array|min:1',           // ← minimal satu file
            'files.*' => 'file|max:20480',               // ← setiap file maks 20MB
        ]);

        // Validasi ekstensi manual
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'blend'];
        foreach ($request->file('files') as $file) {
            $ext = strtolower($file->getClientOriginalExtension());
            if (!in_array($ext, $allowedExtensions)) {
                return back()->withErrors(['files.*' => 'Format file tidak diizinkan. Hanya gambar (jpg, png, gif, webp) atau file .blend.']);
            }
        }

        // Cek apakah sudah pernah submit
        $existing = $miniProject->submissions()->where('user_id', Auth::id())->first();

        // Jika sudah ada submission dengan status 'approved', tolak
        if ($existing && $existing->status === 'approved') {
            return back()->with('error', 'Tugas Anda sudah disetujui, tidak dapat mengirim ulang.');
        }

        // Jika sudah ada submission dengan status 'submitted', tolak
        if ($existing && $existing->status === 'submitted') {
            return back()->with('error', 'Anda sudah mengirim tugas untuk project ini dan sedang menunggu review.');
        }

        // Hapus submission lama jika status 'rejected'
        if ($existing) {
            foreach ($existing->resources as $res) {
                Storage::disk('public')->delete($res->path);
                $res->delete();
            }
            $existing->delete();
        }

        $submission = MiniProjectSubmission::create([
            'mini_project_id' => $miniProject->id,
            'user_id' => Auth::id(),
            'catatan' => $request->catatan,
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        // Simpan file-file yang diupload
        $files = $request->file('files');
        if ($files && is_array($files)) {
            foreach ($files as $file) {
                $path = $file->store('mini-project-submissions', 'public');
                $submission->resources()->create([
                    'path' => $path,
                    'type' => $file->getClientOriginalExtension() === 'blend' ? 'blend' : 'image',
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return back()->with('success', 'Tugas berhasil dikirim!');
    }

    public function resubmit(MiniProject $miniProject)
    {
        $submission = $miniProject->userSubmission();
        if ($submission && $submission->status === 'rejected') {
            foreach ($submission->resources as $res) {
                Storage::disk('public')->delete($res->path);
                $res->delete();
            }
            $submission->delete();
            return back()->with('success', 'Submission lama dihapus. Silakan upload ulang tugas Anda.');
        }
        return back()->with('error', 'Tidak dapat mengulang submission ini.');
    }
}
