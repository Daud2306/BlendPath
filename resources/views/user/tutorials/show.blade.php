@extends('layout.frontend.app')

@section('content')
@section('content')
    <div class="container my-4">
        <div class="card shadow-sm mt-5">
            <div class="card-body">
                <h1 class="h4 mb-3">{{ $tutorial->judul }}</h1>

                @foreach ($tutorial->resources ?? [] as $res)
                    @if (str_contains($res->resource, 'youtube.com/embed'))
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-8">
                                <div class="ratio ratio-16x9">
                                    <iframe src="{{ $res->resource }}" title="YouTube video" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

                @if (!empty($tutorial->konten))
                    <p class="mb-4 text-muted">{!! nl2br(e($tutorial->konten)) !!}</p>
                @endif

                <a href="{{ route('roadmaps.show', $roadmap->id) }}" class="btn btn-secondary">
                    Kembali ke Daftar Tutorial
                </a>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            @if ($prevTutorial)
                <a href="{{ route('roadmaps.tutorials.show', ['roadmap' => $roadmap->id, 'sort_order' => $prevTutorial->sort_order]) }}"
                    class="btn btn-outline-secondary">
                    <i class="fas fa-chevron-left me-1"></i>Tutorial Sebelumnya
                </a>
            @else
                <span class="btn btn-outline-secondary disabled">
                    <i class="fas fa-chevron-left me-1"></i>Tutorial Sebelumnya
                </span>
            @endif

            @if ($nextTutorial)
                <a href="{{ route('roadmaps.tutorials.show', ['roadmap' => $roadmap->id, 'sort_order' => $nextTutorial->sort_order]) }}"
                    class="btn btn-primary">
                    Tutorial Selanjutnya <i class="fas fa-chevron-right ms-1"></i>
                </a>
            @else
                <span class="btn btn-primary disabled">
                    Tutorial Selanjutnya <i class="fas fa-chevron-right ms-1"></i>
                </span>
            @endif
        </div>

        @auth
            <div class="card mt-4">
                <div class="card-body">
                    <h6>Progress Belajar</h6>

                    @if ($tutorial->isCompletedByUser())
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            Anda sudah menyelesaikan tutorial ini!
                        </div>
                        <form
                            action="{{ route('roadmaps.tutorials.incomplete', ['roadmap' => $roadmap->id, 'sort_order' => $tutorial->sort_order]) }}"
                            method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-undo me-1"></i> Tandai Belum Selesai
                            </button>
                        </form>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-clock me-2"></i>
                            Tutorial ini belum diselesaikan
                        </div>
                        <form
                            action="{{ route('roadmaps.tutorials.complete', ['roadmap' => $roadmap->id, 'sort_order' => $tutorial->sort_order]) }}"
                            method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-check me-1"></i> Tandai Sudah Selesai
                            </button>
                        </form>
                    @endif

                    @if (isset($roadmapProgress))
                        <div class="mt-3">
                            <small class="text-muted">Progress Roadmap: {{ $roadmapProgress['progress_text'] }}</small>
                            <div class="progress mt-1" style="height: 8px;">
                                <div class="progress-bar" role="progressbar"
                                    style="width: {{ $roadmapProgress['percentage'] }}%;"
                                    aria-valuenow="{{ $roadmapProgress['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="alert alert-info mt-4">
                <i class="fas fa-info-circle me-2"></i>
                <a href="{{ route('login') }}" class="alert-link">Login</a> untuk menandai progress belajar Anda.
            </div>
        @endauth

        @if ($tutorial->quizzes->count() > 0)
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Quizzes</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach ($tutorial->quizzes as $quiz)
                            <a href="{{ route('roadmaps.tutorials.quiz.show', [
                                'roadmap' => $roadmap->id,
                                'sort_order' => $tutorial->sort_order,
                            ]) }}"
                                class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $quiz->judul_quiz }}</h6>
                                    <small>{{ $quiz->pertanyaan->count() }} soal</small>
                                </div>
                                <p class="mb-1">Passing score: {{ $quiz->passing_score }}%</p>
                                <small class="text-muted">Klik untuk mengerjakan quiz</small>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @include('user.tutorials.partials.qna')
    </div>
@endsection
