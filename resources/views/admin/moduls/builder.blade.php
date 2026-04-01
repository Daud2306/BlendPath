@extends('layout.admin.app')

@section('title', 'Course Builder')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admins/css/builder.css') }}">
@endpush

@section('content')

    {{-- Page header: judul + tombol Simpan Urutan + Modul Baru --}}
    @include('admin.moduls.builder._header')

    {{-- Struktur kursus --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <span class="admin-card-title">
                <i class="fas fa-cubes me-2" style="color:var(--accent);"></i>Struktur Kursus
            </span>
            <span class="text-muted small">
                Seret <i class="fas fa-grip-vertical"></i> untuk mengubah urutan
            </span>
        </div>
        <div class="admin-card-body">
            <div id="modulesContainer"></div>

            @if (count($modulesData) === 0)
                <div class="empty-builder">
                    <i class="fas fa-cubes"></i>
                    <p style="font-size:0.95rem;margin-bottom:0.5rem;">Belum ada modul.</p>
                    <a href="{{ route('admin.moduls.create') }}" class="btn-admin primary mt-2">
                        <i class="fas fa-plus"></i> Buat Modul Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Modal: tambah mini project --}}
    @include('admin.moduls.builder._modal-project')

@endsection

@push('scripts')
    {{-- SortableJS --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    {{--
        Inject data PHP → JS via window.builderConfig.
        builder.js membaca objek ini — tidak ada Blade syntax di dalam file .js.
    --}}
    <script>
        window.builderConfig = {
            modulesData: @json($modulesData),
            csrfToken: document.querySelector('meta[name="csrf-token"]').content,
            routes: {
                reorder:        '{{ route('admin.course.builder.reorder') }}',
                storeProject:   '{{ route('admin.course.builder.project.store') }}',
                destroySubmodul:'{{ route('admin.course.builder.submodul.destroy', ':id') }}',
                destroyQuiz:    '{{ route('admin.course.builder.quiz.destroy', ':id') }}',
                destroyProject: '{{ route('admin.course.builder.project.destroy', ':id') }}',
            },
        };
    </script>

    {{-- Semua logika builder ada di sini --}}
    <script src="{{ asset('admins/js/builder.js') }}"></script>
@endpush
