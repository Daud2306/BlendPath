@extends('layout.frontend.app')

@section('title', 'BlendPath - Platform Belajar Blender 3D')

@section('content')
    <section id="hero" class="hero d-flex align-items-center light-background">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1>
                        Kuasai <span>Blender</span> dengan Mudah
                    </h1>
                    <p>
                        Platform pembelajaran Blender 3D terstruktur untuk mengembangkan skill modeling, animation, dan
                        rendering Anda.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('roadmaps.index') }}" class="btn-get-started">
                            <i class="bi bi-play-circle me-2"></i>Mulai Belajar
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="animated">
                        <img src="{{ asset('frontend/img/details-5.png') }}" alt="Blender 3D" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="features light-background">
        <div class="container">
            <div class="section-title">
                <h2>Mengapa Belajar di BlendPath?</h2>
                <div>Keunggulan Platform Kami</div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="icon-box">
                        <i class="bi bi-diagram-3"></i>
                        <h3>Struktur Belajar Terarah</h3>
                        <p>Roadmap pembelajaran yang jelas dari dasar hingga advanced</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mt-4 mt-md-0">
                    <div class="icon-box">
                        <i class="bi bi-play-btn"></i>
                        <h3>Video Tutorial Lengkap</h3>
                        <p>Konten video step-by-step dengan penjelasan detail</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mt-4 mt-lg-0">
                    <div class="icon-box">
                        <i class="bi bi-chat-dots"></i>
                        <h3>Komunitas Interaktif</h3>
                        <p>Tanya jawab dengan instruktur dan sesama learner</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="roadmaps" class="roadmaps light-background">
        <div class="container">
            <div class="section-title">
                <h2>Learning Path</h2>
                <div>Pilih Jalur Belajar Anda</div>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @php
                    $roadmaps = Roadmap::withCount('tutorials')->take(6)->get();
                @endphp

                @if ($roadmaps->count() > 0)
                    @foreach ($roadmaps as $roadmap)
                        <div class="col">
                            <div class="card h-100 roadmap-card">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex align-items-start mb-3">
                                        @if ($roadmap->gambar)
                                            <img src="{{ asset('storage/' . $roadmap->gambar) }}"
                                                alt="{{ $roadmap->judul }}" class="rounded me-3"
                                                style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="rounded d-flex align-items-center justify-content-center me-3"
                                                style="width: 60px; height: 60px; background: var(--accent-color); color: white;">
                                                <i class="bi bi-cube"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <h5 class="fw-bold mb-1">{{ $roadmap->judul }}</h5>
                                            <span class="badge" style="background: var(--accent-color); color: white;">
                                                {{ $roadmap->tutorials_count }} Tutorial
                                            </span>
                                        </div>
                                    </div>
                                    <p class="mb-3 flex-grow-1">{{ Str::limit($roadmap->deskripsi, 120) }}</p>
                                    <div class="mt-auto">
                                        <a href="{{ route('roadmaps.show', $roadmap) }}"
                                            class="btn btn-sm w-100 roadmap-btn">
                                            Lihat Kursus
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-cube display-1" style="color: var(--accent-color);"></i>
                        <h4 class="mt-3">Kursus Akan Segera Hadir</h4>
                        <p class="text-muted">Kami sedang menyiapkan konten terbaik untuk Anda</p>
                    </div>
                @endif
            </div>

            @if ($roadmaps->count() > 0)
                <div class="text-center mt-4">
                    <a href="{{ route('roadmaps.index') }}" class="btn-get-started">
                        <i class="bi bi-grid me-2"></i>Lihat Semua Kursus
                    </a>
                </div>
            @endif
        </div>
    </section>

    <section id="stats" class="stats light-background">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stats-item">
                        <i class="bi bi-people"></i>
                        <span>{{ User::count() }}+</span>
                        <p>3D Artists</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item">
                        <i class="bi bi-play-circle"></i>
                        <span>{{ Tutorial::count() }}+</span>
                        <p>Video Tutorial</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item">
                        <i class="bi bi-diagram-3"></i>
                        <span>{{ Roadmap::count() }}+</span>
                        <p>Learning Path</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item">
                        <i class="bi bi-chat-dots"></i>
                        <span>{{ Tanya::count() }}+</span>
                        <p>Diskusi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="cta" class="cta light-background">
        <div class="container">
            <div class="text-center">
                <h3>Ready untuk Memulai Perjalanan 3D Anda?</h3>
                <p>Bergabung dengan komunitas Blender terbaik dan kembangkan skill Anda</p>

                @auth
                    <a href="{{ route('roadmaps.index') }}" class="btn-get-started">
                        <i class="bi bi-play-circle me-2"></i>Lanjutkan Belajar
                    </a>
                @else
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('register') }}" class="btn-get-started">
                            <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="btn-watch-video">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </section>
@endsection
