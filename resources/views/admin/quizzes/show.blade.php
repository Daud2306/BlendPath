{{-- Section Quiz --}}
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-question-circle me-2"></i>Quizzes Submodul
        </h5>

        <a href="{{ route('admin.moduls.submoduls.quizzes.create', ['modul' => $modul, 'submodul' => $submodul]) }}"
            class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Tambah Quiz
        </a>
    </div>

    <div class="card-body">
        @if ($submodul->quizzes->count() > 0)
            <div class="row">
                @foreach ($submodul->quizzes as $quiz)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">{{ $quiz->judul_quiz }}</h6>
                                <div>
                                    <span class="badge bg-secondary">#{{ $quiz->sort_order }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <small class="text-muted">Passing Score:</small>
                                    <div>
                                        <span class="badge bg-info">{{ $quiz->passing_score }}%</span>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <small class="text-muted">Pertanyaan:</small>
                                    <div>
                                        <span class="badge bg-primary">{{ $quiz->questions->count() }} soal</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted">Total Poin:</small>
                                    <div>
                                        <span class="badge bg-success">{{ $quiz->questions->sum('poin') }} poin</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted">Tingkat Kesulitan:</small>
                                    <div class="progress" style="height: 8px;">
                                        @php
                                            $totalPoin = $quiz->questions->sum('poin');
                                            $avgPoin = $quiz->questions->avg('poin');
                                            $difficulty = min(100, ($avgPoin / 3) * 100); // Asumsi poin max 3
                                        @endphp
                                        <div class="progress-bar bg-{{ $difficulty > 70 ? 'danger' : ($difficulty > 40 ? 'warning' : 'success') }}"
                                            style="width: {{ $difficulty }}%"></div>
                                    </div>
                                    <small class="text-muted">
                                        @if ($difficulty > 70)
                                            Sulit
                                        @elseif($difficulty > 40)
                                            Sedang
                                        @else
                                            Mudah
                                        @endif
                                    </small>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.moduls.submoduls.quizzes.edit', ['modul' => $modul, 'submodul' => $submodul, 'quiz' => $quiz]) }}"
                                        class="btn btn-outline-warning btn-sm">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.moduls.submoduls.quizzes.destroy', ['modul' => $modul, 'submodul' => $submodul, 'quiz' => $quiz]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('Hapus quiz {{ $quiz->judul_quiz }}?')">
                                            <i class="fas fa-trash me-1"></i>Hapus
                                        </button>
                                    </form>

                                    <a href="#" class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-chart-bar me-1"></i>Statistik
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Summary --}}
            <div class="mt-4 pt-3 border-top">
                <div class="row text-center">
                    <div class="col-md-3">
                        <h4 class="text-primary mb-0">{{ $submodul->quizzes->count() }}</h4>
                        <small class="text-muted">Total Quiz</small>
                    </div>
                    <div class="col-md-3">
                        <h4 class="text-success mb-0">
                            {{ $submodul->quizzes->sum(function ($quiz) {return $quiz->questions->count();}) }}</h4>
                        <small class="text-muted">Total Soal</small>
                    </div>
                    <div class="col-md-3">
                        <h4 class="text-info mb-0">
                            {{ $submodul->quizzes->sum(function ($quiz) {return $quiz->questions->sum('poin');}) }}
                        </h4>
                        <small class="text-muted">Total Poin</small>
                    </div>
                    <div class="col-md-3">
                        <h4 class="text-warning mb-0">{{ $submodul->quizzes->avg('passing_score') }}%</h4>
                        <small class="text-muted">Rata-rata Passing</small>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-4">
                <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum Ada Quiz</h5>
                <p class="text-muted mb-3">Submodul ini belum memiliki quiz. Klik tombol "Tambah Quiz" untuk membuat
                    quiz pertama.</p>
                <a href="{{ route('admin.moduls.submoduls.quizzes.create', ['modul' => $modul, 'submodul' => $submodul]) }}"
                    class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Tambah Quiz Pertama
                </a>
            </div>
        @endif
    </div>
</div>
