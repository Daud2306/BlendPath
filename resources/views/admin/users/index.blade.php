@extends('layout.admin.app')

@section('title', 'Admin - Users')

@section('content')
    <div class="container my-5 pt-5">
        <h2 class="mb-4">Daftar Users</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>1</th>
                            <td>user 1</td>
                            <td>user1@gmail.com</td>
                            <td><span class="badge bg-success">User</span></td>
                            <td>
                                <a href="{{ url('admin/users/1') }}" class="btn btn-sm btn-primary">Detail</a>
                                <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                            </td>
                        </tr>
                        <tr>
                            <th>2</th>
                            <td>Prabu Dharma</td>
                            <td>prabu64@gmail.com</td>
                            <td><span class="badge bg-info">Admin</span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">Detail</a>
                                <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                            </td>
                        </tr>
                        <tr>
                            <th>3</th>
                            <td>Gilang</td>
                            <td>gilang@gmail.com</td>
                            <td><span class="badge bg-success">User</span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">Detail</a>
                                <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
