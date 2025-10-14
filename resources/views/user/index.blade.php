@extends('layout.frontend.app')

@section('title', 'Belajar Blender — Home')

@section('content')
@section('title', 'BlendPath - Platform Belajar Blender 3D')

@section('content')
    <section class="bg-primary py-5">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">
                        Kuasai <span class="text-warning">Blender</span> dengan sulit
                    </h1>
                    <p class="lead mb-4">
                        platform untuk.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('roadmaps.index') }}" class="btn btn-warning btn-lg">
                            <i class="fas fa-play me-2"></i>Mulai Belajar
                        </a>
                        <a href="#roadmaps" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-cube me-2"></i>Lihat Kursus
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="{{ asset('frontend/img/details-5.png') }}" alt="Blender 3D Hero image"
                        class="img-fluid rounded shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Mengapa Belajar di BlendPath?</h2>
                <p class="text-muted">Karena</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-cubes text-primary display-4 mb-3"></i>
                            <h5 class="fw-bold">Struktur belajar tdk terarah</h5>
                            <p class="text-muted">btul</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-video text-success display-4 mb-3"></i>
                            <h5 class="fw-bold">tutor bang</h5>
                            <p class="text-muted">ada video</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-hands-helping text-info display-4 mb-3"></i>
                            <h5 class="fw-bold">tanya jawab</h5>
                            <p class="text-muted">nanyak apa ajah</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="roadmaps" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">ada roadmap</h2>
                <p class="text-muted">beberapa</p>
            </div>

            <div class="row g-4">
                @php
                    $roadmaps = \App\Models\Roadmap::withCount('tutorials')->take(6)->get();
                @endphp

                @if ($roadmaps->count() > 0)
                    @foreach ($roadmaps as $roadmap)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-start mb-3">
                                        @if ($roadmap->gambar)
                                            <img src="{{ asset('storage/' . $roadmap->gambar) }}"
                                                alt="{{ $roadmap->judul }}" class="rounded me-3"
                                                style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-primary rounded d-flex align-items-center justify-content-center me-3 text-white"
                                                style="width: 60px; height: 60px;">
                                                <i class="fas fa-cube fa-lg"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <h5 class="fw-bold mb-1">{{ $roadmap->judul }}</h5>
                                            <span class="badge bg-primary">{{ $roadmap->tutorials_count }} Lesson</span>
                                        </div>
                                    </div>
                                    <p class="text-muted mb-3">{{ Str::limit($roadmap->deskripsi, 120) }}</p>
                                    <a href="{{ route('roadmaps.show', $roadmap) }}" class="btn btn-outline-primary btn-sm">
                                        Lihat Kursus
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center py-4">
                        <i class="fas fa-cube display-1 text-muted mb-3"></i>
                        <h5 class="text-muted">Kursus akan segera hadir</h5>
                        <p class="text-muted">Kami sedang menyiapkan konten terbaik untuk Anda</p>
                    </div>
                @endif
            </div>

            @if ($roadmaps->count() > 0)
                <div class="text-center mt-4">
                    <a href="{{ route('roadmaps.index') }}" class="btn btn-primary">
                        <i class="fas fa-th-large me-2"></i>Semua Kursus
                    </a>
                </div>
            @endif
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4">
                    <i class="fas fa-graduation-cap fa-2x text-primary mb-3"></i>
                    <h4 class="fw-bold">{{ \App\Models\User::count() }}+</h4>
                    <p class="text-muted mb-0">3D Artists</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <i class="fas fa-play-circle fa-2x text-primary mb-3"></i>
                    <h4 class="fw-bold">{{ \App\Models\Tutorial::count() }}+</h4>
                    <p class="text-muted mb-0">Video Tutorial</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <i class="fas fa-project-diagram fa-2x text-primary mb-3"></i>
                    <h4 class="fw-bold">{{ \App\Models\Roadmap::count() }}+</h4>
                    <p class="text-muted mb-0">Learning Path</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <i class="fas fa-comments fa-2x text-primary mb-3"></i>
                    <h4 class="fw-bold">{{ \App\Models\Tanya::count() }}+</h4>
                    <p class="text-muted mb-0">Diskusi</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h3 class="fw-bold mb-3">pernah ga ready?</h3>
            <p class="lead mb-4">mulai perjalanan anda</p>

            @auth
                <a href="{{ route('roadmaps.index') }}" class="btn btn-warning btn-lg">
                    <i class="fas fa-play me-2"></i>Lanjutkan Belajar
                </a>
            @else
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('register') }}" class="btn btn-warning btn-lg">
                        <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i>Masuk
                    </a>
                </div>
            @endauth
        </div>
    </section>
@endsection
