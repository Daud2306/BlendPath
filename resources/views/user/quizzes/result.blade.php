@extends('layout.frontend.app')

@section('content')
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('learn.moduls.index') }}">Moduls</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('learn.moduls.show', $modul) }}">{{ $modul->judul }}</a>
                        </li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('learn.submoduls.show', ['modul' => $modul->id, 'sort_order' => $submodul->sort_order]) }}">{{ $submodul->judul }}</a>
                        </li>
                        <li class="breadcrumb-item active">Hasil Quiz</li>
                    </ol>
                </nav>

                <div class="card shadow-sm">
                    <div class="card-header text-white {{ $lulus ? 'bg-success' : 'bg-warning' }}">
                        <h4 class="mb-0 text-center">
                            <i class="fas fa-{{ $lulus ? 'trophy' : 'exclamation-triangle' }} me-2"></i>
                            Hasil Quiz - {{ $quiz->judul_quiz }}
                        </h4>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <i
                                class="fas fa-{{ $lulus ? 'check-circle' : 'times-circle' }} fa-5x {{ $lulus ? 'text-success' : 'text-warning' }} mb-3"></i>
                            <h3 class="{{ $lulus ? 'text-success' : 'text-warning' }}">
                                {{ $lulus ? 'SELAMAT! ANDA LULUS' : 'ANDA BELUM LULUS' }}
                            </h3>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="text-primary">{{ $jumlahBenar }}/{{ $totalSoal }}</h5>
                                        <small class="text-muted">Jawaban Benar</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="text-success">{{ $totalPoin }} Poin</h5>
                                        <small class="text-muted">Total Poin</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="progress mb-3" style="height: 25px;">
                            <div class="progress-bar {{ $lulus ? 'bg-success' : 'bg-warning' }}"
                                style="width: {{ $persentase }}%">
                                {{ number_format($persentase, 1) }}%
                            </div>
                        </div>
                        <small class="text-muted">Passing Score: {{ $quiz->passing_score }}%</small>

                        <div class="mt-4">
                            @if ($lulus)
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>Selamat!</strong> Anda telah mencapai passing score.
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Jangan menyerah!</strong> Pelajari kembali materi dan coba lagi.
                                </div>
                            @endif
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-center mt-4">
                            <a href="{{ route('learn.submoduls.show', ['modul' => $modul->id, 'sort_order' => $submodul->sort_order]) }}"
                                class="btn btn-primary me-md-2">
                                <i class="fas fa-arrow-left me-1"></i>Kembali ke Submodul
                            </a>
                            <a href="{{ route('learn.quizzes.take', ['modul' => $modul->id, 'submodul' => $submodul->id, 'quiz' => $quiz->id]) }}"
                                class="btn btn-outline-primary">
                                <i class="fas fa-redo me-1"></i>Ulangi Quiz
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
