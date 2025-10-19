<?php

namespace App\Http\Controllers;

use App\Models\Roadmap;
use App\Models\Tutorial;
use App\Models\User;
use Illuminate\Http\Request;

class AdminSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');
        $type = $request->get('type', 'all');

        if (!$query) {
            return redirect()->route('admin.dashboard')
                ->with('info', 'Masukkan kata kunci untuk mencari.');
        }

        $results = [];

        switch ($type) {
            case 'roadmaps':
                $results['roadmaps'] = Roadmap::where('judul', 'like', "%{$query}%")
                    ->orWhere('deskripsi', 'like', "%{$query}%")
                    ->get();
                break;

            case 'tutorials':
                $results['tutorials'] = Tutorial::where('judul', 'like', "%{$query}%")
                    ->orWhere('konten', 'like', "%{$query}%")
                    ->get();
                break;

            case 'users':
                $results['users'] = User::where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->get();
                break;

            case 'all':
            default:
                $results['roadmaps'] = Roadmap::where('judul', 'like', "%{$query}%")
                    ->orWhere('deskripsi', 'like', "%{$query}%")
                    ->get();
                $results['tutorials'] = Tutorial::where('judul', 'like', "%{$query}%")
                    ->orWhere('konten', 'like', "%{$query}%")
                    ->get();
                $results['users'] = User::where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->get();
                break;
        }

        return view('admin.search-results', compact('query', 'type', 'results'));
    }
}
