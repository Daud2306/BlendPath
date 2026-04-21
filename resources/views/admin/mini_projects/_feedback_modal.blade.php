<div class="modal fade" id="feedbackModal-{{ $submission->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.mini_projects.update_status', $submission) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Feedback untuk {{ $submission->user->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="approved" {{ $submission->status == 'approved' ? 'selected' : '' }}>Setujui
                            </option>
                            <option value="rejected" {{ $submission->status == 'rejected' ? 'selected' : '' }}>Tolak
                            </option>
                            <option value="submitted" {{ $submission->status == 'submitted' ? 'selected' : '' }}>Tandai
                                ulang sebagai Menunggu</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Feedback (opsional)</label>
                        <textarea name="feedback" class="form-control" rows="3">{{ $submission->feedback }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
