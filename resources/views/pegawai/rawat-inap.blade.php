@extends('layouts.template-pegawai') {{-- Pastikan ini mengarah ke layout pegawai Anda --}}

@section('title', 'Kelola Rawat Inap')
@section('page-title', 'Daftar Permintaan Rawat Inap')

@push('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    {{-- Asumsi Tailwind CSS dan Bootstrap sudah dimuat di layouts/template-pegawai.blade.php --}}

    <style>
        /* Gaya kustom untuk badge status */
        .badge-pending {
            background-color: #6c757d; /* grey */
            color: white;
            padding: 0.3em 0.6em;
            border-radius: 0.25rem;
            font-size: 0.75em;
        }

        .badge-approved {
            background-color: #28a745; /* green */
            color: white;
            padding: 0.3em 0.6em;
            border-radius: 0.25rem;
            font-size: 0.75em;
        }

        .badge-admitted {
            background-color: #007bff; /* blue */
            color: white;
            padding: 0.3em 0.6em;
            border-radius: 0.25rem;
            font-size: 0.75em;
        }

        .badge-rejected {
            background-color: #dc3545; /* red */
            color: white;
            padding: 0.3em 0.6em;
            border-radius: 0.25rem;
            font-size: 0.75em;
        }

        .badge-cancelled {
            background-color: #ffc107; /* yellow */
            color: #212529;
            padding: 0.3em 0.6em;
            border-radius: 0.25rem;
            font-size: 0.75em;
        }

        /* Jika neumo-card-small tidak didefinisikan di CSS global, Anda mungkin perlu menambahkannya */
        .neumo-card-small {
            background-color: #ecf0f3;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 5px 5px 10px #cbced1, -5px -5px 10px #ffffff;
        }
        /* Responsiveness untuk tabel */
        .table-responsive {
            overflow-x: auto;
        }
    </style>
@endpush

@section('content')
<div class="p-6 md:p-8 lg:p-10 bg-gray-100 min-h-screen"> {{-- Tambahkan bg-gray-100 dan min-h-screen --}}
    <div class="text-center mb-6 animate__animated animate__fadeInDown">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Manajemen Rawat Inap</h2>
        <p class="text-gray-600 text-base md:text-lg">Tinjau dan proses pendaftaran rawat inap pasien.</p>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Sukses!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="neumo-card-small p-6 rounded-xl shadow-md"> {{-- Tambahkan rounded-xl dan shadow-md --}}
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Daftar Permintaan Rawat Inap</h3>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-nowrap">ID Permintaan</th>
                        <th scope="col">Nama Pasien</th>
                        <th scope="col">Rumah Sakit</th>
                        <th scope="col" class="text-nowrap">Tanggal Pengajuan</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ruangan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rawatInapRequests as $request)
                        <tr>
                            <td class="text-nowrap">RI{{ str_pad($request->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="text-nowrap">{{ $request->user->name ?? $request->patient_name }}</td> {{-- Ambil dari relasi user atau fallback ke patient_name --}}
                            <td class="text-nowrap">{{ $request->hospital_name }}</td>
                            <td class="text-nowrap">{{ $request->created_at->format('Y-m-d') }}</td>
                            <td>
                                {{-- Menggunakan fungsi translateStatus dari controller --}}
                                <span class="badge badge-{{ $request->status }}">
                                    {{ $translateStatus($request->status) }}
                                </span>
                            </td>
                            <td>{{ $request->room_number ?? 'Belum Ditentukan' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    {{-- Tombol Lihat Detail --}}
                                    <a href="{{ route('pegawai.rawat-inap.show', $request->id) }}" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                        <i class="fa-solid fa-eye"></i> <span class="d-none d-md-inline">Lihat</span>
                                    </a>

                                    {{-- Tombol Proses (Hanya jika status pending) --}}
                                    @if ($request->status === 'pending')
                                        <button type="button" class="btn btn-sm btn-success" title="Proses"
                                                data-bs-toggle="modal" data-bs-target="#processModal"
                                                data-id="{{ $request->id }}"
                                                data-patient-name="{{ $request->user->name ?? $request->patient_name }}"
                                                data-current-status="{{ $translateStatus($request->status) }}"
                                                data-reason="{{ $request->reason }}">
                                            <i class="fa-solid fa-check"></i> <span class="d-none d-md-inline">Proses</span>
                                        </button>
                                    @endif

                                    {{-- Tombol Atur Ruangan (Hanya jika status approved) --}}
                                    @if ($request->status === 'approved' && !$request->room_number)
                                        <button type="button" class="btn btn-sm btn-primary" title="Atur Ruangan"
                                                data-bs-toggle="modal" data-bs-target="#assignRoomModal"
                                                data-id="{{ $request->id }}"
                                                data-patient-name="{{ $request->user->name ?? $request->patient_name }}"
                                                data-current-room="{{ $request->room_number }}">
                                            <i class="fa-solid fa-bed"></i> <span class="d-none d-md-inline">Atur Ruangan</span>
                                        </button>
                                    @endif

                                    {{-- Tombol Discharge (Hanya jika status admitted) --}}
                                    @if ($request->status === 'admitted')
                                        <button type="button" class="btn btn-sm btn-secondary" title="Selesai/Discharge"
                                                data-bs-toggle="modal" data-bs-target="#dischargeModal"
                                                data-id="{{ $request->id }}"
                                                data-patient-name="{{ $request->user->name ?? $request->patient_name }}">
                                            <i class="fa-solid fa-hospital-user"></i> <span class="d-none d-md-inline">Discharge</span>
                                        </button>
                                    @endif

                                    {{-- Tombol Batalkan (Jika status pending atau approved) --}}
                                    @if ($request->status === 'pending' || $request->status === 'approved')
                                        <button type="button" class="btn btn-sm btn-danger" title="Batalkan"
                                                data-bs-toggle="modal" data-bs-target="#cancelModal"
                                                data-id="{{ $request->id }}"
                                                data-patient-name="{{ $request->user->name ?? $request->patient_name }}">
                                            <i class="fa-solid fa-times"></i> <span class="d-none d-md-inline">Batalkan</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Tidak ada permintaan rawat inap yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $rawatInapRequests->links('vendor.pagination.bootstrap-5') }} {{-- Pastikan Anda sudah menjalankan php artisan vendor:publish --tag=laravel-pagination --}}
        </div>
    </div>
</div>

{{-- Modals for Actions --}}

<div class="modal fade" id="processModal" tabindex="-1" aria-labelledby="processModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="processModalLabel">Proses Permintaan Rawat Inap</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="processForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <p>Memproses permintaan dari: <strong id="modal-patient-name"></strong></p>
                    <p>Status saat ini: <strong id="modal-current-status"></strong></p>
                    <p>Alasan pengajuan: <em id="modal-reason"></em></p>
                    <div class="mb-3">
                        <label for="statusSelect" class="form-label">Ubah Status Menjadi:</label>
                        <select class="form-select" id="statusSelect" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="approved">Disetujui</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan (Opsional):</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Tambahkan catatan untuk pasien atau internal"></textarea>
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignRoomModalLabel">Atur Nomor Ruangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="assignRoomForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <p>Menugaskan ruangan untuk: <strong id="assign-room-patient-name"></strong></p>
                    <div class="mb-3">
                        <label for="room_number" class="form-label">Nomor Ruangan:</label>
                        <input type="text" class="form-control" id="room_number" name="room_number" required placeholder="Contoh: 101A, ICU-2, dll.">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="dischargeModal" tabindex="-1" aria-labelledby="dischargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dischargeModalLabel">Discharge Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="dischargeForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <p>Anda yakin ingin melakukan discharge pasien <strong id="discharge-patient-name"></strong>? Ini akan mengubah status menjadi 'Selesai Dirawat'.</p>
                    <input type="hidden" name="status" value="discharged"> {{-- Misal status baru 'discharged' --}}
                    <div class="mb-3">
                        <label for="discharge_notes" class="form-label">Catatan Discharge (Opsional):</label>
                        <textarea class="form-control" id="discharge_notes" name="notes" rows="3" placeholder="Tambahkan catatan discharge"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Konfirmasi Discharge</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Batalkan Permintaan Rawat Inap</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="cancelForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <p>Anda yakin ingin membatalkan permintaan rawat inap dari <strong id="cancel-patient-name"></strong>?</p>
                    <input type="hidden" name="status" value="cancelled">
                    <div class="mb-3">
                        <label for="cancel_notes" class="form-label">Alasan Pembatalan (Opsional):</label>
                        <textarea class="form-control" id="cancel_notes" name="notes" rows="3" placeholder="Jelaskan alasan pembatalan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Batalkan Permintaan</button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal Proses Listener
        const processModal = document.getElementById('processModal');
        processModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const patientName = button.getAttribute('data-patient-name');
            const currentStatus = button.getAttribute('data-current-status');
            const reason = button.getAttribute('data-reason');

            const modalPatientName = processModal.querySelector('#modal-patient-name');
            const modalCurrentStatus = processModal.querySelector('#modal-current-status');
            const modalReason = processModal.querySelector('#modal-reason');
            const processForm = processModal.querySelector('#processForm');

            modalPatientName.textContent = patientName;
            modalCurrentStatus.textContent = currentStatus;
            modalReason.textContent = reason;
            processForm.action = `/pegawai/rawat-inap/${id}/update-status`; // Update form action URL
        });

        // Modal Atur Ruangan Listener
        const assignRoomModal = document.getElementById('assignRoomModal');
        assignRoomModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const patientName = button.getAttribute('data-patient-name');
            const currentRoom = button.getAttribute('data-current-room');

            const assignRoomPatientName = assignRoomModal.querySelector('#assign-room-patient-name');
            const roomNumberInput = assignRoomModal.querySelector('#room_number');
            const assignRoomForm = assignRoomModal.querySelector('#assignRoomForm');

            assignRoomPatientName.textContent = patientName;
            roomNumberInput.value = currentRoom === 'Belum Ditentukan' ? '' : currentRoom; // Isi jika sudah ada
            assignRoomForm.action = `/pegawai/rawat-inap/${id}/assign-room`;
        });

        // Modal Discharge Listener
        const dischargeModal = document.getElementById('dischargeModal');
        dischargeModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const patientName = button.getAttribute('data-patient-name');

            const dischargePatientName = dischargeModal.querySelector('#discharge-patient-name');
            const dischargeForm = dischargeModal.querySelector('#dischargeForm');

            dischargePatientName.textContent = patientName;
            dischargeForm.action = `/pegawai/rawat-inap/${id}/update-status`; // Ubah status menjadi 'discharged'
        });

        // Modal Batalkan Listener
        const cancelModal = document.getElementById('cancelModal');
        cancelModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const patientName = button.getAttribute('data-patient-name');

            const cancelPatientName = cancelModal.querySelector('#cancel-patient-name');
            const cancelForm = cancelModal.querySelector('#cancelForm');

            cancelPatientName.textContent = patientName;
            cancelForm.action = `/pegawai/rawat-inap/${id}/update-status`; // Ubah status menjadi 'cancelled'
        });
    });
</script>
@endpush
@endsection
