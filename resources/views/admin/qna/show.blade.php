@extends('layout.admin.app')

@section('title', 'Admin - Tanya Jawab / Detail')

@section('content')
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Detail Pertanyaan</h3>
            <div>
                <a href="{{ url('/admin/qna') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="mb-1"><strong>Gilang</strong> bertanya</h5>
                <small class="text-muted">2 jam lalu · <a href="{{ url('/admin/roadmaps/1/tutorials/2') }}">Membuat Donat —
                        Roadmap A</a></small>

                <p class="mt-3">Kalo mau bikin donat gimana caranya? Saya butuh langkah singkat.</p>
                <div class="mb-3">
                    <strong>Lampiran:</strong>
                    <div class="mt-2 d-flex gap-2 flex-wrap">
                        <img src="{{ asset('frontend/img/thumbnail.jpeg') }}" class="img-thumbnail" alt="lampiran"
                            style="max-height:110px;">
                        <a href="#" class="align-self-center">resep-donat.png</a>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-danger">Hapus Pertanyaan</button>
                </div>
            </div>
        </div>
        <h6>Jawaban</h6>
        <div class="card mb-3">
            <div class="card-body">
                <div class="small text-muted">Jawaban oleh <strong>Dewi</strong> · 1 jam lalu</div>
                <p class="mt-2 mb-0">Untuk donat: gunakan torus atau spin modifier pada profile circle. Lihat langkah
                    singkat: ...</p>
                <br>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-secondary">Toggle Hidden</button>
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Jawab Pertanyaan</div>
            <div class="card-body">
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="answer_body" class="form-label">Jawaban</label>
                        <textarea id="answer_body" name="body" class="form-control" rows="4" placeholder="Tulis jawaban..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="answer_files" class="form-label">Lampiran (opsional)</label>
                        <input id="answer_files" name="attachments[]" type="file" class="form-control" multiple>
                        <small class="text-muted">Gambar, PDF, dsb.</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
                        <a href="{{ url('/admin/qna') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
