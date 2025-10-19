<nav class="navbar navbar-light bg-light border-bottom fixed-top">
    <div class="container-fluid">
        <input id="nav-toggle" type="checkbox" class="d-lg-none visually-hidden" />
        <label for="nav-toggle" class="d-lg-none mb-0 btn btn-outline-secondary">
            <span class="mdi mdi-menu" aria-hidden="true"></span>
            <span class="visually-hidden">Toggle menu</span>
        </label>

        <div class="d-none d-lg-flex align-items-center ms-auto gap-3">

            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="mdi mdi-menu me-1"></span>Menu
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('admin.roadmaps.index') }}">
                            <span class="mdi mdi-map-marker-path me-2"></span>Roadmaps
                        </a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.roadmaps.tutorials.index', 1) }}">
                            <span class="mdi mdi-book-open-page-variant me-2"></span>Tutorials
                        </a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">
                            <span class="mdi mdi-account-group me-2"></span>Users
                        </a></li>
                </ul>
            </div>

            <form class="d-flex" method="GET" action="{{ route('admin.search') }}">
                <select name="type" class="form-select form-select-sm me-2" style="width: 120px;">
                    <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All</option>
                    <option value="roadmaps" {{ request('type') == 'roadmaps' ? 'selected' : '' }}>Roadmaps</option>
                    <option value="tutorials" {{ request('type') == 'tutorials' ? 'selected' : '' }}>Tutorials</option>
                    <option value="users" {{ request('type') == 'users' ? 'selected' : '' }}>Users</option>
                </select>
                <input name="q" class="form-control form-control-sm me-2" type="search" placeholder="Search..."
                    value="{{ request('q') }}">
                <button class="btn btn-sm btn-outline-primary" type="submit" aria-label="Search">
                    <span class="mdi mdi-magnify"></span>
                </button>
            </form>

            <div class="d-flex align-items-center border-start ps-3">
                <div class="me-2 text-end d-none d-md-block">
                    <div class="fw-semibold">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <small class="text-muted">Administrator</small>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Logout">
                        <span class="mdi mdi-logout-variant"></span>
                        <span class="d-none d-md-inline ms-1">Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="mobile-menu d-lg-none">
            <div class="p-3">
                <div class="dropdown mb-3">
                    <button class="btn btn-sm btn-outline-secondary w-100 dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="mdi mdi-menu me-1"></span>Quick Menu
                    </button>
                    <ul class="dropdown-menu w-100">
                        <li><a class="dropdown-item" href="{{ route('admin.roadmaps.index') }}">
                                <span class="mdi mdi-map-marker-path me-2"></span>Roadmaps
                            </a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.roadmaps.tutorials.index', 1) }}">
                                <span class="mdi mdi-book-open-page-variant me-2"></span>Tutorials
                            </a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                <span class="mdi mdi-account-group me-2"></span>Users
                            </a></li>
                    </ul>
                </div>

                <form class="mb-3" method="GET" action="{{ route('admin.search') }}">
                    <div class="input-group">
                        <select name="type" class="form-select form-select-sm">
                            <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All</option>
                            <option value="roadmaps" {{ request('type') == 'roadmaps' ? 'selected' : '' }}>Roadmaps
                            </option>
                            <option value="tutorials" {{ request('type') == 'tutorials' ? 'selected' : '' }}>Tutorials
                            </option>
                            <option value="users" {{ request('type') == 'users' ? 'selected' : '' }}>Users</option>
                        </select>
                        <input type="text" class="form-control form-control-sm" name="q"
                            placeholder="Search..." value="{{ request('q') }}">
                        <button class="btn btn-sm btn-outline-primary" type="submit">
                            <span class="mdi mdi-magnify"></span>
                        </button>
                    </div>
                </form>

                <div class="mt-2">
                    <div class="mb-2">
                        <strong>{{ Auth::user()->name ?? 'Admin' }}</strong><br>
                        <small class="text-muted">Administrator</small>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger w-100">
                            <span class="mdi mdi-logout-variant me-1"></span> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
