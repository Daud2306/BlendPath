@extends('layout.admin.app')

@section('title', 'Admin - Users')

@section('content')
@section('title', 'Admin - Manage Users')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">👥 Manage Users</h1>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Tambah User
            </a>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="card shadow">
            <div class="card-body">
                @if ($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                                    style="width: 32px; height: 32px; font-size: 14px;">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                {{ $user->name }}
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->role === 'admin')
                                                <span class="badge bg-success">Admin</span>
                                            @else
                                                <span class="badge bg-secondary">User</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.users.edit', $user) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if ($user->id !== auth()->id())
                                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                        onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-sm btn-outline-secondary" disabled>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada users</h5>
                        <p class="text-muted">Mulai dengan menambahkan user pertama</p>
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Tambah User Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>

        @include('components.pagination', ['paginator' => $users])

        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>{{ \App\Models\User::count() }}</h4>
                                <p class="mb-0">Total Users</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>{{ \App\Models\User::where('role', 'admin')->count() }}</h4>
                                <p class="mb-0">Admin</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-user-shield fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>{{ \App\Models\User::where('role', 'user')->count() }}</h4>
                                <p class="mb-0">Regular Users</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-user fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>{{ \App\Models\User::whereDate('created_at', today())->count() }}</h4>
                                <p class="mb-0">Baru Hari Ini</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-user-plus fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
