@extends('layout.admin.app')

@section('title', 'Admin - Tambah Tutorial')

@section('content')
    <div class="container mt-4">
        <h2>Buat Tutorial Baru</h2>

        <form action="{{ route('admin.roadmaps.tutorials.store', $roadmap->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" name="judul" id="judul" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="konten" class="form-label">Konten</label>
                <textarea name="konten" id="konten" class="form-control" rows="5"></textarea>
            </div>

            <div class="mb-3">
                <label for="resource" class="form-label">Link Resource (YouTube / iframe link)</label>
                <input type="url" name="resource" id="resource" class="form-control"
                    placeholder="https://youtube.com/embed/...">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.roadmaps.tutorials.index', $roadmap->id) }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
