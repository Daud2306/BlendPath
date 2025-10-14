@extends('layout.admin.app')

@section('title', 'Admin - Tambah Tutorial')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Tambah Tutorial Baru</h2>

        <form method="POST" action="{{ route('admin.roadmaps.tutorials.store', $roadmap->id) }}"
            enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="judul" class="form-label">Judul Tutorial</label>
                <input type="text" class="form-control" id="judul" name="judul" required>
            </div>

            <div class="mb-3">
                <label for="konten" class="form-label">Konten Tutorial</label>
                <textarea class="form-control" id="konten" name="konten" rows="6"
                    placeholder="Tulis penjelasan dan langkah-langkah di sini..." required></textarea>
            </div>

            <div class="mb-3">
                <label for="sort_order" class="form-label">Urutan</label>
                <input type="number" class="form-control" id="sort_order" name="sort_order" value="0" min="0">
                <div class="form-text">Nomor urut dalam roadmap (semakin kecil, semakin awal)</div>
            </div>

            {{-- <div class="mb-3">
            <label class="form-label">Upload File (Opsional)</label>
            <input class="form-control" type="file" name="resources[]" multiple>
            <div class="form-text">Format: JPG, PNG, MP4, PDF, .blend (maks 20MB per file)</div>
        </div> --}}

            <div class="mb-3">
                <label for="resource" class="form-label">Link Tambahan (Satu per baris)</label>
                <textarea class="form-control" id="resource" name="resource" rows="3"></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan Tutorial</button>
                <a href="{{ route('admin.roadmaps.tutorials.index', $roadmap->id) }}"
                    class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
