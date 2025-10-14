@extends('layout.frontend.app')

@section('title', $roadmap->judul . ' - Tutorial')

@section('content')
    <div class="container py-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="h3 mb-2">{{ $roadmap->judul }}</h1>
                        <p class="text-muted mb-3">{{ $roadmap->deskripsi }}</p>

                        <div class="progress-section">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold">Progress Belajar</span>
                                <span class="fw-bold text-primary">
                                    {{ $progress['progress_text'] }} ({{ $progress['percentage'] }}%)
                                </span>
                            </div>
                            <div class="progress" style="height: 12px;">
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
                                <div class="text-success mt-2">
                                    <i class="fas fa-trophy me-2"></i>Selamat! Anda telah menyelesaikan roadmap ini!
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        @if ($roadmap->gambar)
                            <img src="{{ asset('storage/' . $roadmap->gambar) }}" alt="{{ $roadmap->judul }}"
                                class="img-fluid rounded" style="max-height: 150px;">
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h4 class="mb-3">Daftar Tutorial</h4>

                @if ($tutorials->count() === 0)
                    <div class="alert alert-info">
                        Belum ada tutorial tersedia untuk roadmap ini.
                    </div>
                @endif

                <div class="list-group">
                    @foreach ($tutorials as $tutorial)
                        @php
                            $isCompleted = $tutorial->isCompletedByUser();
                        @endphp

                        <a href="{{ route('roadmaps.tutorials.show', ['roadmap' => $roadmap->id, 'sort_order' => $tutorial->sort_order]) }}"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">

                                <div class="me-3">
                                    @if ($isCompleted)
                                        <span class="badge bg-success rounded-circle p-2">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    @else
                                        <span class="badge bg-light border rounded-circle p-2">
                                            <i class="fas fa-book text-muted"></i>
                                        </span>
                                    @endif
                                </div>

                                <div>
                                    <h6 class="mb-1 {{ $isCompleted ? 'text-success' : '' }}">
                                        {{ $tutorial->judul }}
                                        @if ($isCompleted)
                                            <i class="fas fa-check-circle text-success ms-1"></i>
                                        @endif
                                    </h6>
                                    <small class="text-muted">
                                        Urutan: {{ $tutorial->sort_order }} •
                                        {{ Str::limit(strip_tags($tutorial->deskripsi), 100) }}
                                    </small>
                                </div>
                            </div>

                            {{-- Tutorial Stats --}}
                            <div class="text-end">
                                <small class="text-muted d-block">
                                    {{ $tutorial->created_at->format('d M Y') }}
                                </small>
                                <small class="text-muted">
                                    {{ $tutorial->tanya->count() }} diskusi
                                </small>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $tutorials->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
