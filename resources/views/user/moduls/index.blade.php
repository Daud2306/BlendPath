@extends('layout.frontend.app')

@section('title', 'Moduls - BlendPath')

@section('content')
    <!-- Hero Section -->
    <section class="page-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="hero-title">
                        Learning Moduls
                    </h1>
                    <p class="hero-subtitle">
                        Ikuti modul terstruktur untuk menguasai Blender 3D dari dasar hingga mahir
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="modul-stats">
                        <div class="stat-item">
                            <span class="stat-number">{{ $moduls->count() }}</span>
                            <span class="stat-label">Moduls Tersedia</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Moduls Section -->
    <section class="moduls-section">
        <div class="container">
            @if ($moduls->count() === 0)
                <div class="empty-state">
                    <i class="bi bi-map display-1"></i>
                    <h3>Belum ada modul tersedia</h3>
                    <p>Modul sedang dalam pengembangan. Silakan kembali nanti.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach ($moduls as $modul)
                        @php
                            $progress = $modul->getUserProgress();
                            $isComplete = $progress['percentage'] == 100;
                        @endphp

                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="modul-card {{ $isComplete ? 'modul-complete' : '' }}">
                                <!-- Card Image -->
                                <div class="card-image">
                                    @if ($modul->gambar)
                                        <img src="{{ asset('storage/' . $modul->gambar) }}" alt="{{ $modul->judul }}">
                                    @else
                                        <div class="card-img-placeholder">
                                            <i class="bi bi-cube"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Card Content -->
                                <div class="card-body">
                                    <div class="modul-meta">
                                        <span>{{ $modul->submoduls->count() }} Submodul</span>
                                    </div>

                                    <h5 class="card-title">{{ $modul->judul }}</h5>

                                    <p class="card-text">
                                        {{ Str::limit(strip_tags($modul->deskripsi), 100) }}
                                    </p>

                                    <!-- Progress Section -->
                                    <div class="progress-section">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="progress-label">Progress</span>
                                            <span class="progress-percentage">{{ $progress['percentage'] }}%</span>
                                        </div>
                                        <div class="modul-progress">
                                            <div class="progress-bar" style="width: {{ $progress['percentage'] }}%;">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <a href="{{ route('moduls.show', $modul) }}" class="modul-btn mt-3">
                                        @if ($isComplete)
                                            Lihat Kembali
                                        @elseif($progress['percentage'] > 0)
                                            Lanjutkan
                                        @else
                                            Mulai Belajar
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
