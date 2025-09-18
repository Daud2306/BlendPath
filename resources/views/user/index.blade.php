@extends('layout.frontend.app')

@section('title', 'Belajar Blender — Home')

@section('content')
    <main>
        <section class="py-5 text-white" style="background: linear-gradient(90deg,#0d47a1, #1976d2);">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="display-5 fw-bold">Belajar 3D bersama prabu </h1>
                        <p class="lead text-white-50 mb-4">pakai teknik seadanya</p>

                        <div class="d-flex gap-2 mb-3">
                            <a href="#" class="btn btn-light btn-lg">Browse Roadmaps</a>
                            <a href="#" class="btn btn-outline-light btn-lg">Mulai
                                Tutorial</a>
                        </div>

                        <form class="d-flex" role="search" action="#" method="GET" aria-label="Search">
                            <input class="form-control form-control-lg me-2" name="q" type="search"
                                placeholder="Cari roadmap atau tutorial..." aria-label="Cari">
                            <button class="btn btn-dark btn-lg" type="submit">Cari</button>
                        </form>
                    </div>

                    <div class="col-lg-6 d-none d-lg-block">
                        <img src="{{ asset('frontend/img/details-5.png') }}" alt="Hero image"
                            class="img-fluid rounded shadow-lg">
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row text-center mb-4">
                    <div class="col">
                        <h2 class="h4">Kenapa pakai Roadmap ini?</h2>
                        <p class="text-muted mb-0">soalnya</p>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card h-100 border-0">
                            <div class="card-body">
                                <h5 class="card-title">baru mulai</h5>
                                <p class="card-text text-muted">awal awal</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0">
                            <div class="card-body">
                                <h5 class="card-title">tutorial nya baru dikit</h5>
                                <p class="card-text text-muted">tutorial pendek</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0">
                            <div class="card-body">
                                <h5 class="card-title">bisa tanya2</h5>
                                <p class="card-text text-muted">lanjut part 2</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h4 mb-0">Roadmaps Populer</h2>
                    <a href="{{ url('/roadmaps') }}" class="small">Lihat semua roadmaps →</a>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('frontend/img/basic.jpeg') }}" class="card-img-top" alt="Roadmap A"
                                style="height:180px; object-fit:cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-1">Roadmap A — dasar</h5>
                                <p class="card-text text-muted mb-2">belajar shorcut</p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <small class="text-muted">5 tutorial</small>
                                    <a href="{{ url('/roadmaps/1/tutorials') }}" class="btn btn-sm btn-primary">Lihat
                                        Tutorial</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('frontend/img/thumbnail.jpeg') }}" class="card-img-top" alt="Roadmap B"
                                style="height:180px; object-fit:cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-1">Roadmap B — lebih lanjut</h5>
                                <p class="card-text text-muted mb-2">teknik yang benar</p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <small class="text-muted">8 tutorial</small>
                                    <a href="{{ url('/roadmaps/2/tutorials') }}" class="btn btn-sm btn-primary">Lihat
                                        Tutorial</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('frontend/img/animasi.jpeg') }}" class="card-img-top" alt="Roadmap C"
                                style="height:180px; object-fit:cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-1">Roadmap C — animasi</h5>
                                <p class="card-text text-muted mb-2">animasi kartun jumbo</p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <small class="text-muted">3 tutorial</small>
                                    <a href="{{ url('/roadmaps/3/tutorials') }}" class="btn btn-sm btn-primary">Lihat
                                        Tutorial</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5 bg-light">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h5 mb-0">Tutorial Populer</h2>
                    <a href="{{ url('/roadmaps/1') }}" class="small">Lihat semua tutorials →</a>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="list-group">
                            <a href="{{ url('/roadmaps/1/tutorials/1') }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">kenalan</h6>
                                    <small class="text-muted">Step 1</small>
                                </div>
                                <p class="mb-1 text-muted">belajar shortcut</p>
                            </a>
                            <a href="{{ url('/roadmaps/1/tutorials/2') }}"
                                class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">membuat objek</h6>
                                    <small class="text-muted">Step 2</small>
                                </div>
                                <p class="mb-1 text-muted">tools tools</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <h2 class="h5 mb-3">Apa kata pengguna?</h2>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <p class="mb-2">"gud"</p>
                                <strong class="d-block">user 1</strong>
                                <small class="text-muted">Learner</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <p class="mb-2">"aku siap kerja di dunia game developer"</p>
                                <strong class="d-block">user 2</strong>
                                <small class="text-muted">Mentor</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <p class="mb-2">"webseite ya bagus"</p>
                                <strong class="d-block">Gilang</strong>
                                <small class="text-muted">Student</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
