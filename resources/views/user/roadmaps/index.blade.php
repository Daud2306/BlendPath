@extends('layout.frontend.app')

@section('title', 'Roadmaps - Demo')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Roadmaps</h1>

        @if ($roadmaps->count() === 0)
            <div class="alert alert-info">Belum ada roadmap tersedia.</div>
        @endif

        <div class="row g-4">
            @foreach ($roadmaps as $roadmap)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        @if ($roadmap->gambar)
                            <img src="{{ asset('storage/' . $roadmap->gambar) }}" class="card-img-top"
                                alt="{{ $roadmap->judul }}" style="height:200px; object-fit:cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                                <span class="text-muted">Tidak ada gambar</span>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-1">{{ $roadmap->judul }}</h5>
                            <small class="text-muted mb-2">Urutan: {{ $roadmap->sort_order }}</small>

                            <p class="card-text mb-3" style="flex:1;">
                                {!! \Illuminate\Support\Str::limit(strip_tags($roadmap->deskripsi), 20) !!}
                            </p>

                            <div class="mt-auto">
                                <a href="{{ route('roadmaps.show', $roadmap) }}" class="btn btn-primary btn-sm">Lihat
                                    Roadmap</a>
                            </div>
                        </div>

                        <div class="card-footer text-muted small">
                            Dibuat: {{ $roadmap->created_at ? $roadmap->created_at->format('d M Y') : '-' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $roadmaps->links() }}
        </div>
    </div>
@endsection
