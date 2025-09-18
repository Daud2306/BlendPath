@extends('layout.frontend.app')

@section('title', 'Tutorials - Roadmap A')

@section('content')
    <div class="container my-5">
        <div class="card mb-4 shadow-sm">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="{{ asset('frontend/img/basic.jpeg') }}" class="img-fluid rounded-start h-100"
                        alt="thumbnail roadmap" style="object-fit:cover;">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h2 class="card-title mb-2">Roadmap A: Belajar Dasar 3D</h2>
                        <p class="card-text text-muted">
                            nyoba2
                        </p>
                        <small class="text-muted">Total: 3 tutorial</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3">

            <div class="col-12">
                <a href="/roadmaps/1/tutorials/1" class="text-decoration-none text-dark">
                    <div class="card h-100">
                        <div class="row g-0">
                            <div class="col-md-9">
                                <div class="card-body d-flex flex-column h-100">
                                    <h5 class="card-title mb-1">Tutorial 1: Pengenalan Blender</h5>
                                    <p class="card-text text-muted">antarmuka nya
                                    </p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Durasi: 10 menit</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12">
                <a href="/roadmaps/1/tutorials/2" class="text-decoration-none text-dark">
                    <div class="card h-100">
                        <div class="row g-0">
                            <div class="col-md-9">
                                <div class="card-body d-flex flex-column h-100">
                                    <h5 class="card-title mb-1">Tutorial 2: Membuat Objek Dasar</h5>
                                    <p class="card-text text-muted">bentuk segitiga, dan kotak</p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Durasi: 15 menit</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12">
                <a href="/roadmaps/1/tutorials/3" class="text-decoration-none text-dark">
                    <div class="card h-100">
                        <div class="row g-0">
                            <div class="col-md-9">
                                <div class="card-body d-flex flex-column h-100">
                                    <h5 class="card-title mb-1">Tutorial 3: Rendering Sederhana</h5>
                                    <p class="card-text text-muted">setup kamera, angle nya coba kau apakan dulu ini biar ga
                                        apa kali
                                    </p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Durasi: 12 menit</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
