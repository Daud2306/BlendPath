@extends('layout.frontend.app')

@section('title', 'Roadmaps - BlendPath')

@section('content')
<!-- Hero Section -->
<section class="page-hero dark-background">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="hero-title" data-aos="fade-up">
                    <i class="bi bi-map me-3"></i>Learning Roadmaps
                </h1>
                <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Ikuti roadmap terstruktur untuk menguasai Blender 3D dari dasar hingga mahir
                </p>
            </div>
            <div class="col-lg-4 text-lg-end" data-aos="fade-left">
                <div class="roadmap-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $roadmaps->count() }}</span>
                        <span class="stat-label">Roadmaps Tersedia</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Roadmaps Section -->
<section class="roadmaps-section py-5">
    <div class="container">
        @if ($roadmaps->count() === 0)
            <div class="empty-state text-center py-5" data-aos="fade-up">
                <i class="bi bi-map display-1 text-muted"></i>
                <h3 class="mt-3">Belum ada roadmap tersedia</h3>
                <p class="text-muted">Roadmap sedang dalam pengembangan. Silakan kembali nanti.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach ($roadmaps as $roadmap)
                    @php
                        $progress = $roadmap->getUserProgress();
                    @endphp

                    <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="roadmap-card card h-100">
                            <!-- Card Header with Image -->
                            <div class="card-image position-relative">
                                @if ($roadmap->gambar)
                                    <img src="{{ asset('storage/' . $roadmap->gambar) }}" class="card-img-top"
                                        alt="{{ $roadmap->judul }}">
                                @else
                                    <div class="card-img-placeholder bg-gradient-primary">
                                        <i class="bi bi-map"></i>
                                    </div>
                                @endif
                                
                                <!-- Progress Badge -->
                                <div class="progress-badge">
                                    @if ($progress['percentage'] == 100)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Selesai
                                        </span>
                                    @elseif($progress['percentage'] > 0)
                                        <span class="badge bg-primary">
                                            {{ $progress['percentage'] }}%
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Baru
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body d-flex flex-column">
                                <div class="roadmap-meta mb-2">
                                    <span class="roadmap-order">
                                        <i class="bi bi-list-ol me-1"></i>Urutan {{ $roadmap->sort_order }}
                                    </span>
                                    <span class="roadmap-tutorials">
                                        <i class="bi bi-play-circle me-1"></i>{{ $roadmap->tutorials->count() }} Tutorial
                                    </span>
                                </div>

                                <h5 class="card-title">{{ $roadmap->judul }}</h5>
                                
                                <p class="card-text flex-grow-1">
                                    {!! \Illuminate\Support\Str::limit(strip_tags($roadmap->deskripsi), 120) !!}
                                </p>

                                <!-- Progress Section -->
                                <div class="progress-section mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <small class="text-muted">Progress Belajar</small>
                                        <small class="fw-bold progress-percentage {{ $progress['percentage'] == 100 ? 'text-success' : 'text-primary' }}">
                                            {{ $progress['percentage'] }}%
                                        </small>
                                    </div>
                                    <div class="progress roadmap-progress">
                                        <div class="progress-bar 
                                            @if ($progress['percentage'] == 100) bg-success
                                            @elseif($progress['percentage'] > 50) bg-primary
                                            @elseif($progress['percentage'] > 0) bg-warning
                                            @else bg-secondary @endif"
                                            role="progressbar" 
                                            style="width: {{ $progress['percentage'] }}%;"
                                            aria-valuenow="{{ $progress['percentage'] }}" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100">
                                        </div>
                                    </div>
                                    @if ($progress['percentage'] == 100)
                                        <small class="text-success mt-2 d-block">
                                            <i class="bi bi-check-circle-fill me-1"></i> Selamat! Anda telah menyelesaikan roadmap ini
                                        </small>
                                    @endif
                                </div>

                                <!-- Action Button -->
                                <div class="mt-auto">
                                    <a href="{{ route('roadmaps.show', $roadmap) }}" class="btn roadmap-btn w-100">
                                        @if ($progress['percentage'] == 100)
                                            <i class="bi bi-arrow-repeat me-2"></i>Review Kembali
                                        @elseif($progress['percentage'] > 0)
                                            <i class="bi bi-play-circle me-2"></i>Lanjutkan Belajar
                                        @else
                                            <i class="bi bi-play-fill me-2"></i>Mulai Belajar
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            {{-- <div class="mt-5">
                {{ $roadmaps->links() }}
            </div> --}}
        @endif
    </div>
</section>
@endsection