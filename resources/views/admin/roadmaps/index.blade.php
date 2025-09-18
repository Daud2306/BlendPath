@extends('layout.admin.app')

@section('title', 'Roadmaps - Demo')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4 pt-5">
            <h2 class="mb-0">Semua Roadmaps</h2>
            <a href="/admin/roadmaps/create" class="btn btn-success btn-sm">+ Tambah Roadmap</a>
        </div>

        <div class="row g-3">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100">
                    <img src="{{ asset('frontend/img/basic.jpeg') }}" class="card-img-top"
                        style="height:160px; object-fit:cover;" alt="Cover Roadmap A">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Roadmap A: Belajar Dasar 3D</h5>
                        <p class="card-text text-muted">
                            konsep dasar
                        </p>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <small class="text-muted">3 tutorial</small>
                            <div class="d-flex gap-2">
                                <a href="/admin/roadmaps/1" class="btn btn-sm btn-primary">Lihat</a>
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100">
                    <img src="{{ asset('frontend/img/thumbnail.jpeg') }}" class="card-img-top"
                        style="height:160px; object-fit:cover;" alt="Cover Roadmap B">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Roadmap B: Lanjutan</h5>
                        <p class="card-text text-muted">
                            rigging
                        </p>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <small class="text-muted">8 tutorial</small>
                            <div class="d-flex gap-2">
                                <a href="/admin/roadmaps/2" class="btn btn-sm btn-primary">Lihat</a>
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100">
                    <img src="{{ asset('frontend/img/animasi.jpeg') }}" class="card-img-top"
                        style="height:160px; object-fit:cover;" alt="Cover Roadmap C">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Roadmap C: Animasi</h5>
                        <p class="card-text text-muted">
                            keyframe.
                        </p>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <small class="text-muted">3 tutorial</small>
                            <div class="d-flex gap-2">
                                <a href="/admin/roadmaps/3" class="btn btn-sm btn-primary">Lihat</a>
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
