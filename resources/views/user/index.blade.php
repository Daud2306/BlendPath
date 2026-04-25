@extends('layout.user.app')

@section('title', 'BlendPath - Kuasai Product Rendering dengan Blender 3D')

@section('content')
    <section id="hero" class="hero d-flex align-items-center light-background">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1>
                        Tingkatkan <span>Kualitas Render</span> Produk Anda
                    </h1>
                    <p>
                        BlendPath menyediakan materi terstruktur untuk belajar Blender 3D. Kamu akan berlatih membuat
                        <strong>product rendering</strong> dengan pendekatan studio, cocok untuk membangun portofolio
                        dan meningkatkan peluang kerja lepas.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        @auth
                            <a href="{{ route('learn.moduls.index') }}" class="btn-get-started">
                                <i class="bi bi-play-circle me-2"></i>Lanjutkan Belajar
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn-get-started">
                                <i class="bi bi-person-plus me-2"></i>Mulai Sekarang – Gratis
                            </a>
                            <a href="{{ route('login') }}" class="btn-watch-video">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Sudah Punya Akun? Masuk
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="animated">
                        <img src="{{ asset('user/img/details-5.png') }}" alt="Blender 3D Product Rendering"
                            class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="features light-background">
        <div class="container">
            <div class="section-title">
                <h2>Kenapa BlendPath Pilihan Tepat?</h2>
                <div>Kami tidak hanya mengajarkan tombol, tapi membangun portofolio yang menjual.</div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="icon-box">
                        <i class="bi bi-diagram-3"></i>
                        <h3>Alur Belajar Terstruktur</h3>
                        <p>Modul disusun dari dasar hingga mahir. Setiap submodul harus tuntas sebelum lanjut, memastikan
                            fondasi Anda kuat.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mt-4 mt-md-0">
                    <div class="icon-box">
                        <i class="bi bi-briefcase"></i>
                        <h3>Fokus Freelance & Portofolio</h3>
                        <p>Setiap materi dirancang untuk kebutuhan dunia nyata: render produk, material realistis,
                            pencahayaan studio, langsung siap tampil di portofolio.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mt-4 mt-lg-0">
                    <div class="icon-box">
                        <i class="bi bi-chat-dots"></i>
                        <h3>Komunitas & Mentoring</h3>
                        <p>Tanya jawab langsung di setiap submodul. Dapatkan umpan balik dari sesama learner.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="light-background" style="padding: 5rem 0; border-top: 1px solid var(--border-color);">
        <div class="container">
            <div class="section-title">
                <h2>Bagaimana Kamu Akan Belajar?</h2>
                <div>Tiga langkah sederhana menuju hasil nyata</div>
            </div>

            <div class="row g-4 text-center">
                <div class="col-lg-4 col-md-4">
                    <div style="padding: 2rem 1.5rem;">
                        <div
                            style="width: 64px; height: 64px; background: var(--text-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;">
                            <span style="color: white; font-size: 1.5rem; font-weight: 700;">1</span>
                        </div>
                        <h4 style="margin-bottom: 0.75rem;">Ikuti Modul Berurutan</h4>
                        <p style="margin-bottom: 0;">Tidak perlu bingung mulai dari mana. Kami susun dari dasar hingga
                            teknik advanced.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div style="padding: 2rem 1.5rem;">
                        <div
                            style="width: 64px; height: 64px; background: var(--text-hover); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;">
                            <span style="color: white; font-size: 1.5rem; font-weight: 700;">2</span>
                        </div>
                        <h4 style="margin-bottom: 0.75rem;">Praktik & Submit Mini Project</h4>
                        <p style="margin-bottom: 0;">Setiap submodul ada tugas mini project untuk mengasah keterampilanmu.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div style="padding: 2rem 1.5rem;">
                        <div
                            style="width: 64px; height: 64px; background: var(--text-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;">
                            <span style="color: white; font-size: 1.5rem; font-weight: 700;">3</span>
                        </div>
                        <h4 style="margin-bottom: 0.75rem;">Bangun Portofolio Nyata</h4>
                        <p style="margin-bottom: 0;">Selesaikan seluruh modul dan kumpulkan hasil karyamu.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="stats" class="stats light-background" style="border-top: 1px solid var(--border-color);">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stats-item">
                        <i class="bi bi-people"></i>
                        <span>{{ App\Models\User::count() }}</span>
                        <p>Pembelajar Aktif</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item">
                        <i class="bi bi-play-circle"></i>
                        <span>{{ App\Models\Submodul::count() }}</span>
                        <p>Video & Materi</p>
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
                        <p>Diskusi Terjadi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="cta" class="cta light-background">
        <div class="container">
            <div class="text-center">
                <h3>Siap Membangun Portofolio Product Rendering?</h3>
                <p>Daripada loncat-loncat antar tutorial, coba ikuti alur yang sudah disusun rapi.</p>

                @auth
                    <a href="{{ route('learn.moduls.index') }}" class="btn-get-started">
                        <i class="bi bi-play-circle me-2"></i>Lanjutkan Perjalananmu
                    </a>
                @else
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('register') }}" class="btn-get-started">
                            <i class="bi bi-person-plus me-2"></i>Daftar Gratis – Mulai Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="btn-watch-video">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Sudah Punya Akun? Masuk
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </section>
@endsection
