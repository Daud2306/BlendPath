@extends('layout.admin.app')

@section('title', 'Admin - Edit User')

@section('content')
    <div class="container my-5">
        <h2 class="mb-4">Edit User</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" value="user 1">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" value="user1@gmail.com">
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select id="role" class="form-select">
                            <option>User</option>
                            <option>Admin</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ url('/admin/users/1') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
