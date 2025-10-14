@extends('layout.admin.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">📊 Dashboard Admin</h1>
            <div class="text-muted">
                <i class="fas fa-calendar me-1"></i>
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Roadmaps
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\Roadmap::count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-map-signs fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Tutorials
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\Tutorial::count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Pertanyaan
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\Tanya::count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-question-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Pengguna
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\User::count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">📈 Aktivitas Terbaru</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @php
                                $recentTutorials = \App\Models\Tutorial::latest()->take(5)->get();
                                $recentTanyas = \App\Models\Tanya::latest()->take(5)->get();
                            @endphp

                            @if ($recentTutorials->count() > 0)
                                @foreach ($recentTutorials as $tutorial)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-book text-primary me-2"></i>
                                            <strong>Tutorial Baru:</strong> {{ Str::limit($tutorial->judul, 40) }}
                                        </div>
                                        <small class="text-muted">{{ $tutorial->created_at->diffForHumans() }}</small>
                                    </div>
                                @endforeach
                            @endif

                            @if ($recentTanyas->count() > 0)
                                @foreach ($recentTanyas as $tanya)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-question text-info me-2"></i>
                                            <strong>Pertanyaan Baru:</strong> {{ Str::limit($tanya->pertanyaan, 40) }}
                                        </div>
                                        <small class="text-muted">{{ $tanya->created_at->diffForHumans() }}</small>
                                    </div>
                                @endforeach
                            @endif

                            @if ($recentTutorials->count() == 0 && $recentTanyas->count() == 0)
                                <div class="text-center text-muted py-3">
                                    <i class="fas fa-inbox fa-2x mb-2"></i>
                                    <p>Belum ada aktivitas terbaru</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">⚡ Aksi Cepat</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.roadmaps.create') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-plus me-2"></i>Buat Roadmap Baru
                            </a>
                            <a href="{{ route('admin.roadmaps.index') }}" class="btn btn-outline-primary btn-block">
                                <i class="fas fa-list me-2"></i>Kelola Roadmaps
                            </a>
                        </div>
                    </div>
                </div>

                {{-- <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">🖥️ Info Sistem</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">Laravel Version</small>
                            <div class="fw-bold">{{ app()->version() }}</div>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">PHP Version</small>
                            <div class="fw-bold">{{ PHP_VERSION }}</div>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Environment</small>
                            <div class="fw-bold">{{ app()->environment() }}</div>
                        </div>
                        <div>
                            <small class="text-muted">Waktu Server</small>
                            <div class="fw-bold">{{ now()->format('H:i:s') }}</div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">🗺️ Roadmaps Overview</h6>
                        <a href="{{ route('admin.roadmaps.index') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="card-body">
                        @php
                            $roadmaps = \App\Models\Roadmap::withCount('tutorials')->latest()->take(6)->get();
                        @endphp

                        @if ($roadmaps->count() > 0)
                            <div class="row">
                                @foreach ($roadmaps as $roadmap)
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100">
                                            @if ($roadmap->gambar)
                                                <img src="{{ asset('storage/' . $roadmap->gambar) }}" class="card-img-top"
                                                    alt="{{ $roadmap->judul }}" style="height: 120px; object-fit: cover;">
                                            @else
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                                    style="height: 120px;">
                                                    <i class="fas fa-map-signs fa-2x text-muted"></i>
                                                </div>
                                            @endif
                                            <div class="card-body">
                                                <h6 class="card-title">{{ Str::limit($roadmap->judul, 30) }}</h6>
                                                <p class="card-text small text-muted">
                                                    {{ $roadmap->tutorials_count }} Tutorial
                                                </p>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.roadmaps.tutorials.index', $roadmap) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        Lihat Tutorial
                                                    </a>
                                                    <a href="{{ route('admin.roadmaps.edit', $roadmap) }}"
                                                        class="btn btn-sm btn-outline-secondary">
                                                        Edit
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-map-signs fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada roadmap. Mulai dengan membuat roadmap pertama!</p>
                                <a href="{{ route('admin.roadmaps.create') }}" class="btn btn-primary">
                                    Buat Roadmap Pertama
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
