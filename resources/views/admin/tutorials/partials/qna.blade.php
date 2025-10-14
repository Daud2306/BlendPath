<div class="card shadow-sm mt-5">
    <div class="card-body">
        <h5 class="mb-3">💬 Tanya Jawab (Admin View)</h5>

        @auth
            @if (Auth::user()->isAdmin())
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title">Ajukan Pertanyaan</h6>
                        <form action="{{ route('tanyas.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="tutorial_id" value="{{ $tutorial->id }}">

                            <div class="mb-3">
                                <textarea name="pertanyaan" class="form-control" rows="3" placeholder="Tulis pertanyaan..." required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Upload Screenshot (opsional)</label>
                                <input type="file" class="form-control" name="gambar[]" multiple accept="image/*">
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm">Kirim Pertanyaan</button>
                        </form>
                    </div>
                </div>
            @endif
        @endauth

        @forelse ($tutorial->tanya as $tanya)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <strong>{{ $tanya->user->name ?? 'User' }}</strong>
                            <small class="text-muted ms-2">{{ $tanya->created_at->diffForHumans() }}</small>
                        </div>

                        @auth
                            @if (Auth::user()->isAdmin())
                                <form action="{{ route('admin.tanyas.destroy', $tanya->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Hapus pertanyaan ini?')">
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>

                    <p class="mb-2">{{ $tanya->pertanyaan }}</p>
                    @if ($tanya->resources->count() > 0)
                        <div class="mb-3">
                            @foreach ($tanya->resources as $resource)
                                <img src="{{ asset('storage/' . $resource->resource) }}" alt="Screenshot"
                                    class="img-thumbnail me-2" style="width: 100px; height: 100px;">
                            @endforeach
                        </div>
                    @endif

                    @auth
                        @if (Auth::user()->isAdmin())
                            <form action="{{ route('jawabs.store') }}" method="POST" enctype="multipart/form-data"
                                class="mb-3">
                                @csrf
                                <input type="hidden" name="tanya_id" value="{{ $tanya->id }}">

                                <div class="input-group">
                                    <textarea name="jawaban" class="form-control" rows="2" placeholder="Tulis jawaban sebagai admin..." required></textarea>
                                    <button type="submit" class="btn btn-success">Kirim</button>
                                </div>

                                <div class="mt-2">
                                    <input type="file" class="form-control form-control-sm" name="gambar_jawaban[]"
                                        multiple accept="image/*">
                                </div>
                            </form>
                        @endif
                    @endauth

                    @foreach ($tanya->jawabs as $jawab)
                        <div class="card bg-light mt-2">
                            <div class="card-body py-2">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>{{ $jawab->user->name ?? 'User' }}</strong>
                                        <small
                                            class="text-muted ms-2">{{ $jawab->created_at->diffForHumans() }}</small>
                                    </div>
                                    @auth
                                        @if (Auth::user()->isAdmin())
                                            <form action="{{ route('jawabs.destroy', $jawab->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Hapus jawaban?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>

                                <p class="mb-1 mt-1">{{ $jawab->jawaban }}</p>
                                @if ($jawab->resources->count() > 0)
                                    <div class="mt-2">
                                        @foreach ($jawab->resources as $resource)
                                            <img src="{{ asset('storage/' . $resource->resource) }}" alt="Screenshot"
                                                class="img-thumbnail me-2" style="width: 80px; height: 80px;">
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-4">
                Belum ada pertanyaan.
            </div>
        @endforelse
    </div>
</div>
