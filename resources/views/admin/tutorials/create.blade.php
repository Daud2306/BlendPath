@extends('layout.admin.app')

@section('title', 'Admin - Tambah Roadmap')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row mb-3">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Tambah Tutorial</h2>
                        <a href="{{ url('/admin/roadmaps') }}" class="btn btn-secondary">Kembali ke daftar Roadmap</a>
                    </div>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h6 class="mb-1">Terjadi kesalahan:</h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-body">

                        <form action="{{ url('/admin/tutorials/create') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Judul Tutorial</label>
                                        <input type="text" id="title" name="title" class="form-control"
                                            value="{{ old('title') }}" placeholder="Contoh: Roadmap A - Belajar Dasar 3D"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="short_description" class="form-label">Deskripsi singkat</label>
                                        <input type="text" id="short_description" name="short_description"
                                            class="form-control" value="{{ old('short_description') }}"
                                            placeholder="Ringkasan singkat roadmap (1 baris)">
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Deskripsi lengkap</label>
                                        <textarea id="description" name="description" class="form-control" rows="6"
                                            placeholder="Deskripsi, tujuan pembelajaran, prasyarat, dsb.">{{ old('description') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sort_order" class="form-label">Urutan tampil (sort order)</label>
                                        <input type="number" id="sort_order" name="sort_order" class="form-control"
                                            value="{{ old('sort_order', 1) }}" min="1">
                                        <small class="text-muted">Angka kecil tampil dulu (mis. 1 = paling atas).</small>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ url('/admin/roadmaps') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Roadmap</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
