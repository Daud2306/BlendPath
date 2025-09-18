@extends('layout.admin.app')

@section('title', 'Admin - Tanya Jawab')

@section('content')
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Tanya Jawab (Q&A)</h3>
            <a href="{{ url('/admin/roadmaps') }}" class="btn btn-outline-secondary">Kembali ke Roadmaps</a>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <form class="row g-2" method="GET" action="{{ url('/admin/qna') }}">
                    <div class="col-md-6">
                        <input name="q" class="form-control" placeholder="Cari by isi, penanya, tutorial..."
                            value="{{ request('q') }}">
                    </div>
                    <div class="col-auto">
                        <select name="status" class="form-select">
                            <option value="">Semua status</option>
                            <option value="pending">Menunggu</option>
                            <option value="resolved">Terjawab</option>
                            <option value="hidden">Tersembunyi</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel daftar pertanyaan (dummy data) -->
        <div class="card">
            <div class="card-body">

                <!-- responsive wrapper: kalau layar sempit, tabel bisa scroll -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Penanya</th>
                                <th scope="col" style="min-width:250px; max-width:420px;">Isi singkat</th>
                                <th scope="col">Tutorial / Roadmap</th>
                                <th scope="col">Waktu</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- dummy row 1 -->
                            <tr>
                                <th scope="row">1</th>
                                <td>Gilang</td>

                                <!-- gunakan div.text-truncate agar tidak memecah layout -->
                                <td style="max-width:420px;">
                                    <div class="text-truncate" style="max-width:420px;">
                                        Bagaimana cara bikin donat di Blender? (preview panjang sedikit...)
                                    </div>
                                </td>

                                <td>
                                    <a class="d-inline-block text-truncate" style="max-width:180px;"
                                        href="{{ url('/admin/roadmaps/1/tutorials/2') }}">
                                        Membuat Donat — Roadmap A
                                    </a>
                                </td>

                                <td>2 jam lalu</td>
                                <td><span class="badge bg-warning text-dark">Menunggu</span></td>
                                <td>
                                    <a href="{{ url('/admin/qna/1') }}" class="btn btn-sm btn-primary">Buka</a>
                                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                </td>
                            </tr>

                            <!-- dummy row 2 -->
                            <tr>
                                <th scope="row">2</th>
                                <td>Andi</td>

                                <td style="max-width:420px;">
                                    <div class="text-truncate" style="max-width:420px;">
                                        Rotate kamera di viewport
                                    </div>
                                </td>

                                <td>
                                    <a class="d-inline-block text-truncate" style="max-width:180px;"
                                        href="{{ url('/admin/roadmaps/1/tutorials/1') }}">
                                        Pengenalan Blender — Roadmap A
                                    </a>
                                </td>

                                <td>1 hari lalu</td>
                                <td><span class="badge bg-success">Terjawab</span></td>
                                <td>
                                    <a href="{{ url('/admin/qna/2') }}" class="btn btn-sm btn-primary">Buka</a>
                                </td>
                            </tr>

                            <!-- dummy row 3 -->
                            <tr>
                                <th scope="row">3</th>
                                <td>Rina</td>

                                <td style="max-width:420px;">
                                    <div class="text-truncate" style="max-width:420px;">
                                        Render noisy apa yang harus diatur?
                                    </div>
                                </td>

                                <td>
                                    <a class="d-inline-block text-truncate" style="max-width:180px;"
                                        href="{{ url('/admin/roadmaps/2/tutorials/8') }}">
                                        Rendering — Roadmap B
                                    </a>
                                </td>

                                <td>3 hari lalu</td>
                                <td><span class="badge bg-info text-dark">1 jawaban</span></td>
                                <td>
                                    <a href="{{ url('/admin/qna/3') }}" class="btn btn-sm btn-primary">Buka</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
