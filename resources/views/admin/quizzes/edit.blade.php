@extends('layout.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Edit Quiz</h2>

                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Edit Informasi Quiz</h5>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ route('admin.moduls.submoduls.quizzes.update', ['modul' => $modul, 'submodul' => $submodul, 'quiz' => $quiz]) }}"
                            method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="judul_quiz" class="form-label">Judul Quiz <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="judul_quiz" name="judul_quiz"
                                        value="{{ old('judul_quiz', $quiz->judul_quiz) }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="urutan" class="form-label">Urutan <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="urutan" name="urutan"
                                        value="{{ old('urutan', $quiz->urutan) }}" min="1" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="passing_score" class="form-label">Passing Score (%) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="passing_score" name="passing_score"
                                        value="{{ old('passing_score', $quiz->passing_score) }}" min="0"
                                        max="100" required>
                                    <div class="form-text">Nilai minimal untuk lulus</div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Daftar Pertanyaan</h5>
                                <button type="button" id="tambah-pertanyaan" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-plus me-1"></i>Tambah Pertanyaan
                                </button>
                            </div>

                            <div id="pertanyaan-container" class="mb-4">
                                @foreach ($quiz->pertanyaan as $index => $pertanyaan)
                                    <div class="card mb-4 question-item" id="question-{{ $index + 1 }}">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">Pertanyaan #{{ $index + 1 }}</h6>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="removeQuestion('question-{{ $index + 1 }}')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label class="form-label">Pertanyaan <span
                                                            class="text-danger">*</span></label>
                                                    <textarea class="form-control" name="pertanyaan[]" rows="3" required>{{ old('pertanyaan.' . $index, $pertanyaan->pertanyaan) }}</textarea>
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <label class="form-label mb-2">Pilihan Jawaban <span
                                                            class="text-danger">*</span></label>

                                                    <div class="row">
                                                        <div class="col-md-6 mb-2">
                                                            <div class="input-group">
                                                                <span
                                                                    class="input-group-text bg-primary text-white">A</span>
                                                                <input type="text" class="form-control"
                                                                    name="pilihan_a[]"
                                                                    value="{{ old('pilihan_a.' . $index, $pertanyaan->pilihan_jawaban['A'] ?? '') }}"
                                                                    placeholder="Pilihan A" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <div class="input-group">
                                                                <span
                                                                    class="input-group-text bg-primary text-white">B</span>
                                                                <input type="text" class="form-control"
                                                                    name="pilihan_b[]"
                                                                    value="{{ old('pilihan_b.' . $index, $pertanyaan->pilihan_jawaban['B'] ?? '') }}"
                                                                    placeholder="Pilihan B" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <div class="input-group">
                                                                <span
                                                                    class="input-group-text bg-primary text-white">C</span>
                                                                <input type="text" class="form-control"
                                                                    name="pilihan_c[]"
                                                                    value="{{ old('pilihan_c.' . $index, $pertanyaan->pilihan_jawaban['C'] ?? '') }}"
                                                                    placeholder="Pilihan C" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <div class="input-group">
                                                                <span
                                                                    class="input-group-text bg-primary text-white">D</span>
                                                                <input type="text" class="form-control"
                                                                    name="pilihan_d[]"
                                                                    value="{{ old('pilihan_d.' . $index, $pertanyaan->pilihan_jawaban['D'] ?? '') }}"
                                                                    placeholder="Pilihan D" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 mb-3">
                                                    <label class="form-label">Jawaban Benar <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select" name="jawaban_benar[]" required>
                                                        <option value="">Pilih jawaban benar</option>
                                                        <option value="A"
                                                            {{ old('jawaban_benar.' . $index, $pertanyaan->jawaban_benar) == 'A' ? 'selected' : '' }}>
                                                            Pilihan A</option>
                                                        <option value="B"
                                                            {{ old('jawaban_benar.' . $index, $pertanyaan->jawaban_benar) == 'B' ? 'selected' : '' }}>
                                                            Pilihan B</option>
                                                        <option value="C"
                                                            {{ old('jawaban_benar.' . $index, $pertanyaan->jawaban_benar) == 'C' ? 'selected' : '' }}>
                                                            Pilihan C</option>
                                                        <option value="D"
                                                            {{ old('jawaban_benar.' . $index, $pertanyaan->jawaban_benar) == 'D' ? 'selected' : '' }}>
                                                            Pilihan D</option>
                                                    </select>
                                                    <div class="form-text">Pilih huruf dari jawaban yang benar</div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Poin <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="poin[]"
                                                        value="{{ old('poin.' . $index, $pertanyaan->poin) }}"
                                                        min="1" required>
                                                    <div class="form-text">Nilai untuk jawaban benar</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Tips:</strong> Pastikan untuk memilih jawaban yang benar untuk setiap pertanyaan.
                            </div>

                            <div class="d-flex justify-content-between border-top pt-3">
                                <a href="{{ route('admin.moduls.submoduls.show', ['modul' => $modul, 'submodul' => $submodul]) }}"
                                    class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Kembali
                                </a>
                                <div>
                                    <button type="button" class="btn btn-outline-danger me-2" onclick="confirmDelete()">
                                        <i class="fas fa-trash me-1"></i>Hapus Quiz
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i>Update Quiz
                                    </button>
                                </div>
                            </div>
                        </form>

                        <form id="delete-form"
                            action="{{ route('admin.moduls.submoduls.quizzes.destroy', ['modul' => $modul, 'submodul' => $submodul, 'quiz' => $quiz]) }}"
                            method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('pertanyaan-container');
            let questionCount = {{ $quiz->pertanyaan->count() }};

            function createQuestionElement() {
                questionCount++;
                const questionId = `question-${questionCount}`;

                const questionHTML = `
            <div class="card mb-4 question-item" id="${questionId}">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Pertanyaan #${questionCount}</h6>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeQuestion('${questionId}')">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">Pertanyaan <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="pertanyaan[]" rows="3" placeholder="Tulis pertanyaan di sini..." required></textarea>
                        </div>
                        
                        <!-- Pilihan Jawaban -->
                        <div class="col-12 mb-3">
                            <label class="form-label mb-2">Pilihan Jawaban <span class="text-danger">*</span></label>
                            
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white">A</span>
                                        <input type="text" class="form-control" name="pilihan_a[]" placeholder="Pilihan A" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white">B</span>
                                        <input type="text" class="form-control" name="pilihan_b[]" placeholder="Pilihan B" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white">C</span>
                                        <input type="text" class="form-control" name="pilihan_c[]" placeholder="Pilihan C" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white">D</span>
                                        <input type="text" class="form-control" name="pilihan_d[]" placeholder="Pilihan D" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Jawaban Benar dan Poin -->
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Jawaban Benar <span class="text-danger">*</span></label>
                            <select class="form-select" name="jawaban_benar[]" required>
                                <option value="">Pilih jawaban benar</option>
                                <option value="A">Pilihan A</option>
                                <option value="B">Pilihan B</option>
                                <option value="C">Pilihan C</option>
                                <option value="D">Pilihan D</option>
                            </select>
                            <div class="form-text">Pilih huruf dari jawaban yang benar</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Poin <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="poin[]" value="1" min="1" required>
                            <div class="form-text">Nilai untuk jawaban benar</div>
                        </div>
                    </div>
                </div>
            </div>
        `;

                return questionHTML;
            }

            window.addQuestion = function() {
                container.insertAdjacentHTML('beforeend', createQuestionElement());
            };

            window.removeQuestion = function(questionId) {
                const questionElement = document.getElementById(questionId);
                if (questionElement && container.children.length > 1) {
                    questionElement.remove();
                    updateQuestionNumbers();
                } else if (container.children.length === 1) {
                    alert('Minimal harus ada satu pertanyaan');
                }
            };

            function updateQuestionNumbers() {
                const questions = container.getElementsByClassName('question-item');
                Array.from(questions).forEach((question, index) => {
                    const header = question.querySelector('.card-header h6');
                    header.textContent = `Pertanyaan #${index + 1}`;
                });
                questionCount = questions.length;
            }

            window.confirmDelete = function() {
                if (confirm(
                    'Apakah Anda yakin ingin menghapus quiz ini? Tindakan ini tidak dapat dibatalkan.')) {
                    document.getElementById('delete-form').submit();
                }
            };

            document.getElementById('tambah-pertanyaan').addEventListener('click', addQuestion);
        });
    </script>

    <style>
        .question-item {
            border-left: 4px solid #ffc107;
            transition: all 0.3s ease;
        }

        .question-item:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .input-group-text {
            font-weight: bold;
            min-width: 40px;
            justify-content: center;
        }
    </style>
@endpush
