<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;
use Exception;

class DriveUploadController extends Controller
{
    public function getSignedUrl(Request $request, GoogleDriveService $driveService)
    {
        try {
            $request->validate([
                'filename' => 'required|string|max:255',
                'mime_type' => 'nullable|string',
            ]);

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'blend', 'zip'];
            $ext = strtolower(pathinfo($request->filename, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowedExtensions)) {
                return response()->json(['error' => 'Format file tidak diizinkan.'], 422);
            }

            $mimeType  = $request->mime_type ?: 'application/octet-stream';
            $uploadUrl = $driveService->generateResumableUploadUrl($request->filename, $mimeType);

            return response()->json([
                'upload_url' => $uploadUrl,
                'expires_in' => 3600
            ]);
        } catch (Exception $e) {
            // Log error untuk debugging
            \Log::error('Google Drive signed URL error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
