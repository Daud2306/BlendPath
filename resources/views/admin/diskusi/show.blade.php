@extends('layout.admin.app')

@section('title', 'Thread Diskusi')

@push('styles')
    <style>
        .thread-bubble {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            position: relative;
        }

        .thread-bubble.question {
            border-left: 3px solid var(--accent);
        }

        .thread-bubble.answer {
            border-left: 3px solid var(--success, #28a745);
            margin-left: 2rem;
        }

        .thread-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            flex-shrink: 0;
            color: #fff;
        }

        .thread-avatar.q {
            background: var(--accent);
        }

        .thread-avatar.a {
            background: var(--success, #28a745);
        }

        .thread-text {
            font-size: 0.9rem;
            line-height: 1.7;
            white-space: pre-line;
        }

        .connector-line {
            width: 2px;
            background: var(--border-color);
            margin: 0 auto;
            flex-shrink: 0;
        }
    </style>
@endpush

@section('content')

    <div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-2">
        <div>
            <h1 class="page-title">Thread Diskusi</h1>
            <p class="page-subtitle mb-0">
                @if ($tanya->submodul)
                    <i class="fas fa-layer-group me-1" style="color:var(--accent);"></i>
                    {{ $tanya->submodul->modul->judul ?? '—' }}
                    <span style="margin:0 0.3rem;color:#adb5bd;">&rsaquo;</span>
                    {{ $tanya->submodul->judul }}
                @endif
            </p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.diskusi.index') }}">Diskusi</a></li>
                    <li class="breadcrumb-item active">Thread</li>
                </ol>
            </nav>
            <form action="{{ route('admin.diskusi.tanya.destroy', $tanya) }}" method="POST"
                onsubmit="return confirm('Hapus seluruh thread ini beserta semua jawabannya?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-admin danger ms-2">
                    <i class="fas fa-trash"></i> Hapus Thread
                </button>
            </form>
        </div>
    </div>

    <div class="row g-3">

        {{-- LEFT: Thread --}}
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title">
                        <i class="fas fa-comments me-2" style="color:var(--accent);"></i>
                        Thread
                        <span
                            style="background:var(--accent-light);color:var(--accent);font-size:0.75rem;padding:0.2rem 0.6rem;border-radius:20px;margin-left:0.5rem;">
                            {{ 1 + $tanya->jawabs->count() }} pesan
                        </span>
                    </span>
                </div>
                <div class="admin-card-body d-flex flex-column gap-3">

                    {{-- Pertanyaan --}}
                    <div>
                        <div class="d-flex align-items-start gap-2 mb-2">
                            <div class="thread-avatar q">
                                {{ strtoupper(substr($tanya->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between gap-2 mb-1">
                                    <div>
                                        <span style="font-weight:600;font-size:0.875rem;">
                                            {{ $tanya->user->name ?? 'User' }}
                                        </span>
                                        <span style="font-size:0.75rem;color:#adb5bd;margin-left:0.4rem;">
                                            <i class="fas fa-question-circle me-1" style="color:var(--accent);"></i>Penanya
                                            · {{ $tanya->created_at->format('d M Y, H:i') }}
                                        </span>
                                    </div>
                                    <form action="{{ route('admin.diskusi.tanya.destroy', $tanya) }}" method="POST"
                                        onsubmit="return confirm('Hapus pertanyaan ini beserta semua jawabannya?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-admin danger sm"
                                            style="padding:0.2rem 0.5rem;font-size:0.75rem;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="thread-bubble question">
                                    <p class="thread-text mb-0">{{ strip_tags($tanya->pertanyaan) }}</p>
                                    {{-- Gambar lampiran pertanyaan --}}
                                    @if ($tanya->resources->isNotEmpty())
                                        <div class="d-flex flex-wrap gap-2 mt-2">
                                            @foreach ($tanya->resources as $res)
                                                <a href="{{ $res->url }}" target="_blank">
                                                    <img src="{{ $res->url }}" alt="Lampiran"
                                                        style="max-height:80px;border-radius:6px;border:1px solid var(--border-color);">
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Garis penghubung --}}
                    @if ($tanya->jawabs->isNotEmpty())
                        <div style="padding-left:18px;">
                            <div class="connector-line" style="height:8px;"></div>
                        </div>
                    @endif

                    {{-- Jawaban --}}
                    @forelse ($tanya->jawabs as $i => $jawab)
                        <div>
                            <div class="d-flex align-items-start gap-2 mb-1">
                                <div style="width:18px;flex-shrink:0;"></div>{{-- indent --}}
                                <div class="thread-avatar a">
                                    {{ strtoupper(substr($jawab->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center justify-content-between gap-2 mb-1">
                                        <div>
                                            <span style="font-weight:600;font-size:0.875rem;">
                                                {{ $jawab->user->name ?? 'User' }}
                                            </span>
                                            <span style="font-size:0.75rem;color:#adb5bd;margin-left:0.4rem;">
                                                <i class="fas fa-reply me-1"
                                                    style="color:var(--success,#28a745);"></i>Jawaban #{{ $i + 1 }}
                                                · {{ $jawab->created_at->format('d M Y, H:i') }}
                                            </span>
                                        </div>
                                        <form action="{{ route('admin.diskusi.jawab.destroy', $jawab) }}" method="POST"
                                            onsubmit="return confirm('Hapus jawaban ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-admin danger sm"
                                                style="padding:0.2rem 0.5rem;font-size:0.75rem;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="thread-bubble answer">
                                        <p class="thread-text mb-0">{{ $jawab->jawaban }}</p>
                                        {{-- Gambar lampiran jawaban --}}
                                        @if ($jawab->resources->isNotEmpty())
                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                @foreach ($jawab->resources as $res)
                                                    <a href="{{ $res->url }}" target="_blank">
                                                        <img src="{{ $res->url }}" alt="Lampiran"
                                                            style="max-height:80px;border-radius:6px;border:1px solid var(--border-color);">
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Garis penghubung antar jawaban --}}
                            @if (!$loop->last)
                                <div style="padding-left:36px;">
                                    <div class="connector-line" style="height:8px;"></div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="empty-state" style="padding:1.5rem;">
                            <i class="fas fa-reply"></i>
                            <p style="margin:0;">Belum ada jawaban untuk pertanyaan ini.</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>

        {{-- RIGHT: Info --}}
        <div class="col-lg-4 d-flex flex-column gap-3">

            {{-- Info Thread --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title">
                        <i class="fas fa-info-circle me-2" style="color:var(--accent);"></i>Info Thread
                    </span>
                </div>
                <div class="admin-card-body">
                    <dl style="font-size:0.875rem;margin:0;">
                        <dt
                            style="color:#adb5bd;font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.2rem;">
                            Penanya</dt>
                        <dd style="margin-bottom:0.85rem;font-weight:500;">{{ $tanya->user->name ?? '—' }}</dd>

                        <dt
                            style="color:#adb5bd;font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.2rem;">
                            Submodul</dt>
                        <dd style="margin-bottom:0.85rem;">
                            @if ($tanya->submodul)
                                <a href="{{ route('admin.moduls.submoduls.show', [$tanya->submodul->modul_id, $tanya->submodul->id]) }}"
                                    style="color:var(--accent);">
                                    {{ $tanya->submodul->judul }}
                                </a>
                            @else
                                —
                            @endif
                        </dd>

                        <dt
                            style="color:#adb5bd;font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.2rem;">
                            Modul</dt>
                        <dd style="margin-bottom:0.85rem;">{{ $tanya->submodul->modul->judul ?? '—' }}</dd>

                        <dt
                            style="color:#adb5bd;font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.2rem;">
                            Diposting</dt>
                        <dd style="margin-bottom:0.85rem;">{{ $tanya->created_at->format('d M Y, H:i') }}</dd>

                        <dt
                            style="color:#adb5bd;font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.2rem;">
                            Jumlah Jawaban</dt>
                        <dd
                            style="margin-bottom:0;font-weight:700;color:{{ $tanya->jawabs->count() > 0 ? 'var(--success,#28a745)' : '#adb5bd' }}">
                            {{ $tanya->jawabs->count() }}
                            @if ($tanya->jawabs->count() === 0)
                                <span style="font-weight:400;font-size:0.8rem;"> — belum dijawab</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

@endsection
