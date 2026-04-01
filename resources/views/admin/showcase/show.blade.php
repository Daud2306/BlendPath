@extends('layout.admin.app')

@section('title', 'Detail Showcase — ' . $showcase->judul)

@push('styles')
<style>
    .media-grid-item {
        border-radius: var(--radius);
        overflow: hidden;
        background: #000;
        aspect-ratio: 16/9;
    }
    .media-grid-item img,
    .media-grid-item video {
        width: 100%; height: 100%;
        object-fit: cover; display: block;
    }
    .komentar-item {
        padding: 0.875rem 0;
        border-bottom: 1px solid var(--border-color);
    }
    .komentar-item:last-child { border-bottom: none; }
    .komentar-avatar {
        width: 34px; height: 34px;
        border-radius: 50%;
        background: var(--accent-light);
        color: var(--accent);
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.85rem;
        flex-shrink: 0;
    }
</style>
@endpush

@section('content')

<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title">{{ $showcase->judul }}</h1>
        <p class="page-subtitle mb-0">
            <i class="fas fa-user me-1" style="color:var(--accent);"></i>
            {{ $showcase->user->name }}
            <span style="margin:0 0.4rem;color:#adb5bd;">·</span>
            {{ $showcase->created_at->format('d M Y, H:i') }}
        </p>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.showcase.index') }}">Showcase</a></li>
                <li class="breadcrumb-item active">{{ Str::limit($showcase->judul, 25) }}</li>
            </ol>
        </nav>
        <form action="{{ route('admin.showcase.destroy', $showcase) }}"
              method="POST"
              onsubmit="return confirm('Hapus karya ini? Semua media dan komentar akan ikut terhapus.')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-admin danger ms-2">
                <i class="fas fa-trash"></i> Hapus Karya
            </button>
        </form>
    </div>
</div>

<div class="row g-3">

    {{-- LEFT: Media + Deskripsi + Komentar --}}
    <div class="col-lg-8 d-flex flex-column gap-3">

        {{-- Media --}}
        @if ($showcase->resources->isNotEmpty())
        <div class="admin-card">
            <div class="admin-card-header">
                <span class="admin-card-title">
                    <i class="fas fa-images me-2" style="color:var(--accent);"></i>Media
                </span>
                <span style="font-size:0.8rem;color:#adb5bd;">
                    {{ $showcase->resources->count() }} file
                </span>
            </div>
            <div class="admin-card-body">
                @if ($showcase->resources->count() === 1)
                    <div class="media-grid-item">
                        @if ($showcase->resources->first()->type === 'video')
                            <video src="{{ $showcase->resources->first()->url }}" controls></video>
                        @else
                            <img src="{{ $showcase->resources->first()->url }}"
                                 alt="{{ $showcase->judul }}"
                                 style="object-fit:contain;background:#111;">
                        @endif
                    </div>
                @else
                    <div class="row g-2">
                        @foreach ($showcase->resources as $i => $resource)
                        <div class="{{ $i === 0 ? 'col-12' : 'col-6' }}">
                            <div class="media-grid-item">
                                @if ($resource->type === 'video')
                                    <video src="{{ $resource->url }}" controls></video>
                                @else
                                    <img src="{{ $resource->url }}" alt="{{ $showcase->judul }}">
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Deskripsi --}}
        @if ($showcase->deskripsi)
        <div class="admin-card">
            <div class="admin-card-header">
                <span class="admin-card-title">
                    <i class="fas fa-align-left me-2" style="color:var(--accent);"></i>Deskripsi
                </span>
            </div>
            <div class="admin-card-body">
                <p style="font-size:0.9rem;line-height:1.7;color:var(--text-primary);margin:0;white-space:pre-line;">{{ $showcase->deskripsi }}</p>
            </div>
        </div>
        @endif

        {{-- Komentar --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <span class="admin-card-title">
                    <i class="fas fa-comments me-2" style="color:var(--accent);"></i>Komentar
                    @if ($showcase->komentars->count() > 0)
                        <span style="background:var(--accent-light);color:var(--accent);font-size:0.75rem;padding:0.2rem 0.6rem;border-radius:20px;margin-left:0.5rem;">
                            {{ $showcase->komentars->count() }}
                        </span>
                    @endif
                </span>
            </div>
            <div class="admin-card-body">
                @forelse ($showcase->komentars as $komentar)
                    <div class="komentar-item">
                        <div class="d-flex align-items-start gap-2">
                            <div class="komentar-avatar">
                                {{ strtoupper(substr($komentar->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between gap-2">
                                    <div>
                                        <span style="font-weight:600;font-size:0.875rem;">{{ $komentar->user->name ?? 'User' }}</span>
                                        <span style="font-size:0.75rem;color:#adb5bd;margin-left:0.4rem;">
                                            {{ $komentar->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <form action="{{ route('admin.showcase.komentar.destroy', $komentar) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus komentar ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-admin danger sm"
                                                style="padding:0.2rem 0.5rem;font-size:0.75rem;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <p style="font-size:0.875rem;margin:0.3rem 0 0;color:var(--text-primary);">
                                    {{ $komentar->komentar }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state" style="padding:2rem;">
                        <i class="fas fa-comments"></i>
                        <p>Belum ada komentar.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- RIGHT: Info --}}
    <div class="col-lg-4 d-flex flex-column gap-3">

        <div class="admin-card">
            <div class="admin-card-header">
                <span class="admin-card-title">
                    <i class="fas fa-info-circle me-2" style="color:var(--accent);"></i>Informasi
                </span>
            </div>
            <div class="admin-card-body">
                <dl style="font-size:0.875rem;margin:0;">
                    <dt style="color:#adb5bd;font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.2rem;">Pembuat</dt>
                    <dd style="margin-bottom:0.85rem;font-weight:500;">{{ $showcase->user->name }}</dd>

                    <dt style="color:#adb5bd;font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.2rem;">Diunggah</dt>
                    <dd style="margin-bottom:0.85rem;">{{ $showcase->created_at->format('d M Y, H:i') }}</dd>

                    <dt style="color:#adb5bd;font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.2rem;">Total Media</dt>
                    <dd style="margin-bottom:0.85rem;">{{ $showcase->resources->count() }} file</dd>

                    <dt style="color:#adb5bd;font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.2rem;">Total Komentar</dt>
                    <dd style="margin-bottom:0;">{{ $showcase->komentars->count() }}</dd>
                </dl>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <span class="admin-card-title">
                    <i class="fas fa-bolt me-2" style="color:var(--accent);"></i>Aksi
                </span>
            </div>
            <div class="admin-card-body d-flex flex-column gap-2">
                <a href="{{ route('admin.showcase.index') }}" class="btn-admin secondary w-100 justify-content-center">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
                <form action="{{ route('admin.showcase.destroy', $showcase) }}"
                      method="POST"
                      onsubmit="return confirm('Hapus karya ini beserta semua media dan komentarnya?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-admin danger w-100 justify-content-center">
                        <i class="fas fa-trash"></i> Hapus Karya Ini
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
