@extends('layouts.template-pegawai') {{-- Pastikan ini mengacu pada layout untuk pegawai --}}

@section('title', 'Detail Konsultasi')
@section('page-title', 'Detail Permintaan Konsultasi')

@section('content')
<div class="p-6 md:p-8 lg:p-10">
    <div class="text-center mb-6 animate__animated animate__fadeInDown">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Detail Konsultasi</h2>
        <p class="text-gray-600 text-base md:text-lg">Tinjau detail konsultasi dan perbarui statusnya.</p>
    </div>

    <div class="neumo-card-small p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Informasi Konsultasi #{{ $consultation->id }}</h3>

        {{-- Bagian Informasi Konsultasi --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Pasien:</strong> {{ $consultation->user->name ?? 'N/A' }}</p>
                <p><strong>Email Pasien:</strong> {{ $consultation->user->email ?? 'N/A' }}</p>
                <p><strong>Subjek:</strong> {{ $consultation->subject }}</p>
                <p><strong>Tanggal Pengajuan:</strong> {{ $consultation->created_at->format('d-m-Y H:i') }}</p>
                <p><strong>Tanggal Konsultasi Dijadwalkan:</strong> {{ $consultation->consultation_date->format('d-m-Y H:i') }}</p>
                <p><strong>Status Saat Ini:</strong> <span class="{{ $consultation->status_badge_class }}">{{ ucfirst(str_replace('_', ' ', $consultation->status)) }}</span></p>
            </div>
            <div class="col-md-6">
                <p><strong>Dokter Ditugaskan:</strong> {{ $consultation->doctor->name ?? 'Belum Ditugaskan' }}</p>
                <p><strong>Catatan Awal Pasien:</strong></p>
                <p class="border p-3 rounded bg-gray-50">{{ $consultation->notes ?? '-' }}</p>
                <p><strong>Deskripsi Detail Keluhan:</strong></p>
                <p class="border p-3 rounded bg-gray-50">{{ $consultation->description ?? '-' }}</p>
                @if ($consultation->response)
                    <p><strong>Tanggapan/Hasil Konsultasi:</strong></p>
                    <p class="border p-3 rounded bg-gray-50">{{ $consultation->response }}</p>
                @endif
            </div>
        </div>

        <hr class="my-4">

        {{-- Form Perbarui Status Konsultasi --}}
        <h4 class="text-lg font-semibold text-gray-800 mb-3">Perbarui Status Konsultasi</h4>
        <form action="{{ route('pegawai.consultations.update', $consultation->id) }}" method="POST">
            @csrf
            @method('PATCH') {{-- Menggunakan method PATCH untuk update --}}

            {{-- Pilihan Status --}}
            <div class="mb-3">
                <label for="status" class="form-label">Status Baru:</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="pending" {{ $consultation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ $consultation->status == 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                    <option value="completed" {{ $consultation->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ $consultation->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    <option value="approved" {{ $consultation->status == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ $consultation->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Field untuk Menugaskan Dokter (akan disembunyikan/ditampilkan berdasarkan status) --}}
            <div class="mb-3" id="doctor-assign-field" style="{{ ($consultation->status == 'pending' || $consultation->status == 'cancelled' || $consultation->status == 'rejected') ? 'display: none;' : '' }}">
                <label for="doctor_id" class="form-label">Tugaskan Dokter (Opsional):</label>
                <select class="form-select @error('doctor_id') is-invalid @enderror" id="doctor_id" name="doctor_id">
                    <option value="">Pilih Dokter</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ $consultation->doctor_id == $doctor->id ? 'selected' : '' }}>
                            Dr. {{ $doctor->name }} ({{ $doctor->specialty }})
                        </option>
                    @endforeach
                </select>
                @error('doctor_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Textarea untuk Tanggapan/Hasil Konsultasi --}}
            <div class="mb-3">
                <label for="response" class="form-label">Tanggapan/Hasil Konsultasi (Opsional):</label>
                <textarea class="form-control @error('response') is-invalid @enderror" id="response" name="response" rows="4">{{ old('response', $consultation->response) }}</textarea>
                @error('response')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-custom-primary">Perbarui Konsultasi</button>
                <a href="{{ route('pegawai.consultations.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status');
        const doctorAssignField = document.getElementById('doctor-assign-field');
        const doctorIdSelect = document.getElementById('doctor_id'); // Dapatkan elemen select doctor_id

        function toggleDoctorAssignField() {
            const selectedStatus = statusSelect.value;
            // Tampilkan field dokter jika status adalah 'in_progress', 'completed', atau 'approved'
            if (selectedStatus === 'in_progress' || selectedStatus === 'completed' || selectedStatus === 'approved') {
                doctorAssignField.style.display = 'block';
            } else {
                doctorAssignField.style.display = 'none';
                doctorIdSelect.value = ''; // Reset pilihan dokter jika field disembunyikan
            }
        }

        // Panggil saat halaman dimuat untuk mengatur visibilitas awal
        toggleDoctorAssignField();

        // Panggil saat status konsultasi berubah
        statusSelect.addEventListener('change', toggleDoctorAssignField);
    });
</script>
@endpush
@endsection
