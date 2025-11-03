<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tutorial;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class UserManagementController extends Controller
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
            ->withCount(['progress as completed_tutorials_count' => function ($query) {
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
        $totalTutorialsCompleted = Progress::where('is_completed', true)->count();
        $topPerformers = $this->getTopPerformers();

        return view('admin.monitoring.index', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'averageProgress',
            'totalTutorialsCompleted',
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
        $totalTutorials = Tutorial::count();
        if ($totalTutorials === 0) return 0;

        $totalCompleted = Progress::where('is_completed', true)->count();
        $totalPossible = User::where('role', 'user')->count() * $totalTutorials;

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
        $totalTutorials = Tutorial::count();
        if ($totalTutorials === 0) return 0;

        $completedTutorials = $user->progress()->where('is_completed', true)->count();
        return round(($completedTutorials / $totalTutorials) * 100, 1);
    }

    public function export()
    {
        $users = User::all();

        $fileName = 'users_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');

            // FIXED: Gunakan koma sebagai delimiter
            fputcsv($file, ['ID', 'Nama', 'Email', 'Role', 'Tanggal Dibuat']);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role,
                    $user->created_at->format('Y-m-d')
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    // FIXED: IMPORT DENGAN KOMA SEBAGAI DELIMITER
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120'
        ]);

        $file = $request->file('csv_file');
        $filePath = $file->getRealPath();

        $imported = 0;
        $updated = 0;
        $errors = [];

        // FIXED: Baca file dengan delimiter koma
        if (($handle = fopen($filePath, 'r')) !== FALSE) {
            // Lewati header
            fgetcsv($handle);

            while (($row = fgetcsv($handle)) !== FALSE) {
                if (empty($row[0]) && empty($row[1]) && empty($row[2])) {
                    continue;
                }

                try {
                    $id = $row[0] ?? null;
                    $name = $row[1] ?? '';
                    $email = $row[2] ?? '';
                    $role = $row[3] ?? 'user';

                    if (empty($name) || empty($email)) {
                        $errors[] = "Data tidak lengkap: " . implode(', ', $row);
                        continue;
                    }

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = "Email tidak valid: $email";
                        continue;
                    }

                    $existingUser = User::where('email', $email)->first();

                    if ($existingUser) {
                        $existingUser->update([
                            'name' => $name,
                            'role' => $role
                        ]);
                        $updated++;
                    } else {
                        $errors[] = "User baru '$name' ($email) perlu dibuat manual";
                        continue;
                    }
                } catch (\Exception $e) {
                    $errors[] = "Error: " . $e->getMessage();
                }
            }
            fclose($handle);
        }

        $message = "Import selesai: $updated user diupdate.";

        if (!empty($errors)) {
            return redirect()->back()
                ->with('warning', $message . ' Ada ' . count($errors) . ' error.')
                ->with('import_errors', $errors);
        }

        return redirect()->back()->with('success', $message);
    }

    // FIXED: TEMPLATE DENGAN KOMA SEBAGAI DELIMITER
    public function downloadTemplate()
    {
        $fileName = 'template_import_user.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // FIXED: Gunakan koma sebagai delimiter
            fputcsv($file, ['ID', 'Nama', 'Email', 'Role', 'Tanggal Dibuat']);

            fputcsv($file, ['1', 'John Doe', 'john@example.com', 'user', '2024-01-01']);
            fputcsv($file, ['2', 'Jane Smith', 'jane@example.com', 'admin', '2024-01-01']);

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
