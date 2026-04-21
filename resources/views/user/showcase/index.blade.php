@extends('layout.frontend.app')
@section('title', 'Galeri Karya — BlendPath')

@push('styles')
    <link href="{{ asset('frontend/css/showcase.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="section">
        <div class="container">

            {{-- Header --}}
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
                <div>
                    <h2 class="mb-1">Galeri Karya</h2>
                    <p class="text-muted mb-0">Hasil render terbaik dari komunitas BlendPath</p>
                </div>
                <a href="{{ route('learn.showcase.create') }}" class="modul-btn" style="width:auto;">
                    <i class="bi bi-plus-lg me-1"></i> Upload Karya
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Empty --}}
            @if ($showcases->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-images display-1 text-muted d-block mb-3"></i>
                    <h4>Belum ada karya</h4>
                    <p class="text-muted mb-4">Jadilah yang pertama upload karya Blender-mu!</p>
                </div>

                {{-- Grid --}}
            @else
                <div class="row g-4">
                    @foreach ($showcases as $showcase)
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="modul-card showcase-card h-100" style="overflow:hidden;">

                                {{-- Thumbnail --}}
                                <a href="{{ route('learn.showcase.show', $showcase) }}" class="d-block"
                                    style="text-decoration:none;">
                                    <div style="aspect-ratio:4/3;overflow:hidden;background:#111;position:relative;">
                                        @if ($showcase->resources->isNotEmpty())
                                            @if ($showcase->resources->first()->type === 'video')
                                                <div
                                                    style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#1a1a2e;">
                                                    <i class="bi bi-play-circle-fill"
                                                        style="font-size:3rem;color:#fff;opacity:0.8;"></i>
                                                </div>
                                            @else
                                                <img src="{{ $showcase->resources->first()->url }}"
                                                    alt="{{ $showcase->judul }}" loading="lazy"
                                                    style="width:100%;height:100%;object-fit:cover;transition:transform 0.3s ease;"
                                                    onmouseover="this.style.transform='scale(1.04)'"
                                                    onmouseout="this.style.transform='scale(1)'">
                                            @endif
                                        @else
                                            <div
                                                style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#2a2a3e;">
                                                <i class="bi bi-image" style="font-size:2.5rem;color:#6c757d;"></i>
                                            </div>
                                        @endif

                                        {{-- Badge jumlah media --}}
                                        @if ($showcase->resources->count() > 1)
                                            <span
                                                style="position:absolute;top:10px;right:10px;background:rgba(0,0,0,0.65);color:#fff;font-size:0.75rem;padding:3px 8px;border-radius:20px;backdrop-filter:blur(4px);">
                                                <i class="bi bi-images me-1"></i>{{ $showcase->resources->count() }}
                                            </span>
                                        @endif
                                    </div>
                                </a>

                                {{-- Info --}}
                                <div class="card-body p-3">
                                    <h6 class="mb-1" style="font-weight:600;line-height:1.4;">
                                        <a href="{{ route('learn.showcase.show', $showcase) }}"
                                            style="color:inherit;text-decoration:none;">
                                            {{ $showcase->judul }}
                                        </a>
                                    </h6>

                                    @if ($showcase->deskripsi)
                                        <p class="text-muted mb-2" style="font-size:0.82rem;line-height:1.5;">
                                            {{ Str::limit($showcase->deskripsi, 80) }}
                                        </p>
                                    @endif

                                    <div class="d-flex align-items-center justify-content-between mt-auto"
                                        style="font-size:0.78rem;color:#adb5bd;">
                                        <span>
                                            <i class="bi bi-person me-1"></i>{{ $showcase->user->name }}
                                        </span>
                                        <div class="d-flex gap-2">
                                            <span>
                                                <i class="bi bi-chat me-1"></i>{{ $showcase->komentars->count() }}
                                            </span>
                                            <span>
                                                <i
                                                    class="bi bi-clock me-1"></i>{{ $showcase->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-5">
                    {{ $showcases->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection
