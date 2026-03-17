@extends('layout.admin.app')

@section('title', $submodul->judul)

@push('styles')
<style>
    .konten-preview {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        padding: 1.25rem 1.5rem;
        font-size: 0.9rem;
        line-height: 1.8;
        color: var(--text-primary);
        max-height: 360px;
        overflow-y: auto;
    }

    .konten-preview::-webkit-scrollbar { width: 4px; }
    .konten-preview::-webkit-scrollbar-track { background: transparent; }
    .konten-preview::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 2px; }

    .konten-preview img { max-width: 100%; border-radius: var(--radius); }
    .konten-preview h1, .konten-preview h2, .konten-preview h3 { margin-top: 1rem; }

    .quiz-item {
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        background: var(--bg-card);
        overflow: hidden;
        transition: var(--transition);
    }

    .quiz-item:hover {
        border-color: var(--accent);
        box-shadow: var(--shadow-hover);
    }

    .quiz-header {
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        cursor: pointer;
        user-select: none;
    }

    .quiz-body {
        border-top: 1px solid var(--border-color);
        padding: 1rem 1.25rem;
        background: var(--bg-primary);
    }

    .pertanyaan-item {
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.875rem;
    }

    .pertanyaan-item:last-child { border-bottom: none; }

    .pilihan-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.4rem;
        margin-top: 0.5rem;
    }

    .pilihan-item {
        padding: 0.4rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8rem;
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .pilihan-item.correct {
        background: #e6f9ed;
        border-color: #c3e6cb;
        color: var(--success);
        font-weight: 600;
    }

    .pilihan-label {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: var(--border-color);
        color: var(--text-primary);
        font-size: 0.7rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .pilihan-item.correct .pilihan-label {
        background: var(--success);
        color: white;
    }

    .diskusi-item {
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-color);
    }

    .diskusi-item:last-child { border-bottom: none; }

    .jawab-item {
        margin-top: 0.75rem;
        padding: 0.75rem;
        background: var(--bg-primary);
        border-radius: var(--radius);
        border-left: 3px solid var(--accent);
        font-size: 0.85rem;
    }

    .nav-submodul-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1rem;
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
        background: var(--bg-card);
        color: var(--text-primary);
        font-size: 0.85rem;
        font-weight: 500;
        transition: var(--transition);
        text-decoration: none;
    }

    .nav-submodul-btn:hover {
        border-color: var(--accent);
        color: var(--accent);
        background: var(--accent-light);
    }

    .nav-submodul-btn.disabled {
        opacity: 0.4;
        pointer-events: none;
    }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title">{{ $submodul->judul }}</h1>
        <p class="page-subtitle mb-0">
            <i class="fas fa-layer-group me-1" style="color:var(--accent);"></i>
            {{ $modul->judul }} &rsaquo; Submodul {{ $submodul->sort_order }}
        </p>
    </div>
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.moduls.index') }}">Modul</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.moduls.submoduls.index', $modul) }}">{{ Str::limit($modul->judul, 20) }}</a></li>
                <li class="breadcrumb-item active">{{ Str::limit($submodul->judul, 20) }}</li>
            </ol>
        </nav>
        <a href="{{ route('admin.moduls.submoduls.edit', [$modul, $submodul]) }}" class="btn-primary-admin ms-2">
            <i class="fas fa-edit"></i> Edit Submodul
        </a>
    </div>
</div>

{{-- Prev / Next Navigation --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    @if($prevSubmodul)
        <a href="{{ route('admin.moduls.submoduls.show', [$modul, $prevSubmodul]) }}" class="nav-submodul-btn">
            <i class="fas fa-arrow-left"></i>
            <div>
                <div style="font-size:0.7rem;color:#adb5bd;">Sebelumnya</div>
                <div>{{ Str::limit($prevSubmodul->judul, 30) }}</div>
            </div>
        </a>
    @else
        <span class="nav-submodul-btn disabled">
            <i class="fas fa-arrow-left"></i> Tidak ada
        </span>
    @endif

    <a href="{{ route('admin.moduls.submoduls.index', $modul) }}" class="btn-outline-admin">
        <i class="fas fa-list"></i> Semua Submodul
    </a>

    @if($nextSubmodul)
        <a href="{{ route('admin.moduls.submoduls.show', [$modul, $nextSubmodul]) }}" class="nav-submodul-btn" style="text-align:right;">
            <div>
                <div style="font-size:0.7rem;color:#adb5bd;">Selanjutnya</div>
                <div>{{ Str::limit($nextSubmodul->judul, 30) }}</div>
            </div>
            <i class="fas fa-arrow-right"></i>
        </a>
    @else
        <span class="nav-submodul-btn disabled" style="text-align:right;">
            Tidak ada <i class="fas fa-arrow-right"></i>
        </span>
    @endif
</div>

<div class="row g-3">

    {{-- LEFT: Konten + Quiz + Diskusi --}}
    <div class="col-lg-8 d-flex flex-column gap-3">

        {{-- Konten --}}
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-file-alt me-2" style="color:var(--accent);"></i>Konten
                </h5>
                <a href="{{ route('admin.moduls.submoduls.edit', [$modul, $submodul]) }}"
                   class="btn-outline-admin">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
            <div class="card-body">
                @if($submodul->konten)
                    <div class="konten-preview">{!! $submodul->konten !!}</div>
                @else
                    <div class="empty-state" style="padding:2rem;">
                        <i class="fas fa-file-alt"></i>
                        <p>Belum ada konten</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Resources --}}
        @if($submodul->resources && $submodul->resources->count() > 0)
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-paperclip me-2" style="color:var(--accent);"></i>
                    Media / Resource
                </h5>
                <span style="font-size:0.8rem;color:#adb5bd;">{{ $submodul->resources->count() }} file</span>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    @foreach($submodul->resources as $resource)
                    <div class="col-sm-6 col-md-4">
                        @if($resource->type === 'video_link')
                            <div style="border:1px solid var(--border-color);border-radius:var(--radius);padding:0.75rem;background:var(--bg-primary);">
                                <div style="font-size:0.75rem;color:#adb5bd;margin-bottom:0.3rem;">
                                    <i class="fas fa-link me-1"></i>Video Link
                                </div>
                                <a href="{{ $resource->path }}" target="_blank"
                                   style="font-size:0.8rem;color:var(--accent);word-break:break-all;">
                                    {{ Str::limit($resource->path, 45) }}
                                </a>
                            </div>
                        @else
                            <div style="border:1px solid var(--border-color);border-radius:var(--radius);overflow:hidden;">
                                @if(in_array(pathinfo($resource->path, PATHINFO_EXTENSION), ['jpg','jpeg','png','gif','webp']))
                                    <img src="{{ asset('storage/' . $resource->path) }}"
                                         alt="Resource"
                                         style="width:100%;height:100px;object-fit:cover;">
                                @else
                                    <div style="height:80px;background:var(--bg-primary);display:flex;align-items:center;justify-content:center;">
                                        <i class="fas fa-file" style="font-size:1.5rem;color:#adb5bd;"></i>
                                    </div>
                                @endif
                                <div style="padding:0.5rem;font-size:0.75rem;color:#adb5bd;border-top:1px solid var(--border-color);">
                                    {{ Str::limit(basename($resource->path), 30) }}
                                </div>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Quiz --}}
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-question-circle me-2" style="color:var(--accent);"></i>
                    Quiz
                    @if($submodul->quizzes->count() > 0)
                        <span style="background:var(--accent-light);color:var(--accent);font-size:0.75rem;padding:0.2rem 0.6rem;border-radius:20px;margin-left:0.5rem;">
                            {{ $submodul->quizzes->count() }}
                        </span>
                    @endif
                </h5>
                <a href="{{ route('admin.moduls.submoduls.quizzes.create', [$modul, $submodul]) }}"
                   class="btn-outline-admin">
                    <i class="fas fa-plus"></i> Tambah Quiz
                </a>
            </div>
            <div class="card-body p-0">
                @if($submodul->quizzes->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-question-circle"></i>
                        <p>Belum ada quiz untuk submodul ini.</p>
                    </div>
                @else
                    <div class="p-3 d-flex flex-column gap-3">
                        @foreach($submodul->quizzes as $quiz)
                        <div class="quiz-item">
                            <div class="quiz-header" data-bs-toggle="collapse" data-bs-target="#quiz-{{ $quiz->id }}">
                                <div>
                                    <div style="font-weight:600;font-size:0.9rem;color:var(--text-primary);">
                                        {{ $quiz->judul_quiz }}
                                    </div>
                                    <div style="font-size:0.78rem;color:#adb5bd;margin-top:3px;">
                                        {{ $quiz->pertanyaan->count() }} soal &bull;
                                        Passing score: {{ $quiz->passing_score }}% &bull;
                                        Urutan: {{ $quiz->urutan }}
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('admin.moduls.submoduls.quizzes.edit', [$modul, $submodul, $quiz]) }}"
                                       class="btn-outline-admin" onclick="event.stopPropagation()">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.moduls.submoduls.quizzes.destroy', [$modul, $submodul, $quiz]) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus quiz ini?')"
                                          onclick="event.stopPropagation()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger-admin">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <i class="fas fa-chevron-down" style="color:#adb5bd;font-size:0.75rem;transition:transform 0.2s;"></i>
                                </div>
                            </div>

                            <div id="quiz-{{ $quiz->id }}" class="collapse">
                                <div class="quiz-body">
                                    @foreach($quiz->pertanyaan as $no => $soal)
                                    <div class="pertanyaan-item">
                                        <div style="font-weight:600;font-size:0.875rem;margin-bottom:0.4rem;">
                                            {{ $no + 1 }}. {{ $soal->pertanyaan }}
                                        </div>
                                        <div class="pilihan-grid">
                                            @foreach($soal->pilihan_jawaban as $key => $value)
                                            <div class="pilihan-item {{ strtoupper($key) === strtoupper($soal->jawaban_benar) ? 'correct' : '' }}">
                                                <span class="pilihan-label">{{ strtoupper($key) }}</span>
                                                {{ $value }}
                                                @if(strtoupper($key) === strtoupper($soal->jawaban_benar))
                                                    <i class="fas fa-check ms-auto" style="font-size:0.7rem;"></i>
                                                @endif
                                            </div>
                                            @endforeach
                                        </div>
                                        <div style="font-size:0.75rem;color:#adb5bd;margin-top:0.4rem;">
                                            Poin: {{ $soal->poin }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Diskusi --}}
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-comments me-2" style="color:var(--accent);"></i>
                    Diskusi
                    @if($submodul->tanya->count() > 0)
                        <span style="background:var(--accent-light);color:var(--accent);font-size:0.75rem;padding:0.2rem 0.6rem;border-radius:20px;margin-left:0.5rem;">
                            {{ $submodul->tanya->count() }}
                        </span>
                    @endif
                </h5>
                <a href="{{ route('admin.tanyas.index') }}" class="btn-outline-admin">
                    <i class="fas fa-external-link-alt"></i> Kelola Semua
                </a>
            </div>
            <div class="card-body">
                @if($submodul->tanya->isEmpty())
                    <div class="empty-state" style="padding:2rem;">
                        <i class="fas fa-comments"></i>
                        <p>Belum ada diskusi di submodul ini</p>
                    </div>
                @else
                    @foreach($submodul->tanya as $tanya)
                    <div class="diskusi-item">
                        <div class="d-flex align-items-start gap-2">
                            <div class="avatar" style="flex-shrink:0;">
                                {{ strtoupper(substr($tanya->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between gap-2">
                                    <div>
                                        <span style="font-weight:600;font-size:0.875rem;">{{ $tanya->user->name ?? 'User' }}</span>
                                        <span style="font-size:0.75rem;color:#adb5bd;margin-left:0.5rem;">
                                            {{ $tanya->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <form action="{{ route('admin.tanyas.destroy', $tanya) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus pertanyaan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger-admin" style="padding:0.25rem 0.6rem;font-size:0.75rem;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <p style="font-size:0.875rem;margin:0.4rem 0 0;color:var(--text-primary);">
                                    {{ $tanya->pertanyaan }}
                                </p>

                                {{-- Jawaban --}}
                                @if($tanya->jawabs->isNotEmpty())
                                    @foreach($tanya->jawabs as $jawab)
                                    <div class="jawab-item">
                                        <div class="d-flex align-items-center justify-content-between gap-2 mb-1">
                                            <span style="font-weight:600;font-size:0.8rem;">
                                                <i class="fas fa-reply me-1" style="color:var(--accent);"></i>
                                                {{ $jawab->user->name ?? 'User' }}
                                                <span style="font-size:0.72rem;color:#adb5bd;font-weight:400;margin-left:0.4rem;">
                                                    {{ $jawab->created_at->diffForHumans() }}
                                                </span>
                                            </span>
                                            <form action="{{ route('admin.jawabs.destroy', $jawab) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Hapus jawaban ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-danger-admin" style="padding:0.2rem 0.5rem;font-size:0.7rem;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div style="font-size:0.85rem;color:var(--text-primary);">
                                            {{ $jawab->jawaban }}
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

    </div>

    {{-- RIGHT: Info sidebar --}}
    <div class="col-lg-4 d-flex flex-column gap-3">

        {{-- Info Card --}}
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-info-circle me-2" style="color:var(--accent);"></i>Informasi
                </h5>
            </div>
            <div class="card-body">
                <dl style="font-size:0.875rem;">
                    <dt style="color:#adb5bd;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem;">Judul</dt>
                    <dd style="color:var(--text-primary);font-weight:500;margin-bottom:1rem;">{{ $submodul->judul }}</dd>

                    <dt style="color:#adb5bd;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem;">Modul</dt>
                    <dd style="margin-bottom:1rem;">
                        <a href="{{ route('admin.moduls.submoduls.index', $modul) }}" style="color:var(--accent);">
                            {{ $modul->judul }}
                        </a>
                    </dd>

                    <dt style="color:#adb5bd;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem;">Urutan</dt>
                    <dd style="margin-bottom:1rem;">
                        <span style="background:var(--accent-light);color:var(--accent);padding:0.25rem 0.65rem;border-radius:20px;font-size:0.8rem;font-weight:600;">
                            {{ $submodul->sort_order }}
                        </span>
                    </dd>

                    <dt style="color:#adb5bd;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem;">Dibuat</dt>
                    <dd style="color:var(--text-primary);margin-bottom:1rem;">
                        {{ $submodul->created_at->format('d M Y, H:i') }}
                    </dd>

                    <dt style="color:#adb5bd;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem;">Diperbarui</dt>
                    <dd style="color:var(--text-primary);margin-bottom:0;">
                        {{ $submodul->updated_at->diffForHumans() }}
                    </dd>
                </dl>
            </div>
        </div>

        {{-- Quick Stats --}}
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-chart-bar me-2" style="color:var(--accent);"></i>Statistik
                </h5>
            </div>
            <div class="card-body d-flex flex-column gap-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div style="font-size:0.875rem;color:var(--text-primary);">
                        <i class="fas fa-question-circle me-2" style="color:var(--accent);"></i>Quiz
                    </div>
                    <span style="font-weight:700;color:var(--text-primary);">{{ $submodul->quizzes->count() }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div style="font-size:0.875rem;color:var(--text-primary);">
                        <i class="fas fa-list-ol me-2" style="color:var(--accent);"></i>Total Soal
                    </div>
                    <span style="font-weight:700;color:var(--text-primary);">
                        {{ $submodul->quizzes->sum(fn($q) => $q->pertanyaan->count()) }}
                    </span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div style="font-size:0.875rem;color:var(--text-primary);">
                        <i class="fas fa-comments me-2" style="color:var(--accent);"></i>Diskusi
                    </div>
                    <span style="font-weight:700;color:var(--text-primary);">{{ $submodul->tanya->count() }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div style="font-size:0.875rem;color:var(--text-primary);">
                        <i class="fas fa-reply me-2" style="color:var(--accent);"></i>Jawaban
                    </div>
                    <span style="font-weight:700;color:var(--text-primary);">
                        {{ $submodul->tanya->sum(fn($t) => $t->jawabs->count()) }}
                    </span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div style="font-size:0.875rem;color:var(--text-primary);">
                        <i class="fas fa-paperclip me-2" style="color:var(--accent);"></i>Resource
                    </div>
                    <span style="font-weight:700;color:var(--text-primary);">{{ $submodul->resources->count() }}</span>
                </div>
            </div>
        </div>

        {{-- Aksi Cepat --}}
        <div class="admin-card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-bolt me-2" style="color:var(--accent);"></i>Aksi
                </h5>
            </div>
            <div class="card-body d-flex flex-column gap-2">
                <a href="{{ route('admin.moduls.submoduls.edit', [$modul, $submodul]) }}" class="btn-primary-admin w-100 justify-content-center">
                    <i class="fas fa-edit"></i> Edit Submodul
                </a>
                <a href="{{ route('admin.moduls.submoduls.quizzes.create', [$modul, $submodul]) }}" class="btn-outline-admin w-100 justify-content-center">
                    <i class="fas fa-plus"></i> Tambah Quiz
                </a>
                <form action="{{ route('admin.moduls.submoduls.destroy', [$modul, $submodul]) }}"
                      method="POST"
                      onsubmit="return confirm('Hapus submodul \'{{ addslashes($submodul->judul) }}\'? Semua data terkait akan terhapus.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger-admin w-100 justify-content-center">
                        <i class="fas fa-trash"></i> Hapus Submodul
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
