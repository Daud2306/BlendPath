@extends('layout.admin.app')

@section('title', 'Diskusi')

@section('content')

    <div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h1 class="page-title">Diskusi</h1>
            <p class="page-subtitle mb-0">Semua pertanyaan dari forum diskusi submodul</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Diskusi</li>
            </ol>
        </nav>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-4">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-comment-dots"></i></div>
                <div class="stat-info">
                    <div class="stat-value">{{ $totalPertanyaan }}</div>
                    <div class="stat-label">Total Pertanyaan</div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-reply"></i></div>
                <div class="stat-info">
                    <div class="stat-value">{{ $totalJawaban }}</div>
                    <div class="stat-label">Total Jawaban (semua data)</div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="stat-card">
                <div class="stat-icon orange"><i class="fas fa-comment-slash"></i></div>
                <div class="stat-info">
                    <div class="stat-value">{{ $belumDijawab }}</div>
                    <div class="stat-label">Belum Dijawab (semua data)</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="admin-card mb-4">
        <div class="admin-card-body">
            <form method="GET" action="{{ route('admin.diskusi.index') }}" class="d-flex flex-wrap gap-2 align-items-end">
                <div>
                    <label class="form-label mb-1"
                        style="font-size:0.8rem;font-weight:600;color:#adb5bd;text-transform:uppercase;letter-spacing:0.05em;">Modul</label>
                    <select name="modul_id" class="form-select form-select-sm" style="min-width:180px;"
                        onchange="this.form.submit()">
                        <option value="">Semua Modul</option>
                        @foreach ($moduls as $modul)
                            <option value="{{ $modul->id }}" {{ request('modul_id') == $modul->id ? 'selected' : '' }}>
                                {{ $modul->judul }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label mb-1"
                        style="font-size:0.8rem;font-weight:600;color:#adb5bd;text-transform:uppercase;letter-spacing:0.05em;">Submodul</label>
                    <select name="submodul_id" class="form-select form-select-sm" style="min-width:200px;"
                        onchange="this.form.submit()">
                        <option value="">Semua Submodul</option>
                        @foreach ($moduls as $modul)
                            @foreach ($modul->submoduls as $sub)
                                <option value="{{ $sub->id }}"
                                    {{ request('submodul_id') == $sub->id ? 'selected' : '' }}>
                                    {{ $modul->judul }} › {{ $sub->judul }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
                @if (request()->hasAny(['modul_id', 'submodul_id']))
                    <a href="{{ route('admin.diskusi.index') }}" class="btn-admin secondary sm">
                        <i class="fas fa-times me-1"></i>Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <span class="admin-card-title">
                <i class="fas fa-comment-dots me-2" style="color:var(--accent);"></i>Daftar Pertanyaan
            </span>
            <span style="font-size:0.8rem;color:#adb5bd;">{{ $tanyas->total() }} pertanyaan</span>
        </div>

        <div class="admin-card-body p-0">
            @if ($tanyas->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-comment-slash"></i>
                    <p>Belum ada diskusi
                        @if (request()->hasAny(['modul_id', 'submodul_id']))
                            untuk filter ini.
                        @else
                            .
                        @endif
                    </p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="width:50px;">#</th>
                                <th>Pertanyaan</th>
                                <th style="width:180px;">Konteks</th>
                                <th style="width:100px;">Penanya</th>
                                <th style="width:80px;">Jawaban</th>
                                <th style="width:130px;">Waktu</th>
                                <th style="width:100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tanyas as $tanya)
                                <tr>
                                    <td style="color:#adb5bd;font-size:0.8rem;">
                                        {{ ($tanyas->currentPage() - 1) * $tanyas->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        <div
                                            style="font-size:0.875rem;color:var(--text-primary);font-weight:500;line-height:1.4;">
                                            {{ Str::limit(strip_tags($tanya->pertanyaan), 90) }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($tanya->submodul)
                                            <div style="font-size:0.78rem;color:#adb5bd;line-height:1.5;">
                                                <div style="color:var(--text-primary);font-weight:500;">
                                                    {{ Str::limit($tanya->submodul->modul->judul ?? '-', 22) }}
                                                </div>
                                                <div>{{ Str::limit($tanya->submodul->judul, 28) }}</div>
                                            </div>
                                        @else
                                            <span style="font-size:0.78rem;color:#adb5bd;">—</span>
                                        @endif
                                    </td>
                                    <td style="font-size:0.85rem;">
                                        {{ Str::limit($tanya->user->name ?? '—', 18) }}
                                    </td>
                                    <td>
                                        <span
                                            style="font-size:0.85rem;font-weight:600; color:{{ $tanya->jawabs_count > 0 ? 'var(--success,#28a745)' : '#adb5bd' }}">
                                            {{ $tanya->jawabs_count }}
                                            @if ($tanya->jawabs_count == 0)
                                                <span style="font-size:0.72rem;font-weight:400;"> belum</span>
                                            @endif
                                        </span>
                                    </td>
                                    <td style="color:#adb5bd;font-size:0.8rem;">
                                        {{ $tanya->created_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.diskusi.show', $tanya) }}"
                                                class="btn-admin secondary sm" title="Lihat Thread">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.diskusi.tanya.destroy', $tanya) }}"
                                                method="POST"
                                                onsubmit="return confirm('Hapus pertanyaan ini beserta semua jawabannya?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-admin danger sm" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($tanyas->hasPages())
                    <div class="d-flex justify-content-between align-items-center px-3 py-3"
                        style="border-top:1px solid var(--border-color);">
                        <div style="font-size:0.8rem;color:#adb5bd;">
                            Menampilkan {{ $tanyas->firstItem() }}–{{ $tanyas->lastItem() }}
                            dari {{ $tanyas->total() }} pertanyaan
                        </div>
                        {{ $tanyas->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @endif
        </div>
    </div>

@endsection
