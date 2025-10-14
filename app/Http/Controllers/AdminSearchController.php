<?php

namespace App\Http\Controllers;

use App\Models\Roadmap;
use App\Models\Tutorial;
use App\Models\User;
use App\Models\Tanya;
use Illuminate\Http\Request;

class AdminSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');

        if (!$query) {
            return redirect()->route('admin.dashboard')
                ->with('info', 'Masukkan kata kunci untuk mencari.');
        }

        $roadmaps = Roadmap::where('judul', 'like', "%{$query}%")
            ->orWhere('deskripsi', 'like', "%{$query}%")
            ->get();

        $tutorials = Tutorial::where('judul', 'like', "%{$query}%")
            ->orWhere('konten', 'like', "%{$query}%")
            ->get();

        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->get();

        return view('admin.search-results', compact(
            'query',
            'roadmaps',
            'tutorials',
            'users',
        ));
    }
}
