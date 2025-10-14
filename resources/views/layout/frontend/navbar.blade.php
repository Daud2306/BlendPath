<nav id="navmenu" class="navmenu">
    <ul>
        <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
        <li><a href="/roadmaps" class="{{ request()->is('roadmaps*') ? 'active' : '' }}">Roadmap</a></li>
        <li><a href="/about" class="{{ request()->is('about*') ? 'active' : '' }}">Tentang</a></li>

        @guest
            <li><a href="/login">Login</a></li>
            <li><a href="/register" class="btn btn-primary">Register</a></li>
        @endguest

        @auth
            @if (Auth::user()->role === 'admin')
                <li><a href="/admin/dashboard" class="{{ request()->is('admin*') ? 'active' : '' }}">Dashboard</a></li>
            @endif
        @endauth

        @auth
            <li class="dropdown">
                <a href="#">
                    <span>{{ Auth::user()->name }}</span>
                    <i class="bi bi-chevron-down toggle-dropdown"></i>
                </a>
                <ul>
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
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>

<style>
    /* Style untuk logout button di dropdown */
    .dropdown-item {
        padding: 0.5rem 1rem;
        color: #212529;
        text-decoration: none;
        display: block;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #16181b;
    }

    /* Pastikan dropdown terlihat */
    .navmenu .dropdown ul {
        position: absolute;
        background: white;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        z-index: 9999;
    }
</style>
