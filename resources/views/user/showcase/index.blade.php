@extends('layout.frontend.app')
@section('title', 'Galeri Karya')

@push('styles')
    <link href="{{ asset('frontend/css/showcase.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="section">
        <div class="container">

            {{-- Header --}}
            <div class="showcase-header">
                <div>
                    <h2>Galeri Karya</h2>
                    <p>Hasil render terbaik dari komunitas BlendPath</p>
                </div>
                <a href="{{ route('learn.showcase.create') }}" class="modul-btn" style="width:auto">
                    <i class="bi bi-plus-lg me-1"></i> Upload Karya
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Empty State --}}
            @if ($showcases->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-images empty-state-icon"></i>
                    <h3>Belum ada karya</h3>
                    <p>Jadilah yang pertama upload karya Blender-mu!</p>
                    <a href="{{ route('learn.showcase.create') }}" class="modul-btn mt-3" style="display:inline-block">
                        Upload Sekarang
                    </a>
                </div>

            {{-- Grid --}}
            @else
                <div class="row g-4">
                    @foreach ($showcases as $showcase)
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="modul-card showcase-card h-100">

                                {{-- Thumbnail --}}
                                <a href="{{ route('learn.showcase.show', $showcase) }}">
                                    <div class="card-image">
                                        @if ($showcase->resources->isNotEmpty())
                                            @if ($showcase->resources->first()->type === 'video')
                                                <video
                                                    src="{{ $showcase->resources->first()->url }}"
                                                    muted
                                                    preload="metadata">
                                                </video>
                                            @else
                                                <img
                                                    src="{{ $showcase->resources->first()->url }}"
                                                    alt="{{ $showcase->judul }}"
                                                    loading="lazy">
                                            @endif
                                        @else
                                            <div class="card-img-placeholder">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif

                                        @if ($showcase->resources->count() > 1)
                                            <span class="showcase-media-badge">
                                                <i class="bi bi-images"></i>
                                                {{ $showcase->resources->count() }}
                                            </span>
                                        @endif
                                    </div>
                                </a>

                                {{-- Card Body --}}
                                <div class="card-body">
                                    <div class="showcase-meta">
                                        <span>
                                            <x-user-avatar :user="$showcase->user" :size="20" />
                                            {{ $showcase->user->name }}
                                        </span>
                                        <span>
                                            <i class="bi bi-chat"></i>
                                            {{ $showcase->komentars->count() }}
                                        </span>
                                        <span>
                                            <i class="bi bi-clock"></i>
                                            {{ $showcase->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <h5 class="card-title">
                                        <a href="{{ route('learn.showcase.show', $showcase) }}"
                                            style="color:inherit;text-decoration:none">
                                            {{ $showcase->judul }}
                                        </a>
                                    </h5>

                                    @if ($showcase->deskripsi)
                                        <p class="card-text">{{ Str::limit($showcase->deskripsi, 80) }}</p>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $showcases->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection
