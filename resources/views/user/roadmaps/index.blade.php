@extends('layout.frontend.app')

@section('title', 'Roadmaps - Demo')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Roadmaps</h1>

        @if ($roadmaps->count() === 0)
            <div class="alert alert-info">Belum ada roadmap tersedia.</div>
        @endif

        <div class="row g-4">
            @foreach ($roadmaps as $roadmap)
                @php
                    $progress = $roadmap->getUserProgress();
                @endphp

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        @if ($roadmap->gambar)
                            <img src="{{ asset('storage/' . $roadmap->gambar) }}" class="card-img-top"
                                alt="{{ $roadmap->judul }}" style="height:200px; object-fit:cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                                <span class="text-muted">Tidak ada gambar</span>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-1">{{ $roadmap->judul }}</h5>
                            <small class="text-muted mb-2">Urutan: {{ $roadmap->sort_order }}</small>

                            <p class="card-text mb-3" style="flex:1;">
                                {!! \Illuminate\Support\Str::limit(strip_tags($roadmap->deskripsi), 100) !!}
                            </p>
                            <div class="progress-section mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Progress Belajar</small>
                                    <small
                                        class="fw-bold {{ $progress['percentage'] == 100 ? 'text-success' : 'text-primary' }}">
                                        {{ $progress['progress_text'] }} ({{ $progress['percentage'] }}%)
                                    </small>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar 
                                        @if ($progress['percentage'] == 100) bg-success
                                        @elseif($progress['percentage'] > 50) bg-primary
                                        @elseif($progress['percentage'] > 0) bg-warning
                                        @else bg-secondary @endif"
                                        role="progressbar" style="width: {{ $progress['percentage'] }}%;"
                                        aria-valuenow="{{ $progress['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                @if ($progress['percentage'] == 100)
                                    <small class="text-success mt-1">
                                        <i class="fas fa-check-circle"></i> Selesai!
                                    </small>
                                @endif
                            </div>

                            <div class="mt-auto">
                                <a href="{{ route('roadmaps.show', $roadmap) }}" class="btn btn-primary btn-sm w-100">
                                    @if ($progress['percentage'] == 100)
                                        <i class="fas fa-redo me-1"></i> Review Kembali
                                    @elseif($progress['percentage'] > 0)
                                        <i class="fas fa-play me-1"></i> Lanjutkan Belajar
                                    @else
                                        <i class="fas fa-play me-1"></i> Mulai Belajar
                                    @endif
                                </a>
                            </div>
                        </div>

                        <div class="card-footer text-muted small">
                            <div class="d-flex justify-content-between">
                                <span>{{ $roadmap->tutorials->count() }} Tutorial</span>
                                <span>Progress: {{ $progress['percentage'] }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- <div class="mt-4">
            {{ $roadmaps->links() }}
        </div>
    </div> --}}
@endsection
