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
            max-height: 400px;
            overflow-y: auto;
        }

        .konten-preview::-webkit-scrollbar {
            width: 4px;
        }

        .konten-preview::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 2px;
        }

        .konten-preview img {
            max-width: 100%;
            border-radius: var(--radius);
        }

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

        .pertanyaan-item:last-child {
            border-bottom: none;
        }

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

        .project-card {
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            background: var(--bg-card);
            padding: 1rem 1.25rem;
            transition: var(--transition);
        }

        .project-card:hover {
            border-color: var(--success);
            box-shadow: var(--shadow-hover);
        }

        .diskusi-item {
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .diskusi-item:last-child {
            border-bottom: none;
        }

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
                    <li class="breadcrumb-item"><a href="{{ route('admin.course.builder') }}">Course Builder</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('admin.moduls.submoduls.index', $modul) }}">{{ Str::limit($modul->judul, 20) }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ Str::limit($submodul->judul, 20) }}</li>
                </ol>
            </nav>
            <a href="{{ route('admin.moduls.submoduls.edit', [$modul, $submodul]) }}" class="btn-admin primary ms-2">
                <i class="fas fa-edit"></i> Edit Submodul
            </a>
        </div>
    </div>

    {{-- Prev / Next Navigation --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        @if ($prevSubmodul)
            <a href="{{ route('admin.moduls.submoduls.show', [$modul, $prevSubmodul]) }}" class="nav-submodul-btn">
                <i class="fas fa-arrow-left"></i>
                <div>
                    <div style="font-size:0.7rem;color:#adb5bd;">Sebelumnya</div>
                    <div>{{ Str::limit($prevSubmodul->judul, 30) }}</div>
                </div>
            </a>
        @else
            <span class="nav-submodul-btn disabled"><i class="fas fa-arrow-left"></i> Tidak ada</span>
        @endif

        <a href="{{ route('admin.moduls.submoduls.index', $modul) }}" class="btn-admin secondary">
            <i class="fas fa-list"></i> Semua Submodul
        </a>

        @if ($nextSubmodul)
            <a href="{{ route('admin.moduls.submoduls.show', [$modul, $nextSubmodul]) }}" class="nav-submodul-btn"
                style="text-align:right;">
                <div>
                    <div style="font-size:0.7rem;color:#adb5bd;">Selanjutnya</div>
                    <div>{{ Str::limit($nextSubmodul->judul, 30) }}</div>
                </div>
                <i class="fas fa-arrow-right"></i>
            </a>
        @else
            <span class="nav-submodul-btn disabled" style="text-align:right;">Tidak ada <i
                    class="fas fa-arrow-right"></i></span>
        @endif
    </div>

    <div class="row g-3">

        {{-- LEFT: Konten + Quiz + Mini Project + Diskusi --}}
        <div class="col-lg-8 d-flex flex-column gap-3">

            {{-- Konten --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title">
                        <i class="fas fa-file-alt me-2" style="color:var(--accent);"></i>Konten
                    </span>
                    <a href="{{ route('admin.moduls.submoduls.edit', [$modul, $submodul]) }}"
                        class="btn-admin secondary sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
                <div class="admin-card-body">
                    @if ($submodul->konten)
                        <div class="konten-preview">{!! $submodul->konten !!}</div>
                    @else
                        <div class="empty-state" style="padding:2rem;">
                            <i class="fas fa-file-alt"></i>
                            <p>Belum ada konten. <a href="{{ route('admin.moduls.submoduls.edit', [$modul, $submodul]) }}"
                                    style="color:var(--accent);">Tambah sekarang</a></p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Resources (video_link + images) --}}
            @if ($submodul->resources && $submodul->resources->count() > 0)
                <div class="admin-card">
                    <div class="admin-card-header">
                        <span class="admin-card-title">
                            <i class="fas fa-paperclip me-2" style="color:var(--accent);"></i>Media / Resource
                        </span>
                        <span style="font-size:0.8rem;color:#adb5bd;">{{ $submodul->resources->count() }} item</span>
                    </div>
                    <div class="admin-card-body">
                        <div class="row g-2">
                            @foreach ($submodul->resources as $resource)
                                <div class="col-sm-6 col-md-4">
                                    @if ($resource->type === 'video_link')
                                        <div
                                            style="border:1px solid var(--border-color);border-radius:var(--radius);overflow:hidden;">
                                            <div style="aspect-ratio:16/9;background:#000;">
                                                <iframe src="{{ $resource->path }}" width="100%" height="100%"
                                                    frameborder="0" allowfullscreen style="display:block;"></iframe>
                                            </div>
                                            <div
                                                style="padding:0.5rem;font-size:0.75rem;color:#adb5bd;border-top:1px solid var(--border-color);">
                                                <i class="fab fa-youtube me-1"></i>Video Embed
                                            </div>
                                        </div>
                                    @else
                                        <div
                                            style="border:1px solid var(--border-color);border-radius:var(--radius);overflow:hidden;">
                                            @if (in_array(pathinfo($resource->path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                <img src="{{ asset('storage/' . $resource->path) }}" alt="Resource"
                                                    style="width:100%;height:100px;object-fit:cover;">
                                            @else
                                                <div
                                                    style="height:80px;background:var(--bg-primary);display:flex;align-items:center;justify-content:center;">
                                                    <i class="fas fa-file" style="font-size:1.5rem;color:#adb5bd;"></i>
                                                </div>
                                            @endif
                                            <div
                                                style="padding:0.5rem;font-size:0.75rem;color:#adb5bd;border-top:1px solid var(--border-color);">
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

            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title">
                        <i class="fas fa-question-circle me-2" style="color:var(--accent);"></i>Quiz
                        @if ($submodul->quizzes->count() > 0)
                            <span
                                style="background:var(--accent-light);color:var(--accent);font-size:0.75rem;padding:0.2rem 0.6rem;border-radius:20px;margin-left:0.5rem;">
                                {{ $submodul->quizzes->count() }}
                            </span>
                        @endif
                    </span>
                    <a href="{{ route('admin.moduls.submoduls.quiz.create', [$modul, $submodul]) }}"
                        class="btn-admin secondary sm">
                        <i class="fas fa-plus"></i> Tambah Quiz
                    </a>
                </div>
                <div class="admin-card-body p-0">
                    @forelse($submodul->quizzes as $quiz)
                        <div class="p-3">
                            <div class="quiz-item">
                                <div class="quiz-header" data-bs-toggle="collapse"
                                    data-bs-target="#quiz-{{ $quiz->id }}">
                                    <div>
                                        <div style="font-weight:600;font-size:0.9rem;color:var(--text-primary);">
                                            {{ $quiz->judul_quiz }}
                                        </div>
                                        <div style="font-size:0.78rem;color:#adb5bd;margin-top:3px;">
                                            {{ $quiz->questions->count() }} soal &bull;
                                            Passing score: {{ $quiz->passing_score }}%
                                            @if ($quiz->deskripsi)
                                                &bull; {{ Str::limit($quiz->deskripsi, 40) }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('admin.moduls.submoduls.quiz.edit', [$modul, $submodul, $quiz]) }}"
                                            class="btn-admin secondary sm" onclick="event.stopPropagation()">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form
                                            action="{{ route('admin.moduls.submoduls.quiz.destroy', [$modul, $submodul, $quiz]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Hapus quiz ini? Semua soal dan riwayat attempt akan ikut terhapus.')"
                                            onclick="event.stopPropagation()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-admin danger sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        <i class="fas fa-chevron-down"
                                            style="color:#adb5bd;font-size:0.75rem;transition:transform 0.2s;"></i>
                                    </div>
                                </div>

                                <div id="quiz-{{ $quiz->id }}" class="collapse">
                                    <div class="quiz-body">
                                        @forelse($quiz->questions as $no => $soal)
                                            <div class="pertanyaan-item">
                                                <div style="font-weight:600;font-size:0.875rem;margin-bottom:0.4rem;">
                                                    {{ $no + 1 }}. {{ $soal->pertanyaan }}
                                                </div>
                                                @if ($soal->gambar_soal)
                                                    <img src="{{ asset('storage/' . $soal->gambar_soal) }}"
                                                        alt="Gambar soal"
                                                        style="max-height:120px;border-radius:6px;margin-bottom:0.4rem;">
                                                @endif
                                                <div class="pilihan-grid">
                                                    @foreach ($soal->pilihan_jawaban as $key => $value)
                                                        <div
                                                            class="pilihan-item {{ strtoupper($key) === strtoupper($soal->jawaban_benar) ? 'correct' : '' }}">
                                                            <span class="pilihan-label">{{ strtoupper($key) }}</span>
                                                            {{ $value }}
                                                            @if (strtoupper($key) === strtoupper($soal->jawaban_benar))
                                                                <i class="fas fa-check ms-auto"
                                                                    style="font-size:0.7rem;"></i>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div style="font-size:0.75rem;color:#adb5bd;margin-top:0.4rem;">
                                                    Poin: {{ $soal->poin }}
                                                </div>
                                            </div>
                                        @empty
                                            <p style="font-size:0.875rem;color:#adb5bd;margin:0;">Belum ada soal. <a
                                                    href="{{ route('admin.moduls.submoduls.quiz.edit', [$modul, $submodul, $quiz]) }}"
                                                    style="color:var(--accent);">Tambah soal</a></p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-question-circle"></i>
                            <p>Belum ada quiz untuk submodul ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Mini Project --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title">
                        <i class="fas fa-project-diagram me-2" style="color:var(--success);"></i>Mini Project
                        @if ($submodul->miniProjects->count() > 0)
                            <span
                                style="background:#e6f9ed;color:var(--success);font-size:0.75rem;padding:0.2rem 0.6rem;border-radius:20px;margin-left:0.5rem;">
                                {{ $submodul->miniProjects->count() }}
                            </span>
                        @endif
                    </span>
                    {{-- Tombol tambah mini project — diarahkan ke Course Builder karena belum ada halaman create tersendiri --}}
                    <a href="{{ route('admin.course.builder') }}" class="btn-admin secondary sm">
                        <i class="fas fa-cubes"></i> Kelola di Builder
                    </a>
                </div>
                <div class="admin-card-body p-0">
                    @if ($submodul->miniProjects->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-project-diagram"></i>
                            <p>Belum ada mini project. Tambahkan lewat <a href="{{ route('admin.course.builder') }}"
                                    style="color:var(--accent);">Course Builder</a>.</p>
                        </div>
                    @else
                        <div class="p-3 d-flex flex-column gap-2">
                            @foreach ($submodul->miniProjects as $project)
                                <div class="project-card">
                                    <div class="d-flex align-items-start justify-content-between gap-2">
                                        <div>
                                            <div
                                                style="font-weight:600;font-size:0.9rem;color:var(--text-primary);margin-bottom:0.25rem;">
                                                <i class="fas fa-flag me-1"
                                                    style="color:var(--success);font-size:0.8rem;"></i>
                                                {{ $project->judul }}
                                            </div>
                                            <div style="font-size:0.82rem;color:#adb5bd;line-height:1.5;">
                                                {{ Str::limit($project->deskripsi, 120) }}
                                            </div>
                                            @if ($project->passing_criteria)
                                                <div
                                                    style="margin-top:0.5rem;font-size:0.78rem;background:var(--bg-primary);border:1px solid var(--border-color);border-radius:6px;padding:0.4rem 0.6rem;color:var(--text-primary);">
                                                    <strong>Kriteria:</strong>
                                                    {{ Str::limit($project->passing_criteria, 80) }}
                                                </div>
                                            @endif
                                            {{-- Gambar referensi dari resources --}}
                                            @php $projectImages = $project->resources->where('type', 'image'); @endphp
                                            @if ($projectImages->isNotEmpty())
                                                <div class="d-flex gap-1 mt-2 flex-wrap">
                                                    @foreach ($projectImages->take(3) as $img)
                                                        <img src="{{ asset('storage/' . $img->path) }}" alt="Referensi"
                                                            style="width:56px;height:56px;object-fit:cover;border-radius:6px;border:1px solid var(--border-color);">
                                                    @endforeach
                                                    @if ($projectImages->count() > 3)
                                                        <div
                                                            style="width:56px;height:56px;border-radius:6px;background:var(--bg-primary);border:1px solid var(--border-color);display:flex;align-items:center;justify-content:center;font-size:0.75rem;color:#adb5bd;">
                                                            +{{ $projectImages->count() - 3 }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        <span style="font-size:0.75rem;color:#adb5bd;white-space:nowrap;">
                                            Urutan {{ $project->sort_order }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Diskusi --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title">
                        <i class="fas fa-comments me-2" style="color:var(--accent);"></i>Diskusi
                        @if ($submodul->tanya->count() > 0)
                            <span
                                style="background:var(--accent-light);color:var(--accent);font-size:0.75rem;padding:0.2rem 0.6rem;border-radius:20px;margin-left:0.5rem;">
                                {{ $submodul->tanya->count() }}
                            </span>
                        @endif
                    </span>
                    <a href="{{ route('admin.tanyas.index') }}" class="btn-admin secondary sm">
                        <i class="fas fa-external-link-alt"></i> Kelola Semua
                    </a>
                </div>
                <div class="admin-card-body">
                    @if ($submodul->tanya->isEmpty())
                        <div class="empty-state" style="padding:2rem;">
                            <i class="fas fa-comments"></i>
                            <p>Belum ada diskusi di submodul ini</p>
                        </div>
                    @else
                        @foreach ($submodul->tanya as $tanya)
                            <div class="diskusi-item">
                                <div class="d-flex align-items-start gap-2">
                                    <div class="avatar" style="flex-shrink:0;">
                                        {{ strtoupper(substr($tanya->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center justify-content-between gap-2">
                                            <div>
                                                <span
                                                    style="font-weight:600;font-size:0.875rem;">{{ $tanya->user->name ?? 'User' }}</span>
                                                <span style="font-size:0.75rem;color:#adb5bd;margin-left:0.5rem;">
                                                    {{ $tanya->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <form action="{{ route('admin.tanyas.destroy', $tanya) }}" method="POST"
                                                onsubmit="return confirm('Hapus pertanyaan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-admin danger sm"
                                                    style="padding:0.25rem 0.6rem;font-size:0.75rem;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <p style="font-size:0.875rem;margin:0.4rem 0 0;color:var(--text-primary);">
                                            {{ $tanya->pertanyaan }}
                                        </p>

                                        @if ($tanya->jawabs->isNotEmpty())
                                            @foreach ($tanya->jawabs as $jawab)
                                                <div class="jawab-item">
                                                    <div
                                                        class="d-flex align-items-center justify-content-between gap-2 mb-1">
                                                        <span style="font-weight:600;font-size:0.8rem;">
                                                            <i class="fas fa-reply me-1" style="color:var(--accent);"></i>
                                                            {{ $jawab->user->name ?? 'User' }}
                                                            <span
                                                                style="font-size:0.72rem;color:#adb5bd;font-weight:400;margin-left:0.4rem;">
                                                                {{ $jawab->created_at->diffForHumans() }}
                                                            </span>
                                                        </span>
                                                        <form action="{{ route('admin.jawabs.destroy', $jawab) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Hapus jawaban ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn-admin danger sm"
                                                                style="padding:0.2rem 0.5rem;font-size:0.7rem;">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div style="font-size:0.85rem;color:var(--text-primary);">
                                                        {{ $jawab->jawaban }}</div>
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
                <div class="admin-card-header">
                    <span class="admin-card-title">
                        <i class="fas fa-info-circle me-2" style="color:var(--accent);"></i>Informasi
                    </span>
                </div>
                <div class="admin-card-body">
                    <dl style="font-size:0.875rem;margin:0;">
                        <dt
                            style="color:#adb5bd;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem;">
                            Judul</dt>
                        <dd style="color:var(--text-primary);font-weight:500;margin-bottom:1rem;">{{ $submodul->judul }}
                        </dd>

                        <dt
                            style="color:#adb5bd;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem;">
                            Modul</dt>
                        <dd style="margin-bottom:1rem;">
                            <a href="{{ route('admin.moduls.submoduls.index', $modul) }}" style="color:var(--accent);">
                                {{ $modul->judul }}
                            </a>
                        </dd>

                        <dt
                            style="color:#adb5bd;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem;">
                            Urutan</dt>
                        <dd style="margin-bottom:1rem;">
                            <span
                                style="background:var(--accent-light);color:var(--accent);padding:0.25rem 0.65rem;border-radius:20px;font-size:0.8rem;font-weight:600;">
                                {{ $submodul->sort_order }}
                            </span>
                        </dd>

                        <dt
                            style="color:#adb5bd;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem;">
                            Dibuat</dt>
                        <dd style="color:var(--text-primary);margin-bottom:1rem;">
                            {{ $submodul->created_at->format('d M Y, H:i') }}</dd>

                        <dt
                            style="color:#adb5bd;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.25rem;">
                            Diperbarui</dt>
                        <dd style="color:var(--text-primary);margin-bottom:0;">
                            {{ $submodul->updated_at->diffForHumans() }}</dd>
                    </dl>
                </div>
            </div>

            {{-- Statistik --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title">
                        <i class="fas fa-chart-bar me-2" style="color:var(--accent);"></i>Statistik
                    </span>
                </div>
                <div class="admin-card-body d-flex flex-column gap-3">
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
                            {{ $submodul->quizzes->sum(fn($q) => $q->questions->count()) }}
                        </span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div style="font-size:0.875rem;color:var(--text-primary);">
                            <i class="fas fa-project-diagram me-2" style="color:var(--success);"></i>Mini Project
                        </div>
                        <span
                            style="font-weight:700;color:var(--text-primary);">{{ $submodul->miniProjects->count() }}</span>
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
                        <span
                            style="font-weight:700;color:var(--text-primary);">{{ $submodul->resources->count() }}</span>
                    </div>
                </div>
            </div>

            {{-- Aksi Cepat --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title">
                        <i class="fas fa-bolt me-2" style="color:var(--accent);"></i>Aksi
                    </span>
                </div>
                <div class="admin-card-body d-flex flex-column gap-2">
                    <a href="{{ route('admin.moduls.submoduls.edit', [$modul, $submodul]) }}"
                        class="btn-admin primary w-100 justify-content-center">
                        <i class="fas fa-edit"></i> Edit Konten
                    </a>

                    {{-- Tombol tambah quiz baru (selalu tampil) --}}
                    <a href="{{ route('admin.moduls.submoduls.quiz.create', [$modul, $submodul]) }}"
                        class="btn-admin secondary w-100 justify-content-center">
                        <i class="fas fa-plus"></i> Tambah Quiz Baru
                    </a>

                    {{-- Daftar semua quiz yang sudah ada --}}
                    @foreach ($submodul->quizzes as $quiz)
                        <a href="{{ route('admin.moduls.submoduls.quiz.edit', [$modul, $submodul, $quiz]) }}"
                            class="btn-admin secondary w-100 justify-content-center"
                            style="font-size:0.8rem; background:var(--bg-primary);">
                            <i class="fas fa-edit"></i> Edit Quiz: {{ Str::limit($quiz->judul_quiz, 35) }}
                        </a>
                    @endforeach

                    <a href="{{ route('admin.course.builder') }}"
                        class="btn-admin secondary w-100 justify-content-center">
                        <i class="fas fa-cubes"></i> Course Builder
                    </a>

                    <form action="{{ route('admin.moduls.submoduls.destroy', [$modul, $submodul]) }}" method="POST"
                        onsubmit="return confirm('Hapus submodul \'{{ addslashes($submodul->judul) }}\'? Semua data terkait akan terhapus.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin danger w-100 justify-content-center">
                            <i class="fas fa-trash"></i> Hapus Submodul
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection
