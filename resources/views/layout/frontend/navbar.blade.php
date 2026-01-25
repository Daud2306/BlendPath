<div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

    <a href="/" class="logo d-flex align-items-center me-4">
        <img src="{{ asset('frontend/img/logo.png') }}" alt="BlendPath Logo">
    </a>

    <nav id="navmenu" class="navmenu flex-grow-1">
        <ul class="d-flex align-items-center justify-content-end mb-0">
            <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
            <li><a href="/moduls" class="{{ request()->is('moduls*') ? 'active' : '' }}">Learning Path</a></li>
            <li><a href="/about" class="{{ request()->is('about*') ? 'active' : '' }}">Tentang</a></li>

            @guest
                <li><a href="/login" class="ms-3">Login</a></li>
                <li><a href="/register" class="btn btn-primary ms-2">Register</a></li>
            @endguest

            @auth
                @if (Auth::user()->role === 'admin')
                    <li><a href="/admin/dashboard" class="{{ request()->is('admin*') ? 'active' : '' }}">Dashboard</a></li>
                @endif

                <li class="dropdown ms-3">
                    <a href="#" class="d-flex align-items-center">
                        <span>{{ Auth::user()->name }}</span>
                        <i class="bi bi-chevron-down ms-1"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item"
                                    style="border: none; background: none; width: 100%; text-align: left;">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            @endauth
        </ul>
    </nav>

    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</div>
