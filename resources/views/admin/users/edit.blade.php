@extends('layout.admin.app')

@section('title', 'Admin - Edit User')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">👥 Edit User</h1>
            {{-- <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a> --}}
        </div>

        <div class="card shadow">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select" name="role" required>
                                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User
                                    </option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password (Kosongkan jika tidak diubah)</label>
                                <input type="password" class="form-control" name="password"
                                    placeholder="Biarkan kosong untuk menggunakan password lama">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                    placeholder="Hanya diisi jika mengganti password">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Update User
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Info User</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> {{ $user->id }}</p>
                        <p><strong>Tanggal Daftar:</strong> {{ $user->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Terakhir Update:</strong> {{ $user->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
