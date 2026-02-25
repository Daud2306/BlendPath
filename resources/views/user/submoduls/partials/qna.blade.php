{{-- qna.blade.php --}}
<link href="{{ asset('frontend/css/qna.css') }}" rel="stylesheet">

<div class="qna-section" id="qna-section">
    <!-- Header -->
    <div class="qna-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1">
                    <i class="bi bi-chat-right-text me-2"></i>Diskusi & Tanya Jawab
                </h5>
                <p class="qna-subtitle mb-0">Berbagi pengetahuan dan solusi tentang materi ini</p>
            </div>
            <div class="badge bg-light text-dark">
                <i class="bi bi-question-circle me-1"></i>
                {{ $submodul->tanya->count() }} Pertanyaan
            </div>
        </div>
    </div>

    <!-- Ask Question Form -->
    @auth
        <div class="ask-question-card" id="askQuestionForm">
            <div class="question-form">
                <h6 class="mb-3 fw-semibold">
                    <i class="bi bi-pencil-square me-2 text-primary"></i>Ajukan Pertanyaan
                </h6>

                <form id="form-ask-question" action="{{ route('learn.tanyas.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="submodul_id" value="{{ $submodul->id }}">

                    <div class="mb-3">
                        <label class="form-label">Pertanyaan Anda</label>
                        <textarea name="pertanyaan" class="form-control tinymce-question" placeholder="Tulis pertanyaan Anda di sini..."
                            rows="5">{{ old('pertanyaan') }}</textarea>
                        @error('pertanyaan')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lampirkan Gambar (Opsional)</label>
                        <div class="file-upload-wrapper">
                            <input type="file" class="file-upload-input" name="gambar[]" id="questionImages" multiple
                                accept="image/*">
                            <label for="questionImages" class="file-upload-label">
                                <i class="bi bi-paperclip me-2"></i>
                                <span class="file-upload-text">Pilih file gambar</span>
                            </label>
                        </div>
                        <div class="form-text small mt-2">
                            Maksimal 5 file (JPG, PNG, GIF), 2MB per file
                        </div>
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
                <div>
                    <p class="mb-0">Silakan <a href="{{ route('login') }}" class="text-primary fw-semibold">login</a>
                        untuk mengajukan pertanyaan atau berpartisipasi dalam diskusi.</p>
                </div>
            </div>
        </div>
    @endauth

    <!-- Questions List -->
    <div class="questions-list">
        @if ($submodul->tanya->count() > 0)
            @foreach ($submodul->tanya as $tanya)
                <div class="question-item @if ($loop->first && session('success')) new-highlight @endif">
                    <!-- Question Header -->
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
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary border-0" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <form action="{{ route('learn.tanyas.destroy', $tanya->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"
                                                        onclick="return confirm('Hapus pertanyaan ini?')">
                                                        <i class="bi bi-trash me-2"></i>Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            @endauth
                        </div>

                        <div class="question-text">
                            {!! $tanya->pertanyaan !!}
                        </div>

                        @if ($tanya->resources->count() > 0)
                            <div class="mt-3">
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($tanya->resources as $resource)
                                        <a href="{{ asset('storage/' . $resource->resource) }}"
                                            data-lightbox="question-{{ $tanya->id }}">
                                            <img src="{{ asset('storage/' . $resource->resource) }}" alt="Screenshot"
                                                class="img-thumbnail rounded" style="max-height: 80px;">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    @auth
                        <div class="answer-section">
                            <form action="{{ route('learn.jawabs.store') }}" method="POST" enctype="multipart/form-data"
                                class="mb-3">
                                @csrf
                                <input type="hidden" name="tanya_id" value="{{ $tanya->id }}">

                                <div class="mb-3">
                                    <label class="form-label small">Tambahkan Jawaban</label>
                                    <textarea name="jawaban" class="form-control tinymce-answer" placeholder="Tulis jawaban Anda..." rows="3"></textarea>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="file-upload-wrapper" style="max-width: 200px;">
                                        <input type="file" class="file-upload-input" name="gambar_jawaban[]"
                                            id="answerImages-{{ $tanya->id }}" multiple accept="image/*">
                                        <label for="answerImages-{{ $tanya->id }}" class="file-upload-label btn-sm">
                                            <i class="bi bi-image me-1"></i>Gambar
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="bi bi-send me-1"></i>Kirim Jawaban
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endauth

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
                                                <h6 class="mb-0 small fw-semibold">{{ $jawab->user->name ?? 'User' }}
                                                </h6>
                                                <small class="text-muted">
                                                    {{ $jawab->created_at->diffForHumans() }}
                                                </small>
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

                                    <div class="answer-text">
                                        {!! $jawab->jawaban !!}
                                    </div>

                                    @if ($jawab->resources->count() > 0)
                                        <div class="mt-2">
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach ($jawab->resources as $resource)
                                                    <a href="{{ asset('storage/' . $resource->resource) }}"
                                                        data-lightbox="answer-{{ $jawab->id }}">
                                                        <img src="{{ asset('storage/' . $resource->resource) }}"
                                                            alt="Screenshot Jawaban" class="img-thumbnail rounded"
                                                            style="max-height: 60px;">
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        @else
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
        @endif
    </div>
</div>

@push('tinymce-scripts')
    <script src="https://cdn.tiny.cloud/1/it9jtu12pg1wokv2pa9ifoc66gaqghavr7m7k06amjcnf97d/tinymce/8/tinymce.min.js"
        referrerpolicy="origin" crossorigin="anonymous"></script>

    <script>
        tinymce.init({
            selector: '.tinymce-question, .tinymce-answer',
            plugins: 'link lists media code',
            toolbar: 'undo redo | bold italic underline | bullist numlist | link media | code',
            menubar: false,
            branding: false
        });
    </script>

    <script>
        document.getElementById('form-ask-question')
            .addEventListener('submit', function() {
                tinymce.triggerSave();
            });
    </script>
@endpush
