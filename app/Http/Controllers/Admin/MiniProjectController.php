<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MiniProjectSubmission;
use Illuminate\Http\Request;

class MiniProjectController extends Controller
{
    public function updateStatus(Request $request, MiniProjectSubmission $submission)
    {
        $request->validate([
            'status' => 'required|in:submitted,approved,rejected',
            'feedback' => 'nullable|string',
        ]);

        $submission->update([
            'status' => $request->status,
            'feedback' => $request->feedback,
        ]);

        return back()->with('success', 'Status submission diperbarui.');
    }
}
