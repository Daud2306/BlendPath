@extends('layout.frontend.app')

@section('title', 'Halaman Tidak Ditemukan - BlendPath')

@section('hide_navbar', false)

@section('content')
    <!-- 404 Hero Section -->
    <section class="error-hero dark-background">
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6 order-2 order-lg-1">
                    <div class="error-content text-center text-lg-start">
                        <div class="error-badge mb-4" data-aos="fade-up">
                            <span class="badge">Error 404</span>
                        </div>

                        <h1 class="error-title" data-aos="fade-up" data-aos-delay="100">
                            <i class="bi bi-emoji-frown me-3"></i>Halaman Tidak Ditemukan
                        </h1>

                        <p class="error-description" data-aos="fade-up" data-aos-delay="200">
                            Maaf, halaman yang Anda cari tidak dapat ditemukan.
                            Mungkin halaman telah dipindahkan, dihapus, atau Anda salah mengetik URL.
                        </p>

                        <div class="error-stats mt-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="stat-item">
                                <i class="bi bi-search text-primary"></i>
                                <span class="stat-text">Halaman tidak ditemukan</span>
                            </div>
                            <div class="stat-item">
                                <i class="bi bi-clock text-warning"></i>
                                <span class="stat-text">{{ now()->format('d M Y, H:i') }}</span>
                            </div>
                        </div>

                        <div class="error-actions mt-5" data-aos="fade-up" data-aos-delay="400">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <a href="{{ url('/') }}" class="btn btn-primary btn-lg w-100">
                                        <i class="bi bi-house me-2"></i>Kembali ke Beranda
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('roadmaps.index') }}" class="btn btn-outline-primary btn-lg w-100">
                                        <i class="bi bi-map me-2"></i>Lihat Roadmaps
                                    </a>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <button onclick="history.back()" class="btn btn-outline-secondary w-100">
                                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Halaman Sebelumnya
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 order-1 order-lg-2">
                    <div class="error-image text-center" data-aos="zoom-in" data-aos-delay="300">
                        <div class="error-graphic">
                            <i class="bi bi-binoculars display-1 text-primary"></i>
                            <div class="error-animation">
                                <div class="circle circle-1"></div>
                                <div class="circle circle-2"></div>
                                <div class="circle circle-3"></div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h4 style="color: var(--accent-color);">Mencari di BlendPath</h4>
                            <p class="text-muted">Gunakan navigasi untuk menemukan konten yang Anda cari</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
