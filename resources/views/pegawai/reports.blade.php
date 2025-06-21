@extends('layouts.template-pegawai')

@section('title', 'Statistik & Laporan')
@section('page-title', 'Statistik dan Laporan Rumah Sakit')

@section('content')
<div class="p-6 md:p-8 lg:p-10">
    <div class="text-center mb-6 animate__animated animate__fadeInDown">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Statistik & Laporan</h2>
        <p class="text-gray-600 text-base md:text-lg">Lihat ringkasan operasional dan laporan mendalam rumah sakit Anda.</p>
    </div>

    <div class="neumo-card-small p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Ringkasan Statistik</h3>
        <p class="text-gray-700 mb-4">
            Bagian ini akan menampilkan grafik interaktif dan ringkasan data penting, seperti:
        </p>
        <ul class="list-disc list-inside text-gray-600 mb-6">
            <li>Jumlah Konsultasi per bulan</li>
            <li>Status Rawat Inap (tersedia/terisi)</li>
            <li>Tren permintaan Layanan Ambulans</li>
            <li>Distribusi jenis Tes Lab</li>
            <li>Jumlah resep yang diterbitkan</li>
        </ul>

        <div class="row g-4 mb-6">
            <div class="col-md-6 col-lg-4">
                <div class="neumo-card-small p-4 text-center">
                    <i class="fa-solid fa-users text-4xl text-blue-600 mb-3"></i>
                    <h4 class="text-2xl font-bold text-gray-900">1,200</h4>
                    <p class="text-gray-600">Total Pasien Terdaftar</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="neumo-card-small p-4 text-center">
                    <i class="fa-solid fa-notes-medical text-4xl text-green-600 mb-3"></i>
                    <h4 class="text-2xl font-bold text-gray-900">350</h4>
                    <p class="text-gray-600">Konsultasi Bulan Ini</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="neumo-card-small p-4 text-center">
                    <i class="fa-solid fa-bed-pulse text-4xl text-purple-600 mb-3"></i>
                    <h4 class="text-2xl font-bold text-gray-900">45 / 60</h4>
                    <p class="text-gray-600">Kamar Rawat Inap Terisi</p>
                </div>
            </div>
        </div>

        <h3 class="text-xl font-semibold text-gray-900 mb-4">Laporan Detil</h3>
        <p class="text-gray-700">
            Di sini Anda dapat menemukan opsi untuk mengunduh laporan periodik atau membuat laporan kustom.
        </p>
        <div class="d-flex flex-wrap gap-3 mt-4">
            <button class="btn-custom-primary">
                <i class="fa-solid fa-file-pdf me-2"></i> Unduh Laporan Bulanan
            </button>
            <button class="btn-custom-primary">
                <i class="fa-solid fa-chart-pie me-2"></i> Laporan Kinerja Dokter
            </button>
            <button class="btn-custom-primary">
                <i class="fa-solid fa-calendar-alt me-2"></i> Laporan Penggunaan Layanan
            </button>
        </div>
    </div>
</div>
@endsection
