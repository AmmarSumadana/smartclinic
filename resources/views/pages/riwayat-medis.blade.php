@extends('layouts.app')

@section('title', 'Riwayat Medis')
@section('page-title', 'Riwayat Medis')

@push('head')
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Animate.css untuk animasi -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    {{-- Asumsi Tailwind CSS sudah dimuat di layouts/app.blade.php --}}

    <style>
        /* Gaya tambahan untuk loading spinner di tengah modal */
        .loading-spinner {
            border: 4px solid #f3f3f3; /* Light grey */
            border-top: 4px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Mengatur background body dan main content wrapper menjadi abu-abu terang */
        body {
            background-color: #f0f2f5; /* Sesuai dengan --neumo-bg sebelumnya */
            font-family: 'Roboto', sans-serif;
            color: #343a40;
        }
        .bg-gray-100.min-h-screen {
            background-color: #f0f2f5 !important; /* Memastikan konsistensi background */
        }

        /* Gaya untuk card agar konsisten putih */
        .card-white {
            background-color: #ffffff; /* White background */
            border-radius: 0.75rem; /* rounded-xl */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* shadow-md */
            transition: all 0.2s ease-in-out;
        }
        .card-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* shadow-lg */
        }
    </style>
@endpush

@section('content')
    <div class="p-6 md:p-8 lg:p-10 bg-gray-100 min-h-screen">
        <div class="text-center mb-6 animate__animated animate__fadeInDown">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Riwayat Medis Anda</h2>
            <p class="text-gray-600 text-base md:text-lg">Daftar lengkap catatan kesehatan dan riwayat pemeriksaan Anda.</p>
        </div>

        <div class="max-w-4xl mx-auto">
            @php
                use Carbon\Carbon; // Pastikan ini ada di sini untuk format tanggal
            @endphp

            @if(count($allMedicalRecords) > 0)
                <div class="space-y-6">
                    @foreach($allMedicalRecords as $record)
                        <div class="card-white p-6 animate__animated animate__fadeInUp">
                            <div class="flex items-center justify-between mb-3">
                                {{-- Mengakses properti objek Eloquent atau collection --}}
                                <h3 class="text-lg md:text-xl font-semibold text-gray-900">
                                    {{
                                        Carbon::parse(
                                            $record->test_date ?? // Untuk Tes Lab
                                            $record->date ?? // Untuk Konsultasi, Cek Medis, Rawat Inap
                                            $record->created_at // Default jika kolom tanggal spesifik tidak ada
                                        )->translatedFormat('d F Y')
                                    }}
                                </h3>
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm font-medium rounded-full">
                                    {{ $record->type_category }}
                                </span>
                            </div>
                            <div>
                                @switch($record->type_category)
                                    @case('Tes Lab')
                                        <p class="text-gray-700 mb-2">
                                            <i class="fa-solid fa-flask text-red-600 me-2"></i>
                                            <span class="font-semibold">Nama Tes:</span> {{ $record->test_name }}
                                        </p>
                                        <p class="text-gray-700 mb-2">
                                            <i class="fa-solid fa-vial text-red-600 me-2"></i>
                                            <span class="font-semibold">Hasil:</span> {{ $record->result }}
                                        </p>
                                        <p class="text-gray-700 mb-0 text-sm italic">
                                            <i class="fa-solid fa-hospital text-gray-500 me-2"></i>
                                            Lab: {{ $record->lab_name ?? 'N/A' }} - Catatan: {{ $record->notes ?? 'Tidak ada' }}
                                        </p>
                                        @break

                                    @case('Cek Medis')
                                        <p class="text-gray-700 mb-2">
                                            <i class="fa-solid fa-heart-pulse text-red-600 me-2"></i>
                                            <span class="font-semibold">Nama Pasien:</span> {{ $record->nama }}
                                        </p>
                                        <p class="text-gray-700 mb-2">
                                            <i class="fa-solid fa-notes-medical text-red-600 me-2"></i>
                                            <span class="font-semibold">Gejala:</span> {{ $record->gejala ?? 'Tidak disebutkan' }}
                                        </p>
                                        <p class="text-gray-700 mb-2">
                                            <i class="fa-solid fa-user-doctor text-red-600 me-2"></i>
                                            <span class="font-semibold">Rumah Sakit:</span> {{ $record->hospital->nama ?? 'Tidak diketahui' }}
                                        </p>
                                        <p class="text-gray-700 mb-0 text-sm italic">
                                            <i class="fa-solid fa-info-circle text-gray-500 me-2"></i>
                                            Paket: {{ $record->paket }} - Jadwal: {{ Carbon::parse($record->jadwal_tanggal)->translatedFormat('d M Y') }} pukul {{ $record->jadwal_jam }}
                                        </p>
                                        @break

                                    @case('Pembelian Obat')
                                        <p class="text-gray-700 mb-2">
                                            <i class="fa-solid fa-pills text-red-600 me-2"></i>
                                            <span class="font-semibold">Obat:</span> {{ $record->medicine_name }}
                                        </p>
                                        <p class="text-gray-700 mb-2">
                                            <i class="fa-solid fa-boxes-stacked text-red-600 me-2"></i>
                                            <span class="font-semibold">Dosis & Jumlah:</span> {{ $record->dosage ?? 'N/A' }}, {{ $record->quantity }} unit
                                        </p>
                                        <p class="text-gray-700 mb-0 text-sm italic">
                                            <i class="fa-solid fa-shop text-gray-500 me-2"></i>
                                            Apotek: {{ $record->pharmacy ?? 'Tidak diketahui' }} - Total: Rp{{ number_format($record->price, 0, ',', '.') }} - Catatan: {{ $record->notes ?? 'Tidak ada' }}
                                        </p>
                                        @break

                                    @case('Rawat Inap')
                                        <p class="text-gray-700 mb-2">
                                            <i class="fa-solid fa-hospital-user text-red-600 me-2"></i>
                                            <span class="font-semibold">Rumah Sakit:</span> {{ $record->hospital_name }}
                                        </p>
                                        <p class="text-gray-700 mb-2">
                                            <i class="fa-solid fa-stethoscope text-red-600 me-2"></i>
                                            <span class="font-semibold">Diagnosa:</span> {{ $record->diagnosis ?? 'N/A' }}
                                        </p>
                                        <p class="text-gray-700 mb-0 text-sm italic">
                                            <i class="fa-solid fa-calendar-alt text-gray-500 me-2"></i>
                                            Masuk: {{ Carbon::parse($record->admission_date)->translatedFormat('d M Y') }}
                                            @if($record->discharge_date)
                                            - Pulang: {{ Carbon::parse($record->discharge_date)->translatedFormat('d M Y') }}
                                            @endif
                                            - Dokter: {{ $record->doctor_in_charge ?? 'N/A' }}
                                        </p>
                                        @break

                                    @case('Konsultasi Dokter')
                                        <p class="text-gray-700 mb-2">
                                            <i class="fa-solid fa-user-md text-red-600 me-2"></i>
                                            <span class="font-semibold">Dokter:</span> {{ $record->doctor_name }} ({{ $record->specialty ?? 'N/A' }})
                                        </p>
                                        <p class="text-gray-700 mb-2">
                                            <i class="fa-solid fa-notes-medical text-red-600 me-2"></i>
                                            <span class="font-semibold">Diagnosa:</span> {{ $record->diagnosis }}
                                        </p>
                                        <p class="text-gray-700 mb-0 text-sm italic">
                                            <i class="fa-solid fa-comment-medical text-gray-500 me-2"></i>
                                            Catatan: {{ $record->notes ?? 'Tidak ada' }}
                                        </p>
                                        @break

                                    @default
                                        <p class="text-gray-700 mb-0">Detail tidak tersedia.</p>
                                @endswitch
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card-white p-6 text-center animate__animated animate__fadeInUp">
                    <i class="fa-solid fa-folder-open text-gray-400 text-5xl mb-4"></i>
                    <p class="text-gray-600 text-lg">Tidak ada riwayat medis yang tersedia saat ini.</p>
                    <p class="text-gray-500">Mulai catat riwayat kesehatan Anda di sini!</p>
                </div>
            @endif
        </div>
    </div>
@endsection
