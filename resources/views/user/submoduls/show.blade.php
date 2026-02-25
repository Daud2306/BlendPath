@extends('layout.frontend.app')

@section('title', $submodul->judul . ' - BlendPath')

@section('content')
    <section class="submodul-hero dark-background">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('learn.moduls.index') }}" class="breadcrumb-link">
                                    <i class="bi bi-map me-1"></i>Moduls
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('learn.moduls.show', $modul->id) }}" class="breadcrumb-link">
                                    <i class="bi bi-signpost-2 me-1"></i>{{ Str::limit($modul->judul, 20) }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="bi bi-play-circle me-1"></i>{{ Str::limit($submodul->judul, 25) }}
                            </li>
                        </ol>
                    </nav>

                    <h1 class="submodul-title" data-aos="fade-up">
                        <i class="bi bi-play-circle-fill me-3"></i>{{ $submodul->judul }}
                    </h1>

                    <div class="submodul-meta" data-aos="fade-up" data-aos-delay="100">
                        <span class="meta-item">
                            <i class="bi bi-list-ol me-1"></i>Urutan: {{ $submodul->sort_order }}
                        </span>
                        <span class="meta-item">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $submodul->created_at->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (session('error'))
        <div class="container mt-4">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <section class="submodul-content py-5 light-background">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    @foreach ($submodul->resources ?? [] as $res)
                        @if (str_contains($res->resource, 'youtube.com/embed'))
                            <div class="video-container mb-5" data-aos="fade-up">
                                <div class="ratio ratio-16x9">
                                    <iframe src="{{ $res->resource }}" title="YouTube video" allowfullscreen
                                        class="rounded shadow-sm"></iframe>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    @if (!empty($submodul->konten))
                        <div class="content-card card shadow-sm mb-5" data-aos="fade-up">
                            <div class="card-body">
                                <h4 class="card-title mb-4">
                                    <i class="bi bi-journal-text me-2"></i>Materi Submodul
                                </h4>
                                <div class="submodul-text">
                                    {!! nl2br(e($submodul->konten)) !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="navigation-buttons d-flex justify-content-between mt-5" data-aos="fade-up">
                        @if ($prevSubmodul)
                            <a href="{{ route('learn.submoduls.show', ['modul' => $modul->id, 'sort_order' => $prevSubmodul->sort_order]) }}"
                                class="btn btn-outline-primary">
                                <i class="bi bi-chevron-left me-2"></i>Submodul Sebelumnya
                            </a>
                        @else
                            <a href="{{ route('learn.moduls.show', $modul->id) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali ke Modul
                            </a>
                        @endif

                        @if ($nextSubmodul)
                            @php
                                $isNextAccessible = auth()->check() && $submodul->isCompletedByUser();
                            @endphp

                            @if ($isNextAccessible)
                                <a href="{{ route('learn.submoduls.show', ['modul' => $modul->id, 'sort_order' => $nextSubmodul->sort_order]) }}"
                                    class="btn btn-primary">
                                    Submodul Selanjutnya <i class="bi bi-chevron-right ms-2"></i>
                                </a>
                            @else
                                <button class="btn btn-secondary" disabled title="Selesaikan submodul ini terlebih dahulu">
                                    Submodul Selanjutnya <i class="bi bi-lock ms-2"></i>
                                </button>
                            @endif
                        @else
                            <a href="{{ route('moduls.show', $modul->id) }}" class="btn btn-success">
                                <i class="bi bi-check-circle me-2"></i>Selesai Modul
                            </a>
                        @endif
                    </div>

                    @auth
                        <div class="progress-card card mt-4" data-aos="fade-up">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="bi bi-graph-up me-2"></i>Progress Belajar
                                </h5>

                                @if ($submodul->isCompletedByUser())
                                    <div class="alert alert-success">
                                        <i class="bi bi-check-circle-fill me-2"></i>
                                        Anda sudah menyelesaikan submodul ini!
                                    </div>
                                    <form
                                        action="{{ route('learn.submoduls.incomplete', ['modul' => $modul->id, 'sort_order' => $submodul->sort_order]) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-warning">
                                            <i class="bi bi-arrow-repeat me-2"></i> Tandai Belum Selesai
                                        </button>
                                    </form>
                                @else
                                    <div class="alert alert-info">
                                        <i class="bi bi-clock me-2"></i>
                                        Submodul ini belum diselesaikan
                                    </div>
                                    <form
                                        action="{{ route('learn.submoduls.complete', ['modul' => $modul->id, 'sort_order' => $submodul->sort_order]) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-check-circle me-2"></i> Tandai Sudah Selesai
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info mt-4" data-aos="fade-up">
                            <i class="bi bi-info-circle me-2"></i>
                            <a href="{{ route('login') }}" class="alert-link">Login</a> untuk menandai progress belajar Anda.
                        </div>
                    @endauth

                    @if ($submodul->quizzes->count() > 0)
                        <div class="quizzes-card card mt-4" data-aos="fade-up">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-patch-question me-2"></i>Quiz
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="quizzes-list">
                                    @foreach ($submodul->quizzes as $quiz)
                                        <a href="{{ route('learn.submoduls.quiz.show', [
                                            'modul' => $modul->id,
                                            'sort_order' => $submodul->sort_order,
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

                    @include('user.submoduls.partials.qna')
                </div>
            </div>
        </div>
    </section>
@endsection
