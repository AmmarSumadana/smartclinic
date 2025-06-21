@extends('layouts.app')

@section('title', 'Konsul Dokter')
@section('page-title', 'Konsultasi Dokter')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-4">Halaman Konsultasi Dokter</h2>
        <form action="{{ route('consultations.store') }}" method="POST"> <!-- Perbaiki rute di sini -->
            @csrf
            <div class="mb-4">
                <label for="doctor_id" class="block text-sm font-medium text-gray-700">Pilih Dokter</label>
                <select name="doctor_id" id="doctor_id" class="form-select mt-1 block w-full">
                    <option value="">-- Pilih Dokter --</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }} - {{ $doctor->specialization }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="notes" class="block text-sm font-medium text-gray-700">Catatan</label>
                <textarea name="notes" id="notes" class="form-textarea mt-1 block w-full" rows="3" required></textarea>
            </div>

            <div class="mb-4">
                <label for="consultation_date" class="block text-sm font-medium text-gray-700">Jadwal Konsultasi</label>
                <input type="datetime-local" name="consultation_date" id="consultation_date"
                    class="form-input mt-1 block w-full" required>
            </div>

            <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700">Konsultasi</button>
        </form>


    </div>
@endsection
