<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use App\Models\Modul;
use App\Models\Submodul;
use App\Models\Tanya;
use App\Models\Jawab;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'resourceable_id'   => 'required|integer',
            'resourceable_type' => 'required|string|in:App\Models\Submodul,App\Models\Tanya,App\Models\Jawab',
            'files.*'           => 'required|file|max:20480|mimes:jpg,jpeg,png,gif,zip,rar,blend',
        ]);

        $type = $request->resourceable_type;
        $model = $type::findOrFail($request->resourceable_id);

        foreach ($request->file('files') as $file) {
            if ($file->isValid()) {
                $path = $file->store('attachments', 'public');
                $ext  = $file->getClientOriginalExtension();

                Resource::create([
                    'user_id'           => Auth::id(),
                    'resourceable_id'   => $model->id,
                    'resourceable_type' => $type,
                    'path'              => $path,
                    'original_name'     => $file->getClientOriginalName(),
                    'mime_type'         => $file->getMimeType(),
                    'size'              => $file->getSize(),
                    'type'              => in_array($ext, ['zip', 'rar', 'blend'])
                        ? 'file'
                        : 'image',
                ]);
            }
        }

        return back()->with('success', 'File berhasil diupload!');
    }

    public function destroy(Resource $resource)
    {
        if ($resource->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $resource->delete(); // booted() auto-delete file dari storage

        return back()->with('success', 'File berhasil dihapus!');
    }
}
