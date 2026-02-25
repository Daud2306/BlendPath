<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BlendPath - @yield('title')</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <link href="{{ asset('frontend/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('frontend/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Atau jika ingin menggunakan local -->
    <!-- <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> -->

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Atau jika ingin menggunakan local -->
    <!-- <link href="{{ asset('frontend/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet"> -->

    <!-- Custom CSS -->
    <link href="{{ asset('frontend/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/navbar.css') }}" rel="stylesheet">

    @if (request()->is('login*') || request()->is('register*'))
        <link href="{{ asset('frontend/css/auth.css') }}" rel="stylesheet">
    @endif
</head>

<body>
    <header id="header" class="header d-flex align-items-center fixed-top">
        @if (!isset($hide_navbar) || !$hide_navbar)
            @include('layout.frontend.navbar')
        @endif
    </header>

    <main class="main @if (!isset($hide_navbar) || !$hide_navbar) with-navbar @endif">
        @yield('content')
    </main>

    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-chevron-up"></i>
    </a>

    <div id="preloader"></div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Atau jika ingin menggunakan local -->
    <!-- <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script> -->

    <script>
        // Mobile navigation toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
            const navmenu = document.getElementById('navmenu');

            if (mobileNavToggle) {
                mobileNavToggle.addEventListener('click', function() {
                    navmenu.classList.toggle('active');
                });
            }

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.navmenu') && !event.target.closest('.mobile-nav-toggle')) {
                    navmenu.classList.remove('active');
                }
            });

            // Scroll top button
            const scrollTop = document.getElementById('scroll-top');
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    scrollTop.classList.add('show');
                } else {
                    scrollTop.classList.remove('show');
                }
            });

            scrollTop.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Add animation to elements on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                    }
                });
            }, observerOptions);

            // Observe elements you want to animate
            document.querySelectorAll('.icon-box, .modul-card').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
    <script src="{{ asset('frontend/js/navbar.js') }}"></script>
    @stack('tinymce-scripts')
</body>

</html>
