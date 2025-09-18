@extends('layout.admin.app')

@section('title', 'Admin - Dashboard')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="container-fluid">
                <h1 class="mb-4">Dashboard Admin</h1>
                <div class="row mb-4">
                    <!-- gunakan struktur kolom konsisten: 1 / 2 / 4 columns -->
                    <div class="col-12 col-sm-6 col-md-3 mb-3">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <div>
                                    <h6 class="mb-1">Total Users</h6>
                                    <h3>50</h3>
                                    <small class="text-muted">Aktif sekarang: <span class="fw-bold">10</span></small>
                                </div>
                                <!-- spacer supaya konten bawah tetap di bawah -->
                                <div class="mt-auto">
                                    <small class="text-muted">Overview</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 mb-3">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <div>
                                    <h6 class="mb-1">Roadmaps</h6>
                                    <h3>8</h3>
                                    <small class="text-muted">Terbit aktif: <span class="fw-bold">6</span></small>
                                </div>
                                <div class="mt-auto">
                                    <small class="text-muted">Manage roadmaps</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 mb-3">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <div>
                                    <h6 class="mb-1">Tutorials</h6>
                                    <h3>42</h3>
                                    <small class="text-muted">Baru minggu ini: <span class="fw-bold">3</span></small>
                                </div>
                                <div class="mt-auto">
                                    <small class="text-muted">Latest tutorials</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 mb-3">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <div>
                                    <h6 class="mb-1">Pertanyaan Pending</h6>
                                    <h3>7</h3>
                                    <small class="text-muted">Perlu jawaban</small>
                                </div>

                                <div class="mt-auto">
                                    <a href="{{ url('/admin/qna') }}" class="btn btn-sm btn-outline-primary">Tinjau</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                Roadmaps Populer
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Roadmap A - Belajar Dasar 3D
                                        <div style="width:40%">
                                            <div class="d-flex justify-content-end align-items-center gap-2">
                                                <span class="badge bg-primary">420 views</span>
                                            </div>
                                            <div class="progress mt-2" style="height:6px;">
                                                <div class="progress-bar" style="width: 70%;"></div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Roadmap B - Blender Intermediate
                                        <div style="width:40%">
                                            <div class="d-flex justify-content-end align-items-center gap-2">
                                                <span class="badge bg-secondary">310 views</span>
                                            </div>
                                            <div class="progress mt-2" style="height:6px;">
                                                <div class="progress-bar bg-success" style="width: 50%;">
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Roadmap C - Animation Basics
                                        <div style="width:40%">
                                            <div class="d-flex justify-content-end align-items-center gap-2">
                                                <span class="badge bg-info">190 views</span>
                                            </div>
                                            <div class="progress mt-2" style="height:6px;">
                                                <div class="progress-bar bg-warning" style="width: 22%;">
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">Pertanyaan Terbaru</div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <strong>Gilang</strong> - "Cara bikin donat gimana?"
                                                <div><small class="text-muted">2 jam lalu</small></div>
                                            </div>
                                            <div>
                                                <a href="#" class="btn btn-sm btn-outline-primary">Buka</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <strong>Prabu Dharma</strong> - "Render saya noise, solusi?"
                                                <div><small class="text-muted">6 jam lalu</small></div>
                                            </div>
                                            <div>
                                                <a href="#" class="btn btn-sm btn-outline-primary">Buka</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-header">User Terbaru</div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <div>
                                            <strong>user 2</strong>
                                            <div><small class="text-muted">user2@gmail.com - 2 hari lalu</small></div>
                                        </div>
                                        <div>
                                            <a href="{{ url('/admin/users/1') }}"
                                                class="btn btn-sm btn-outline-secondary">Detail</a>
                                        </div>
                                    </li>

                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <div>
                                            <strong>user 1</strong>
                                            <div><small class="text-muted">user1@gmail.com - 5 hari lalu</small></div>
                                        </div>
                                        <div>
                                            <a href="{{ url('/admin/users/2') }}"
                                                class="btn btn-sm btn-outline-secondary">Detail</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">Tutorial Terbaru</div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Pengenalan Blender (Roadmap A)
                                        <span class="badge bg-primary">Baru</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Membuat Objek Dasar (Roadmap A)
                                        <span class="badge bg-secondary">Populer</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
