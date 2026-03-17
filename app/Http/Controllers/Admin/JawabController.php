<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jawab;
use Illuminate\Http\Request;

class JawabController extends Controller
{
    public function index()
    {
        $jawabs = Jawab::with(['user', 'tanya'])
            ->latest()
            ->paginate(20);

        return view('admin.jawabs.index', compact('jawabs'));
    }

    public function destroy(Jawab $jawab)
    {
        $this->authorize('delete', $jawab);

        $jawab->delete();
        return redirect()->back()->with('success', 'Jawaban berhasil dihapus!');
    }
}
