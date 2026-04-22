{{-- ── Mini Project ── --}}
@if ($submodul->miniProjects->isNotEmpty())
    <div class="mb-5" data-aos="fade-up">
        <h5 class="fw-bold mb-3">
            <i class="bi bi-flag-fill text-success me-2"></i>Mini Project
        </h5>
        <div class="d-flex flex-column gap-3">
            @foreach ($submodul->miniProjects as $project)
                @php $userSubmission = $project->userSubmission(); @endphp
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        {{-- Header project --}}
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div
                                style="width:40px;height:40px;border-radius:10px;background:#e6f9ed;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-flag-fill text-success"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">{{ $project->judul }}</h6>
                                <p class="text-muted mb-0" style="font-size:0.9rem;white-space:pre-line;">
                                    {{ $project->deskripsi }}</p>
                            </div>
                        </div>

                        @if ($project->passing_criteria)
                            <div class="alert alert-success py-2 px-3 mb-3" style="font-size:0.85rem;">
                                <i class="bi bi-check2-circle me-2"></i>
                                <strong>Kriteria:</strong> {{ $project->passing_criteria }}
                            </div>
                        @endif

                        @php $projectImages = $project->resources->where('type', 'image'); @endphp
                        @if ($projectImages->isNotEmpty())
                            <p class="text-muted mb-2"
                                style="font-size:0.78rem;text-transform:uppercase;letter-spacing:0.05em;font-weight:600;">
                                <i class="bi bi-images me-1"></i>Gambar Referensi
                            </p>
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                @foreach ($projectImages as $img)
                                    <img src="{{ asset('storage/' . $img->path) }}" alt="Referensi" class="img-lightbox"
                                        style="width:80px;height:80px;object-fit:cover;border-radius:8px;border:1px solid #dee2e6;cursor:pointer;">
                                @endforeach
                            </div>
                        @endif

                        @if (!$userSubmission)
                            @if ($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('learn.mini_projects.submit', $project) }}" method="POST"
                                enctype="multipart/form-data" class="mini-project-submit-form mt-3 border-top pt-3">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label small fw-semibold">Catatan (opsional)</label>
                                    <textarea name="catatan" class="form-control form-control-sm" rows="2"
                                        placeholder="Tulis catatan untuk tugas Anda... (Anda juga bisa paste gambar di sini)"></textarea>
                                </div>

                                {{-- Dropzone area --}}
                                <div class="mb-2">
                                    <label class="form-label small fw-semibold">Upload File (Gambar / .blend)</label>
                                    <div class="dropzone-area border rounded p-3 text-center"
                                        style="background:#fcfcfc; transition: all 0.2s; cursor: pointer;">
                                        <input type="file" name="files[]" multiple class="d-none"
                                            accept="image/*,.blend,application/zip">
                                        <i class="bi bi-cloud-upload fs-1 text-muted"></i>
                                        <p class="mb-1 mt-2">Klik atau drag & drop file di sini</p>
                                        <small class="text-muted">Maks 20MB per file. Bisa upload gambar (jpg, png, gif,
                                            webp) atau file .blend</small>
                                        <div class="file-preview-container d-flex flex-wrap gap-2 mt-2"></div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="bi bi-cloud-upload me-1"></i>Kirim Tugas
                                    </button>
                                </div>
                            </form>
                        @elseif ($userSubmission->status === 'submitted')
                            <div class="alert alert-info mt-3 mb-0">
                                <i class="bi bi-clock-history me-2"></i>
                                <strong>Tugas sedang menunggu review</strong> (dikirim
                                {{ $userSubmission->submitted_at->format('d M Y H:i') }})
                            </div>
                        @elseif ($userSubmission->status === 'approved')
                            <div class="alert alert-success mt-3 mb-0">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <strong>Tugas disetujui!</strong> pada
                                {{ $userSubmission->submitted_at->format('d M Y H:i') }}
                                @if ($userSubmission->feedback)
                                    <p class="mt-2 mb-0 small"><strong>Feedback:</strong>
                                        {{ $userSubmission->feedback }}</p>
                                @endif
                            </div>
                        @elseif ($userSubmission->status === 'rejected')
                            <div class="alert alert-danger mt-3 mb-0">
                                <i class="bi bi-x-circle-fill me-2"></i>
                                <strong>Tugas ditolak.</strong>
                                @if ($userSubmission->feedback)
                                    <p class="mt-2 mb-2 small"><strong>Feedback:</strong>
                                        {{ $userSubmission->feedback }}</p>
                                @endif
                                <form action="{{ route('learn.mini_projects.resubmit', $project) }}" method="POST"
                                    class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-warning"
                                        onclick="return confirm('Hapus submission lama dan ajukan ulang?')">
                                        <i class="bi bi-arrow-repeat me-1"></i>Ajukan Ulang
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function rebuildPreviews(previewContainer, fileInput) {
                previewContainer.innerHTML = '';
                Array.from(fileInput.files).forEach(file => {
                    addPreview(previewContainer, file, fileInput);
                });
            }

            function addPreview(container, file, fileInput) {
                const wrapper = document.createElement('div');
                wrapper.className = 'position-relative d-inline-block m-1';
                wrapper.style.width = '80px';
                wrapper.style.height = '80px';
                wrapper.setAttribute('data-filename', file.name);

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        wrapper.innerHTML = `
                            <img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;border-radius:8px;border:1px solid #dee2e6;">
                            <button type="button" class="btn-close btn-sm position-absolute top-0 end-0 bg-white rounded-circle" style="font-size:0.6rem; width:1rem; height:1rem;"></button>
                            <div class="small text-muted text-truncate mt-1" style="max-width:80px;">${file.name}</div>
                        `;
                        container.appendChild(wrapper);
                    };
                    reader.readAsDataURL(file);
                } else {
                    wrapper.innerHTML = `
                        <div style="width:100%;height:100%;background:#f8f9fa;border-radius:8px;border:1px solid #dee2e6;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-filetype-blend fs-1 text-secondary"></i>
                        </div>
                        <button type="button" class="btn-close btn-sm position-absolute top-0 end-0 bg-white rounded-circle" style="font-size:0.6rem; width:1rem; height:1rem;"></button>
                        <div class="small text-muted text-truncate mt-1" style="max-width:80px;">${file.name}</div>
                    `;
                    container.appendChild(wrapper);
                }

                const removeBtn = wrapper.querySelector('.btn-close');
                removeBtn.addEventListener('click', () => {
                    const dt = new DataTransfer();
                    const currentFiles = Array.from(fileInput.files);
                    const newFiles = currentFiles.filter(f => f !== file);
                    newFiles.forEach(f => dt.items.add(f));
                    fileInput.files = dt.files;
                    rebuildPreviews(container, fileInput);
                });
            }

            document.querySelectorAll('.mini-project-submit-form').forEach(form => {
                const textarea = form.querySelector('textarea');
                const dropzone = form.querySelector('.dropzone-area');
                const fileInput = dropzone.querySelector('input[type="file"]');
                const previewContainer = dropzone.querySelector('.file-preview-container');

                if (!fileInput || !previewContainer) return;

                dropzone.addEventListener('click', (e) => {
                    if (e.target.closest('.btn-close')) return;
                    fileInput.click();
                });

                dropzone.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    dropzone.style.background = '#e9ecef';
                    dropzone.style.borderColor = '#86b7fe';
                });
                dropzone.addEventListener('dragleave', (e) => {
                    e.preventDefault();
                    dropzone.style.background = '#fcfcfc';
                    dropzone.style.borderColor = '#dee2e6';
                });
                dropzone.addEventListener('drop', (e) => {
                    e.preventDefault();
                    dropzone.style.background = '#fcfcfc';
                    dropzone.style.borderColor = '#dee2e6';
                    const files = Array.from(e.dataTransfer.files);
                    if (files.length) {
                        const dt = new DataTransfer();
                        const currentFiles = Array.from(fileInput.files);
                        currentFiles.forEach(f => dt.items.add(f));
                        files.forEach(f => dt.items.add(f));
                        fileInput.files = dt.files;
                        rebuildPreviews(previewContainer, fileInput);
                    }
                });

                fileInput.addEventListener('change', function() {
                    rebuildPreviews(previewContainer, this);
                });

                if (textarea) {
                    textarea.addEventListener('paste', (event) => {
                        const clipboardData = event.clipboardData || window.clipboardData;
                        const items = clipboardData.items;
                        const filesToAdd = [];

                        for (let i = 0; i < items.length; i++) {
                            if (items[i].type.indexOf('image') !== -1) {
                                const blob = items[i].getAsFile();
                                const file = new File([blob], `pasted-${Date.now()}-${i}.png`, {
                                    type: blob.type
                                });
                                filesToAdd.push(file);
                            }
                        }

                        if (filesToAdd.length) {
                            const dt = new DataTransfer();
                            const currentFiles = Array.from(fileInput.files);
                            currentFiles.forEach(f => dt.items.add(f));
                            filesToAdd.forEach(f => dt.items.add(f));
                            fileInput.files = dt.files;
                            rebuildPreviews(previewContainer, fileInput);
                            event.preventDefault();

                            const toast = document.createElement('div');
                            toast.className =
                                'alert alert-success alert-dismissible fade show mt-2';
                            toast.innerHTML =
                                `<i class="bi bi-check-circle-fill me-2"></i> ${filesToAdd.length} gambar berhasil ditambahkan dari clipboard! <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
                            toast.style.fontSize = '0.85rem';
                            form.insertBefore(toast, form.querySelector(
                                '.d-flex.justify-content-end'));
                            setTimeout(() => toast.remove(), 3000);
                        }
                    });
                }
            });
        });
    </script>
@endpush
