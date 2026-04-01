<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tanya;
use App\Models\Resource;
use App\Models\Submodul;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TanyaController extends Controller
{
    public function index()
    {
        $tanyas = Tanya::with(['user', 'submodul.modul'])->latest()->get();
        return view('admin.tanyas.index', compact('tanyas'));
    }

    public function destroy(Tanya $tanya)
    {
        $this->authorize('delete', $tanya);

        $tanya->delete();

        return redirect()->back()->with('success', 'Pertanyaan berhasil dihapus!');
    }
}
