<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Submodul;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|in:user,admin',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dibuat!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'min:8|confirmed';
        }

        $validated = $request->validate($rules);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    public function monitoring()
    {
        $users = User::where('role', 'user')
            ->withCount(['progress as completed_submoduls_count' => function ($query) {
                $query->where('is_completed', true);
            }])
            ->with('progress')
            ->orderBy('name')
            ->paginate(10);

        $users->each(function ($user) {
            $user->progress_percentage = $this->calculateUserProgress($user);
            $user->is_active = $user->updated_at && $user->updated_at->gte(now()->subDays(30));
        });

        $totalUsers = User::where('role', 'user')->count();
        $activeUsers = $this->getActiveUsersCount();
        $averageProgress = $this->calculateAverageProgress();
        $totalSubmodulsCompleted = Progress::where('is_completed', true)->count();
        $topPerformers = $this->getTopPerformers();

        return view('admin.monitoring.index', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'averageProgress',
            'totalSubmodulsCompleted',
            'topPerformers'
        ));
    }

    private function getActiveUsersCount()
    {
        return User::where('role', 'user')
            ->where('updated_at', '>=', now()->subDays(30))
            ->count();
    }

    private function calculateAverageProgress()
    {
        $totalSubmoduls = Submodul::count();
        if ($totalSubmoduls === 0) return 0;

        $totalCompleted = Progress::where('is_completed', true)->count();
        $totalPossible = User::where('role', 'user')->count() * $totalSubmoduls;
        return $totalPossible > 0 ? round(($totalCompleted / $totalPossible) * 100, 1) : 0;
    }

    private function getTopPerformers()
    {
        return User::where('role', 'user')
            ->withCount(['progress as completed_count' => function ($query) {
                $query->where('is_completed', true);
            }])
            ->orderBy('completed_count', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($user) {
                $user->progress_percentage = $this->calculateUserProgress($user);
                return $user;
            });
    }

    private function calculateUserProgress(User $user)
    {
        $totalSubmoduls = Submodul::count();
        if ($totalSubmoduls === 0) return 0;

        $completedSubmoduls = $user->progress()->where('is_completed', true)->count();
        return round(($completedSubmoduls / $totalSubmoduls) * 100, 1);
    }

    public function export(): BinaryFileResponse
    {
        return Excel::download(new UsersExport, 'users_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            Excel::import(new UsersImport, $request->file('file'));

            return redirect()->route('admin.users.index')
                ->with('success', 'Users imported successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    public function downloadTemplate(): BinaryFileResponse
    {
        return Excel::download(new UsersExport, 'users_import_template.xlsx');
    }
}
