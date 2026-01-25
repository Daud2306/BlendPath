<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Resource;

class TinyMCEController extends Controller
{
    /**
     * Upload gambar dari TinyMCE
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120', // 5MB
        ]);

        if (!$request->hasFile('file')) {
            return response()->json([
                'error' => 'Tidak ada file yang diupload'
            ], 400);
        }

        $file = $request->file('file');
        $userId = Auth::id();
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        // ✅ PERBAIKI PATH: Tambahkan 'media/' di depan
        $fileName = 'img_' . $userId . '_' . Str::slug($originalName) . '_' . time() . '.' . $extension;
        $folder = 'media/tinymce-images/' . date('Y/m'); // ✅ Tambah 'media/'
        $filePath = $folder . '/' . $fileName;

        // Simpan file
        Storage::disk('public')->put($filePath, file_get_contents($file));

        // Buat URL publik
        $publicUrl = Storage::url($filePath); // Akan jadi: /storage/media/tinymce-images/...

        // Simpan ke tabel resources
        $resource = Resource::create([
            'user_id' => $userId,
            'resource' => $filePath,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'original_name' => $originalName . '.' . $extension,
            'type' => 'tinymce_image'
        ]);

        return response()->json([
            'location' => asset($publicUrl), // Contoh: http://localhost:8000/storage/media/tinymce-images/2024/01/...
            'id' => $resource->id,
            'filename' => $fileName
        ]);
    }

    /**
     * Upload video dari TinyMCE
     */
    public function uploadVideo(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:mp4,webm,ogg|max:51200', // 50MB untuk video
        ]);

        $file = $request->file('file');
        $userId = Auth::id();
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        // Generate nama file
        $fileName = 'vid_' . $userId . '_' . Str::slug($originalName) . '_' . time() . '.' . $extension;
        $folder = 'tinymce-videos/' . date('Y/m');
        $filePath = $folder . '/' . $fileName;

        // Simpan file
        Storage::disk('public')->put($filePath, file_get_contents($file));

        // Buat URL publik
        $publicUrl = Storage::url($filePath);

        // Simpan ke tabel resources
        $resource = Resource::create([
            'user_id' => $userId,
            'resource' => $filePath,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'original_name' => $originalName . '.' . $extension,
            'type' => 'tinymce_video'
        ]);

        return response()->json([
            'location' => asset($publicUrl),
            'id' => $resource->id,
            'filename' => $fileName
        ]);
    }

    /**
     * Hapus media yang sudah diupload
     */
    public function delete($id)
    {
        $resource = Resource::findOrFail($id);

        // Cek kepemilikan
        if ($resource->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Hapus dari storage
        if (Storage::disk('public')->exists($resource->resource)) {
            Storage::disk('public')->delete($resource->resource);
        }

        // Hapus dari database
        $resource->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Get list of user's uploaded media
     */
    public function index()
    {
        $media = Resource::where('user_id', Auth::id())
            ->whereIn('type', ['tinymce_image', 'tinymce_video'])
            ->latest()
            ->get();

        return response()->json($media);
    }
}
