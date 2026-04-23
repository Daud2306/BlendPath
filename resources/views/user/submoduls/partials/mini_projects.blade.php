{{-- ── Mini Project ── --}}
@if ($submodul->miniProjects->isNotEmpty())
    <div class="mb-5" data-aos="fade-up">
        <h5 class="fw-bold mb-3">
            <i class="bi bi-flag-fill text-success me-2"></i>Mini Project
        </h5>
        <div class="d-flex flex-column gap-3">
            @foreach ($submodul->miniProjects as $project)
                @php $userSubmission = $project->userSubmission(); @endphp
                <div class="card border-0 shadow-sm" data-project-id="{{ $project->id }}">
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

                            <form method="POST" action="{{ route('learn.mini_projects.submit', $project) }}"
                                enctype="multipart/form-data" class="mt-3 border-top pt-3">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label small fw-semibold">Catatan (opsional)</label>
                                    <textarea name="catatan" class="form-control form-control-sm" rows="2"
                                        placeholder="Tulis catatan untuk tugas Anda..."></textarea>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label small fw-semibold">Upload File (Gambar / .blend)</label>
                                    <input type="file" name="files[]" multiple class="form-control form-control-sm"
                                        accept="image/*,.blend,application/zip">
                                    <div class="form-text">Maks 20MB per file. Bisa upload gambar (jpg, png, gif, webp)
                                        atau file .blend</div>
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
                                <strong>Tugas sedang menunggu review</strong>
                                (dikirim {{ $userSubmission->submitted_at->format('d M Y H:i') }})
                                {{-- Tampilkan file yang sudah diupload --}}
                                @if ($userSubmission->resources->isNotEmpty())
                                    <div class="mt-2 d-flex flex-wrap gap-2">
                                        @foreach ($userSubmission->resources as $res)
                                            @if ($res->type === 'image')
                                                <a href="{{ route('learn.mini_projects.serve_file', [$userSubmission, $res->id]) }}"
                                                    target="_blank">
                                                    <img src="{{ route('learn.mini_projects.serve_file', [$userSubmission, $res->id]) }}"
                                                        style="width:60px;height:60px;object-fit:cover;border-radius:6px;border:1px solid #dee2e6;">
                                                </a>
                                            @else
                                                <a href="{{ route('learn.mini_projects.serve_file', [$userSubmission, $res->id]) }}"
                                                    class="btn btn-sm btn-outline-secondary" target="_blank">
                                                    <i class="bi bi-file-earmark me-1"></i>{{ $res->original_name }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
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
