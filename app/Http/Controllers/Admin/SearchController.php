<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Modul;
use App\Models\Submodul;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
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
            case 'moduls':
                $results['moduls'] = Modul::where('judul', 'like', "%{$query}%")
                    ->orWhere('deskripsi', 'like', "%{$query}%")
                    ->get();
                break;

            case 'submoduls':
                $results['submoduls'] = Submodul::where('judul', 'like', "%{$query}%")
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
                $results['moduls'] = Modul::where('judul', 'like', "%{$query}%")
                    ->orWhere('deskripsi', 'like', "%{$query}%")
                    ->get();
                $results['submoduls'] = Submodul::where('judul', 'like', "%{$query}%")
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
