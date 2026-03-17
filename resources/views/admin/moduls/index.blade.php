@extends('layout.admin.app')

@section('title', 'Kelola Modul')

@section('content')

{{-- Page Header --}}
<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title">Kelola Modul</h1>
        <p class="page-subtitle mb-0">Daftar semua modul pembelajaran Blender 3D</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Modul</li>
            </ol>
        </nav>
        <a href="{{ route('admin.moduls.create') }}" class="btn-primary-admin ms-2">
            <i class="fas fa-plus"></i> Tambah Modul
        </a>
    </div>
</div>

{{-- Stats row --}}
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-layer-group"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $moduls->total() }}</div>
                <div class="stat-label">Total Modul</div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-book-open"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ \App\Models\Submodul::count() }}</div>
                <div class="stat-label">Total Submodul</div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon orange"><i class="fas fa-sort-numeric-up"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $moduls->max('sort_order') ?? 0 }}</div>
                <div class="stat-label">Urutan Tertinggi</div>
            </div>
        </div>
    </div>
</div>

{{-- Table Card --}}
<div class="admin-card">
    <div class="card-header">
        <h5 class="card-title">
            <i class="fas fa-layer-group me-2" style="color:var(--accent);"></i>
            Daftar Modul
        </h5>
        <span style="font-size:0.8rem;color:#adb5bd;">
            {{ $moduls->total() }} modul ditemukan
        </span>
    </div>

    <div class="card-body p-0">
        @if($moduls->isEmpty())
            <div class="empty-state">
                <i class="fas fa-layer-group"></i>
                <p>Belum ada modul. <a href="{{ route('admin.moduls.create') }}" style="color:var(--accent);">Tambah sekarang</a></p>
            </div>
        @else
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th>Modul</th>
                        <th style="width:120px;">Urutan</th>
                        <th style="width:120px;">Submodul</th>
                        <th style="width:140px;">Dibuat</th>
                        <th style="width:160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($moduls as $index => $modul)
                    <tr>
                        <td style="color:#adb5bd;font-size:0.8rem;">
                            {{ ($moduls->currentPage() - 1) * $moduls->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                {{-- Gambar thumbnail --}}
                                @if($modul->gambar)
                                    <img src="{{ asset('storage/' . $modul->gambar) }}"
                                         alt="{{ $modul->judul }}"
                                         style="width:44px;height:44px;object-fit:cover;border-radius:var(--radius);border:1px solid var(--border-color);flex-shrink:0;">
                                @else
                                    <div style="width:44px;height:44px;border-radius:var(--radius);background:var(--accent-light);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="fas fa-cube" style="color:var(--accent);font-size:1.1rem;"></i>
                                    </div>
                                @endif
                                <div>
                                    <div style="font-weight:600;font-size:0.9rem;color:var(--text-primary);">
                                        {{ $modul->judul }}
                                    </div>
                                    <div style="font-size:0.78rem;color:#adb5bd;margin-top:2px;">
                                        {{ Str::limit($modul->deskripsi, 60) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="display:inline-flex;align-items:center;gap:0.4rem;background:var(--bg-primary);padding:0.3rem 0.75rem;border-radius:20px;font-size:0.8rem;font-weight:600;border:1px solid var(--border-color);">
                                <i class="fas fa-sort-numeric-up" style="color:var(--accent);font-size:0.7rem;"></i>
                                {{ $modul->sort_order }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.moduls.submoduls.index', $modul) }}"
                               style="display:inline-flex;align-items:center;gap:0.4rem;color:var(--accent);font-size:0.875rem;font-weight:500;">
                                <i class="fas fa-book-open" style="font-size:0.8rem;"></i>
                                {{ $modul->submoduls()->count() }} submodul
                            </a>
                        </td>
                        <td style="color:#adb5bd;font-size:0.8rem;">
                            {{ $modul->created_at->format('d M Y') }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                {{-- Lihat Submodul --}}
                                <a href="{{ route('admin.moduls.submoduls.index', $modul) }}"
                                   class="btn-outline-admin" title="Lihat Submodul">
                                    <i class="fas fa-list"></i>
                                </a>
                                {{-- Edit --}}
                                <a href="{{ route('admin.moduls.edit', $modul) }}"
                                   class="btn-outline-admin" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {{-- Hapus --}}
                                <form action="{{ route('admin.moduls.destroy', $modul) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus modul \'{{ addslashes($modul->judul) }}\'? Semua submodul di dalamnya juga akan terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger-admin" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($moduls->hasPages())
        <div class="d-flex justify-content-between align-items-center px-3 py-3" style="border-top:1px solid var(--border-color);">
            <div style="font-size:0.8rem;color:#adb5bd;">
                Menampilkan {{ $moduls->firstItem() }}–{{ $moduls->lastItem() }} dari {{ $moduls->total() }} modul
            </div>
            {{ $moduls->links('pagination::bootstrap-5') }}
        </div>
        @endif
        @endif
    </div>
</div>

@endsection
