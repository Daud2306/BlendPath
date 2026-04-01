<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Modul;
use App\Models\Submodul;
use App\Models\Tanya;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers    = User::where('role', 'user')->count();
        $totalModuls   = Modul::count();
        $totalSubmoduls = Submodul::count();
        $totalTanyas   = Tanya::count();

        $recentUsers  = User::where('role', 'user')->latest()->limit(6)->get();
        $recentModuls = Modul::withCount('submoduls')->latest()->limit(4)->get();
        $recentTanyas = Tanya::with('user')->latest()->limit(4)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalModuls',
            'totalSubmoduls',
            'totalTanyas',
            'recentUsers',
            'recentModuls',
            'recentTanyas'
        ));
    }
}
