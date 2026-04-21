@extends('layout.user.app')

@section('content')
    <div class="container py-5">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card profile-card mx-auto" style="max-width:600px;">
            <div class="card-body text-center">

                <img src="https://ui-avatars.com/api/?name={{ $user->name }}" class="profile-avatar mb-3">

                <h4 class="profile-title">{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->role }}</p>

                <hr>

                <div class="profile-info text-start">
                    <div class="mb-3">
                        <label>Email</label>
                        <div>{{ $user->email }}</div>
                    </div>

                    <div class="mb-3">
                        <label>Bergabung sejak</label>
                        <div>{{ $user->created_at->format('d M Y') }}</div>
                    </div>
                </div>

                <div class="profile-actions mt-4 d-flex justify-content-center gap-2">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                        Edit Profile
                    </a>

                    <form action="{{ route('profile.destroy') }}" method="POST"
                        onsubmit="return confirm('Yakin hapus akun?')">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger">
                            Hapus Akun
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
@endsection
