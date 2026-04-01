{{-- ── Quiz (sekarang per submodul, bukan hanya submodul terakhir) ── --}}
@if ($quiz)
    <div class="quizzes-card card mt-4 mb-5" data-aos="fade-up">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-patch-question me-2"></i>Quiz Submodul
            </h5>
        </div>
        <div class="card-body">
            @if (!$isCurrentCompleted)
                <div class="alert alert-warning mb-3">
                    <i class="bi bi-lock me-2"></i>
                    Selesaikan submodul ini terlebih dahulu untuk mengakses quiz.
                </div>
            @elseif ($quizLulus)
                <div class="alert alert-success mb-3">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Kamu sudah lulus quiz ini!
                </div>
            @else
                @if ($quiz->deskripsi)
                    <p class="text-muted small mb-3">{{ $quiz->deskripsi }}</p>
                @endif
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="badge bg-light text-dark me-2">
                            <i class="bi bi-list-check me-1"></i>{{ $quiz->questions->count() }} soal
                        </span>
                        <span class="badge bg-light text-dark">
                            <i class="bi bi-trophy me-1"></i>Passing: {{ $quiz->passing_score }}%
                        </span>
                    </div>
                    {{-- FIX: route quiz sekarang butuh modul + submodul --}}
                    <a href="{{ route('learn.quizzes.take', ['modul' => $modul->id, 'submodul' => $submodul->id, 'quiz' => $quiz->id]) }}"
                        class="btn btn-primary">
                        <i class="bi bi-play-fill me-1"></i>Mulai Quiz
                    </a>
                </div>
            @endif
        </div>
    </div>
@endif
