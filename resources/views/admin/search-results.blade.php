@extends('layout.admin.app')

@section('title', 'Search Results - BlendPath Admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Search Results</h1>
            <div class="text-muted">Keyword: "{{ $query }}"</div>
        </div>

        @if ($roadmaps->isEmpty() && $tutorials->isEmpty() && $users->isEmpty())
            <div class="alert alert-info">
                <i class="mdi mdi-information-outline me-2"></i>
                Tidak ditemukan hasil untuk "{{ $query }}".
            </div>
        @endif

        @if (!$roadmaps->isEmpty())
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="mdi mdi-map-marker-path me-2"></i>
                        Roadmaps ({{ $roadmaps->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roadmaps as $roadmap)
                                    <tr>
                                        <td>{{ $roadmap->judul }}</td>
                                        <td>{{ Str::limit(strip_tags($roadmap->deskripsi), 100) }}</td>
                                        <td>
                                            <a href="{{ route('admin.roadmaps.edit', $roadmap) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <a href="{{ route('admin.roadmaps.tutorials.index', $roadmap) }}"
                                                class="btn btn-sm btn-info">Tutorials</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        @if (!$tutorials->isEmpty())
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="mdi mdi-book-open-page-variant me-2"></i>
                        Tutorials ({{ $tutorials->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Konten</th>
                                    <th>Roadmap</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tutorials as $tutorial)
                                    <tr>
                                        <td>{{ $tutorial->judul }}</td>
                                        <td>{{ Str::limit(strip_tags($tutorial->konten), 100) }}</td>
                                        <td>{{ $tutorial->roadmap->judul ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('admin.roadmaps.tutorials.edit', [$tutorial->roadmap_id, $tutorial]) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        @if (!$users->isEmpty())
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="mdi mdi-account-group me-2"></i>
                        Users ({{ $users->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        {{-- @if (!$questions->isEmpty())
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="mdi mdi-forum me-2"></i>
                        Questions ({{ $questions->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Pertanyaan</th>
                                    <th>User</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $question)
                                    <tr>
                                        <td>{{ Str::limit($question->pertanyaan, 150) }}</td>
                                        <td>{{ $question->user->name ?? 'Unknown' }}</td>
                                        <td>
                                            <form action="{{ route('admin.tanyas.destroy', $question) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Hapus pertanyaan ini?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif --}}
    </div>
@endsection
