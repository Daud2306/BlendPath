@extends('layout.frontend.app')

@section('title', $roadmap->judul . ' - BlendPath')

@section('content')
    <!-- Hero Section -->
    <section class="roadmap-hero dark-background">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('roadmaps.index') }}" class="breadcrumb-link">
                                    <i class="bi bi-map me-1"></i>Roadmaps
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="bi bi-signpost-2 me-1"></i>{{ Str::limit($roadmap->judul, 30) }}
                            </li>
                        </ol>
                    </nav>

                    <h1 class="roadmap-title" data-aos="fade-up">
                        <i class="bi bi-signpost-2-fill me-3"></i>{{ $roadmap->judul }}
                    </h1>

                    <p class="roadmap-description" data-aos="fade-up" data-aos-delay="100">
                        {{ $roadmap->deskripsi }}
                    </p>

                    <div class="roadmap-stats" data-aos="fade-up" data-aos-delay="200">
                        <div class="stat-item">
                            <i class="bi bi-play-circle"></i>
                            <span class="stat-number">{{ $tutorials->count() }}</span>
                            <span class="stat-label">Tutorial</span>
                        </div>
                        <div class="stat-item">
                            <i class="bi bi-clock"></i>
                            <span class="stat-number">{{ $progress['completed'] }}/{{ $progress['total'] }}</span>
                            <span class="stat-label">Selesai</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 text-center" data-aos="zoom-in" data-aos-delay="300">
                    @if ($roadmap->gambar)
                        <img src="{{ asset('storage/' . $roadmap->gambar) }}" alt="{{ $roadmap->judul }}"
                            class="roadmap-image img-fluid rounded">
                    @else
                        <div class="roadmap-image-placeholder">
                            <i class="bi bi-signpost-2 display-1"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Progress Section -->
    <section class="progress-section py-4 border-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="progress-card" data-aos="fade-up">
                        <div class="progress-header">
                            <h4 class="progress-title">
                                <i class="bi bi-graph-up me-2"></i>Progress Belajar
                            </h4>
                            <span
                                class="progress-percentage {{ $progress['percentage'] == 100 ? 'text-success' : 'text-primary' }}">
                                {{ $progress['progress_text'] }} ({{ $progress['percentage'] }}%)
                            </span>
                        </div>

                        <div class="progress roadmap-progress-bar">
                            <div class="progress-bar 
                            @if ($progress['percentage'] == 100) bg-success
                            @elseif($progress['percentage'] > 50) bg-primary
                            @elseif($progress['percentage'] > 0) bg-warning
                            @else bg-secondary @endif"
                                role="progressbar" style="width: {{ $progress['percentage'] }}%;"
                                aria-valuenow="{{ $progress['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>

                        @if ($progress['percentage'] == 100)
                            <div class="completion-message text-center mt-3">
                                <i class="bi bi-trophy-fill me-2"></i>
                                <strong>Selamat!</strong> Anda telah menyelesaikan roadmap ini!
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tutorials Section -->
    <section class="tutorials-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-header mb-5" data-aos="fade-up">
                        <h2 class="section-title">
                            <i class="bi bi-list-task me-3"></i>Daftar Tutorial
                        </h2>
                        <p class="section-subtitle">Ikuti tutorial secara berurutan untuk menguasai materi</p>
                    </div>

                    @if ($tutorials->count() === 0)
                        <div class="empty-state text-center py-5" data-aos="fade-up">
                            <i class="bi bi-book display-1 text-muted"></i>
                            <h3 class="mt-3">Belum ada tutorial tersedia</h3>
                            <p class="text-muted">Tutorial untuk roadmap ini sedang dalam pengembangan.</p>
                        </div>
                    @else
                        <div class="tutorials-list">
                            @foreach ($tutorials as $tutorial)
                                @php
                                    $isCompleted = $tutorial->isCompletedByUser();
                                    $isNext =
                                        !$isCompleted &&
                                        ($loop->first || $tutorials[$loop->index - 1]->isCompletedByUser());
                                @endphp

                                <div class="tutorial-card card mb-4 {{ $isCompleted ? 'completed' : '' }} {{ $isNext ? 'next-tutorial' : '' }}"
                                    data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-1 text-center">
                                                <div class="tutorial-order">
                                                    @if ($isCompleted)
                                                        <span class="order-badge completed">
                                                            <i class="bi bi-check-lg"></i>
                                                        </span>
                                                    @elseif($isNext)
                                                        <span class="order-badge next">
                                                            {{ $tutorial->sort_order }}
                                                        </span>
                                                    @else
                                                        <span class="order-badge">
                                                            {{ $tutorial->sort_order }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="tutorial-info">
                                                    <h5 class="tutorial-title {{ $isCompleted ? 'completed' : '' }}">
                                                        @if ($isCompleted)
                                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                        @elseif($isNext)
                                                            <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                        @else
                                                            <i class="bi bi-circle text-muted me-2"></i>
                                                        @endif
                                                        {{ $tutorial->judul }}
                                                    </h5>

                                                    <p class="tutorial-description">
                                                        {{ Str::limit(strip_tags($tutorial->deskripsi), 120) }}
                                                    </p>

                                                    <div class="tutorial-meta">
                                                        <span class="meta-item">
                                                            <i class="bi bi-calendar3 me-1"></i>
                                                            {{ $tutorial->created_at->format('d M Y') }}
                                                        </span>
                                                        <span class="meta-item">
                                                            <i class="bi bi-chat-dots me-1"></i>
                                                            {{ $tutorial->tanya->count() }} diskusi
                                                        </span>
                                                        @if ($isCompleted)
                                                            <span class="meta-item completed">
                                                                <i class="bi bi-check-lg me-1"></i>
                                                                Selesai
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 text-end">
                                                <a href="{{ route('roadmaps.tutorials.show', ['roadmap' => $roadmap->id, 'sort_order' => $tutorial->sort_order]) }}"
                                                    class="btn tutorial-btn {{ $isCompleted ? 'btn-outline-success' : ($isNext ? 'btn-primary' : 'btn-outline-primary') }}">
                                                    @if ($isCompleted)
                                                        <i class="bi bi-arrow-repeat me-2"></i>
                                                        Review
                                                    @elseif($isNext)
                                                        <i class="bi bi-play-fill me-2"></i>
                                                        Lanjutkan
                                                    @else
                                                        <i class="bi bi-lock me-2"></i>
                                                        Kunci
                                                    @endif
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-5">
                            {{ $tutorials->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
