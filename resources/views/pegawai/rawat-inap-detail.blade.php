@extends('layouts.template-pegawai')

@section('title', 'Detail Permintaan Rawat Inap')
@section('page-title', 'Detail Permintaan Rawat Inap')

@push('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .neumo-card {
            background-color: #ecf0f3;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 8px 8px 15px #cbced1, -8px -8px 15px #ffffff;
        }
        .neumo-input {
            background-color: #ecf0f3;
            border: none;
            border-radius: 10px;
            padding: 10px 15px;
            box-shadow: inset 2px 2px 5px #babecc, inset -5px -5px 10px #ffffff;
        }
        .neumo-button {
            background-color: #ecf0f3;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            box-shadow: 3px 3px 6px #b8b9be, -3px -3px 6px #ffffff;
            transition: all 0.2s ease-in-out;
        }
        .neumo-button:hover {
            box-shadow: 2px 2px 5px #b8b9be, -2px -2px 5px #ffffff;
        }
        .neumo-button:active {
            box-shadow: inset 2px 2px 5px #b8b9be, inset -5px -5px 10px #ffffff;
        }
        .file-preview-image {
            max-width: 100%;
            height: auto;
            max-height: 200px; /* Batasi tinggi preview */
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .file-icon {
            font-size: 3rem;
            color: #6c757d;
        }
        .badge-pending { background-color: #6c757d; color: white; }
        .badge-approved { background-color: #28a745; color: white; }
        .badge-admitted { background-color: #007bff; color: white; }
        .badge-rejected { background-color: #dc3545; color: white; }
        .badge-cancelled { background-color: #ffc107; color: #212529; }
        .badge-discharged { background-color: #6f42c1; color: white; } /* Tambahan status discharge */
    </style>
@endpush

@section('content')
<div class="p-6 md:p-8 lg:p-10 bg-gray-100 min-h-screen">
    <div class="text-center mb-6 animate__animated animate__fadeInDown">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Detail Permintaan Rawat Inap</h2>
        <p class="text-gray-600 text-base md:text-lg">Tinjau informasi lengkap dan dokumen pendukung.</p>
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

    <div class="neumo-card p-6 rounded-xl shadow-md mb-6">
        <div class="flex justify-between items-center mb-4 border-b pb-3">
            <h3 class="text-2xl font-bold text-gray-900">Permintaan #RI{{ str_pad($rawatInap->id, 3, '0', STR_PAD_LEFT) }}</h3>
            <span class="badge badge-{{ $rawatInap->status }} text-lg font-bold">
                {{ $translateStatus($rawatInap->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h4 class="text-lg font-semibold text-gray-800 mb-2">Informasi Pasien</h4>
                <p><strong>Nama Pasien:</strong> {{ $rawatInap->user->name ?? $rawatInap->patient_name }}</p>
                <p><strong>Email Pasien:</strong> {{ $rawatInap->user->email ?? 'N/A' }}</p>
                <p><strong>Nomor Telepon:</strong> {{ $rawatInap->user->phone_number ?? 'N/A' }}</p> {{-- Asumsi ada kolom phone_number di tabel users --}}
            </div>
            <div>
                <h4 class="text-lg font-semibold text-gray-800 mb-2">Detail Permintaan</h4>
                <p><strong>Rumah Sakit Tujuan:</strong> {{ $rawatInap->hospital_name }}</p>
                <p><strong>Tanggal Pengajuan:</strong> {{ $rawatInap->created_at->format('d M Y H:i') }}</p>
                <p><strong>Tanggal Masuk Diinginkan:</strong> {{ $rawatInap->admission_date->format('d M Y') }}</p>
                <p><strong>Alasan Rawat Inap:</strong> {{ $rawatInap->reason }}</p>
                <p><strong>Nomor Ruangan:</strong> {{ $rawatInap->room_number ?? 'Belum Ditentukan' }}</p>
                <p><strong>Catatan Pegawai:</strong> {{ $rawatInap->notes ?? 'Tidak ada catatan.' }}</p>
            </div>
        </div>

        <h4 class="text-lg font-semibold text-gray-800 mb-3 border-t pt-4">Dokumen Pendukung</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="font-medium text-gray-700 mb-2">Scan KTP/Identitas:</p>
                @if ($rawatInap->ktp_file)
                    @if (in_array(pathinfo($rawatInap->ktp_file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                        <img src="{{ Storage::url($rawatInap->ktp_file) }}" alt="KTP Preview" class="file-preview-image">
                    @else
                        <i class="fa-solid fa-file-pdf file-icon d-block text-center mb-2"></i>
                    @endif
                    <a href="{{ Storage::url($rawatInap->ktp_file) }}" target="_blank" class="btn btn-sm btn-info text-white mt-2">
                        <i class="fa-solid fa-download me-1"></i> Lihat/Download KTP
                    </a>
                @else
                    <p class="text-gray-500">Tidak ada file KTP.</p>
                @endif
            </div>
            <div>
                <p class="font-medium text-gray-700 mb-2">Surat Pengantar Dokter:</p>
                @if ($rawatInap->surat_pengantar_file)
                    @if (in_array(pathinfo($rawatInap->surat_pengantar_file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                        <img src="{{ Storage::url($rawatInap->surat_pengantar_file) }}" alt="Surat Pengantar Preview" class="file-preview-image">
                    @else
                        <i class="fa-solid fa-file-pdf file-icon d-block text-center mb-2"></i>
                    @endif
                    <a href="{{ Storage::url($rawatInap->surat_pengantar_file) }}" target="_blank" class="btn btn-sm btn-info text-white mt-2">
                        <i class="fa-solid fa-download me-1"></i> Lihat/Download Surat Pengantar
                    </a>
                @else
                    <p class="text-gray-500">Tidak ada file Surat Pengantar.</p>
                @endif
            </div>
            <div>
                <p class="font-medium text-gray-700 mb-2">Scan Kartu Asuransi/BPJS (Opsional):</p>
                @if ($rawatInap->kartu_asuransi_file)
                    @if (in_array(pathinfo($rawatInap->kartu_asuransi_file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                        <img src="{{ Storage::url($rawatInap->kartu_asuransi_file) }}" alt="Kartu Asuransi Preview" class="file-preview-image">
                    @else
                        <i class="fa-solid fa-file-pdf file-icon d-block text-center mb-2"></i>
                    @endif
                    <a href="{{ Storage::url($rawatInap->kartu_asuransi_file) }}" target="_blank" class="btn btn-sm btn-info text-white mt-2">
                        <i class="fa-solid fa-download me-1"></i> Lihat/Download Kartu Asuransi
                    </a>
                @else
                    <p class="text-gray-500">Tidak ada file Kartu Asuransi/BPJS.</p>
                @endif
            </div>
        </div>

        <div class="mt-8 pt-4 border-t flex justify-between items-center">
            <a href="{{ route('pegawai.rawat-inap.index') }}" class="btn btn-secondary neumo-button">
                <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Daftar
            </a>
            {{-- Tombol Aksi di halaman detail (opsional, bisa juga hanya di daftar) --}}
            <div class="d-flex gap-2">
                {{-- Tombol Proses (Hanya jika status pending) --}}
                @if ($rawatInap->status === 'pending')
                    <button type="button" class="btn btn-sm btn-success" title="Proses"
                            data-bs-toggle="modal" data-bs-target="#processModal"
                            data-id="{{ $rawatInap->id }}"
                            data-patient-name="{{ $rawatInap->user->name ?? $rawatInap->patient_name }}"
                            data-current-status="{{ $translateStatus($rawatInap->status) }}"
                            data-reason="{{ $rawatInap->reason }}">
                        <i class="fa-solid fa-check"></i> Proses
                    </button>
                @endif

                {{-- Tombol Atur Ruangan (Hanya jika status approved dan belum ada ruangan) --}}
                @if ($rawatInap->status === 'approved' && !$rawatInap->room_number)
                    <button type="button" class="btn btn-sm btn-primary" title="Atur Ruangan"
                            data-bs-toggle="modal" data-bs-target="#assignRoomModal"
                            data-id="{{ $rawatInap->id }}"
                            data-patient-name="{{ $rawatInap->user->name ?? $rawatInap->patient_name }}"
                            data-current-room="{{ $rawatInap->room_number }}">
                        <i class="fa-solid fa-bed"></i> Atur Ruangan
                    </button>
                @endif

                {{-- Tombol Discharge (Hanya jika status admitted) --}}
                @if ($rawatInap->status === 'admitted')
                    <button type="button" class="btn btn-sm btn-secondary" title="Selesai/Discharge"
                            data-bs-toggle="modal" data-bs-target="#dischargeModal"
                            data-id="{{ $rawatInap->id }}"
                            data-patient-name="{{ $rawatInap->user->name ?? $rawatInap->patient_name }}">
                        <i class="fa-solid fa-hospital-user"></i> Discharge
                    </button>
                @endif

                {{-- Tombol Batalkan (Jika status pending atau approved atau admitted) --}}
                @if (in_array($rawatInap->status, ['pending', 'approved', 'admitted']))
                    <button type="button" class="btn btn-sm btn-danger" title="Batalkan"
                            data-bs-toggle="modal" data-bs-target="#cancelModal"
                            data-id="{{ $rawatInap->id }}"
                            data-patient-name="{{ $rawatInap->user->name ?? $rawatInap->patient_name }}">
                        <i class="fa-solid fa-times"></i> Batalkan
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Include Modals from the list view --}}
@include('pegawai.partials.rawat-inap-modals')

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Re-initialize modal listeners if they are in a partial
        // Or ensure this script block is loaded *after* the modals in the partial
        // (It's better to put modal listeners in the main script of the view)

        // Modal Proses Listener
        const processModal = document.getElementById('processModal');
        if (processModal) {
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
        }


        // Modal Atur Ruangan Listener
        const assignRoomModal = document.getElementById('assignRoomModal');
        if (assignRoomModal) {
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
        }

        // Modal Discharge Listener
        const dischargeModal = document.getElementById('dischargeModal');
        if (dischargeModal) {
            dischargeModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const patientName = button.getAttribute('data-patient-name');

                const dischargePatientName = dischargeModal.querySelector('#discharge-patient-name');
                const dischargeForm = dischargeModal.querySelector('#dischargeForm');

                dischargePatientName.textContent = patientName;
                dischargeForm.action = `/pegawai/rawat-inap/${id}/update-status`; // Ubah status menjadi 'discharged'
            });
        }

        // Modal Batalkan Listener
        const cancelModal = document.getElementById('cancelModal');
        if (cancelModal) {
            cancelModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const patientName = button.getAttribute('data-patient-name');

                const cancelPatientName = cancelModal.querySelector('#cancel-patient-name');
                const cancelForm = cancelModal.querySelector('#cancelForm');

                cancelPatientName.textContent = patientName;
                cancelForm.action = `/pegawai/rawat-inap/${id}/update-status`; // Ubah status menjadi 'cancelled'
            });
        }
    });
</script>
@endpush
@endsection
