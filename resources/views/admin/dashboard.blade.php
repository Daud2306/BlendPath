@extends('layout.admin.app')

@section('title', 'Dashboard')

@section('content')

{{-- Breadcrumb --}}
<nav class="admin-breadcrumb">
    <div class="breadcrumb-item active">Dashboard</div>
</nav>

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Selamat datang kembali, {{ Auth::user()->name ?? 'Admin' }} 👋</p>
    </div>
    <a href="{{ route('admin.moduls.create') }}" class="btn-admin primary">
        <i class="fas fa-plus"></i> Modul Baru
    </a>
</div>

{{-- ── Stat Cards ─────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">

    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-layer-group"></i>
            </div>
            <div class="stat-body">
                <div class="stat-value">{{ $totalModuls ?? 0 }}</div>
                <div class="stat-label">Total Modul</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-body">
                <div class="stat-value">{{ $totalUsers ?? 0 }}</div>
                <div class="stat-label">Pengguna Terdaftar</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-comment-dots"></i>
            </div>
            <div class="stat-body">
                <div class="stat-value">{{ $totalDiskusi ?? 0 }}</div>
                <div class="stat-label">Diskusi Aktif</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon red">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="stat-body">
                <div class="stat-value">{{ $totalQuizzes ?? 0 }}</div>
                <div class="stat-label">Total Kuis</div>
            </div>
        </div>
    </div>

</div>

{{-- ── Row: Modul List + Aktivitas ───────────────────────────── --}}
<div class="row g-3 mb-3">

    {{-- Recent Moduls --}}
    <div class="col-lg-7">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <span class="admin-card-title">Modul Terbaru</span>
                <a href="{{ route('admin.moduls.index') }}" class="btn-admin secondary sm">
                    Lihat semua
                </a>
            </div>
            <div style="overflow-x:auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Submodul</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentModuls ?? [] as $i => $modul)
                        <tr>
                            <td style="color:var(--text-muted)">{{ $i + 1 }}</td>
                            <td>
                                <span style="font-weight:500">{{ $modul->judul ?? $modul->title ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="badge-admin gray">{{ $modul->submoduls_count ?? 0 }} sub</span>
                            </td>
                            <td>
                                @if(($modul->is_published ?? true))
                                    <span class="badge-admin green">Aktif</span>
                                @else
                                    <span class="badge-admin gray">Draft</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.moduls.edit', $modul) }}"
                                   class="btn-admin secondary sm">
                                    Edit
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align:center;color:var(--text-muted);padding:28px 0">
                                Belum ada modul
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Activity Feed --}}
    <div class="col-lg-5">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <span class="admin-card-title">Diskusi Terbaru</span>
                <a href="{{ route('admin.tanyas.index') }}" class="btn-admin secondary sm">
                    Lihat semua
                </a>
            </div>
            <div class="admin-card-body" style="padding-top:12px">
                @forelse($recentTanyas ?? [] as $tanya)
                <div class="activity-item">
                    <div class="activity-dot blue"></div>
                    <div>
                        <div class="activity-text">
                            <strong>{{ $tanya->user->name ?? 'Pengguna' }}</strong>
                            bertanya di
                            <em>{{ $tanya->submodul->judul ?? 'submodul' }}</em>
                        </div>
                        <div class="activity-time">{{ $tanya->created_at?->diffForHumans() ?? '' }}</div>
                    </div>
                </div>
                @empty
                <div style="color:var(--text-muted);font-size:13px;padding:20px 0;text-align:center">
                    Belum ada diskusi
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

{{-- ── Row: Pengguna Terbaru + Progress Ringkasan ─────────────── --}}
<div class="row g-3">

    {{-- Recent Users --}}
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <span class="admin-card-title">Pengguna Terbaru</span>
                <a href="{{ route('admin.users.index') }}" class="btn-admin secondary sm">
                    Lihat semua
                </a>
            </div>
            <div style="overflow-x:auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Bergabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentUsers ?? [] as $user)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:8px">
                                    <div style="width:26px;height:26px;border-radius:50%;background:var(--accent-soft);color:var(--accent);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span style="font-weight:500">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td style="color:var(--text-muted)">{{ $user->email }}</td>
                            <td style="color:var(--text-muted)">{{ $user->created_at?->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="text-align:center;color:var(--text-muted);padding:28px 0">
                                Belum ada pengguna
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Module completion summary --}}
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <span class="admin-card-title">Progress per Modul</span>
                <a href="{{ route('admin.monitoring.index') }}" class="btn-admin secondary sm">
                    Detail
                </a>
            </div>
            <div class="admin-card-body">
                @forelse($modulProgress ?? [] as $item)
                <div style="margin-bottom:16px">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
                        <span style="font-size:13px;font-weight:500;color:var(--text)">
                            {{ $item['judul'] ?? '-' }}
                        </span>
                        <span style="font-size:12px;color:var(--text-muted)">
                            {{ $item['pct'] ?? 0 }}%
                        </span>
                    </div>
                    <div class="admin-progress">
                        <div class="admin-progress-bar {{ ($item['pct'] ?? 0) >= 70 ? 'green' : (($item['pct'] ?? 0) >= 40 ? '' : 'orange') }}"
                             style="width:{{ $item['pct'] ?? 0 }}%"></div>
                    </div>
                </div>
                @empty
                <div style="color:var(--text-muted);font-size:13px;text-align:center;padding:20px 0">
                    Belum ada data progress
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

@endsection
