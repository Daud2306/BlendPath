@extends('layout.admin.app')

@section('title', 'Monitoring Progress User')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">📊 Monitoring Progress</h1>
                <p class="text-muted mb-0">Pantau perkembangan belajar pengguna</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4 mb-4">
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 p-3 rounded">
                                    <i class="fas fa-users text-primary fa-lg"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="mb-0">{{ $totalUsers }}</h4>
                                <p class="text-muted mb-0">Total Users</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-opacity-10 p-3 rounded">
                                    <i class="fas fa-user-check text-success fa-lg"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="mb-0">{{ $activeUsers }}</h4>
                                <p class="text-muted mb-0">Users Aktif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-warning bg-opacity-10 p-3 rounded">
                                    <i class="fas fa-book text-warning fa-lg"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="mb-0">{{ $totalTutorialsCompleted }}</h4>
                                <p class="text-muted mb-0">Tutorial Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Daftar Pengguna</h5>
            </div>
            <div class="card-body p-0">
                @if ($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 ps-4">User</th>
                                    <th class="border-0">Progress</th>
                                    <th class="border-0">Tutorial Selesai</th>
                                    <th class="border-0">Terakhir Aktif</th>
                                    <th class="border-0">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                                    <span class="text-primary fw-bold">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                                    <small class="text-muted">{{ $user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                    <div class="progress-bar 
                                                    @if ($user->progress_percentage >= 80) bg-success
                                                    @elseif($user->progress_percentage >= 40) bg-warning
                                                    @else bg-danger @endif"
                                                        style="width: {{ $user->progress_percentage }}%">
                                                    </div>
                                                </div>
                                                <small class="fw-bold">{{ $user->progress_percentage }}%</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                                {{ $user->completed_tutorials_count }} selesai
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                @if ($user->updated_at)
                                                    {{ $user->updated_at->diffForHumans() }}
                                                @else
                                                    <span class="text-muted">Belum ada</span>
                                                @endif
                                            </small>
                                        </td>
                                        <td>
                                            @if ($user->is_active)
                                                <span
                                                    class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                                    <i class="fas fa-circle me-1 small"></i>Aktif
                                                </span>
                                            @else
                                                <span
                                                    class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25">
                                                    <i class="fas fa-circle me-1 small"></i>Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-users fa-3x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted">Belum ada data user</h5>
                        <p class="text-muted mb-0">Data monitoring progress akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>

        @include('components.pagination', ['paginator' => $users])

        {{-- <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-trophy text-warning me-2"></i>Top Performers
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($topPerformers->count() > 0)
                            @foreach ($topPerformers as $performer)
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                    <div
                                        class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <span class="text-primary fw-bold small">
                                            {{ strtoupper(substr($performer->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ \Illuminate\Support\Str::limit($performer->name, 20) }}</h6>
                                        <small class="text-muted">{{ $performer->completed_count }} tutorial
                                            selesai</small>
                                    </div>
                                    <div class="text-end">
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                            {{ $performer->progress_percentage }}%
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-trophy fa-2x text-muted opacity-50 mb-2"></i>
                                <p class="text-muted mb-0">Belum ada data top performers</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    <style>
        .avatar-sm {
            width: 40px;
            height: 40px;
            font-size: 14px;
        }

        .progress {
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .progress-bar {
            border-radius: 4px;
            transition: width 0.6s ease;
        }

        .card {
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .table th {
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            border-bottom: 1px solid #dee2e6;
        }
    </style>
@endsection
