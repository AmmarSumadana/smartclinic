{{-- resources/views/pegawai/consultations/show.blade.php --}}

@extends('layouts.template-pegawai') {{-- Atau layout khusus pegawai Anda --}}

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Detail Konsultasi #{{ $consultation->id }}</h5>
        </div>
        <div class="card-body">
            {{-- Pesan sukses/error --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Pasien:</strong> {{ $consultation->patient->name ?? 'N/A' }}</p>
                    <p><strong>Email Pasien:</strong> {{ $consultation->patient->email ?? 'N/A' }}</p>
                    <p><strong>Dokter Tujuan:</strong> {{ $consultation->doctor->name ?? 'N/A' }}</p>
                    <p><strong>Tanggal/Waktu Konsultasi:</strong> {{ $consultation->formatted_consultation_date }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Status Saat Ini:</strong>
                        <span class="badge {{
                            $consultation->status == 'pending' ? 'bg-warning' :
                            ($consultation->status == 'approved' ? 'bg-info' :
                            ($consultation->status == 'completed' ? 'bg-success' : 'bg-danger'))
                        }}">
                            {{ ucfirst($consultation->status) }}
                        </span>
                    </p>
                    <p><strong>Diproses Oleh:</strong> {{ $consultation->responder->name ?? '-' }}</p>
                    <p><strong>Tanggal Diajukan:</strong> {{ $consultation->created_at->format('d F Y, H:i') }}</p>
                </div>
            </div>

            <div class="mb-3">
                <h6>Catatan dari Pasien:</h6>
                <p class="border p-3 rounded bg-light">{{ $consultation->notes ?? '-' }}</p>
            </div>

            <hr>

            <h6>Perbarui Status Konsultasi:</h6>
            <form action="{{ route('pegawai.consultations.update-status', $consultation->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="status" class="form-label">Ubah Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="pending" {{ $consultation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $consultation->status == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ $consultation->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        <option value="completed" {{ $consultation->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="response_notes" class="form-label">Catatan Respon (Opsional)</label>
                    <textarea class="form-control @error('response_notes') is-invalid @enderror" id="response_notes" name="response_notes" rows="3">{{ old('response_notes', $consultation->response_notes) }}</textarea>
                    @error('response_notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('pegawai.consultations.index') }}" class="btn btn-secondary">Kembali ke Daftar Konsultasi</a>
            </form>
        </div>
    </div>
</div>
@endsection
