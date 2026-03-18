@extends('layout.frontend.app')

@section('title', 'Moduls - BlendPath')

@section('content')
    <section class="page-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="hero-title">
                        Learning Moduls
                    </h1>
                    <p class="hero-subtitle">
                        Ikuti modul terstruktur untuk menguasai Blender 3D dari dasar hingga mahir
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="modul-stats">
                        <div class="stat-item">
                            <span class="stat-number">{{ $moduls->total() }}</span>
                            <span class="stat-label">Moduls Tersedia</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="moduls-section">
        <div class="container">
            @if ($moduls->total() === 0)
                <div class="empty-state">
                    <i class="bi bi-map display-1"></i>
                    <h3>Belum ada modul tersedia</h3>
                    <p>Modul sedang dalam pengembangan. Silakan kembali nanti.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach ($moduls as $modul)
                        @php
                            $progress = $modul->getUserProgress();
                            $isComplete = $progress['percentage'] == 100;
                        @endphp

                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="modul-card {{ $isComplete ? 'modul-complete' : '' }}">

                                <div class="card-body">
                                    <div class="modul-meta">
                                        <span>{{ $modul->submoduls->count() }} Submodul</span>
                                    </div>

                                    <h5 class="card-title">{{ $modul->judul }}</h5>

                                    <p class="card-text">
                                        {{ Str::limit(strip_tags($modul->deskripsi), 100) }}
                                    </p>

                                    <div class="progress-section">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="progress-label">Progress</span>
                                            <span class="progress-percentage">{{ $progress['percentage'] }}%</span>
                                        </div>
                                        <div class="modul-progress">
                                            <div class="modul-progress-fill" style="width: {{ $progress['percentage'] }}%">
                                            </div>
                                        </div>
                                    </div>

                                    @if ($modul->target_sort_order)
                                        <a href="{{ route('learn.submoduls.show', ['modul' => $modul, 'sort_order' => $modul->target_sort_order]) }}"
                                            class="modul-btn mt-3">
                                            @if ($isComplete)
                                                Lihat Kembali
                                            @elseif($progress['percentage'] > 0)
                                                Lanjutkan
                                            @else
                                                Mulai Belajar
                                            @endif
                                        </a>
                                    @else
                                        <a href="{{ route('learn.moduls.show', $modul) }}" class="modul-btn mt-3">
                                            Lihat Modul
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
