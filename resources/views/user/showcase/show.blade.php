@extends('layout.frontend.app')
@section('title', $showcase->judul)

@push('styles')
    <link href="{{ asset('frontend/css/showcase.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="section">
        <div class="container" style="max-width:860px">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Back + Header --}}
            <a href="{{ route('learn.showcase.index') }}" class="showcase-back-link">
                <i class="bi bi-arrow-left"></i> Galeri Karya
            </a>

            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <h2 class="mb-2">{{ $showcase->judul }}</h2>
                    <div class="showcase-detail-meta">
                        <span>
                            <x-user-avatar :user="$showcase->user" :size="22" />
                            {{ $showcase->user->name }}
                        </span>
                        <span>
                            <i class="bi bi-clock"></i>
                            {{ $showcase->created_at->diffForHumans() }}
                        </span>
                        <span>
                            <i class="bi bi-chat"></i>
                            {{ $showcase->komentars->count() }} komentar
                        </span>
                        <span>
                            <i class="bi bi-images"></i>
                            {{ $showcase->resources->count() }} media
                        </span>
                    </div>
                </div>

                @can('delete', $showcase)
                    <form action="{{ route('learn.showcase.destroy', $showcase) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus karya ini? Tindakan ini tidak bisa dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn" style="color:#dc3545;border-color:#dc3545">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                @endcan

            </div>

            {{-- ── Media ── --}}
            @if ($showcase->resources->count() === 1)

                <div class="showcase-media-single">
                    @if ($showcase->resources->first()->type === 'video')
                        <video src="{{ $showcase->resources->first()->url }}" controls></video>
                    @else
                        <img src="{{ $showcase->resources->first()->url }}"
                             alt="{{ $showcase->judul }}">
                    @endif
                </div>

            @elseif ($showcase->resources->count() > 1)

                <div class="row g-2 showcase-media-grid mb-4">
                    @foreach ($showcase->resources as $resource)
                        <div class="{{ $loop->first ? 'col-12 col-md-8' : 'col-6 col-md-4' }}">
                            <div class="showcase-media-grid-item {{ $loop->first ? 'showcase-media-aspect-wide' : 'showcase-media-aspect-square' }}">
                                @if ($resource->type === 'video')
                                    <video src="{{ $resource->url }}" controls></video>
                                @else
                                    <img src="{{ $resource->url }}"
                                         alt="{{ $showcase->judul }}"
                                         title="Klik untuk lihat penuh"
                                         loading="lazy">
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

            @endif

            {{-- ── Deskripsi ── --}}
            @if ($showcase->deskripsi)
                <div class="ask-question-card mb-4">
                    <div class="question-form">
                        <p class="showcase-description mb-0">{{ $showcase->deskripsi }}</p>
                    </div>
                </div>
            @endif

            {{-- ── Komentar ── --}}
            <div class="qna-section">

                <div class="qna-header">
                    <h5 class="mb-0">
                        Komentar
                        <span class="badge ms-1" style="background:var(--text-hover);color:white">
                            {{ $showcase->komentars->count() }}
                        </span>
                    </h5>
                </div>

                {{-- Form Komentar --}}
                <div class="showcase-komentar-form">
                    <form action="{{ route('learn.showcase.komentar.store', $showcase) }}" method="POST">
                        @csrf
                        <div class="d-flex gap-2 align-items-start">
                            <x-user-avatar :user="Auth::user()" :size="34" class="mt-1" />
                            <div class="flex-grow-1">
                                <textarea
                                    name="komentar"
                                    class="form-control"
                                    rows="2"
                                    placeholder="Tulis komentar..."
                                    required
                                    style="font-size:13px;resize:none"></textarea>
                                <button type="submit"
                                        class="modul-btn mt-2"
                                        style="width:auto;font-size:13px;padding:0.375rem 1rem">
                                    Kirim
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- List Komentar --}}
                <div class="showcase-komentar-list">
                    @forelse ($showcase->komentars as $komentar)
                        <div class="showcase-komentar-item">

                            <x-user-avatar :user="$komentar->user" :size="32" />

                            <div class="showcase-komentar-body">
                                <div class="showcase-komentar-header">
                                    <span class="showcase-komentar-name">{{ $komentar->user->name }}</span>
                                    <span class="showcase-komentar-time">{{ $komentar->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="showcase-komentar-text mb-1">{{ $komentar->komentar }}</p>

                                @if (Auth::id() === $komentar->user_id)
                                    <form action="{{ route('learn.showcase.komentar.destroy', $komentar) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Hapus komentar ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-link p-0"
                                                style="font-size:12px;color:#dc3545;text-decoration:none">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>

                        </div>
                    @empty
                        <p class="showcase-komentar-empty">
                            Belum ada komentar. Jadilah yang pertama!
                        </p>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('frontend/js/showcase.js') }}"></script>
@endpush
