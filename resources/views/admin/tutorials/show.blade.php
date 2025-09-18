@extends('layout.admin.app')

@section('content')
    <div class="container my-5 pt-5">
        <div class="mb-4">
            <h2>tutorial 1: pengenalan</h2>
            <p class="text-muted">mencoba paham</p>
        </div>
        <a href="#" alt="video tutorial">video tutorial</a>
        <div class="mb-5">
            <h5>Langkah-langkah</h5>
            <ol>
                <li>buka blender</li>
                <li>biki donat</li>
                <li>render</li>
                <li>save renderan</li>
                <li>save projek dengan nama terserah.blend</li>
            </ol>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                Sesi Tanya
            </div>
            <div class="card-body">
                <p class="mb-3">Punya pertanyaan tentang materi ini? Silakan tulis di bawah:</p>
                <form enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="question" class="form-label">Pertanyaan</label>
                        <textarea class="form-control" id="question" rows="3" placeholder="Tulis pertanyaanmu di sini..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="media" class="form-label">Tambahkan Media (opsional)</label>
                        <input class="form-control" type="file" id="media" multiple>
                        <small class="text-muted">Boleh unggah gambar, video, atau dokumen. Bisa pilih lebih dari
                            satu.</small>
                    </div>

                    <button type="submit" class="btn btn-primary">Kirim Pertanyaan</button>
                </form>
            </div>
        </div>

        <h5 class="mb-3">Diskusi Terbaru</h5>
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
                    <br>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </div>
                    <hr>
                </div>
                <div class="border-start ps-3 mt-3">
                    <h6 class="card-subtitle mb-2 text-success">Jawaban oleh <strong>Dewi</strong>:</h6>
                    <p class="card-text">pakai circle tool atau spin tool</p>
                </div>
                <br>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-success">Jadikan jawaban terbaik</button>
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted"><strong>Gilang</strong> bertanya:</h6>
                <p class="card-text">Kalo mau bikin bola gimana caranya?</p>

                <button class="btn btn-outline-primary btn-sm mt-2" type="button" data-bs-toggle="collapse"
                    data-bs-target="#answerForm2">Jawab</button>
                <button class="btn btn-sm btn-danger">Hapus</button>
                <div class="collapse mt-3" id="answerForm2">
                    <form enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="jawab-1" class="form-label">Jawaban</label>
                            <textarea class="form-control" id="jawab-1" rows="3" placeholder="Tulis jawabanmu di sini..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="media-answer-2" class="form-label">Tambahkan Media (opsional)</label>
                            <input class="form-control" type="file" id="media-answer-2" multiple>
                        </div>

                        <button type="submit" class="btn btn-success btn-sm">Kirim Jawaban</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
