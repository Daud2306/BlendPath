@extends('layout.admin.app')

@section('title', 'Moduls - Demo')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Manajemen Moduls</h1>
            <div>
                <a href="{{ route('admin.moduls.create') }}" class="btn btn-success">+ Buat Modul</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif
        @if ($moduls->count() === 0)
            <div class="alert alert-info">Belum ada modul. Buat modul baru untuk memulai.</div>
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
                            @foreach ($moduls as $modul)
                                <tr>
                                    <td>
                                        @if ($modul->gambar)
                                            <img src="{{ asset('storage/' . $modul->gambar) }}"
                                                alt="{{ $modul->judul }}"
                                                style="width:72px; height:48px; object-fit:cover; border-radius:4px;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center"
                                                style="width:72px; height:48px; border-radius:4px; color:#888;">
                                                No Img
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $modul->judul }}</div>
                                        <div class="text-muted small">{!! \Illuminate\Support\Str::limit(strip_tags($modul->deskripsi), 100) !!}</div>
                                    </td>
                                    <td>{{ $modul->sort_order }}</td>
                                    <td>
                                        <div class="small text-muted">
                                            {{ $modul->created_at ? $modul->created_at->format('d M Y') : '-' }}</div>
                                        <div class="small text-muted">ID: {{ $modul->id }}</div>
                                    </td>
                                    <td>
                                  
                                        <a href="{{ route('moduls.show', $modul) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary">Lihat</a>

                                        <a href="{{ route('admin.moduls.edit', $modul) }}"
                                            class="btn btn-sm btn-warning">Edit</a>

                                        <form action="{{ route('admin.moduls.destroy', $modul) }}" method="POST"
                                            class="d-inline-block" style="vertical-align:middle;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                        <a href="{{ url('admin/moduls/' . $modul->id . '/submoduls') }}"
                                            class="btn btn-sm btn-info">Submoduls</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-3 border-top bg-white">
                    {{ $moduls->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
