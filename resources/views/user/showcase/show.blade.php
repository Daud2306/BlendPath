@extends('layout.frontend.app')
@section('title', $showcase->judul . ' — BlendPath')

@push('styles')
    <link href="{{ asset('frontend/css/showcase.css') }}" rel="stylesheet">
    <style>
        .media-single {
            border-radius: 12px;
            overflow: hidden;
            background: #111;
            max-height: 520px;
        }

        .media-single img,
        .media-single video {
            width: 100%;
            max-height: 520px;
            object-fit: contain;
            display: block;
        }

        .media-thumb {
            border-radius: 8px;
            overflow: hidden;
            aspect-ratio: 16/9;
            background: #111;
            cursor: pointer;
        }

        .media-thumb img,
        .media-thumb video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .komentar-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--bs-primary, #0d6efd);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .komentar-item+.komentar-item {
            border-top: 1px solid #f0f0f0;
        }

        .komentar-item {
            padding: 0.875rem 0;
        }
    </style>
@endpush

@section('content')
    <div class="section">
        <div class="container" style="max-width:900px;">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Back --}}
            <a href="{{ route('learn.showcase.index') }}"
                style="display:inline-flex;align-items:center;gap:0.4rem;color:#6c757d;text-decoration:none;font-size:0.875rem;margin-bottom:1rem;">
                <i class="bi bi-arrow-left"></i> Galeri Karya
            </a>

            {{-- Judul & Meta --}}
            <div class="d-flex align-items-start justify-content-between gap-3 mb-4">
                <div>
                    <h2 class="mb-2" style="font-weight:700;">{{ $showcase->judul }}</h2>
                    <div style="font-size:0.85rem;color:#6c757d;display:flex;gap:1rem;flex-wrap:wrap;">
                        <span><i class="bi bi-person me-1"></i>{{ $showcase->user->name }}</span>
                        <span><i class="bi bi-clock me-1"></i>{{ $showcase->created_at->diffForHumans() }}</span>
                        <span><i class="bi bi-chat me-1"></i>{{ $showcase->komentars->count() }} komentar</span>
                        <span><i class="bi bi-images me-1"></i>{{ $showcase->resources->count() }} media</span>
                    </div>
                </div>

                @can('delete', $showcase)
                    <form action="{{ route('learn.showcase.destroy', $showcase) }}" method="POST"
                        onsubmit="return confirm('Hapus karya ini?')" class="flex-shrink-0">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-trash me-1"></i>Hapus
                        </button>
                    </form>
                @endcan
            </div>

            {{-- Media --}}
            @if ($showcase->resources->isNotEmpty())
                @if ($showcase->resources->count() === 1)
                    <div class="media-single mb-4">
                        @if ($showcase->resources->first()->type === 'video')
                            <video src="{{ $showcase->resources->first()->url }}" controls></video>
                        @else
                            <img src="{{ $showcase->resources->first()->url }}" alt="{{ $showcase->judul }}">
                        @endif
                    </div>
                @else
                    {{-- Main media --}}
                    <div class="media-single mb-3" id="mainMedia">
                        @if ($showcase->resources->first()->type === 'video')
                            <video src="{{ $showcase->resources->first()->url }}" controls id="mainMediaEl"></video>
                        @else
                            <img src="{{ $showcase->resources->first()->url }}" alt="{{ $showcase->judul }}"
                                id="mainMediaEl">
                        @endif
                    </div>
                    {{-- Thumbnails --}}
                    <div class="row g-2 mb-4">
                        @foreach ($showcase->resources as $i => $resource)
                            <div class="col-3 col-sm-2">
                                <div class="media-thumb {{ $i === 0 ? 'border border-primary border-2' : '' }}"
                                    id="thumb-{{ $i }}"
                                    onclick="switchMedia('{{ $resource->url }}', '{{ $resource->type }}', {{ $i }}, {{ $showcase->resources->count() }})">
                                    @if ($resource->type === 'video')
                                        <div
                                            style="width:100%;height:100%;background:#1a1a2e;display:flex;align-items:center;justify-content:center;">
                                            <i class="bi bi-play-circle-fill text-white" style="font-size:1.5rem;"></i>
                                        </div>
                                    @else
                                        <img src="{{ $resource->url }}" alt="Media {{ $i + 1 }}">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif

            {{-- Deskripsi --}}
            @if ($showcase->deskripsi)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <p class="mb-0" style="line-height:1.75;white-space:pre-line;">{{ $showcase->deskripsi }}</p>
                    </div>
                </div>
            @endif

            {{-- Komentar --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">
                        Komentar
                        <span class="badge ms-1" style="background:#f0f0f0;color:#333;font-size:0.8rem;font-weight:600;">
                            {{ $showcase->komentars->count() }}
                        </span>
                    </h5>

                    {{-- Form komentar --}}
                    @auth
                        <form action="{{ route('learn.showcase.komentar.store', $showcase) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="d-flex gap-2 align-items-start">
                                <div class="komentar-avatar" style="background:#6c757d;margin-top:2px;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <textarea name="komentar" class="form-control mb-2" rows="2" placeholder="Tulis komentar..." required
                                        style="resize:none;font-size:0.9rem;"></textarea>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="modul-btn"
                                            style="width:auto;font-size:0.85rem;padding:0.4rem 1.2rem;">
                                            <i class="bi bi-send me-1"></i> Kirim
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-light border mb-4" style="font-size:0.875rem;">
                            <i class="bi bi-info-circle me-2 text-primary"></i>
                            <a href="{{ route('login') }}" class="fw-semibold">Login</a> untuk ikut berkomentar.
                        </div>
                    @endauth

                    {{-- List komentar --}}
                    @forelse ($showcase->komentars as $komentar)
                        <div class="komentar-item">
                            <div class="d-flex align-items-start gap-2">
                                <div class="komentar-avatar">
                                    {{ strtoupper(substr($komentar->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center justify-content-between gap-2">
                                        <div>
                                            <span
                                                style="font-weight:600;font-size:0.875rem;">{{ $komentar->user->name }}</span>
                                            <span style="font-size:0.75rem;color:#adb5bd;margin-left:0.4rem;">
                                                {{ $komentar->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        @auth
                                            @if (Auth::id() === $komentar->user_id)
                                                <form action="{{ route('learn.showcase.komentar.destroy', $komentar) }}"
                                                    method="POST" onsubmit="return confirm('Hapus komentar ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-link p-0"
                                                        style="font-size:0.78rem;color:#dc3545;text-decoration:none;">
                                                        <i class="bi bi-trash me-1"></i>Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                    <p style="font-size:0.875rem;margin-top:0.25rem;margin-bottom:0;color:#333;">
                                        {{ $komentar->komentar }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4" style="color:#adb5bd;">
                            <i class="bi bi-chat-square d-block mb-2" style="font-size:2rem;"></i>
                            <p class="mb-0 small">Belum ada komentar. Jadilah yang pertama!</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function switchMedia(url, type, idx, total) {
            const el = document.getElementById('mainMediaEl');
            if (!el) return;

            if (type === 'video') {
                const video = document.createElement('video');
                video.src = url;
                video.controls = true;
                video.id = 'mainMediaEl';
                el.parentNode.replaceChild(video, el);
            } else {
                el.src = url;
                if (el.tagName === 'VIDEO') {
                    const img = document.createElement('img');
                    img.src = url;
                    img.alt = '';
                    img.id = 'mainMediaEl';
                    el.parentNode.replaceChild(img, el);
                }
            }

            // Update border aktif pada thumbnail
            for (let i = 0; i < total; i++) {
                const thumb = document.getElementById('thumb-' + i);
                if (thumb) {
                    thumb.classList.toggle('border', i === idx);
                    thumb.classList.toggle('border-primary', i === idx);
                    thumb.classList.toggle('border-2', i === idx);
                }
            }
        }
    </script>
@endpush
