<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') - BlendPath</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('admins/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admins/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('admins/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('admins/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admins/vendors/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('admins/vendors/flag-icon-css/css/flag-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admins/vendors/owl-carousel-2/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admins/vendors/owl-carousel-2/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('admins/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('admins/images/favicon.png') }}" />
</head>

<body>
    <div class="container-scroller">
        <!-- Sidebar -->
        @include('layout.admin.sidebar')

        <!-- Wrapper -->
        <div class="container-fluid page-body-wrapper">
            <!-- Navbar fixed -->
            <header>
                <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
                    @include('layout.admin.navbar')
                </nav>
            </header>

            <!-- Main Content with spacing for fixed navbar -->
            <main class="content-wrapper" style="padding-top: 70px;">
                @yield('content')
            </main>

            <!-- Footer (opsional) -->
            {{-- @include('layout.admin.footer') --}}
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('admins/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('admins/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('admins/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('admins/vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
    <script src="{{ asset('admins/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('admins/vendors/owl-carousel-2/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('admins/js/jquery.cookie.js') }}"></script>
    <script src="{{ asset('admins/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admins/js/misc.js') }}"></script>
    <script src="{{ asset('admins/js/settings.js') }}"></script>
    <script src="{{ asset('admins/js/todolist.js') }}"></script>
    <script src="{{ asset('admins/js/proBanner.js') }}"></script>
    <script src="{{ asset('admins/js/dashboard.js') }}"></script>
    @stack('scripts')
</body>

</html>
