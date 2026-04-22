<div class="discuss-section" id="discuss-section">

    {{-- Header --}}
    <div class="discuss-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1">
                    <i class="bi bi-chat-right-text me-2"></i>Diskusi & Tanya Jawab
                </h5>
                <p class="discuss-subtitle mb-0">Berbagi pengetahuan dan solusi tentang materi ini</p>
            </div>
            <div class="badge bg-light text-dark">
                <i class="bi bi-question-circle me-1"></i>
                {{ $submodul->tanya->count() }} Pertanyaan
            </div>
        </div>
    </div>

    {{-- Form tanya (hanya untuk user login) --}}
    @auth
        <div class="ask-question-card mb-4" id="askQuestionForm">
            <div class="question-form">
                <h6 class="mb-3 fw-semibold">
                    <i class="bi bi-pencil-square me-2 text-primary"></i>Ajukan Pertanyaan
                </h6>

                <form action="{{ route('learn.tanyas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="submodul_id" value="{{ $submodul->id }}">

                    <div class="mb-3">
                        <label class="form-label">Pertanyaan Anda <span class="text-danger">*</span></label>
                        <textarea name="pertanyaan" class="form-control" placeholder="Tulis pertanyaan Anda di sini..." rows="4" required>{{ old('pertanyaan') }}</textarea>
                        @error('pertanyaan')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Lampiran gambar --}}
                    <div class="mb-3">
                        <label class="form-label">Lampiran Gambar <span class="text-muted small">(opsional, maks 5
                                file)</span></label>
                        <input type="file" class="form-control" name="gambar[]" multiple
                            accept="image/jpeg,image/png,image/gif,image/webp">
                        <div class="form-text">Format: JPG, PNG, GIF, WebP — Maks 2MB per file</div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i>Kirim Pertanyaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-light border mb-4">
            <div class="d-flex align-items-center">
                <i class="bi bi-info-circle text-primary me-3 fs-4"></i>
                <p class="mb-0">
                    Silakan <a href="{{ route('login') }}" class="text-primary fw-semibold">login</a>
                    untuk mengajukan pertanyaan atau berpartisipasi dalam diskusi.
                </p>
            </div>
        </div>
    @endauth

    {{-- Daftar pertanyaan --}}
    <div class="questions-list">
        @forelse ($submodul->tanya as $tanya)
            <div class="question-item @if ($loop->first && session('success')) new-highlight @endif">

                {{-- Header pertanyaan --}}
                <div class="question-content">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center">
                            <div class="user-avatar-mini me-3">
                                {{ substr($tanya->user->name ?? 'U', 0, 1) }}
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
                                <form action="{{ route('learn.tanyas.destroy', $tanya->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0"
                                        onclick="return confirm('Hapus pertanyaan ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>

                    {{-- Teks pertanyaan — plain text, bukan HTML --}}
                    <div class="question-text" style="white-space:pre-line;">{{ $tanya->pertanyaan }}</div>

                    {{-- Lampiran gambar pada pertanyaan (dengan lightbox) --}}
                    @if ($tanya->resources->count() > 0)
                        <div class="mt-3 d-flex flex-wrap gap-2">
                            @foreach ($tanya->resources as $resource)
                                <img src="{{ $resource->url }}" alt="Lampiran"
                                    class="img-thumbnail rounded img-lightbox"
                                    style="max-height:150px; max-width:100%; cursor:pointer;">
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Form jawaban --}}
                @auth
                    <div class="answer-section mt-3">
                        <form action="{{ route('learn.jawabs.store') }}" method="POST" enctype="multipart/form-data"
                            class="mb-3">
                            @csrf
                            <input type="hidden" name="tanya_id" value="{{ $tanya->id }}">

                            <div class="mb-2">
                                <textarea name="jawaban" class="form-control form-control-sm" placeholder="Tulis jawaban Anda..." rows="3"
                                    required></textarea>
                            </div>

                            <div class="d-flex justify-content-between align-items-center gap-2">
                                <input type="file" class="form-control form-control-sm" name="gambar_jawaban[]" multiple
                                    accept="image/jpeg,image/png,image/gif,image/webp" style="max-width:220px;">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="bi bi-send me-1"></i>Kirim Jawaban
                                </button>
                            </div>
                        </form>
                    </div>
                @endauth

                {{-- Daftar jawaban --}}
                @if ($tanya->jawabs->count() > 0)
                    <div class="answers-list px-3 pb-3">
                        <h6 class="small fw-semibold mb-3 text-muted">
                            <i class="bi bi-chat-left-text me-2"></i>
                            {{ $tanya->jawabs->count() }} Jawaban
                        </h6>

                        @foreach ($tanya->jawabs as $jawab)
                            <div class="answer-item">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar-mini me-2 bg-success">
                                            {{ substr($jawab->user->name ?? 'U', 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 small fw-semibold">{{ $jawab->user->name ?? 'User' }}</h6>
                                            <small class="text-muted">{{ $jawab->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>

                                    @auth
                                        @if ($jawab->user_id == Auth::id())
                                            <form action="{{ route('learn.jawabs.destroy', $jawab->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger border-0"
                                                    onclick="return confirm('Hapus jawaban ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>

                                <div class="answer-text" style="white-space:pre-line;">{{ $jawab->jawaban }}</div>

                                {{-- Lampiran gambar pada jawaban (dengan lightbox) --}}
                                @if ($jawab->resources->count() > 0)
                                    <div class="mt-2 d-flex flex-wrap gap-1">
                                        @foreach ($jawab->resources as $resource)
                                            <img src="{{ $resource->url }}" alt="Lampiran"
                                                class="img-thumbnail rounded img-lightbox"
                                                style="max-height:100px; max-width:100%; cursor:pointer;">
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-chat-square empty-state-icon"></i>
                <h5 class="mb-2">Belum Ada Diskusi</h5>
                <p class="text-muted mb-3">Mulailah diskusi pertama tentang materi ini</p>
                @auth
                    <a href="#askQuestionForm" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-2"></i>Ajukan Pertanyaan Pertama
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login untuk Bertanya
                    </a>
                @endauth
            </div>
        @endforelse
    </div>

</div>
