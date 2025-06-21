@extends('layouts.app')

@section('title', 'Konsul Dokter')
@section('page-title', 'Konsultasi Dokter')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-4">Halaman Konsultasi Dokter</h2>
        {{-- Menampilkan pesan sukses atau error --}}
        @if (session('success'))
            <div class="bg-green-500 text-white p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('consultations.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="doctor_id" class="form-label">Pilih Dokter</label>
                <select class="form-select" id="doctor_id" name="doctor_id" required>
                    <option value="">-- Pilih Dokter --</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                    @endforeach
                </select>
                @error('doctor_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="notes" class="block text-sm font-medium text-gray-700">Catatan/Pesan Konsultasi</label>
                <textarea name="notes" id="notes" class="form-textarea mt-1 block w-full @error('notes') border-red-500 @enderror"
                    rows="5">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="consultation_date" class="block text-sm font-medium text-gray-700">Jadwal Konsultasi</label>
                <input type="datetime-local" name="consultation_date" id="consultation_date"
                    class="form-input mt-1 block w-full @error('consultation_date') border-red-500 @enderror"
                    value="{{ old('consultation_date') }}" required>
                @error('consultation_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700">Jadwalkan
                Konsultasi</button>
        </form>
    </div>
@endsection
