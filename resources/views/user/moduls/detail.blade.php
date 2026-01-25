@extends('layout.frontend.app')

@section('title', 'Submoduls - Modul A')

@section('content')
    <div class="container my-5">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('moduls.index') }}" class="text-decoration-none">Moduls</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $modul->judul }}</li>
            </ol>
        </nav>

        <div class="card mb-4 shadow-sm">
            <div class="row g-0 align-items-center">
                <div class="col-md-4">
                    @php
                        $thumb = $modul->gambar
                            ? asset('storage/' . $modul->gambar)
                            : asset('frontend/img/basic.jpeg');
                    @endphp
                    <img src="{{ $thumb }}" alt="Thumbnail {{ $modul->judul }}"
                        class="img-fluid rounded-start w-100" style="height:200px; object-fit:cover;">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h2 class="card-title mb-1">{{ $modul->judul }}</h2>
                        <p class="card-text text-muted mb-2">{!! nl2br(e(Str::limit($modul->deskripsi ?? '-', 400))) !!}</p>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <span class="badge bg-primary">Total: {{ $submoduls->total() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            @forelse($submoduls as $submodul)
                <div class="col-12">
                    <article class="card h-100 shadow-sm">
                        <div class="row g-0 align-items-center">
                            <div class="col-md">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h5 class="card-title mb-1">{{ $submodul->judul }}</h5>
                                        <span
                                            class="badge bg-secondary">#{{ $submodul->sort_order ?? $submodul->id }}</span>
                                    </div>

                                    <p class="card-text text-muted mb-2">
                                        {!! \Illuminate\Support\Str::limit(strip_tags($submodul->deskripsi ?? ($submodul->konten ?? '')), 180) !!}
                                    </p>

                                    <div class="mt-auto d-flex gap-3 align-items-center">
                                        <small class="text-muted">Dibuat:
                                            {{ $submodul->created_at ? $submodul->created_at->format('d M Y') : '-' }}</small>
                                        @if (isset($submodul->durasi) && $submodul->durasi)
                                            <small class="text-muted">Durasi: {{ $submodul->durasi }}</small>
                                        @endif
                                        <div class="ms-auto">
                                            <a href="{{ route('moduls.submoduls.show', ['modul' => $modul->id, 'sort_order' => $submodul->sort_order]) }}"
                                                class="btn btn-primary btn-sm">Buka Submodul</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">Belum ada submodul pada modul ini.</div>
                </div>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $submoduls->withQueryString()->links() }}
        </div>

        <div class="mt-4">
            <a href="{{ route('moduls.index') }}" class="text-decoration-none">← Kembali ke daftar Moduls</a>
        </div>
    </div>
@endsection