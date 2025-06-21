{{-- resources/views/pages/konsul-dokter/konsul-dokter.blade.php --}}

@extends('layouts.app') {{-- Ganti dengan nama layout utama Anda, contoh: layouts.app, layouts.master, dll. --}}

@section('content')
<div class="container-fluid"> {{-- Atau .container jika ingin lebar terbatas --}}
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Jadwalkan Konsultasi Baru</h5>
        </div>
        <div class="card-body">
            {{-- Bagian untuk menampilkan pesan sukses/error --}}
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

            <form action="{{ route('consultations.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="doctor_id" class="form-label">Pilih Dokter</label>
                    <select class="form-select @error('doctor_id') is-invalid @enderror" id="doctor_id" name="doctor_id" required>
                        <option value="">-- Pilih Dokter --</option>
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->name }} ({{ $doctor->specialty ?? 'Umum' }}) {{-- Tampilkan nama dan spesialisasi dokter --}}
                            </option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">Catatan/Pesan Konsultasi (Opsional)</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="consultation_date" class="form-label">Jadwal Konsultasi</label>
                    <input type="datetime-local" class="form-control @error('consultation_date') is-invalid @enderror" id="consultation_date" name="consultation_date" value="{{ old('consultation_date') }}" required>
                    @error('consultation_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Jadwalkan Konsultasi</button>
                <a href="{{ route('consultations.index') }}" class="btn btn-secondary">Lihat Riwayat Konsultasi</a>
            </form>
        </div>
    </div>
</div>
@endsection
