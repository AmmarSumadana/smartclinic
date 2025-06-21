<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Update Status Rawat Inap</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pegawai.rawat-inap.update-status', $rawatInap->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="statusSelect" class="form-label">Status</label>
                        <select class="form-select" id="statusSelect" name="status" required>
                            <option value="pending" {{ $rawatInap->status == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                            <option value="approved" {{ $rawatInap->status == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="admitted" {{ $rawatInap->status == 'admitted' ? 'selected' : '' }}>Sedang Dirawat</option>
                            <option value="rejected" {{ $rawatInap->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="cancelled" {{ $rawatInap->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            <option value="discharged" {{ $rawatInap->status == 'discharged' ? 'selected' : '' }}>Selesai Dirawat</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notesTextarea" class="form-label">Catatan Pegawai (Opsional)</label>
                        <textarea class="form-control" id="notesTextarea" name="notes" rows="3">{{ $rawatInap->notes }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="assignRoomModal" tabindex="-1" aria-labelledby="assignRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignRoomModalLabel">Tugaskan Nomor Kamar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pegawai.rawat-inap.assign-room', $rawatInap->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="roomNumberInput" class="form-label">Nomor Kamar</label>
                        <input type="text" class="form-control" id="roomNumberInput" name="room_number" value="{{ $rawatInap->room_number }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tugaskan Kamar</button>
                </div>
            </form>
        </div>
    </div>
</div>
