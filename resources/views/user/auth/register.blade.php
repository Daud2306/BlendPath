@extends('layout.frontend.app')

@section('title', 'Register - BlendPath')
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

                            <h2 class="auth-title text-center">Daftarkan Akun Anda</h2>
                            <p class="auth-subtitle text-center">
                                <i class="bi bi-rocket-takeoff me-2"></i>Daftar sekarang dan mulai perjalanan kreatifmu di
                                BlendPath.
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

                            <form action="{{ route('register.process') }}" method="POST" class="auth-form"
                                data-aos="fade-up" data-aos-delay="200">
                                @csrf

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-person"></i>
                                        </span>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback d-block">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="Alamat Email" value="{{ old('email') }}" required>
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
                                            <i class="bi bi-key"></i>
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

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-key-fill"></i>
                                        </span>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="Konfirmasi Kata Sandi" required>
                                    </div>
                                </div>

                                <button type="submit" class="auth-btn">
                                    <i class="bi bi-person-plus me-2"></i>Buat Akun
                                </button>

                                <div class="auth-footer">
                                    <span>Sudah punya akun?
                                        <a href="{{ route('login') }}" class="auth-link">
                                            <i class="bi bi-box-arrow-in-right me-1"></i>Masuk Sekarang!
                                        </a>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 order-1 order-lg-2">
                    <div class="auth-image" data-aos="zoom-out" data-aos-delay="300">
                        <img src="{{ asset('frontend/img/details-5.png') }}" alt="Blender 3D Register" class="img-fluid">
                        <div class="mt-4">
                            <h4><i class="bi bi-people me-2"></i>Bergabung dengan Komunitas</h4>
                            <p class="auth-image-description">Akses roadmap lengkap dan belajar bersama expert</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
