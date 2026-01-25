<div class="container py-4">
    
    <div class="text-center mb-4">
        <h1 class="display-5 fw-bold">{{ $submodul->judul }}</h1>
        <p class="lead text-muted">Dari modul: <strong>{{ $submodul->modul->judul }}</strong></p>
    </div>

    @if ($submodul->resources->isNotEmpty())
        <div class="bg-white p-4 rounded shadow-sm mb-4">
            <h4 class="mb-3">Media Pendukung</h4>

            @foreach ($submodul->resources as $resource)
                @php
                    $url = $resource->resource;
                    $isExternal = Str::startsWith($url, ['http://', 'https://']);
                    $fullUrl = $isExternal ? $url : asset('storage/' . $url);
                @endphp

                @if (Str::contains($url, ['youtube.com', 'youtu.be']))
                   
                    <div class="ratio ratio-16x9 mb-3">
                        <iframe src="{{ str_replace(['watch?v=', 'v/'], 'embed/', $url) }}" title="YouTube video"
                            allowfullscreen>
                        </iframe>
                    </div>
                @elseif(Str::endsWith($url, ['.jpg', '.jpeg', '.png', '.gif']))

                    <img src="{{ $fullUrl }}" alt="Media submodul" class="img-fluid rounded mb-3">
                @else
                    <a href="{{ $fullUrl }}" target="_blank"
                        class="btn btn-outline-secondary btn-sm mb-2 d-inline-block">
                        🔗 {{ Str::limit($url, 40) }}
                    </a>
                @endif
            @endforeach
        </div>
    @endif

    <div class="bg-white p-4 rounded shadow-sm">
        <h3 class="mb-4">Penjelasan & Langkah-Langkah</h3>
        <div class="fs-5">
            {!! nl2br(e($submodul->konten)) !!}
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        @if ($prevSubmodul)
            <a href="{{ route('moduls.submoduls.show', [$prevSubmodul->modul, $prevSubmodul]) }}"
                class="btn btn-outline-secondary">
                ← Sebelumnya
            </a>
        @else
            <span class="btn btn-outline-secondary disabled">← Sebelumnya</span>
        @endif

        @if ($nextSubmodul)
            <a href="{{ route('moduls.submoduls.show', [$nextSubmodul->modul, $nextSubmodul]) }}"
                class="btn btn-primary">
                Selanjutnya →
            </a>
        @else
            <span class="btn btn-primary disabled">Selanjutnya →</span>
        @endif
    </div>
</div>
