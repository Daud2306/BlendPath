<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BlendPath - @yield('title')</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <link href="{{ asset('user/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('user/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Atau jika ingin menggunakan local -->
    <!-- <link href="{{ asset('user/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> -->

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Atau jika ingin menggunakan local -->
    <!-- <link href="{{ asset('user/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet"> -->

    <!-- Custom CSS -->
    <link href="{{ asset('user/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('user/css/navbar.css') }}" rel="stylesheet">
    <link href="{{ asset('user/css/ai-chat.css') }}" rel="stylesheet">

    @if (request()->is('login*') || request()->is('register*'))
        <link href="{{ asset('user/css/auth.css') }}" rel="stylesheet">
    @endif
</head>

<body>
    @hasSection('hide_navbar')
    @else
        <header id="header" class="header d-flex align-items-center fixed-top">
            @include('layout.user.navbar')
        </header>
    @endif

    <main class="main @hasSection('hide_navbar')
@else
with-navbar
@endif">
        @yield('content')
    </main>

    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-chevron-up"></i>
    </a>

    <div id="preloader"></div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Atau jika ingin menggunakan local -->
    <!-- <script src="{{ asset('user/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script> -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
            const navmenu = document.getElementById('navmenu');

            if (mobileNavToggle) {
                mobileNavToggle.addEventListener('click', function() {
                    navmenu.classList.toggle('active');
                });
            }

            document.addEventListener('click', function(event) {
                if (!event.target.closest('.navmenu') && !event.target.closest('.mobile-nav-toggle')) {
                    if (navmenu) navmenu.classList.remove('active');
                }
            });

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

            document.querySelectorAll('.icon-box, .modul-card').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
    <script src="{{ asset('user/js/navbar.js') }}"></script>
    @stack('tinymce-scripts')
    @stack('scripts')
    @auth
        <x-ai-chat />
    @endauth
    @auth
        <script src="{{ asset('user/js/ai-chat.js') }}"></script>
        <script src="{{ asset('js/lightbox.js') }}"></script>
    @endauth
    <div class="modal fade" id="globalLightbox" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body text-center p-0">
                    <img id="globalLightboxImage" src="" alt="Preview" class="img-fluid rounded shadow-lg"
                        style="max-height: 80vh;">
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
