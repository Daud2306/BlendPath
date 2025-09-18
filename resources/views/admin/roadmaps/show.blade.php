@extends('layout.admin.app')

@section('title', 'Tutorials - Roadmap A')

@section('content')
    <div class="container my-5">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0">Tutorials untuk Roadmap A: Belajar Dasar 3D</h2>
                <small class="text-muted">Total: 5 tutorial</small>
            </div>
            <a href="/admin/tutorials/create" class="btn btn-success btn-sm">+ Tambah Tutorial</a>
        </div>

        <div class="row g-3">
            <!-- Tutorial 1 -->
            <div class="col-12">
                <div class="card h-100">
                    <div class="row g-0">
                        <!-- Thumbnail -->
                        <div class="col-md-3">
                            <img src="#" class="img-fluid rounded-start" alt="thumbnail">
                        </div>
                        <!-- Content -->
                        <div class="col-md-9">
                            <div class="card-body d-flex flex-column h-100">
                                <h5 class="card-title mb-1">Tutorial 1: Pengenalan Blender</h5>
                                <p class="card-text text-muted">Belajar interface, navigasi dasar, dan shortcut penting.</p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <small class="text-muted">Durasi: 10 menit</small>
                                    <div class="d-flex gap-2">
                                        <a href="/admin/roadmaps/1/tutorials/1" class="btn btn-sm btn-primary">Lihat</a>
                                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tutorial 2 -->
            <div class="col-12">
                <div class="card h-100">
                    <div class="row g-0">
                        <div class="col-md-3">
                            <img src="#" class="img-fluid rounded-start" alt="thumbnail">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body d-flex flex-column h-100">
                                <h5 class="card-title mb-1">Tutorial 2: Membuat Objek Dasar</h5>
                                <p class="card-text text-muted">Cube, sphere, cylinder, dan cara memodifikasinya.</p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <small class="text-muted">Durasi: 15 menit</small>
                                    <div class="d-flex gap-2">
                                        <a href="/admin/roadmaps/1/tutorials/2" class="btn btn-sm btn-primary">Lihat</a>
                                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tutorial 3 -->
            <div class="col-12">
                <div class="card h-100">
                    <div class="row g-0">
                        <div class="col-md-3">
                            <img src="#" class="img-fluid rounded-start" alt="thumbnail">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body d-flex flex-column h-100">
                                <h5 class="card-title mb-1">Tutorial 3: Rendering Sederhana</h5>
                                <p class="card-text text-muted">Setup kamera, pencahayaan dasar, dan render pertama.</p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <small class="text-muted">Durasi: 12 menit</small>
                                    <div class="d-flex gap-2">
                                        <a href="/admin/roadmaps/1/tutorials/3" class="btn btn-sm btn-primary">Lihat</a>
                                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
