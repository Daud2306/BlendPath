<nav class="navbar navbar-light bg-light border-bottom fixed-top">
    <div class="container-fluid">
        <input id="nav-toggle" type="checkbox" class="d-lg-none visually-hidden" />
        <label for="nav-toggle" class="d-lg-none mb-0 btn btn-outline-secondary">
            <span class="mdi mdi-menu" aria-hidden="true"></span>
            <span class="visually-hidden">Toggle menu</span>
        </label>


        <div class="d-none d-lg-flex align-items-center ms-auto gap-3">

            <form class="d-flex" method="GET" action="{{ route('admin.search') }}">
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
                <form class="mb-3" method="GET" action="{{ route('admin.search') }}">
                    <div class="input-group">
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
