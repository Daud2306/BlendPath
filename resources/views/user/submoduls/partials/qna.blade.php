<div class="qna-section mt-5" id="qna-section">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-transparent border-0 pb-0">
            <h5 class="card-title mb-0">
                <i class="bi bi-chat-dots-fill me-2 text-primary"></i>Diskusi & Tanya Jawab
            </h5>
            <p class="text-muted mt-2">Ajukan pertanyaan atau bantu menjawab pertanyaan lainnya</p>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 success-highlight" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @auth
                <div class="ask-question-card card border-0 bg-light mb-4" id="askQuestionForm">
                    <div class="card-body">
                        <h6 class="card-title d-flex align-items-center">
                            <i class="bi bi-pencil-square me-2 text-primary"></i>Ajukan Pertanyaan Baru
                        </h6>
                        <form action="{{ route('tanyas.store') }}" method="POST" enctype="multipart/form-data"
                            class="mt-3">
                            @csrf
                            <input type="hidden" name="submodul_id" value="{{ $submodul->id }}">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Pertanyaan Anda</label>
                                <textarea name="pertanyaan" class="form-control question-textarea" rows="4"
                                    placeholder="Tulis pertanyaan detail tentang submodul ini..." required>{{ old('pertanyaan') }}</textarea>
                                @error('pertanyaan')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Jelaskan masalah atau pertanyaan Anda dengan jelas</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-image me-1"></i>Screenshot Blender (Opsional)
                                </label>
                                <input type="file" class="form-control file-input" name="gambar[]" multiple
                                    accept="image/*">
                                <div class="form-text">Maksimal 5 file, format: JPG, PNG, GIF (maks. 2MB per file)</div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>Pertanyaan akan dilihat oleh komunitas
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send me-2"></i>Kirim Pertanyaan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="auth-prompt alert alert-info border-0">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-chat-square-text display-6 text-primary me-3"></i>
                        <div>
                            <h6 class="alert-heading mb-1">Ingin Bertanya?</h6>
                            <p class="mb-0">Silakan <a href="{{ route('login') }}"
                                    class="alert-link fw-semibold">login</a>
                                untuk mengajukan pertanyaan atau menjawab diskusi.</p>
                        </div>
                    </div>
                </div>
            @endauth

            <!-- Indicator Urutan -->
            <div class="sort-indicator d-flex align-items-center mb-3 p-3 bg-light rounded">
                <i class="bi bi-sort-down text-primary me-2"></i>
                <small class="text-muted">Menampilkan pertanyaan terbaru di atas</small>
            </div>

            <div class="questions-list">
                @forelse ($submodul->tanya as $tanya)
                    <div class="question-card card border-0 shadow-sm mb-4 
                                @if ($loop->first && session('success')) new-question-highlight @endif"
                        data-question-id="{{ $tanya->id }}">
                        <div class="card-body">
                            @if ($loop->first)
                                <div class="new-badge mb-2">
                                    <span class="badge bg-primary">
                                        <i class="bi bi-star-fill me-1"></i>Pertanyaan Terbaru
                                    </span>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar bg-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 40px; height: 40px;">
                                        <span class="text-white fw-bold">
                                            {{ substr($tanya->user->name ?? 'U', 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">{{ $tanya->user->name ?? 'User' }}</h6>
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i>{{ $tanya->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>

                                @auth
                                    @if ($tanya->user_id == Auth::id())
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary border-0 dropdown-toggle"
                                                type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <form action="{{ route('tanyas.destroy', $tanya->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')">
                                                            <i class="bi bi-trash me-2"></i>Hapus Pertanyaan
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                @endauth
                            </div>

                            <div class="question-content mb-3">
                                <p class="mb-0">{{ $tanya->pertanyaan }}</p>
                            </div>

                            @if ($tanya->resources->count() > 0)
                                <div class="question-images mb-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($tanya->resources as $resource)
                                            <a href="{{ asset('storage/' . $resource->resource) }}"
                                                data-lightbox="question-{{ $tanya->id }}"
                                                class="screenshot-thumbnail">
                                                <img src="{{ asset('storage/' . $resource->resource) }}"
                                                    alt="Screenshot" class="img-thumbnail rounded">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @auth
                                <div class="answer-form mt-4">
                                    <form action="{{ route('jawabs.store') }}" method="POST"
                                        enctype="multipart/form-data" class="bg-light rounded p-3">
                                        @csrf
                                        <input type="hidden" name="tanya_id" value="{{ $tanya->id }}">

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold small">
                                                <i class="bi bi-reply me-1"></i>Jawaban Anda
                                            </label>
                                            <textarea name="jawaban" class="form-control answer-textarea" rows="3"
                                                placeholder="Tulis jawaban Anda untuk membantu..." required></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold">
                                                <i class="bi bi-paperclip me-1"></i>Lampirkan Screenshot (Opsional)
                                            </label>
                                            <input type="file" class="form-control form-control-sm file-input"
                                                name="gambar_jawaban[]" multiple accept="image/*">
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="bi bi-send me-1"></i>Kirim Jawaban
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endauth

                            @if ($tanya->jawabs->count() > 0)
                                <div class="answers-section mt-4">
                                    <h6 class="answers-title mb-3">
                                        <i class="bi bi-chat-text me-2"></i>
                                        {{ $tanya->jawabs->count() }} Jawaban
                                    </h6>

                                    <div class="answers-list">
                                        @foreach ($tanya->jawabs as $jawab)
                                            <div class="answer-card card border-0 bg-light mb-3">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <div class="d-flex align-items-center">
                                                            <div class="user-avatar bg-success rounded-circle d-flex align-items-center justify-content-center me-2"
                                                                style="width: 32px; height: 32px;">
                                                                <span class="text-white fw-bold small">
                                                                    {{ substr($jawab->user->name ?? 'U', 0, 1) }}
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0 small fw-semibold">
                                                                    {{ $jawab->user->name ?? 'User' }}</h6>
                                                                <small class="text-muted">
                                                                    <i
                                                                        class="bi bi-clock me-1"></i>{{ $jawab->created_at->diffForHumans() }}
                                                                </small>
                                                            </div>
                                                        </div>

                                                        @auth
                                                            @if ($jawab->user_id == Auth::id())
                                                                <form action="{{ route('jawabs.destroy', $jawab->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-outline-danger border-0"
                                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus jawaban ini?')">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        @endauth
                                                    </div>

                                                    <div class="answer-content">
                                                        <p class="mb-2 small">{{ $jawab->jawaban }}</p>
                                                    </div>

                                                    @if ($jawab->resources->count() > 0)
                                                        <div class="answer-images mt-2">
                                                            <div class="d-flex flex-wrap gap-2">
                                                                @foreach ($jawab->resources as $resource)
                                                                    <a href="{{ asset('storage/' . $resource->resource) }}"
                                                                        data-lightbox="answer-{{ $jawab->id }}"
                                                                        class="screenshot-thumbnail">
                                                                        <img src="{{ asset('storage/' . $resource->resource) }}"
                                                                            alt="Screenshot Jawaban"
                                                                            class="img-thumbnail rounded"
                                                                            style="max-width: 60px; max-height: 60px;">
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="no-answers text-center text-muted py-3">
                                    <i class="bi bi-chat-dots display-6 mb-2"></i>
                                    <p class="mb-0">Belum ada jawaban. Jadilah yang pertama menjawab!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-state text-center py-5">
                        <i class="bi bi-chat-square-text display-1 text-muted mb-3"></i>
                        <h5 class="text-muted">Belum Ada Diskusi</h5>
                        <p class="text-muted mb-4">Jadilah yang pertama memulai diskusi tentang submodul ini</p>
                        @auth
                            <a href="#askQuestionForm" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Ajukan Pertanyaan Pertama
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Login untuk Bertanya
                            </a>
                        @endauth
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
