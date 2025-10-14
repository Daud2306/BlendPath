<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="sidebar-brand brand-logo" href="/"><img src="{{ asset('frontend/img/logo.png') }}"
                alt="logo" /></a>
        <a class="sidebar-brand brand-logo-mini" href="/"><img src="{{ asset('admins/images/logo-mini.png') }}"
                alt="logo" /></a>
    </div>
    <ul class="nav">
        <li class="nav-item profile">
        </li>
        <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
        </li>
        <li class="nav-item menu-items">
            <a href="/admin/dashboard" class="nav-link">
                <span class="menu-icon">
                    <i class="mdi mdi-speedometer"></i>
                </span>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a href="/admin/roadmaps" class="nav-link">
                <span class="menu-icon">
                    <i class="mdi mdi-map-marker-path"></i>
                </span>
                <span class="menu-title">Roadmap</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.users.index') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-account-multiple"></i>
                </span>
                <span class="menu-title">Manajemen Pengguna</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.monitoring.index') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-chart-bar"></i>
                </span>
                <span class="menu-title">Monitoring Progress</span>
            </a>
        </li>
    </ul>
</nav>