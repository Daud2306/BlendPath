@extends('layout.admin.app')

@section('title', 'Moderasi Showcase')

@section('content')

<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title">Showcase</h1>
        <p class="page-subtitle mb-0">Moderasi karya komunitas BlendPath</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Showcase</li>
        </ol>
    </nav>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-images"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $showcases->total() }}</div>
                <div class="stat-label">Total Karya</div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $showcases->pluck('user_id')->unique()->count() }}</div>
                <div class="stat-label">Kontributor (halaman ini)</div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon orange"><i class="fas fa-comments"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $showcases->sum(fn($s) => $s->komentars->count()) }}</div>
                <div class="stat-label">Komentar (halaman ini)</div>
            </div>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <span class="admin-card-title">
            <i class="fas fa-images me-2" style="color:var(--accent);"></i>Daftar Showcase
        </span>
        <span style="font-size:0.8rem;color:#adb5bd;">{{ $showcases->total() }} karya</span>
    </div>

    <div class="admin-card-body p-0">
        @if ($showcases->isEmpty())
            <div class="empty-state">
                <i class="fas fa-images"></i>
                <p>Belum ada showcase yang diupload.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width:60px;">#</th>
                            <th>Karya</th>
                            <th style="width:160px;">Pembuat</th>
                            <th style="width:90px;">Media</th>
                            <th style="width:90px;">Komentar</th>
                            <th style="width:140px;">Diunggah</th>
                            <th style="width:120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($showcases as $showcase)
                        <tr>
                            <td style="color:#adb5bd;font-size:0.8rem;">
                                {{ ($showcases->currentPage() - 1) * $showcases->perPage() + $loop->iteration }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    {{-- Thumbnail --}}
                                    @if ($showcase->resources->isNotEmpty())
                                        @if ($showcase->resources->first()->type === 'video')
                                            <div style="width:52px;height:52px;border-radius:var(--radius);background:#000;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <i class="fas fa-play" style="color:#fff;font-size:1rem;"></i>
                                            </div>
                                        @else
                                            <img src="{{ $showcase->resources->first()->url }}"
                                                 alt="{{ $showcase->judul }}"
                                                 style="width:52px;height:52px;object-fit:cover;border-radius:var(--radius);flex-shrink:0;">
                                        @endif
                                    @else
                                        <div style="width:52px;height:52px;border-radius:var(--radius);background:var(--accent-light);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                            <i class="fas fa-image" style="color:var(--accent);"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div style="font-weight:600;font-size:0.9rem;color:var(--text-primary);">
                                            {{ $showcase->judul }}
                                        </div>
                                        @if ($showcase->deskripsi)
                                            <div style="font-size:0.78rem;color:#adb5bd;margin-top:2px;">
                                                {{ Str::limit($showcase->deskripsi, 55) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size:0.875rem;font-weight:500;">{{ $showcase->user->name }}</div>
                            </td>
                            <td>
                                <span style="font-size:0.85rem;">
                                    <i class="fas fa-images me-1" style="color:#adb5bd;"></i>
                                    {{ $showcase->resources->count() }}
                                </span>
                            </td>
                            <td>
                                <span style="font-size:0.85rem;">
                                    <i class="fas fa-comment me-1" style="color:#adb5bd;"></i>
                                    {{ $showcase->komentars->count() }}
                                </span>
                            </td>
                            <td style="color:#adb5bd;font-size:0.8rem;">
                                {{ $showcase->created_at->format('d M Y') }}
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.showcase.show', $showcase) }}"
                                       class="btn-admin secondary sm" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.showcase.destroy', $showcase) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus karya \'{{ addslashes($showcase->judul) }}\'? Semua media dan komentar akan ikut terhapus.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-admin danger sm" title="Hapus">
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

            @if ($showcases->hasPages())
            <div class="d-flex justify-content-between align-items-center px-3 py-3"
                 style="border-top:1px solid var(--border-color);">
                <div style="font-size:0.8rem;color:#adb5bd;">
                    Menampilkan {{ $showcases->firstItem() }}–{{ $showcases->lastItem() }}
                    dari {{ $showcases->total() }} karya
                </div>
                {{ $showcases->links('pagination::bootstrap-5') }}
            </div>
            @endif
        @endif
    </div>
</div>

@endsection
