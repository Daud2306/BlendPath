@extends('layout.frontend.app')

@section('content')
    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('learn.moduls.index') }}">Moduls</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('learn.moduls.show', $modul) }}">{{ $modul->judul }}</a>
                        </li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('learn.submoduls.show', ['modul' => $modul->id, 'sort_order' => $submodul->sort_order]) }}">{{ $submodul->judul }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ $quiz->judul_quiz }}</li>
                    </ol>
                </nav>

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-play-circle me-2"></i>{{ $quiz->judul_quiz }}
                        </h4>
                    </div>
                    <div class="card-body">
                        @if ($latestAttempt)
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Anda sudah mengerjakan quiz ini sebelumnya. Poin:
                                <strong>{{ $latestAttempt->total_poin }}</strong>
                            </div>
                        @endif

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Perhatian:</strong> Passing score untuk quiz ini adalah
                            <strong>{{ $quiz->passing_score }}%</strong>.
                            Pastikan Anda sudah mempelajari materi dengan baik.
                        </div>

                        <form
                            action="{{ route('learn.quizzes.submit', ['modul' => $modul->id, 'submodul' => $submodul->id, 'quiz' => $quiz->id]) }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">

                            @foreach ($quiz->questions as $index => $pertanyaan)
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Pertanyaan #{{ $index + 1 }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="fw-semibold mb-3">{{ $pertanyaan->pertanyaan }}</p>

                                        <div class="form-group">
                                            @foreach ($pertanyaan->pilihan_jawaban as $huruf => $pilihan)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio"
                                                        name="jawaban[{{ $pertanyaan->id }}]"
                                                        id="jawaban_{{ $pertanyaan->id }}_{{ $huruf }}"
                                                        value="{{ $huruf }}" required>
                                                    <label class="form-check-label"
                                                        for="jawaban_{{ $pertanyaan->id }}_{{ $huruf }}">
                                                        <strong>{{ $huruf }}.</strong> {{ $pilihan }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <small class="text-muted">Poin: {{ $pertanyaan->poin }}</small>
                                    </div>
                                </div>
                            @endforeach

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('learn.submoduls.show', ['modul' => $modul->id, 'sort_order' => $submodul->sort_order]) }}"
                                    class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-paper-plane me-1"></i>Submit Jawaban
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
