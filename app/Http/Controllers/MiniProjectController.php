<?php

namespace App\Http\Controllers;

use App\Models\MiniProject;
use App\Models\MiniProjectSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MiniProjectController extends Controller
{
    public function store(Request $request, MiniProject $miniProject)
    {
        $request->validate([
            'catatan' => 'nullable|string',
            'files'   => 'required|array|min:1',
            'files.*' => 'file|max:20480',
        ]);

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'blend', 'zip'];
        foreach ($request->file('files') as $file) {
            $ext = strtolower($file->getClientOriginalExtension());
            if (!in_array($ext, $allowedExtensions)) {
                return back()->withErrors(['files.*' => 'Format file tidak diizinkan.']);
            }
        }

        $existing = $miniProject->submissions()->where('user_id', Auth::id())->first();

        if ($existing && $existing->status === 'approved') {
            return back()->with('error', 'Tugas Anda sudah disetujui.');
        }
        if ($existing && $existing->status === 'submitted') {
            return back()->with('error', 'Tugas sedang menunggu review.');
        }

        // Hapus submission lama jika rejected
        if ($existing) {
            foreach ($existing->resources as $res) {
                Storage::disk('google')->delete($res->path); // ← ganti ke google
                $res->delete();
            }
            $existing->delete();
        }

        $submission = MiniProjectSubmission::create([
            'mini_project_id' => $miniProject->id,
            'user_id'         => Auth::id(),
            'catatan'         => $request->catatan,
            'status'          => 'submitted',
            'submitted_at'    => now(),
        ]);

        foreach ($request->file('files') as $file) {
            $ext      = strtolower($file->getClientOriginalExtension());
            $filename = 'mini-project-submissions/' . Str::uuid() . '.' . $ext;

            // ← Upload ke Google Drive
            Storage::disk('google')->put($filename, file_get_contents($file));

            $submission->resources()->create([
                'path'          => $filename,
                'type'          => in_array($ext, ['blend', 'zip']) ? 'blend' : 'image',
                'mime_type'     => $file->getMimeType(),
                'size'          => $file->getSize(),
                'original_name' => $file->getClientOriginalName(),
            ]);
        }

        return back()->with('success', 'Tugas berhasil dikirim!');
    }

    public function resubmit(MiniProject $miniProject)
    {
        $submission = $miniProject->userSubmission();
        if ($submission && $submission->status === 'rejected') {
            foreach ($submission->resources as $res) {
                Storage::disk('google')->delete($res->path); // ← ganti ke google
                $res->delete();
            }
            $submission->delete();
            return back()->with('success', 'Submission lama dihapus. Silakan upload ulang.');
        }
        return back()->with('error', 'Tidak dapat mengulang submission ini.');
    }

    // ← Tambahan: untuk menampilkan/download file dari Google Drive
    public function serveFile(MiniProjectSubmission $submission, int $resourceId)
    {
        // Pastikan hanya pemilik atau admin yang bisa akses
        abort_unless(
            Auth::id() === $submission->user_id || Auth::user()->role === 'admin',
            403
        );

        $resource = $submission->resources()->findOrFail($resourceId);

        $file = Storage::disk('google')->get($resource->path);

        return response($file, 200)
            ->header('Content-Type', $resource->mime_type)
            ->header('Content-Disposition', 'inline; filename="' . $resource->original_name . '"');
    }
}
