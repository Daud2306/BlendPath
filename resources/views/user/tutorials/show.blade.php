@extends('layout.frontend.app')

@section('title', $tutorial->judul . ' - BlendPath')

@section('content')
    <!-- Hero Section -->
    <section class="tutorial-hero dark-background">
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
                            <li class="breadcrumb-item">
                                <a href="{{ route('roadmaps.show', $roadmap->id) }}" class="breadcrumb-link">
                                    <i class="bi bi-signpost-2 me-1"></i>{{ Str::limit($roadmap->judul, 20) }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="bi bi-play-circle me-1"></i>{{ Str::limit($tutorial->judul, 25) }}
                            </li>
                        </ol>
                    </nav>

                    <h1 class="tutorial-title" data-aos="fade-up">
                        <i class="bi bi-play-circle-fill me-3"></i>{{ $tutorial->judul }}
                    </h1>

                    <div class="tutorial-meta" data-aos="fade-up" data-aos-delay="100">
                        <span class="meta-item">
                            <i class="bi bi-list-ol me-1"></i>Urutan: {{ $tutorial->sort_order }}
                        </span>
                        <span class="meta-item">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $tutorial->created_at->format('d M Y') }}
                        </span>
                    </div>
                </div>

                <div class="col-lg-4 text-center" data-aos="zoom-in">
                    @if ($roadmap->gambar)
                        <img src="{{ asset('storage/' . $roadmap->gambar) }}" alt="{{ $roadmap->judul }}"
                            class="roadmap-thumbnail img-fluid rounded">
                    @else
                        <div class="roadmap-thumbnail-placeholder">
                            <i class="bi bi-signpost-2 display-1"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Alert Messages -->
    @if (session('error'))
        <div class="container mt-4">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- Tutorial Content -->
    <section class="tutorial-content py-5 light-background">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Video Resources -->
                    @foreach ($tutorial->resources ?? [] as $res)
                        @if (str_contains($res->resource, 'youtube.com/embed'))
                            <div class="video-container mb-5" data-aos="fade-up">
                                <div class="ratio ratio-16x9">
                                    <iframe src="{{ $res->resource }}" title="YouTube video" allowfullscreen
                                        class="rounded shadow-sm"></iframe>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <!-- Tutorial Content -->
                    @if (!empty($tutorial->konten))
                        <div class="content-card card shadow-sm mb-5" data-aos="fade-up">
                            <div class="card-body">
                                <h4 class="card-title mb-4">
                                    <i class="bi bi-journal-text me-2"></i>Materi Tutorial
                                </h4>
                                <div class="tutorial-text">
                                    {!! nl2br(e($tutorial->konten)) !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Navigation Buttons -->
                    <div class="navigation-buttons d-flex justify-content-between mt-5" data-aos="fade-up">
                        @if ($prevTutorial)
                            <a href="{{ route('roadmaps.tutorials.show', ['roadmap' => $roadmap->id, 'sort_order' => $prevTutorial->sort_order]) }}"
                                class="btn btn-outline-primary">
                                <i class="bi bi-chevron-left me-2"></i>Tutorial Sebelumnya
                            </a>
                        @else
                            <a href="{{ route('roadmaps.show', $roadmap->id) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali ke Roadmap
                            </a>
                        @endif

                        @if ($nextTutorial)
                            @php
                                $isNextAccessible = auth()->check() && $tutorial->isCompletedByUser();
                            @endphp

                            @if ($isNextAccessible)
                                <a href="{{ route('roadmaps.tutorials.show', ['roadmap' => $roadmap->id, 'sort_order' => $nextTutorial->sort_order]) }}"
                                    class="btn btn-primary">
                                    Tutorial Selanjutnya <i class="bi bi-chevron-right ms-2"></i>
                                </a>
                            @else
                                <button class="btn btn-secondary" disabled title="Selesaikan tutorial ini terlebih dahulu">
                                    Tutorial Selanjutnya <i class="bi bi-lock ms-2"></i>
                                </button>
                            @endif
                        @else
                            <a href="{{ route('roadmaps.show', $roadmap->id) }}" class="btn btn-success">
                                <i class="bi bi-check-circle me-2"></i>Selesai Roadmap
                            </a>
                        @endif
                    </div>

                    @auth
                        <div class="progress-card card mt-4" data-aos="fade-up">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="bi bi-graph-up me-2"></i>Progress Belajar
                                </h5>

                                @if ($tutorial->isCompletedByUser())
                                    <div class="alert alert-success">
                                        <i class="bi bi-check-circle-fill me-2"></i>
                                        Anda sudah menyelesaikan tutorial ini!
                                    </div>
                                    <form
                                        action="{{ route('roadmaps.tutorials.incomplete', ['roadmap' => $roadmap->id, 'sort_order' => $tutorial->sort_order]) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-warning">
                                            <i class="bi bi-arrow-repeat me-2"></i> Tandai Belum Selesai
                                        </button>
                                    </form>
                                @else
                                    <div class="alert alert-info">
                                        <i class="bi bi-clock me-2"></i>
                                        Tutorial ini belum diselesaikan
                                    </div>
                                    <form
                                        action="{{ route('roadmaps.tutorials.complete', ['roadmap' => $roadmap->id, 'sort_order' => $tutorial->sort_order]) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-check-circle me-2"></i> Tandai Sudah Selesai
                                        </button>
                                    </form>
                                @endif

                                @if (isset($roadmapProgress))
                                    <div class="roadmap-progress mt-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted">Progress Roadmap</small>
                                            <small class="fw-bold text-primary">
                                                {{ $roadmapProgress['progress_text'] }}
                                                ({{ $roadmapProgress['percentage'] }}%)
                                            </small>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ $roadmapProgress['percentage'] }}%;"
                                                aria-valuenow="{{ $roadmapProgress['percentage'] }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info mt-4" data-aos="fade-up">
                            <i class="bi bi-info-circle me-2"></i>
                            <a href="{{ route('login') }}" class="alert-link">Login</a> untuk menandai progress belajar Anda.
                        </div>
                    @endauth

                    @if ($tutorial->quizzes->count() > 0)
                        <div class="quizzes-card card mt-4" data-aos="fade-up">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-patch-question me-2"></i>Quiz
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="quizzes-list">
                                    @foreach ($tutorial->quizzes as $quiz)
                                        <a href="{{ route('roadmaps.tutorials.quiz.show', [
                                            'roadmap' => $roadmap->id,
                                            'sort_order' => $tutorial->sort_order,
                                        ]) }}"
                                            class="quiz-item d-block p-3 border rounded mb-3 text-decoration-none">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1 text-dark">{{ $quiz->judul_quiz }}</h6>
                                                    <p class="mb-1 text-muted small">
                                                        Passing score: {{ $quiz->passing_score }}%
                                                    </p>
                                                    <small class="text-muted">{{ $quiz->pertanyaan->count() }}
                                                        soal</small>
                                                </div>
                                                <i class="bi bi-arrow-right-short text-primary fs-4"></i>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @include('user.tutorials.partials.qna')
                </div>
            </div>
        </div>
    </section>
@endsection
