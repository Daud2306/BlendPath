<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Resource;

class TinyMCEController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120', // 5MB
        ]);

        $file = $request->file('file');
        $userId = Auth::id();
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $ext = $file->getClientOriginalExtension();

        $fileName = 'img_' . $userId . '_' . Str::slug($originalName) . '_' . time() . '.' . $ext;
        $folder = 'media/tinymce-images/' . date('Y/m');
        $filePath = $folder . '/' . $fileName;

        Storage::disk('public')->put($filePath, file_get_contents($file));

        $resource = Resource::create([
            'user_id' => $userId,
            'path' => $filePath,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'original_name' => $originalName . '.' . $ext,
            'type' => 'tinymce_image'
        ]);

        return response()->json([
            'location' => asset(Storage::url($filePath)),
            'id' => $resource->id,
        ]);
    }

    public function delete($id)
    {
        $resource = Resource::findOrFail($id);

        if ($resource->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($resource->resourceable_id) {
            return response()->json(['error' => 'Media masih digunakan.'], 400);
        }

        $resource->delete();
        return response()->json(['success' => true]);
    }

    public function index()
    {
        $media = Resource::where('user_id', Auth::id())
            ->whereIn('type', ['tinymce_image', 'tinymce_video'])
            ->latest()
            ->get();

        return response()->json($media);
    }
}
