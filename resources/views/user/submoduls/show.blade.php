@extends('layout.frontend.app')

@section('title', $submodul->judul . ' - BlendPath')

@section('content')

    {{-- Hero --}}
    <section class="submodul-hero dark-background">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('learn.moduls.index') }}" class="breadcrumb-link">
                                    <i class="bi bi-map me-1"></i>Moduls
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('learn.moduls.show', $modul->id) }}" class="breadcrumb-link">
                                    <i class="bi bi-signpost-2 me-1"></i>{{ Str::limit($modul->judul, 20) }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="bi bi-play-circle me-1"></i>{{ Str::limit($submodul->judul, 25) }}
                            </li>
                        </ol>
                    </nav>

                    <h1 class="submodul-title" data-aos="fade-up">
                        <i class="bi bi-play-circle-fill me-3"></i>{{ $submodul->judul }}
                    </h1>

                    <div class="submodul-meta" data-aos="fade-up" data-aos-delay="100">
                        <span class="meta-item">
                            <i class="bi bi-list-ol me-1"></i>Urutan: {{ $submodul->sort_order }}
                        </span>
                        <span class="meta-item">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $submodul->created_at->format('d M Y') }}
                        </span>
                        @if ($submodul->quiz)
                            <span class="meta-item">
                                <i class="bi bi-question-circle me-1"></i>Ada Quiz
                            </span>
                        @endif
                        @if ($submodul->miniProjects->count() > 0)
                            <span class="meta-item">
                                <i class="bi bi-flag me-1"></i>{{ $submodul->miniProjects->count() }} Mini Project
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Flash error --}}
    @if (session('error'))
        <div class="container mt-4">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <section class="submodul-content py-5 light-background">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    {{-- ── Video embed (YouTube / Vimeo dari tabel resources) ── --}}
                    @foreach ($submodul->resources->where('type', 'video_link') as $res)
                        <div class="video-container mb-5" data-aos="fade-up">
                            <div class="ratio ratio-16x9">
                                {{-- FIX: kolom path, bukan resource --}}
                                <iframe src="{{ $res->path }}" title="Video" allowfullscreen
                                    class="rounded shadow-sm"></iframe>
                            </div>
                        </div>
                    @endforeach

                    {{-- ── Konten submodul (dari TinyMCE — render HTML apa adanya) ── --}}
                    @if (!empty($submodul->konten))
                        <div class="content-card card shadow-sm mb-5" data-aos="fade-up">
                            <div class="card-body">
                                <h4 class="card-title mb-4">
                                    <i class="bi bi-journal-text me-2"></i>Materi Submodul
                                </h4>
                                {{-- FIX: {!! !!} tanpa e() agar HTML dari TinyMCE bisa dirender --}}
                                <div class="submodul-text prose">
                                    {!! $submodul->konten !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    @include('user.submoduls.partials.navigation')

                    @include('user.submoduls.partials.progress')

                    @include('user.submoduls.partials.mini_projects')

                    @include('user.submoduls.partials.quiz')

                    @include('user.submoduls.partials.qna')

                </div>
            </div>
        </div>
    </section>

@endsection
