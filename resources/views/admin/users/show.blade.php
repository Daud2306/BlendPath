@extends('layout.admin.app')

@section('title', 'Admin - User Detail')

@section('content')
    <div class="container my-5">
        <h2 class="mb-4">Detail User</h2>

        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div>
                    <h5 class="card-title mb-1">user 1</h5>
                    <p class="text-muted mb-0">user1@gmail.com</p>
                    <span class="badge bg-success">User</span>
                </div>
            </div>
        </div>
        <div class="card mb-4 shadow-sm">
            <div class="card-header">Info Akun</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>ID User:</strong> 1</li>
                    <li class="list-group-item"><strong>Username:</strong> user 1</li>
                    <li class="list-group-item"><strong>Tanggal Daftar:</strong> 29 Agustus 2025</li>
                    <li class="list-group-item"><strong>Terakhir Login:</strong> 10 September 2025</li>
                </ul>
            </div>
        </div>
        <div class="card mb-4 shadow-sm">
            <div class="card-header">Aktivitas Terbaru</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Mengikuti <strong>Roadmap A</strong></li>
                    <li class="list-group-item">Mengerjakan Tutorial: <em>Pengenalan Blender</em></li>
                    <li class="list-group-item">Mengajukan pertanyaan: "Gimana cara rotate kamera?"</li>
                </ul>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ url('/admin/users') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ url('/admin/users/1/edit') }}" class="btn btn-warning">Edit</a>
            <a href="#" class="btn btn-danger">Hapus</a>
        </div>
    </div>
@endsection
