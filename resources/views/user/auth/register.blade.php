@extends('layout.user.app')

@section('title', 'Register - BlendPath')
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
                                Daftar sekarang untuk memulai perjalananmu!
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

                            <form action="{{ route('register.process') }}" method="POST" class="auth-form">
                                @csrf

                                <div class="form-group">
                                    <label class="form-label mb-2 small text-muted">Nama Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-person"></i>
                                        </span>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required
                                            autofocus>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback d-block">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label mb-2 small text-muted">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="Masukkan email" value="{{ old('email') }}" required>
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
                                            placeholder="Buat kata sandi" required>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label mb-2 small text-muted">Konfirmasi Kata Sandi</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock-fill"></i>
                                        </span>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="Ulangi kata sandi" required>
                                    </div>
                                </div>

                                <button type="submit" class="auth-btn mt-3">
                                    <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                                </button>

                                <div class="auth-footer">
                                    <span>Sudah punya akun?
                                        <a href="{{ route('login') }}" class="auth-link">
                                            Masuk
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
