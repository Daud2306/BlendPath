{{-- @extends('layout.admin.app')

@section('title', 'Search Results - BlendPath Admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Search Results</h1>

            <form class="d-flex" method="GET" action="{{ route('admin.search') }}">
                <select name="type" class="form-select form-select-sm me-2" style="width: 120px;">
                    <option value="all" {{ $type == 'all' ? 'selected' : '' }}>All</option>
                    <option value="moduls" {{ $type == 'moduls' ? 'selected' : '' }}>Moduls</option>
                    <option value="submoduls" {{ $type == 'submoduls' ? 'selected' : '' }}>Submoduls</option>
                    <option value="users" {{ $type == 'users' ? 'selected' : '' }}>Users</option>
                </select>
                <input name="q" class="form-control form-control-sm me-2" type="search" placeholder="Search..."
                    value="{{ $query }}">
                <button class="btn btn-sm btn-outline-primary" type="submit">
                    <span class="mdi mdi-magnify"></span>
                </button>
            </form>
        </div>

        <div class="text-muted mb-4">Keyword: "{{ $query }}" | Category: {{ ucfirst($type) }}</div>

        @if ($type == 'all' || $type == 'moduls')
            @if (isset($results['moduls']) && $results['moduls']->count() > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="mdi mdi-map-marker-path me-2"></i>
                            Moduls ({{ $results['moduls']->count() }})
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
                                    @foreach ($results['moduls'] as $modul)
                                        <tr>
                                            <td>{{ $modul->judul }}</td>
                                            <td>{{ Str::limit(strip_tags($modul->deskripsi), 100) }}</td>
                                            <td>
                                                <a href="{{ route('admin.moduls.edit', $modul) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <a href="{{ route('admin.moduls.submoduls.index', $modul) }}"
                                                    class="btn btn-sm btn-info">Submoduls</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @elseif($type == 'moduls')
                <div class="alert alert-info">
                    <i class="mdi mdi-information-outline me-2"></i>
                    Tidak ditemukan modul untuk "{{ $query }}".
                </div>
            @endif
        @endif

        @if ($type == 'all' || $type == 'submoduls')
            @if (isset($results['submoduls']) && $results['submoduls']->count() > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="mdi mdi-book-open-page-variant me-2"></i>
                            Submoduls ({{ $results['submoduls']->count() }})
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Konten</th>
                                        <th>Modul</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($results['submoduls'] as $submodul)
                                        <tr>
                                            <td>{{ $submodul->judul }}</td>
                                            <td>{{ Str::limit(strip_tags($submodul->konten), 100) }}</td>
                                            <td>{{ $submodul->modul->judul ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('admin.moduls.submoduls.edit', [$submodul->modul_id, $submodul]) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @elseif($type == 'submoduls')
                <div class="alert alert-info">
                    <i class="mdi mdi-information-outline me-2"></i>
                    Tidak ditemukan submodul untuk "{{ $query }}".
                </div>
            @endif
        @endif

        @if ($type == 'all' || $type == 'users')
            @if (isset($results['users']) && $results['users']->count() > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="mdi mdi-account-group me-2"></i>
                            Users ({{ $results['users']->count() }})
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
                                    @foreach ($results['users'] as $user)
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
            @elseif($type == 'users')
                <div class="alert alert-info">
                    <i class="mdi mdi-information-outline me-2"></i>
                    Tidak ditemukan user untuk "{{ $query }}".
                </div>
            @endif
        @endif

        @if (
            $type == 'all' &&
                (!isset($results['moduls']) || $results['moduls']->count() == 0) &&
                (!isset($results['submoduls']) || $results['submoduls']->count() == 0) &&
                (!isset($results['users']) || $results['users']->count() == 0))
            <div class="alert alert-info">
                <i class="mdi mdi-information-outline me-2"></i>
                Tidak ditemukan hasil untuk "{{ $query }}".
            </div>
        @endif
    </div>
@endsection --}}
