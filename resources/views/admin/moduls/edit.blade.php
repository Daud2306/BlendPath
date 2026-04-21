@extends('layout.admin.app')

@section('title', 'Admin - Edit Modul')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Edit Modul</h1>
            <a href="{{ route('admin.moduls.index') }}" class="btn btn-secondary">Back</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.moduls.update', $modul) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control" name="judul"
                                    value="{{ old('judul', $modul->judul) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="deskripsi" rows="4">{{ old('deskripsi', $modul->deskripsi) }}</textarea>
                            </div>

                            {{-- <div class="mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" class="form-control" name="sort_order"
                                    value="{{ old('sort_order', $modul->sort_order) }}">
                            </div> --}}
                        </div>

                        <div class="col-md-4">
                            @if ($modul->gambar)
                                <div class="mb-3">
                                    <label class="form-label">Current Image</label>
                                    <img src="{{ asset('storage/' . $modul->gambar) }}"
                                        class="img-fluid rounded border mb-2">
                                    <a href="{{ asset('storage/' . $modul->gambar) }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary w-100">
                                        View Image
                                    </a>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label">New Image (Optional)</label>
                                <input type="file" class="form-control" name="gambar" accept="image/*">
                                <small class="text-muted">Max: 2MB (JPG, PNG, GIF)</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">Update Modul</button>
                        <a href="{{ route('admin.moduls.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>

                <form method="POST" action="{{ route('admin.moduls.destroy', $modul) }}" class="ms-auto mt-2"
                    onsubmit="return confirm('Apakah anda yakin?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection
