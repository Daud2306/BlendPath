@extends('layout.admin.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h4 mb-0">Edit Tutorial</h1>
            <a href="{{ route('admin.roadmaps.tutorials.index', $roadmap) }}" class="btn btn-secondary">Back to Tutorials</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success mb-3">{{ session('success') }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <form action="{{ route('admin.roadmaps.tutorials.update', [$roadmap, $tutorial]) }}" method="POST"
                            novalidate>
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Title *</label>
                                <input type="text" name="judul" class="form-control" required
                                    value="{{ old('judul', $tutorial->judul) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Content *</label>
                                <textarea name="konten" class="form-control" rows="12" required>{{ old('konten', $tutorial->konten) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control"
                                    value="{{ old('sort_order', $tutorial->sort_order) }}">
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Update Tutorial</button>
                                <a href="{{ route('admin.roadmaps.tutorials.index', $roadmap) }}"
                                    class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <h6 class="mb-2">Tutorial Info</h6>
                                <div class="small">Roadmap: <strong>{{ $roadmap->judul }}</strong></div>
                                <div class="small">Created: <strong>{{ $tutorial->created_at->format('d M Y') }}</strong>
                                </div>
                                <div class="small">Questions: <strong>{{ $tutorial->tanya->count() }}</strong></div>
                                <div class="small">Resources: <strong>{{ $tutorial->resources->count() }}</strong></div>
                            </div>
                        </div>

                        @if ($tutorial->resources->count() > 0)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="mb-3">Current Resources</h6>

                                    @foreach ($tutorial->resources as $resource)
                                        <div class="mb-3 border rounded p-2">
                                            @php
                                                $isYoutube = Str::contains($resource->resource, [
                                                    'youtube.com',
                                                    'youtu.be',
                                                    'youtube.com/embed',
                                                ]);
                                            @endphp

                                            @if ($isYoutube)
                                                <div class="fw-semibold mb-1">YouTube</div>
                                                <div class="small text-truncate mb-2" style="max-width:100%;">
                                                    <a href="{{ $resource->resource }}" target="_blank"
                                                        rel="noopener noreferrer">
                                                        {{ $resource->resource }}
                                                    </a>
                                                </div>

                                                <form
                                                    action="{{ route('admin.roadmaps.tutorials.resources.store', [$roadmap, $tutorial]) }}"
                                                    method="POST" class="mb-2">
                                                    @csrf
                                                    <input type="hidden" name="resource_id" value="{{ $resource->id }}">
                                                    <label class="form-label visually-hidden"
                                                        for="resource-{{ $resource->id }}">Resource</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="url" id="resource-{{ $resource->id }}"
                                                            name="resource" class="form-control"
                                                            placeholder="https://www.youtube.com/embed/..."
                                                            value="{{ old('resource_' . $resource->id, $resource->resource) }}"
                                                            required>
                                                        <button class="btn btn-sm btn-primary" type="submit">Save</button>
                                                    </div>
                                                </form>
                                            @else
                                                <div class="fw-semibold mb-1">File</div>
                                                <div class="small mb-2">{{ basename($resource->resource) }}</div>
                                            @endif

                                            <form
                                                action="{{ route('admin.roadmaps.tutorials.resources.destroy', [$roadmap, $tutorial, $resource]) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex">
            <div class="ms-auto">
                <form action="{{ route('admin.roadmaps.tutorials.destroy', [$roadmap, $tutorial]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">Delete Tutorial</button>
                </form>
            </div>
        </div>
    </div>
@endsection
