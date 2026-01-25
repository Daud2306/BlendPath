@extends('layout.frontend.app')

@section('title', $modul->judul . ' - BlendPath')

@section('content')
    <!-- Hero Section -->
    <section class="modul-hero dark-background">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('moduls.index') }}" class="breadcrumb-link">
                                    <i class="bi bi-map me-1"></i>Moduls
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="bi bi-signpost-2 me-1"></i>{{ Str::limit($modul->judul, 30) }}
                            </li>
                        </ol>
                    </nav>

                    <h1 class="modul-title" data-aos="fade-up">
                        <i class="bi bi-signpost-2-fill me-3"></i>{{ $modul->judul }}
                    </h1>

                    <p class="modul-description" data-aos="fade-up" data-aos-delay="100">
                        {{ $modul->deskripsi }}
                    </p>

                    <div class="modul-stats" data-aos="fade-up" data-aos-delay="200">
                        <div class="stat-item">
                            <i class="bi bi-play-circle"></i>
                            <span class="stat-number">{{ $submoduls->count() }}</span>
                            <span class="stat-label">Submodul</span>
                        </div>
                        <div class="stat-item">
                            <i class="bi bi-clock"></i>
                            <span class="stat-number">{{ $progress['completed'] }}/{{ $progress['total'] }}</span>
                            <span class="stat-label">Selesai</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 text-center" data-aos="zoom-in" data-aos-delay="300">
                    @if ($modul->gambar)
                        <img src="{{ asset('storage/' . $modul->gambar) }}" alt="{{ $modul->judul }}"
                            class="modul-image img-fluid rounded">
                    @else
                        <div class="modul-image-placeholder">
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

                        <div class="progress modul-progress-bar">
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
                                <strong>Selamat!</strong> Anda telah menyelesaikan modul ini!
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Submoduls Section -->
    <section class="submoduls-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-header mb-5" data-aos="fade-up">
                        <h2 class="section-title">
                            <i class="bi bi-list-task me-3"></i>Daftar Submodul
                        </h2>
                        <p class="section-subtitle">Ikuti submodul secara berurutan untuk menguasai materi</p>
                    </div>

                    @if ($submoduls->count() === 0)
                        <div class="empty-state text-center py-5" data-aos="fade-up">
                            <i class="bi bi-book display-1 text-muted"></i>
                            <h3 class="mt-3">Belum ada submodul tersedia</h3>
                            <p class="text-muted">Submodul untuk modul ini sedang dalam pengembangan.</p>
                        </div>
                    @else
                        <div class="submoduls-list">
                            @foreach ($submoduls as $submodul)
                                @php
                                    $isCompleted = $submodul->isCompletedByUser();
                                    $isNext =
                                        !$isCompleted &&
                                        ($loop->first || $submoduls[$loop->index - 1]->isCompletedByUser());
                                @endphp

                                <div class="submodul-card card mb-4 {{ $isCompleted ? 'completed' : '' }} {{ $isNext ? 'next-submodul' : '' }}"
                                    data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-1 text-center">
                                                <div class="submodul-order">
                                                    @if ($isCompleted)
                                                        <span class="order-badge completed">
                                                            <i class="bi bi-check-lg"></i>
                                                        </span>
                                                    @elseif($isNext)
                                                        <span class="order-badge next">
                                                            {{ $submodul->sort_order }}
                                                        </span>
                                                    @else
                                                        <span class="order-badge">
                                                            {{ $submodul->sort_order }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="submodul-info">
                                                    <h5 class="submodul-title {{ $isCompleted ? 'completed' : '' }}">
                                                        @if ($isCompleted)
                                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                        @elseif($isNext)
                                                            <i class="bi bi-play-circle-fill text-primary me-2"></i>
                                                        @else
                                                            <i class="bi bi-circle text-muted me-2"></i>
                                                        @endif
                                                        {{ $submodul->judul }}
                                                    </h5>

                                                    <p class="submodul-description">
                                                        {{ Str::limit(strip_tags($submodul->deskripsi), 120) }}
                                                    </p>

                                                    <div class="submodul-meta">
                                                        <span class="meta-item">
                                                            <i class="bi bi-calendar3 me-1"></i>
                                                            {{ $submodul->created_at->format('d M Y') }}
                                                        </span>
                                                        <span class="meta-item">
                                                            <i class="bi bi-chat-dots me-1"></i>
                                                            {{ $submodul->tanya->count() }} diskusi
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
                                                <a href="{{ route('moduls.submoduls.show', ['modul' => $modul->id, 'sort_order' => $submodul->sort_order]) }}"
                                                    class="btn submodul-btn {{ $isCompleted ? 'btn-outline-success' : ($isNext ? 'btn-primary' : 'btn-outline-primary') }}">
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
                            {{ $submoduls->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
