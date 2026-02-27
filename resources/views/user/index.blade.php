@extends('layout.frontend.app')

@section('title', 'BlendPath - Platform Belajar Blender 3D')

@section('content')
    {{-- HERO SECTION --}}
    <section id="hero" class="hero d-flex align-items-center light-background">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1>
                        Belajar <span>Blender</span> dengan Terstruktur
                    </h1>
                    <p>
                        BlendPath menyediakan materi pembelajaran Blender 3D yang disusun secara bertahap — mulai dari
                        dasar, dikerjakan sesuai urutan yang sudah disiapkan.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        @auth
                            <a href="{{ route('learn.moduls.index') }}" class="btn-get-started">
                                <i class="bi bi-play-circle me-2"></i>Mulai Belajar
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn-get-started">
                                <i class="bi bi-person-plus me-2"></i>Daftar Gratis
                            </a>
                            <a href="{{ route('login') }}" class="btn-watch-video">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="animated">
                        <img src="{{ asset('frontend/img/details-5.png') }}" alt="Blender 3D" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURES SECTION --}}
    <section id="features" class="features light-background">
        <div class="container">
            <div class="section-title">
                <h2>Mengapa Belajar di BlendPath?</h2>
                <div>Keunggulan Platform Kami</div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="icon-box">
                        <i class="bi bi-diagram-3"></i>
                        <h3>Struktur Belajar Terarah</h3>
                        <p>Modul pembelajaran yang dirancang dari dasar hingga tingkat lanjut, memastikan Anda belajar
                            dengan urutan yang tepat.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mt-4 mt-md-0">
                    <div class="icon-box">
                        <i class="bi bi-play-btn"></i>
                        <h3>Video per Submodul</h3>
                        <p>Setiap submodul dilengkapi video sebagai panduan. Tonton, coba sendiri, ulangi jika perlu.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mt-4 mt-lg-0">
                    <div class="icon-box">
                        <i class="bi bi-chat-dots"></i>
                        <h3>Komunitas Interaktif</h3>
                        <p>Tanya jawab langsung dengan instruktur dan sesama learner untuk mendukung proses belajar Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ABOUT / HOW IT WORKS SECTION --}}
    <section id="how-it-works" class="light-background" style="padding: 5rem 0; border-top: 1px solid var(--border-color);">
        <div class="container">
            <div class="section-title">
                <h2>Bagaimana Cara Belajarnya?</h2>
                <div>Tiga langkah sederhana untuk mulai perjalanan 3D Anda</div>
            </div>

            <div class="row g-4 text-center">
                <div class="col-lg-4 col-md-4">
                    <div style="padding: 2rem 1.5rem;">
                        <div
                            style="width: 64px; height: 64px; background: var(--text-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;">
                            <span style="color: white; font-size: 1.5rem; font-weight: 700;">1</span>
                        </div>
                        <h4 style="margin-bottom: 0.75rem;">Buat Akun</h4>
                        <p style="margin-bottom: 0;">Daftar gratis dan lengkapi profil Anda untuk memulai pengalaman belajar
                            yang personal.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div style="padding: 2rem 1.5rem;">
                        <div
                            style="width: 64px; height: 64px; background: var(--text-hover); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;">
                            <span style="color: white; font-size: 1.5rem; font-weight: 700;">2</span>
                        </div>
                        <h4 style="margin-bottom: 0.75rem;">Kerjakan Modul</h4>
                        <p style="margin-bottom: 0;">Modul dikerjakan berurutan — modul berikutnya baru terbuka setelah
                            modul sebelumnya selesai.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div style="padding: 2rem 1.5rem;">
                        <div
                            style="width: 64px; height: 64px; background: var(--text-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;">
                            <span style="color: white; font-size: 1.5rem; font-weight: 700;">3</span>
                        </div>
                        <h4 style="margin-bottom: 0.75rem;">Tonton, Coba, Tanya</h4>
                        <p style="margin-bottom: 0;">Pelajari submodul videonya, praktikkan sendiri, dan gunakan fitur
                            diskusi kalau ada yang membingungkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- STATS SECTION --}}
    <section id="stats" class="stats light-background" style="border-top: 1px solid var(--border-color);">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stats-item">
                        <i class="bi bi-people"></i>
                        <span>{{ App\Models\User::count() }}</span>
                        <p>Pengguna Aktif</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item">
                        <i class="bi bi-play-circle"></i>
                        <span>{{ App\Models\Submodul::count() }}</span>
                        <p>Video Submodul</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item">
                        <i class="bi bi-diagram-3"></i>
                        <span>{{ App\Models\Modul::count() }}</span>
                        <p>Learning Path</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item">
                        <i class="bi bi-chat-dots"></i>
                        <span>{{ App\Models\Tanya::count() }}</span>
                        <p>Diskusi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA SECTION --}}
    <section id="cta" class="cta light-background">
        <div class="container">
            <div class="text-center">
                <h3>Mulai dari mana dulu?</h3>
                <p>Buat akun, lalu langsung buka modul pertama. Tidak ada yang perlu disiapkan sebelumnya.</p>

                @auth
                    <a href="{{ route('learn.moduls.index') }}" class="btn-get-started">
                        <i class="bi bi-play-circle me-2"></i>Lanjutkan Belajar
                    </a>
                @else
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('register') }}" class="btn-get-started">
                            <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="btn-watch-video">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Sudah punya akun? Masuk
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </section>
@endsection
