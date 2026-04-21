@extends('layout.user.app')

@section('title', 'Login - BlendPath')
@section('hide_navbar', true)

@section('content')
    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="auth-container">
                        <a href="/" class="auth-logo">
                            <img src="{{ asset('user/img/logo.png') }}" alt="BlendPath Logo">
                        </a>

                        <div class="auth-card">
                            <p class="auth-subtitle-only">
                                Lanjutkan perjalanan belajar Blender 3D-mu
                            </p>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        <strong>Terjadi kesalahan:</strong>
                                    </div>
                                    <ul class="mb-0 mt-2 ps-4">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success">
                                    <i class="bi bi-check-circle me-2"></i>
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('login.process') }}" method="POST" class="auth-form">
                                @csrf

                                <div class="form-group">
                                    <label class="form-label mb-2 small text-muted">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="Masukkan email" value="{{ old('email') }}" required autofocus>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label mb-2 small text-muted">Kata Sandi</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock"></i>
                                        </span>
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Masukkan kata sandi" required>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <label>
                                    <input type="checkbox" name="remember">
                                    Remember Me
                                </label>

                                <button type="submit" class="auth-btn mt-3">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                                </button>

                                <div class="auth-footer">
                                    <span>Belum punya akun?
                                        <a href="{{ route('register') }}" class="auth-link">
                                            Daftar Sekarang
                                        </a>
                                    </span>
                                </div>

                                <div class="text-center my-3">
                                    <span class="text-muted small">atau</span>
                                </div>

                                <a href="{{ route('auth.google.redirect') }}" class="auth-btn google-btn">
                                    <i class="bi bi-google me-2"></i>
                                    Masuk dengan Google
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
