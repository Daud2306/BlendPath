<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BlendPath Admin — @yield('title', 'Dashboard')</title>

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    {{-- Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Admin CSS --}}
    <link rel="stylesheet" href="{{ asset('admins/css/main.css') }}">

    {{-- Page-specific styles --}}
    @stack('styles')
</head>

<body>
<div class="container-scroller">

    {{-- Sidebar --}}
    @include('layout.admin.sidebar')

    {{-- Main wrapper --}}
    <div class="page-body-wrapper">

        {{-- Navbar --}}
        @include('layout.admin.navbar')

        {{-- Content --}}
        <main class="content-wrapper">

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="admin-alert success" id="flashAlert">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="ms-auto btn-close btn-close-sm" onclick="this.parentElement.remove()"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="admin-alert error" id="flashAlert">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                    <button type="button" class="ms-auto btn-close btn-close-sm" onclick="this.parentElement.remove()"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="admin-alert info" id="flashAlert">
                    <i class="fas fa-info-circle"></i>
                    {{ session('info') }}
                    <button type="button" class="ms-auto btn-close btn-close-sm" onclick="this.parentElement.remove()"></button>
                </div>
            @endif

            {{-- Page content --}}
            @yield('content')

        </main>
    </div>
</div>

{{-- Bootstrap 5 JS Bundle --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Sidebar toggle script --}}
<script>
    const sidebarToggle   = document.getElementById('sidebarToggle');
    const adminSidebar    = document.getElementById('adminSidebar');
    const sidebarOverlay  = document.getElementById('sidebarOverlay');

    function openSidebar() {
        adminSidebar.classList.add('open');
        sidebarOverlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        adminSidebar.classList.remove('open');
        sidebarOverlay.classList.remove('show');
        document.body.style.overflow = '';
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            adminSidebar.classList.contains('open') ? closeSidebar() : openSidebar();
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeSidebar);
    }

    // Auto-dismiss flash alerts after 4s
    setTimeout(() => {
        const flash = document.getElementById('flashAlert');
        if (flash) {
            flash.style.transition = 'opacity 0.4s ease';
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 400);
        }
    }, 4000);
</script>

@stack('scripts')
</body>
</html>
