@extends('layout.admin.app')

@section('content')
    <div class="container my-4">
        <div class="card shadow-sm mt-5">
            <div class="card-body">
                <h1 class="h4 mb-3">{{ $submodul->judul }}</h1>

                @foreach ($submodul->resources ?? [] as $res)
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

                @if (!empty($submodul->konten))
                    <p class="mb-4 text-muted">{!! nl2br(e($submodul->konten)) !!}</p>
                @endif

                <a href="{{ route('admin.moduls.submoduls.index', $submodul->modul_id) }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            @if ($prevSubmodul)
                <a href="{{ route('admin.moduls.submoduls.show', [$modul, $prevSubmodul]) }}"
                    class="btn btn-outline-secondary">&lt;- Sebelumnya</a>
            @else
                <span class="btn btn-outline-secondary disabled">&lt;- Sebelumnya</span>
            @endif

            @if ($nextSubmodul)
                <a href="{{ route('admin.moduls.submoduls.show', [$modul, $nextSubmodul]) }}"
                    class="btn btn-primary">Selanjutnya -&gt;</a>
            @else
                <span class="btn btn-primary disabled">Selanjutnya -&gt;</span>
            @endif
        </div>

        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-question-circle me-2"></i>Quiz Submodul
                </h5>

                @if ($submodul->quiz)
                    <div>
                        <span class="badge bg-success me-2">
                            <i class="fas fa-check me-1"></i>Quiz Tersedia
                        </span>
                        <a href="{{ route('admin.moduls.submoduls.quizzes.edit', ['modul' => $modul, 'submodul' => $submodul, 'quiz' => $submodul->quiz]) }}"
                            class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-edit me-1"></i>Edit Quiz
                        </a>
                        <form
                            action="{{ route('admin.moduls.submoduls.quizzes.destroy', ['modul' => $modul, 'submodul' => $submodul, 'quiz' => $submodul->quiz]) }}"
                            method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus quiz ini?')">
                                <i class="fas fa-trash me-1"></i>Hapus Quiz
                            </button>
                        </form>
                    </div>
                {{-- @else
                    <a href="{{ route('admin.moduls.submoduls.quizzes.create', ['modul' => $modul, 'submodul' => $submodul]) }}"
                        class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Buat Quiz
                    </a> --}}
                @endif
            </div>

            <div class="card-body">
                @if ($submodul->quizzes->count() > 0)
                    <div class="card mt-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Quizzes Submodul</h5>
                            <a href="{{ route('admin.moduls.submoduls.quizzes.create', ['modul' => $modul, 'submodul' => $submodul]) }}"
                                class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Tambah Quiz
                            </a>
                        </div>
                        <div class="card-body">
                            @foreach ($submodul->quizzes as $quiz)
                                <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                                    <div>
                                        <h6 class="mb-1">{{ $quiz->judul_quiz }}</h6>
                                        <small class="text-muted">
                                            {{ $quiz->pertanyaan->count() }} soal |
                                            Passing: {{ $quiz->passing_score }}% |
                                            Urutan: {{ $quiz->urutan }}
                                        </small>
                                    </div>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.moduls.submoduls.quizzes.edit', ['modul' => $modul, 'submodul' => $submodul, 'quiz' => $quiz]) }}"
                                            class="btn btn-outline-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form
                                            action="{{ route('admin.moduls.submoduls.quizzes.destroy', ['modul' => $modul, 'submodul' => $submodul, 'quiz' => $quiz]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Hapus quiz ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="card mt-4">
                        <div class="card-body text-center">
                            <p class="text-muted mb-3">Belum ada quiz untuk submodul ini.</p>
                            <a href="{{ route('admin.moduls.submoduls.quizzes.create', ['modul' => $modul, 'submodul' => $submodul]) }}"
                                class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Buat Quiz Pertama
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @include('admin.submoduls.partials.qna')
    </div>
@endsection
