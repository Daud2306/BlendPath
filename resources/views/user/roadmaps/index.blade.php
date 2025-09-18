@extends('layout.frontend.app')

@section('title', 'Roadmaps - Demo')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Semua Roadmaps</h2>
        </div>

        <div class="row g-3">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100">
                    <img src="{{ asset('frontend/img/basic.jpeg') }}" class="card-img-top"
                        style="height:160px; object-fit:cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Roadmap A: Belajar Dasar 3D</h5>
                        <p class="card-text text-muted">teori</p>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-muted">Progress</small>
                                <span class="badge bg-danger">complete - 10%</span>
                            </div>
                            <div class="progress" style="height:8px;">
                                <div class="progress-bar bg-danger" style="width: 10%;"
                                    aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <small class="text-muted">3 tutorial</small>
                            <a href="/roadmaps/1" class="btn btn-sm btn-primary">Lihat Roadmap</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100">
                    <img src="{{ asset('frontend/img/thumbnail.jpeg') }}" class="card-img-top"
                        style="height:160px; object-fit:cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Roadmap B: Lanjutan</h5>
                        <p class="card-text text-muted">rigging</p>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-muted">Progress</small>
                                <span class="badge bg-warning">complete - 50%</span>
                            </div>
                            <div class="progress" style="height:8px;">
                                <div class="progress-bar bg-warning" style="width: 50%;"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <small class="text-muted">8 tutorial</small>
                            <a href="/roadmaps/2" class="btn btn-sm btn-primary">Lihat Roadmap</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100">
                    <img src="{{ asset('frontend/img/animasi.jpeg') }}" class="card-img-top"
                        style="height:160px; object-fit:cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Roadmap C: Animasi</h5>
                        <p class="card-text text-muted">keyframe</p>

                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-muted">Progress</small>
                                <span class="badge bg-success">complete - 100%</span>
                            </div>
                            <div class="progress" style="height:8px;">
                                <div class="progress-bar bg-success" style="width: 100%;"
                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <small class="text-muted">3 tutorial</small>
                            <a href="/roadmaps/3" class="btn btn-sm btn-primary">Lihat
                                Tutorial</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
