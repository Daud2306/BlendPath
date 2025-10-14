@extends('layout.frontend.app')

@section('content')
    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('roadmaps.index') }}">Roadmaps</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('roadmaps.show', $roadmap) }}">{{ $roadmap->nama }}</a>
                        </li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('roadmaps.tutorials.show', ['roadmap' => $roadmap->id, 'sort_order' => $tutorial->sort_order]) }}">{{ $tutorial->judul }}</a>
                        </li>
                        <li class="breadcrumb-item active">Quizzes</li>
                    </ol>
                </nav>

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-tasks me-2"></i>Quizzes - {{ $tutorial->judul }}
                        </h4>
                    </div>
                    <div class="card-body">
                        @if ($tutorial->quizzes->count() > 0)
                            <div class="row">
                                @foreach ($tutorial->quizzes as $quiz)
                                    @php
                                        $userQuizRespon = $userRespon[$quiz->id] ?? null;
                                    @endphp
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-header bg-light">
                                                <h5 class="card-title mb-0">{{ $quiz->judul_quiz }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <small class="text-muted">Jumlah Soal:</small>
                                                    <div class="fw-semibold">{{ $quiz->pertanyaan->count() }} soal</div>
                                                </div>
                                                <div class="mb-3">
                                                    <small class="text-muted">Passing Score:</small>
                                                    <div class="fw-semibold">{{ $quiz->passing_score }}%</div>
                                                </div>
                                                <div class="mb-3">
                                                    <small class="text-muted">Total Poin:</small>
                                                    <div class="fw-semibold">{{ $quiz->pertanyaan->sum('poin') }} poin</div>
                                                </div>

                                                @if ($userQuizRespon)
                                                    <div
                                                        class="alert alert-{{ $userQuizRespon->lulus ? 'success' : 'warning' }} mt-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <i
                                                                    class="fas fa-{{ $userQuizRespon->lulus ? 'check-circle' : 'exclamation-triangle' }} me-2"></i>
                                                                <strong>{{ $userQuizRespon->lulus ? 'Lulus' : 'Belum Lulus' }}</strong>
                                                            </div>
                                                            <span
                                                                class="badge bg-{{ $userQuizRespon->lulus ? 'success' : 'warning' }}">
                                                                {{ $userQuizRespon->total_poin }} poin
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="card-footer bg-transparent">
                                                @if ($userQuizRespon)
                                                    <div class="d-grid gap-2">
                                                        <a href="{{ route('roadmaps.tutorials.quiz.result', [
                                                            'roadmap' => $roadmap->id,
                                                            'sort_order' => $tutorial->sort_order,
                                                            'quiz' => $quiz->id,
                                                        ]) }}"
                                                            class="btn btn-outline-primary">
                                                            <i class="fas fa-chart-bar me-1"></i>Lihat Hasil
                                                        </a>
                                                        <a href="{{ route('roadmaps.tutorials.quiz.take', [
                                                            'roadmap' => $roadmap->id,
                                                            'sort_order' => $tutorial->sort_order,
                                                            'quiz' => $quiz->id,
                                                        ]) }}"
                                                            class="btn btn-outline-secondary">
                                                            <i class="fas fa-redo me-1"></i>Ulangi Quiz
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="d-grid">
                                                        <a href="{{ route('roadmaps.tutorials.quiz.take', [
                                                            'roadmap' => $roadmap->id,
                                                            'sort_order' => $tutorial->sort_order,
                                                            'quiz' => $quiz->id,
                                                        ]) }}"
                                                            class="btn btn-primary">
                                                            <i class="fas fa-play me-1"></i>Mulai Quiz
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-question-circle fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">Belum Ada Quiz</h4>
                                <p class="text-muted">Tutorial ini belum memiliki quiz.</p>
                                <a href="{{ route('roadmaps.tutorials.show', ['roadmap' => $roadmap->id, 'sort_order' => $tutorial->sort_order]) }}"
                                    class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Tutorial
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
