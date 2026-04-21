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
                            action="{{ route('admin.moduls.submoduls.quiz.store', ['modul' => $modul, 'submodul' => $submodul]) }}"
                            method="POST" enctype="multipart/form-data" id="quizForm">
                            @csrf

                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="judul_quiz" class="form-label">Judul Quiz <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="judul_quiz" name="judul_quiz" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="passing_score" class="form-label">Passing Score (%) <span
                                            class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="passing_score" name="passing_score"
                                            value="70" min="0" max="100" required>
                                            <div class="form-text">Nilai minimal untuk lulus</div>
                                        </div>
                                        <!-- sort_order tidak ada di form -->
                                    </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Daftar Pertanyaan</h5>
                                <button type="button" id="tambah-pertanyaan" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-plus me-1"></i>Tambah Pertanyaan
                                </button>
                            </div>

                            <div id="pertanyaan-container" class="mb-4"></div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Tips:</strong> Klik pada pilihan A, B, C, atau D untuk menandai jawaban benar.
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

    <!-- Modal preview gambar -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Preview" style="max-width:100%; max-height:80vh;">
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
                return `
            <div class="card mb-4 question-item" id="${questionId}">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Pertanyaan #${questionCount}</h6>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeQuestion('${questionId}')">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Gambar -->
                        <div class="col-12 mb-3">
                            <label class="form-label">Gambar Soal (opsional)</label>
                            <input type="file" class="form-control gambar-input" name="gambar[]" accept="image/*">
                            <div class="gambar-preview mt-2" style="display: none;">
                                <img src="" style="max-width:150px; max-height:150px; cursor:pointer;" class="img-thumbnail preview-img">
                                <button type="button" class="btn btn-sm btn-outline-danger mt-1 btn-hapus-preview">Hapus</button>
                            </div>
                        </div>
                        <!-- Pertanyaan -->
                        <div class="col-12 mb-3">
                            <label class="form-label">Pertanyaan <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="pertanyaan[]" rows="3" required></textarea>
                        </div>
                        <!-- Pilihan Jawaban (klik untuk memilih jawaban benar) -->
                        <div class="col-12 mb-3">
                            <label class="form-label mb-2">Pilihan Jawaban <span class="text-danger">*</span></label>
                            <div class="row" id="pilihan-container-${questionCount}">
                                <div class="col-md-6 mb-2">
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white option-label" data-opt="A">A</span>
                                        <input type="text" class="form-control pilihan-text" name="pilihan_a[]" placeholder="Pilihan A" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white option-label" data-opt="B">B</span>
                                        <input type="text" class="form-control pilihan-text" name="pilihan_b[]" placeholder="Pilihan B" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white option-label" data-opt="C">C</span>
                                        <input type="text" class="form-control pilihan-text" name="pilihan_c[]" placeholder="Pilihan C" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white option-label" data-opt="D">D</span>
                                        <input type="text" class="form-control pilihan-text" name="pilihan_d[]" placeholder="Pilihan D" required>
                                    </div>
                                </div>
                            </div>
                            <!-- Hidden input untuk jawaban benar -->
                            <input type="hidden" name="jawaban_benar[]" class="jawaban-benar-input" value="">
                            <div class="mt-2">
                                <small class="text-muted">Klik pada huruf A/B/C/D untuk menandai sebagai jawaban benar</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
            }

            // Fungsi untuk attach event klik pada option label
            function attachOptionClick(containerDiv) {
                const labels = containerDiv.querySelectorAll('.option-label');
                labels.forEach(label => {
                    label.removeEventListener('click', handleOptionClick);
                    label.addEventListener('click', handleOptionClick);
                });
            }

            function handleOptionClick(e) {
                const label = e.currentTarget;
                const opt = label.getAttribute('data-opt');
                const cardBody = label.closest('.card-body');
                const hiddenInput = cardBody.querySelector('.jawaban-benar-input');
                hiddenInput.value = opt;

                // Reset highlight semua option di card ini
                const allLabels = cardBody.querySelectorAll('.option-label');
                allLabels.forEach(lbl => {
                    lbl.classList.remove('bg-success', 'text-white');
                    lbl.classList.add('bg-primary', 'text-white');
                });
                // Highlight yang dipilih
                label.classList.remove('bg-primary');
                label.classList.add('bg-success', 'text-white');
            }

            // Preview gambar (sama seperti sebelumnya)
            function initPreview() {
                container.addEventListener('change', function(e) {
                    const target = e.target;
                    if (target && target.classList.contains('gambar-input')) {
                        const input = target;
                        const previewDiv = input.parentElement.querySelector('.gambar-preview');
                        const img = previewDiv.querySelector('img');
                        if (input.files && input.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                img.src = e.target.result;
                                previewDiv.style.display = 'block';
                            };
                            reader.readAsDataURL(input.files[0]);
                        } else {
                            img.src = '';
                            previewDiv.style.display = 'none';
                        }
                    }
                });

                container.addEventListener('click', function(e) {
                    const target = e.target;
                    if (target && target.classList.contains('btn-hapus-preview')) {
                        const previewDiv = target.closest('.gambar-preview');
                        const input = previewDiv.parentElement.querySelector('.gambar-input');
                        input.value = '';
                        const img = previewDiv.querySelector('img');
                        img.src = '';
                        previewDiv.style.display = 'none';
                    }
                    if (target && target.classList.contains('preview-img') && target.src) {
                        const modalImg = document.getElementById('modalImage');
                        modalImg.src = target.src;
                        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
                        modal.show();
                    }
                });
            }

            window.addQuestion = function() {
                const html = createQuestionElement();
                container.insertAdjacentHTML('beforeend', html);
                const newCard = container.lastElementChild;
                const pilihanContainer = newCard.querySelector('[id^="pilihan-container-"]');
                attachOptionClick(pilihanContainer);
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
                const questions = container.querySelectorAll('.question-item');
                Array.from(questions).forEach((question, index) => {
                    const header = question.querySelector('.card-header h6');
                    if (header) header.textContent = `Pertanyaan #${index + 1}`;
                });
                questionCount = questions.length;
            }

            function updateEmptyState() {
                const isEmpty = container.children.length === 0;
                if (isEmpty) {
                    container.innerHTML = `<div class="text-center py-4 text-muted" id="empty-placeholder">
                <i class="fas fa-question-circle fa-2x mb-2"></i>
                <p>Belum ada pertanyaan. Klik "Tambah Pertanyaan" untuk menambahkan.</p>
            </div>`;
                } else {
                    const placeholder = document.getElementById('empty-placeholder');
                    if (placeholder) placeholder.remove();
                }
            }

            initPreview();
            document.getElementById('tambah-pertanyaan').addEventListener('click', addQuestion);
            addQuestion(); // buat satu pertanyaan awal
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

        .option-label {
            cursor: pointer;
            transition: all 0.2s;
            user-select: none;
        }

        .option-label:hover {
            filter: brightness(0.9);
        }

        .input-group-text {
            font-weight: bold;
            min-width: 40px;
            justify-content: center;
        }
    </style>
@endpush
