@extends('layout.frontend.app')
@section('title', 'Upload Karya')

@push('styles')
    <link href="{{ asset('frontend/css/showcase.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="section">
        <div class="container" style="max-width:700px">

            <div class="mb-4">
                <h2 class="mb-1">Upload Karya</h2>
                <p style="color:#6c757d">Pamerkan hasil render Blender terbaikmu!</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="ask-question-card">
                <form action="{{ route('learn.showcase.store') }}" method="POST" enctype="multipart/form-data"
                    class="question-form">
                    @csrf

                    {{-- Judul --}}
                    <div class="mb-3">
                        <label class="form-label">
                            Judul Karya <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                            placeholder="Contoh: Low-poly Forest Scene" value="{{ old('judul') }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"
                            placeholder="Ceritakan proses pembuatan, software version, render engine, dll...">{{ old('deskripsi') }}</textarea>
                    </div>

                    {{-- Upload Media --}}
                    <div class="mb-4">
                        <label class="form-label">
                            Media <span class="text-danger">*</span>
                            <small class="text-muted ms-1">(foto/video, maks 5 file, 100MB/file)</small>
                        </label>

                        <div id="showcase-drop-zone" class="showcase-drop-zone">
                            <i class="bi bi-cloud-upload"></i>
                            <p>Klik atau drag &amp; drop file di sini</p>
                            <small>JPG, PNG, GIF, WEBP, MP4, MOV</small>
                        </div>

                        <input type="file" id="showcase-media-input" name="media[]"
                            accept="image/*,video/mp4,video/quicktime" multiple style="display:none">

                        <div id="showcase-preview-container" class="row g-2 showcase-preview-grid"></div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="modul-btn" style="width:auto">
                            <i class="bi bi-upload me-1"></i> Upload Karya
                        </button>
                        <a href="{{ route('learn.showcase.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('frontend/js/showcase.js') }}"></script>
@endpush
