<div class="modal fade" id="projectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-project-diagram me-2" style="color:var(--success,#28a745);"></i>
                    Tambah Mini Project
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Judul <span class="text-danger">*</span>
                    </label>
                    <input type="text" id="projectJudulInput" class="form-control"
                           placeholder="Contoh: Modeling Karakter Sederhana">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi / Instruksi</label>
                    <textarea id="projectDeskInput" class="form-control" rows="4"
                              placeholder="Jelaskan langkah-langkah dan tujuan mini project..."></textarea>
                </div>

                <div>
                    <label class="form-label fw-semibold">
                        Kriteria Penilaian
                        <span class="text-muted" style="font-weight:400;">(opsional)</span>
                    </label>
                    <textarea id="projectCriteriaInput" class="form-control" rows="2"
                              placeholder="Contoh: Objek harus memiliki minimal 500 vertex, render dengan HDRI..."></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-admin secondary" data-bs-dismiss="modal">
                    Batal
                </button>
                <button type="button" class="btn-admin primary" id="saveProjectBtn">
                    Simpan Project
                </button>
            </div>

        </div>
    </div>
</div>
