@extends('layout.frontend.app')

@section('title', 'Login - BlendPath')
@section('hide_navbar', true)

@section('content')
    <section class="auth-section light-background">
        <div class="container">
            <div class="row gy-4 align-items-center">
                <div class="col-lg-6 order-2 order-lg-1">
                    <div class="auth-container">
                        <div class="auth-card" data-aos="fade-up">
                            <div class="text-center">
                                <a href="/" class="auth-logo">
                                    <img src="{{ asset('frontend/img/logo.png') }}" alt="BlendPath Logo" class="me-2"
                                        style="height: 40px;">
                                </a>
                            </div>

                            <h2 class="auth-title text-center">Login ke Akun Anda</h2>
                            <p class="auth-subtitle text-center">
                                <i class="bi bi-cube me-2"></i>Masuk dan bentuk dunia 3D-mu hari ini!
                            </p>

                            @if ($errors->any())
                                <div class="alert alert-danger" data-aos="fade-up" data-aos-delay="100">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    <strong>Terjadi kesalahan:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success" data-aos="fade-up" data-aos-delay="100">
                                    <i class="bi bi-check-circle me-2"></i>
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('login.process') }}" method="POST" class="auth-form" data-aos="fade-up"
                                data-aos-delay="200">
                                @csrf

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="Alamat Email" value="{{ old('email') }}" required autofocus>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock"></i>
                                        </span>
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Kata Sandi" required>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="auth-btn">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Akun
                                </button>

                                <div class="auth-footer">
                                    <span>Belum punya akun?
                                        <a href="{{ route('register') }}" class="auth-link">
                                            <i class="bi bi-person-plus me-1"></i>Daftar Sekarang!
                                        </a>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 order-1 order-lg-2">
                    <div class="auth-image" data-aos="zoom-out" data-aos-delay="300">
                        <img src="{{ asset('frontend/img/details-5.png') }}" alt="Blender 3D Login" class="img-fluid">
                        <div class="mt-4">
                            <h4><i class="bi bi-stars me-2"></i>Mulai Perjalanan 3D Anda</h4>
                            <p class="auth-image-description">Bergabung dengan komunitas Blender terbesar di Indonesia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
