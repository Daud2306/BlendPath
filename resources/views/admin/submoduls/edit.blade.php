@extends('layout.admin.app')

@section('title', 'Edit Submodul — ' . $submodul->judul)

@push('styles')
    <style>
        .tox-tinymce {
            border-radius: var(--radius) !important;
            border-color: var(--border-color) !important;
        }

        .video-preview {
            aspect-ratio: 16/9;
            width: 100%;
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
            background: #000;
        }

        .resource-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 0.75rem;
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            font-size: 0.85rem;
        }

        .resource-item .resource-thumb {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 6px;
            flex-shrink: 0;
        }

        .resource-item .resource-icon {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            background: var(--accent-light);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--accent);
        }
    </style>
@endpush

@section('content')

    {{-- Page Header --}}
    <div class="page-header d-flex align-items-start justify-content-between flex-wrap gap-2">
        <div>
            <h1 class="page-title">Edit Submodul</h1>
            <p class="page-subtitle mb-0">
                <i class="fas fa-layer-group me-1" style="color:var(--accent);"></i>
                {{ $modul->judul }} &rsaquo; {{ $submodul->judul }}
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.course.builder') }}">Course Builder</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('admin.moduls.submoduls.show', [$modul, $submodul]) }}">{{ Str::limit($submodul->judul, 20) }}</a>
                </li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="row g-3">

        {{-- LEFT: Form Edit --}}
        <div class="col-lg-8">

            <form action="{{ route('admin.moduls.submoduls.update', [$modul, $submodul]) }}" method="POST"
                id="editSubmodulForm">
                @csrf
                @method('PUT')

                {{-- Judul --}}
                <div class="admin-card mb-3">
                    <div class="admin-card-header">
                        <span class="admin-card-title">
                            <i class="fas fa-heading me-2" style="color:var(--accent);"></i>Judul & Urutan
                        </span>
                    </div>
                    <div class="admin-card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul Submodul <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                                value="{{ old('judul', $submodul->judul) }}" required maxlength="255">
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label fw-semibold">Urutan (sort_order)</label>
                            <input type="number" name="sort_order" class="form-control"
                                value="{{ old('sort_order', $submodul->sort_order) }}" min="0"
                                style="max-width:120px;">
                            <div class="form-text">Angka kecil tampil lebih awal. Atur urutan visual di Course Builder.
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Konten TinyMCE --}}
                <div class="admin-card mb-3">
                    <div class="admin-card-header">
                        <span class="admin-card-title">
                            <i class="fas fa-file-alt me-2" style="color:var(--accent);"></i>Konten
                        </span>
                        <span style="font-size:0.78rem;color:#adb5bd;">Gunakan toolbar untuk insert gambar atau embed
                            video</span>
                    </div>
                    <div class="admin-card-body">
                        @error('konten')
                            <div class="alert alert-danger mb-2">{{ $message }}</div>
                        @enderror
                        <textarea name="konten" id="kontenEditor">{{ old('konten', $submodul->konten) }}</textarea>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn-admin primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.moduls.submoduls.show', [$modul, $submodul]) }}" class="btn-admin secondary">
                        Batal
                    </a>
                </div>
            </form>

        </div>

        {{-- RIGHT: Video Link + Info --}}
        <div class="col-lg-4 d-flex flex-column gap-3">

            {{-- Tambah Video YouTube/Vimeo --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title">
                        <i class="fab fa-youtube me-2" style="color:#ff0000;"></i>Video Embed
                    </span>
                </div>
                <div class="admin-card-body">
                    <p style="font-size:0.82rem;color:#adb5bd;margin-bottom:0.75rem;">
                        Tambahkan link YouTube atau Vimeo. Video akan disimpan sebagai resource terpisah dan bisa
                        ditampilkan di halaman submodul.
                    </p>

                    {{-- Daftar video yang sudah ada --}}
                    @php $videoResources = $submodul->resources->where('type', 'video_link'); @endphp
                    @if ($videoResources->isNotEmpty())
                        <div class="d-flex flex-column gap-2 mb-3">
                            @foreach ($videoResources as $res)
                                <div class="resource-item">
                                    <div class="resource-icon"><i class="fab fa-youtube"></i></div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <div style="font-size:0.78rem;color:#adb5bd;">Video Link</div>
                                        <a href="{{ $res->path }}" target="_blank"
                                            style="font-size:0.82rem;color:var(--accent);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;display:block;max-width:160px;">
                                            {{ Str::limit($res->path, 40) }}
                                        </a>
                                    </div>
                                    {{-- <form action="{{ route('storage.file', $res->path) }}" method="POST"
                                  onsubmit="return confirm('Hapus video ini?')" style="flex-shrink:0;">
                                @csrf
                                @method('DELETE')

                            </form> --}}
                                    <button type="button" onclick="deleteResource({{ $res->id }}, this)"
                                        style="background:none;border:none;color:#adb5bd;cursor:pointer;padding:4px;flex-shrink:0;"
                                        title="Hapus">
                                        <i class="fas fa-trash-alt" style="font-size:0.8rem;"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Form tambah video baru --}}
                    <form id="addVideoForm">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label fw-semibold" style="font-size:0.85rem;">URL YouTube / Vimeo</label>
                            <input type="url" id="videoUrlInput" class="form-control form-control-sm"
                                placeholder="https://www.youtube.com/watch?v=...">
                            <div class="form-text">Paste URL biasa, bukan embed URL.</div>
                        </div>
                        {{-- Preview --}}
                        <div id="videoPreviewWrap" style="display:none;margin-bottom:0.75rem;">
                            <iframe id="videoPreviewFrame" class="video-preview" frameborder="0" allowfullscreen></iframe>
                        </div>
                        <button type="button" id="addVideoBtn" class="btn-admin secondary w-100">
                            <i class="fas fa-plus"></i> Tambah Video
                        </button>
                    </form>
                </div>
            </div>

            {{-- Info Card --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <span class="admin-card-title">
                        <i class="fas fa-info-circle me-2" style="color:var(--accent);"></i>Info
                    </span>
                </div>
                <div class="admin-card-body">
                    <dl style="font-size:0.875rem;margin:0;">
                        <dt
                            style="color:#adb5bd;font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.2rem;">
                            Modul</dt>
                        <dd style="margin-bottom:0.75rem;font-weight:500;">{{ $modul->judul }}</dd>

                        <dt
                            style="color:#adb5bd;font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.2rem;">
                            Dibuat</dt>
                        <dd style="margin-bottom:0.75rem;">{{ $submodul->created_at->format('d M Y, H:i') }}</dd>

                        <dt
                            style="color:#adb5bd;font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.2rem;">
                            Terakhir diperbarui</dt>
                        <dd style="margin-bottom:0;">{{ $submodul->updated_at->diffForHumans() }}</dd>
                    </dl>
                    <hr style="border-color:var(--border-color);">
                    <a href="{{ route('admin.moduls.submoduls.show', [$modul, $submodul]) }}"
                        class="btn-admin secondary w-100 justify-content-center">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    {{-- TinyMCE --}}
    <script src="https://cdn.tiny.cloud/1/{{ env('TINYMCE_API_KEY') }}/tinymce/6/tinymce.min.js" referrerpolicy="origin">
    </script>
    <script>
        tinymce.init({
            selector: '#kontenEditor',
            height: 500,
            menubar: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap',
                'preview', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic underline | ' +
                'alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | ' +
                'image media link | table | code fullscreen | help',

            // Image upload ke server via TinyMCEController
            images_upload_url: '{{ url('learn/tinymce/upload') }}',
            images_upload_credentials: true,
            automatic_uploads: true,
            images_reuse_filename: false,
            images_upload_handler: function(blobInfo, progress) {
                return new Promise((resolve, reject) => {
                    const formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch('{{ url('learn/tinymce/upload') }}', {
                            method: 'POST',
                            body: formData,
                            credentials: 'same-origin',
                        })
                        .then(r => r.json())
                        .then(data => {
                            if (data.location) resolve(data.location);
                            else reject({
                                message: 'Upload gagal',
                                remove: true
                            });
                        })
                        .catch(() => reject({
                            message: 'Upload gagal',
                            remove: true
                        }));
                });
            },

            // Media embed (YouTube/Vimeo) via plugin media
            media_live_embeds: true,
            media_url_resolver: function(data, resolve) {
                const url = data.url;
                let embedUrl = '';

                // YouTube
                const ytMatch = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
                if (ytMatch) {
                    embedUrl = `https://www.youtube.com/embed/${ytMatch[1]}`;
                }

                // Vimeo
                const vimeoMatch = url.match(/vimeo\.com\/(\d+)/);
                if (vimeoMatch) {
                    embedUrl = `https://player.vimeo.com/video/${vimeoMatch[1]}`;
                }

                if (embedUrl) {
                    resolve({
                        html: `<iframe src="${embedUrl}" width="100%" height="400" frameborder="0" allowfullscreen></iframe>`
                    });
                } else {
                    resolve({
                        html: ''
                    });
                }
            },

            content_style: 'body { font-family: Inter, sans-serif; font-size: 14px; line-height: 1.8; } img { max-width: 100%; }',
            skin: (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'oxide-dark' : 'oxide'),
        });
    </script>

    {{-- Video Resource (simpan ke tabel resources) --}}
    <script>
        const submodulId = {{ $submodul->id }};
        const submodulType = 'App\\Models\\Submodul';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Konversi URL YouTube/Vimeo biasa → embed URL
        function toEmbedUrl(url) {
            const ytMatch = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
            if (ytMatch) return `https://www.youtube.com/embed/${ytMatch[1]}`;

            const vimeoMatch = url.match(/vimeo\.com\/(\d+)/);
            if (vimeoMatch) return `https://player.vimeo.com/video/${vimeoMatch[1]}`;

            return null;
        }

        // Preview real-time saat user ketik URL
        document.getElementById('videoUrlInput').addEventListener('input', function() {
            const embedUrl = toEmbedUrl(this.value.trim());
            const wrap = document.getElementById('videoPreviewWrap');
            const frame = document.getElementById('videoPreviewFrame');
            if (embedUrl) {
                frame.src = embedUrl;
                wrap.style.display = 'block';
            } else {
                wrap.style.display = 'none';
                frame.src = '';
            }
        });

        // Simpan video ke tabel resources
        document.getElementById('addVideoBtn').addEventListener('click', async function() {
            const rawUrl = document.getElementById('videoUrlInput').value.trim();
            const embedUrl = toEmbedUrl(rawUrl);

            if (!embedUrl) {
                alert('URL tidak valid. Masukkan link YouTube atau Vimeo.');
                return;
            }

            // 👇 TAMBAHKAN CONSOLE.LOG DI SINI (sebelum this.disabled)
            console.log('Menyimpan video:', {
                submodul_id: submodulId,
                embed_url: embedUrl
            });

            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

            try {
                const response = await fetch('{{ url('admin/course-builder/submodul-video') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        submodul_id: submodulId,
                        embed_url: embedUrl,
                    }),
                });

                const data = await response.json();
                console.log('Response:', data); // Opsional: lihat response dari server

                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message ?? 'Gagal menyimpan video.');
                }
            } catch (e) {
                console.error('Error:', e); // Opsional: lihat error detail
                alert('Terjadi kesalahan. Coba lagi.');
            } finally {
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-plus"></i> Tambah Video';
            }
        });

        // Hapus resource
        async function deleteResource(resourceId, btn) {
            if (!confirm('Hapus resource ini?')) return;
            btn.disabled = true;

            try {
                const response = await fetch(`/admin/course-builder/resource/${resourceId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                });
                const data = await response.json();
                if (data.success) {
                    btn.closest('.resource-item').remove();
                } else {
                    alert(data.message ?? 'Gagal menghapus.');
                    btn.disabled = false;
                }
            } catch (e) {
                alert('Terjadi kesalahan.');
                btn.disabled = false;
            }
        }
    </script>
@endpush
