@extends('layout.frontend.app')

@section('title', 'Tutorials - Roadmap A')

@section('content')
    <div class="container my-5">
        {{-- breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('roadmaps.index') }}" class="text-decoration-none">Roadmaps</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $roadmap->judul }}</li>
            </ol>
        </nav>

        {{-- header roadmap --}}
        <div class="card mb-4 shadow-sm">
            <div class="row g-0 align-items-center">
                <div class="col-md-4">
                    @php
                        $thumb = $roadmap->gambar
                            ? asset('storage/' . $roadmap->gambar)
                            : asset('frontend/img/basic.jpeg');
                    @endphp
                    <img src="{{ $thumb }}" alt="Thumbnail {{ $roadmap->judul }}"
                        class="img-fluid rounded-start w-100" style="height:200px; object-fit:cover;">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h2 class="card-title mb-1">{{ $roadmap->judul }}</h2>
                        <p class="card-text text-muted mb-2">{!! nl2br(e(Str::limit($roadmap->deskripsi ?? '-', 400))) !!}</p>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <span class="badge bg-primary">Total: {{ $tutorials->total() }}</span>
                            <span class="text-muted small">Diurutkan: {{ request('sort', 'sort_asc') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- controls: pencarian + sort (GET form, tanpa JS) --}}
        <form method="GET" action="{{ route('roadmaps.show', $roadmap) }}" class="row g-2 mb-3" role="search"
            aria-label="Cari tutorial">
            <div class="col-md-7">
                <input type="search" name="q" value="{{ request('q') }}" class="form-control"
                    placeholder="Cari tutorial (judul / deskripsi)..." aria-label="Cari tutorial">
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-outline-primary" type="submit">Terapkan</button>
            </div>
        </form>

        {{-- list tutorial --}}
        <div class="row g-3">
            @forelse($tutorials as $tutorial)
                <div class="col-12">
                    <article class="card h-100 shadow-sm">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-9">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h5 class="card-title mb-1">{{ $tutorial->judul }}</h5>
                                        <span
                                            class="badge bg-secondary">#{{ $tutorial->sort_order ?? $tutorial->id }}</span>
                                    </div>

                                    <p class="card-text text-muted mb-2">
                                        {!! \Illuminate\Support\Str::limit(strip_tags($tutorial->deskripsi ?? ($tutorial->konten ?? '')), 180) !!}
                                    </p>

                                    <div class="mt-auto d-flex gap-3 align-items-center">
                                        <small class="text-muted">Dibuat:
                                            {{ $tutorial->created_at ? $tutorial->created_at->format('d M Y') : '-' }}</small>
                                        @if (isset($tutorial->durasi) && $tutorial->durasi)
                                            <small class="text-muted">Durasi: {{ $tutorial->durasi }}</small>
                                        @endif
                                        <div class="ms-auto">
                                            <a href="{{ route('roadmaps.tutorials.show', ['roadmap' => $roadmap->id, 'tutorial' => $tutorial->id]) }}"
                                                class="btn btn-primary btn-sm">Buka Tutorial</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 d-none d-md-block">
                                @if (!empty($tutorial->gambar))
                                    <img src="{{ asset('storage/' . $tutorial->gambar) }}" alt="thumb"
                                        class="img-fluid rounded-end h-100" style="object-fit:cover;">
                                @else
                                    <div class="h-100 d-flex align-items-center justify-content-center bg-light"
                                        style="min-height:120px;">
                                        <small class="text-muted">Tidak ada gambar</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">Belum ada tutorial pada roadmap ini.</div>
                </div>
            @endforelse
        </div>

        {{-- pagination --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $tutorials->withQueryString()->links() }}
        </div>

        {{-- back link --}}
        <div class="mt-4">
            <a href="{{ route('roadmaps.index') }}" class="text-decoration-none">← Kembali ke daftar Roadmaps</a>
        </div>
    </div>
@endsection
