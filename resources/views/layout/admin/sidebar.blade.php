<aside id="adminSidebar">

    {{-- Brand --}}
    <div class="sidebar-brand">
        <a href="/" class="sidebar-brand-logo-full">
            <img src="{{ asset('frontend/img/logo.png') }}" alt="BlendPath"
                style="height:32px;width:auto;object-fit:contain">
        </a>
        <a href="/" class="sidebar-brand-logo-mini" style="display:none">
            <img src="{{ asset('admins/images/logo-mini.png') }}" alt="logo"
                style="height:32px;width:auto;object-fit:contain">
        </a>
    </div>

    <nav class="sidebar-nav">

        <div class="sidebar-section-label">Utama</div>

        <a href="{{ route('admin.dashboard') }}"
            class="sidebar-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i> Dashboard
        </a>

        <a href="{{ route('admin.monitoring.index') }}"
            class="sidebar-nav-item {{ request()->routeIs('admin.monitoring.*') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> Monitoring
        </a>

        <div class="sidebar-section-label">Konten</div>

        <a href="{{ route('admin.course.builder') }}"
            class="sidebar-nav-item {{
                request()->routeIs('admin.course.*') || request()->routeIs('admin.moduls.*')
                    ? 'active' : ''
            }}">
            <i class="fas fa-cubes"></i> Course Builder
        </a>

        <div class="sidebar-section-label">Komunitas</div>

        <a href="{{ route('admin.showcase.index') }}"
            class="sidebar-nav-item {{ request()->routeIs('admin.showcase.*') ? 'active' : '' }}">
            <i class="fas fa-images"></i> Showcase
        </a>

        <a href="{{ route('admin.diskusi.index') }}"
            class="sidebar-nav-item {{ request()->routeIs('admin.diskusi.*') ? 'active' : '' }}">
            <i class="fas fa-comment-dots"></i> Diskusi
        </a>

        <div class="sidebar-section-label">Pengguna</div>

        <a href="{{ route('admin.users.index') }}"
            class="sidebar-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Pengguna
        </a>

        <div class="sidebar-section-label">Sistem</div>

        <a href="{{ route('admin.search') }}"
            class="sidebar-nav-item {{ request()->routeIs('admin.search') ? 'active' : '' }}">
            <i class="fas fa-search"></i> Pencarian
        </a>

    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ Auth::user()->name ?? 'Admin' }}</div>
                <div class="sidebar-user-role">Administrator</div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="ms-auto">
                @csrf
                <button type="submit" title="Keluar"
                    style="background:none;border:none;padding:4px 6px;border-radius:6px;color:var(--text-muted);font-size:13px;cursor:pointer;transition:color .18s ease"
                    onmouseover="this.style.color='var(--danger)'" onmouseout="this.style.color='var(--text-muted)'">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </div>

</aside>

<div id="sidebarOverlay"></div>
