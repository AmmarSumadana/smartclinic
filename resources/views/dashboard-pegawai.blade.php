@extends('layouts.template-pegawai') {{-- Using the new layout --}}

@section('title', 'Pegawai Dashboard SmartClinic')
@section('page-title', 'Welcome to SmartClinic')

{{-- @push('head') and <style> section REMOVED because handled by layouts/template-pegawai --}}
{{-- If you need specific styles, add them in the layout or use a dedicated CSS file --}}

@section('content')
<div class="p-6 md:p-8 lg:p-10"> {{-- Removed bg-gray-100 and min-h-screen as handled by layout --}}
    <div class="text-center mb-6 animate__animated animate__fadeInDown">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Hospital Dashboard</h2>
        <p class="text-gray-600 text-base md:text-lg">Welcome back, {{ Auth::user()->name }}! Manage hospital data and services here.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="neumo-card-small p-6 animate__animated animate__fadeInUp">
            <div class="flex items-center gap-4 mb-4">
                {{-- ICON COLOR CHANGED TO RED --}}
                <div class="icon-circle bg-red-600">
                    <i class="fa-solid fa-comments"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Total Konsultasi</h3>
            </div>
            <p class="text-gray-600 text-sm mb-4">Jumlah total konsultasi yang tercatat.</p>
            {{-- Pastikan variabel $totalConsultations dikirim dari controller --}}
            <div class="text-4xl font-bold text-blue-800">{{ $totalConsultations ?? 'N/A' }}</div>
            <a href="{{ route('pegawai.consultations.index') }}" class="btn-custom-primary mt-4 block text-center">
                <i class="fa-solid fa-arrow-right me-2"></i> Lihat Konsultasi
            </a>
        </div>

        <div class="neumo-card-small p-6 animate__animated animate__fadeInUp animate__delay-0-5s">
            <div class="flex items-center gap-4 mb-4">
                {{-- ICON COLOR CHANGED TO RED --}}
                <div class="icon-circle bg-red-600">
                    <i class="fa-solid fa-bed-pulse"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Pasien Rawat Inap Aktif</h3>
            </div>
            <p class="text-gray-600 text-sm mb-4">Jumlah pasien yang sedang dirawat inap saat ini.</p>
            {{-- Pastikan variabel $totalRawatInap dikirim dari controller --}}
            <div class="text-4xl font-bold text-green-800">{{ $totalRawatInap ?? 'N/A' }}</div>
            <a href="{{ route('pegawai.rawat-inap.index') }}" class="btn-custom-primary mt-4 block text-center">
                <i class="fa-solid fa-arrow-right me-2"></i> Lihat Rawat Inap
            </a>
        </div>

        <div class="neumo-card-small p-6 animate__animated animate__fadeInUp animate__delay-1s">
            <div class="flex items-center gap-4 mb-4">
                {{-- ICON COLOR IS ALREADY RED --}}
                <div class="icon-circle bg-red-600">
                    <i class="fa-solid fa-users"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Total Data Pasien</h3>
            </div>
            <p class="text-gray-600 text-sm mb-4">Jumlah total pasien yang terdaftar di sistem.</p>
            {{-- Pastikan variabel $totalPatients dikirim dari controller --}}
            <div class="text-4xl font-bold text-red-800">{{ $totalPatients ?? 'N/A' }}</div>
            <a href="{{ route('pegawai.patients.index') }}" class="btn-custom-primary mt-4 block text-center">
                <i class="fa-solid fa-arrow-right me-2"></i> Kelola Pasien
            </a>
        </div>

        {{-- Semua kartu lain yang sebelumnya ada di sini telah dihapus --}}
    </div>
</div>
@endsection
