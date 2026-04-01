{{-- ── Navigasi prev / next ── --}}
<div class="navigation-buttons d-flex justify-content-between mt-3 mb-4" data-aos="fade-up">
    @if ($prevSubmodul)
        <a href="{{ route('learn.submoduls.show', ['modul' => $modul->id, 'sort_order' => $prevSubmodul->sort_order]) }}"
            class="btn btn-outline-primary">
            <i class="bi bi-chevron-left me-2"></i>Sebelumnya
        </a>
    @else
        <a href="{{ route('learn.moduls.show', $modul->id) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Modul
        </a>
    @endif

    @if ($nextSubmodul)
        @if ($isNextAccessible)
            <a href="{{ route('learn.submoduls.show', ['modul' => $modul->id, 'sort_order' => $nextSubmodul->sort_order]) }}"
                class="btn btn-primary">
                Selanjutnya <i class="bi bi-chevron-right ms-2"></i>
            </a>
        @else
            <button class="btn btn-secondary" disabled title="Selesaikan submodul ini terlebih dahulu">
                Selanjutnya <i class="bi bi-lock ms-2"></i>
            </button>
        @endif
    @else
        <a href="{{ route('learn.moduls.show', $modul->id) }}" class="btn btn-success">
            <i class="bi bi-check-circle me-2"></i>Selesai Modul
        </a>
    @endif
</div>
