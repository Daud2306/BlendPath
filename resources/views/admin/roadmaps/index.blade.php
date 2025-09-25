@extends('layout.admin.app')

@section('title', 'Roadmaps - Demo')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Manajemen Roadmaps</h1>
            <div>
                <a href="{{ route('admin.roadmaps.create') }}" class="btn btn-success">+ Buat Roadmap</a>
            </div>
        </div>

        {{-- Flash --}}
        @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif

        @if ($roadmaps->count() === 0)
            <div class="alert alert-info">Belum ada roadmap. Buat roadmap baru untuk memulai.</div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width:80px;">Gambar</th>
                                <th>Judul & Deskripsi</th>
                                <th style="width:100px;">Urutan</th>
                                <th style="width:170px;">Tanggal / ID</th>
                                <th style="width:260px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roadmaps as $roadmap)
                                <tr>
                                    <td>
                                        @if ($roadmap->gambar)
                                            <img src="{{ asset('storage/' . $roadmap->gambar) }}"
                                                alt="{{ $roadmap->judul }}"
                                                style="width:72px; height:48px; object-fit:cover; border-radius:4px;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center"
                                                style="width:72px; height:48px; border-radius:4px; color:#888;">
                                                No Img
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $roadmap->judul }}</div>
                                        <div class="text-muted small">{!! \Illuminate\Support\Str::limit(strip_tags($roadmap->deskripsi), 100) !!}</div>
                                    </td>
                                    <td>{{ $roadmap->sort_order }}</td>
                                    <td>
                                        <div class="small text-muted">
                                            {{ $roadmap->created_at ? $roadmap->created_at->format('d M Y') : '-' }}</div>
                                        <div class="small text-muted">ID: {{ $roadmap->id }}</div>
                                    </td>
                                    <td>
                                        {{-- Lihat publik --}}
                                        <a href="{{ route('roadmaps.show', $roadmap) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary">Lihat</a>

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.roadmaps.edit', $roadmap) }}"
                                            class="btn btn-sm btn-warning">Edit</a>

                                        {{-- Hapus (form) --}}
                                        <form action="{{ route('admin.roadmaps.destroy', $roadmap) }}" method="POST"
                                            class="d-inline-block" style="vertical-align:middle;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>

                                        {{-- Link ke daftar tutorial admin (sesuaikan route jika beda) --}}
                                        <a href="{{ url('admin/roadmaps/' . $roadmap->id . '/tutorials') }}"
                                            class="btn btn-sm btn-info">Tutorials</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="p-3 border-top bg-white">
                    {{ $roadmaps->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
