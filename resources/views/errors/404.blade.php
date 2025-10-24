@extends('layout.frontend.app')

@section('title', '404 Not Found')
@section('hide_navbar', true)

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h1>Halaman tidak ditemukan</h1>
                <p>Maaf, halaman yang Anda cari tidak ditemukan.</p>
                <a href="/" class="btn btn-primary">Kembali ke Home</a>
            </div>
        </div>
    </div>
@endsection
