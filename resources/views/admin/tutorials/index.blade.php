@extends('layout.admin.app')

@section('content')
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-4 mt-5">
            <div class="mt-2">
                <h1 class="h3 mb-1">Tutorial pada Roadmap: {{ $roadmap->judul }}</h1>
                <p class="text-muted mb-0">Kelola semua tutorial dalam roadmap ini.</p>
            </div>
            <a href="{{ route('admin.roadmaps.tutorials.create', $roadmap->id) }}" class="btn btn-primary">
                + Tambah Tutorial
            </a>
        </div>

        @if ($tutorials->isEmpty())
            <div class="alert alert-info">
                Belum ada tutorial untuk roadmap ini.
            </div>
        @else
            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table table-striped mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 50px;">#</th>
                                <th scope="col">Judul</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col" style="width: 120px;">Urutan</th>
                                <th scope="col" style="width: 180px;" class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tutorials as $tutorial)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tutorial->judul }}</td>
                                    <td>{{ Str::limit($tutorial->deskripsi, 60) }}</td>
                                    <td>{{ $tutorial->sort_order }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.roadmaps.tutorials.show', [$roadmap->id, $tutorial->id]) }}"
                                            class="btn btn-sm btn-info">
                                            Detail
                                        </a>
                                        <a href="{{ route('admin.roadmaps.tutorials.edit', [$roadmap->id, $tutorial->id]) }}"
                                            class="btn btn-sm btn-warning">
                                            Edit
                                        </a>
                                        <form
                                            action="{{ route('admin.roadmaps.tutorials.destroy', [$roadmap->id, $tutorial->id]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit"
                                                onclick="return confirm('Yakin ingin menghapus tutorial ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
