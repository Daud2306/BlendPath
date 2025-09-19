@extends('layout.admin.app')

@section('title', 'Admin - Media Resources')

@section('content')
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Media Resources — Demo (3 item)</h3>
            <a href="{{ url('/admin') }}" class="btn btn-outline-secondary">Back</a>
        </div>

        <div class="row g-3">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#previewImageModal" class="d-block">
                        <img src="{{ asset('frontend\img\rotate.jpeg') }}" class="card-img-top" alt="Contoh Foto"
                            style="height:180px; object-fit:cover;">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <strong class="d-block text-truncate mb-1">rotate-help.png</strong>
                        <small class="text-muted mb-3">Uploaded by Andi · 2 jam lalu</small>

                        <div class="mt-auto d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#previewImageModal">Preview</button>
                            <a href="#" class="btn btn-sm btn-primary" download>Download</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#previewVideoModal" class="d-block">
                        <div
                            style="height:180px; background:#000; display:flex; align-items:center; justify-content:center;">
                            <img src="https://via.placeholder.com/640x360.png?text=Video+Poster" alt="Video Poster"
                                style="max-width:100%; max-height:100%;">
                        </div>
                    </a>
                    <div class="card-body d-flex flex-column">
                        <strong class="d-block text-truncate mb-1">donut-tutorial.mp4</strong>
                        <small class="text-muted mb-3">Uploaded by Gilang · 3 jam lalu</small>

                        <div class="mt-auto d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#previewVideoModal">Preview</button>
                            <a href="#" class="btn btn-sm btn-primary" download>Download</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#previewDocModal" class="d-block">
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height:180px;">
                            <div class="text-center">
                                <img src="#" alt="Blend File" style="height:56px; opacity:.9;">
                            </div>
                        </div>
                    </a>
                    <div class="card-body d-flex flex-column">
                        <strong class="d-block text-truncate mb-1">project1.blend</strong>
                        <small class="text-muted mb-3">Uploaded by Dewi · 1 jam lalu</small>

                        <div class="mt-auto d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#previewDocModal">Preview</button>
                            <a href="#" class="btn btn-sm btn-primary" download>Download</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="previewImageModal" tabindex="-1" aria-labelledby="previewImageLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="previewImageLabel">rotate-help.png</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <img src="#" alt="rotate-help.png" class="img-fluid w-100">
                            </div>
                            <div class="col-md-4">
                                <dl class="row">
                                    <dt class="col-5">Filename</dt>
                                    <dd class="col-7">rotate-help.png</dd>

                                    <dt class="col-5">Type</dt>
                                    <dd class="col-7">Image</dd>

                                    <dt class="col-5">Uploader</dt>
                                    <dd class="col-7">Andi</dd>

                                    <dt class="col-5">Uploaded</dt>
                                    <dd class="col-7">2 jam lalu</dd>

                                    <dt class="col-5">Source</dt>
                                    <dd class="col-7">Question #1 (Roadmap A)</dd>
                                </dl>

                                <div class="mt-3">
                                    <a href="#" class="btn btn-primary d-block mb-2" download>Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="previewVideoModal" tabindex="-1" aria-labelledby="previewVideoLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="previewVideoLabel">donut-tutorial.mp4</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <video controls class="w-100" style="max-height:65vh;">
                                    <source src="#" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            <div class="col-md-4">
                                <dl class="row">
                                    <dt class="col-5">Filename</dt>
                                    <dd class="col-7">donut-tutorial.mp4</dd>

                                    <dt class="col-5">Type</dt>
                                    <dd class="col-7">Video</dd>

                                    <dt class="col-5">Uploader</dt>
                                    <dd class="col-7">Gilang</dd>

                                    <dt class="col-5">Uploaded</dt>
                                    <dd class="col-7">3 jam lalu</dd>

                                    <dt class="col-5">Source</dt>
                                    <dd class="col-7">Question #2 (Roadmap A)</dd>
                                </dl>

                                <div class="mt-3">
                                    <a href="#" class="btn btn-primary d-block mb-2" download>Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="previewDocModal" tabindex="-1" aria-labelledby="previewDocLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="previewDocLabel">instruksi-rotate.pdf</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>instruksi-rotate.pdf</strong></p>
                        <p class="small text-muted">Uploaded by Dewi · 1 jam lalu</p>
                        <p class="mb-0">Preview dokumen tidak tersedia pada demo ini. Klik <strong>Download</strong>
                            untuk mengambil file.</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-primary" download>Download</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
