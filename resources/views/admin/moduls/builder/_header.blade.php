<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title">Course Builder</h1>
        <p class="page-subtitle">Atur struktur kursus, urutan, quiz, dan mini project</p>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <span id="unsavedBadge">
            <i class="fas fa-circle" style="font-size:0.5rem;"></i>
            Perubahan belum disimpan
        </span>
        {{-- <button type="button" id="saveOrderBtn" class="btn-admin primary">
            <i class="fas fa-save"></i> Simpan Urutan
        </button> --}}
        <a href="{{ route('admin.moduls.create') }}" class="btn-admin secondary">
            <i class="fas fa-plus"></i> Modul Baru
        </a>
    </div>
</div>
