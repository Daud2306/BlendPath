@extends('layout.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Buat Quiz Baru</h2>

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Informasi Quiz</h5>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ route('admin.moduls.submoduls.quizzes.store', ['modul' => $modul, 'submodul' => $submodul]) }}"
                            method="POST">
                            @csrf

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="judul_quiz" class="form-label">Judul Quiz <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="judul_quiz" name="judul_quiz" required
                                        placeholder="Masukkan judul quiz">
                                </div>
                                <div class="col-md-3">
                                    <label for="urutan" class="form-label">Urutan <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="urutan" name="urutan" min="1"
                                        required placeholder="1">
                                </div>
                                <div class="col-md-3">
                                    <label for="passing_score" class="form-label">Passing Score (%) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="passing_score" name="passing_score"
                                        min="0" max="100" required placeholder="70">
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
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i>Simpan Quiz
                                </button>
                            </div>
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
            let questionCount = 0;

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
                updateEmptyState();
            };

            window.removeQuestion = function(questionId) {
                const questionElement = document.getElementById(questionId);
                if (questionElement && container.children.length > 1) {
                    questionElement.remove();
                    updateQuestionNumbers();
                    updateEmptyState();
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

            function updateEmptyState() {
                const isEmpty = container.children.length === 0;
                if (isEmpty) {
                    container.innerHTML = `
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-question-circle fa-2x mb-2"></i>
                    <p>Belum ada pertanyaan. Klik "Tambah Pertanyaan" untuk menambahkan.</p>
                </div>
            `;
                }
            }

            document.getElementById('tambah-pertanyaan').addEventListener('click', addQuestion);

            addQuestion();
        });
    </script>

    <style>
        .question-item {
            border-left: 4px solid #007bff;
            transition: all 0.3s ease;
        }

        .question-item:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background-color: #f8f9fa !important;
        }

        .input-group-text {
            font-weight: bold;
            min-width: 40px;
            justify-content: center;
        }
    </style>
@endpush
