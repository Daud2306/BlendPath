{{-- ── Mini Project ── --}}
@if ($submodul->miniProjects->isNotEmpty())
    <div class="mb-5" data-aos="fade-up">
        <h5 class="fw-bold mb-3">
            <i class="bi bi-flag-fill text-success me-2"></i>Mini Project
        </h5>
        <div class="d-flex flex-column gap-3">
            @foreach ($submodul->miniProjects as $project)
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
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
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($projectImages as $img)
                                    <a href="{{ asset('storage/' . $img->path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $img->path) }}" alt="Referensi"
                                            style="width:80px;height:80px;object-fit:cover;border-radius:8px;border:1px solid #dee2e6;">
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
