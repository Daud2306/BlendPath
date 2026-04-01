{{-- ── Progress (tandai selesai / belum) ── --}}
@auth
    <div class="progress-card card mb-4" data-aos="fade-up">
        <div class="card-body">
            <h5 class="card-title">
                <i class="bi bi-graph-up me-2"></i>Progress Belajar
            </h5>

            @if ($submodul->isCompletedByUser())
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Anda sudah menyelesaikan submodul ini!
                </div>
                <form
                    action="{{ route('learn.submoduls.incomplete', ['modul' => $modul->id, 'sort_order' => $submodul->sort_order]) }}"
                    method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-warning">
                        <i class="bi bi-arrow-repeat me-2"></i>Tandai Belum Selesai
                    </button>
                </form>
            @else
                <div class="alert alert-info">
                    <i class="bi bi-clock me-2"></i>Submodul ini belum diselesaikan
                </div>
                <form
                    action="{{ route('learn.submoduls.complete', ['modul' => $modul->id, 'sort_order' => $submodul->sort_order]) }}"
                    method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-2"></i>Tandai Sudah Selesai
                    </button>
                </form>
            @endif
        </div>
    </div>
@else
    <div class="alert alert-info mb-4" data-aos="fade-up">
        <i class="bi bi-info-circle me-2"></i>
        <a href="{{ route('login') }}" class="alert-link">Login</a> untuk menandai progress belajar Anda.
    </div>
@endauth
