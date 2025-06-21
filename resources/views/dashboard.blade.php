@extends('layouts.app')

@section('title', 'Dashboard Pasien')
@section('page-title', 'Dashboard Pasien')

@push('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

    {{-- Custom CSS for consistency --}}
    <style>
        /* Basic styles for body and main content wrapper */
        body {
            background-color: #f0f2f5; /* Light gray background */
            font-family: 'Inter', sans-serif;
            color: #343a40;
        }

        /* Styles for chart container */
        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .chart-container canvas {
            background-color: #ffffff; /* White background for canvas */
            border-radius: 0.75rem; /* rounded-xl */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* shadow-md */
            padding: 15px;
            max-width: 100%;
            max-height: 100%;
        }

        /* Basic table styling for consistency */
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }
        .table tbody + tbody {
            border-top: 2px solid #dee2e6;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 2px;
        }
        /* Make table rows clickable or hoverable */
        .table-hover tbody tr:hover {
            color: #212529;
            background-color: rgba(0, 0, 0, 0.075);
        }

        /* Pagination styles */
        .pagination {
            display: flex;
            flex-wrap: wrap; /* Added for explicit wrapping on smaller screens */
            padding-left: 0;
            list-style: none;
            border-radius: 0.25rem;
            justify-content: center; /* Center pagination */
        }
        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }
        .page-item .page-link {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #007bff;
            background-color: #fff;
            border: 1px solid #dee2e6;
            text-decoration: none; /* Remove underline */
        }
        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        .page-item:first-child .page-link {
            border-top-left-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
        }
        .page-item:last-child .page-link {
            border-top-right-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
        }
    </style>
@endpush

@section('content')
<div class="p-6 md:p-8 lg:p-10 bg-gray-100 min-h-screen">
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4 animate__animated animate__fadeIn">
            {{ session('success') }}
        </div>
    @endif

    {{-- Grid for Rumah Sakit, Konsultasi, Tes Lab --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        <div class="bg-white p-6 rounded-xl shadow-md animate__animated animate__fadeInUp">
            <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <i class="fa-solid fa-hospital text-red-600 text-2xl"></i>
                Rumah Sakit
            </h2>
            <p>Informasi rumah sakit yang tersedia di sekitar Anda.</p>
            <div class="table-responsive">
                <table class="table table-bordered mt-3 table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($hospitals as $hospital)
                            <tr>
                                <td>{{ $hospital->nama }}</td>
                                <td>{{ $hospital->alamat }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-gray-500">Tidak ada data rumah sakit.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $hospitals->links('pagination::bootstrap-4') }}
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md animate__animated animate__fadeInUp animate__delay-0-5s">
            <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <i class="fa-solid fa-user-doctor text-red-600 text-2xl"></i>
                Konsultasi Dokter
            </h2>
            <p>Riwayat konsultasi Anda dengan dokter profesional.</p>
            <div class="table-responsive">
                <table class="table table-bordered mt-3 table-hover">
                    <thead>
                        <tr>
                            <th>Dokter</th>
                            <th>Tanggal/Waktu</th>
                            <th>Status</th>
                            <th>Catatan</th> {{-- Tambahkan kolom ini --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($consultations as $consultation)
                            <tr>
                                {{-- Memanggil relasi 'doctor' yang telah didefinisikan di model Consultation --}}
                                <td>{{ $consultation->doctor->name ?? 'Dokter Tidak Dikenal' }}</td>
                                {{-- Memanggil accessor 'formatted_consultation_date' dari model Consultation --}}
                                <td>{{ $consultation->formatted_consultation_date }}</td>
                                <td>
                                    @if ($consultation->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif ($consultation->status == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif ($consultation->status == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @elseif ($consultation->status == 'completed')
                                        <span class="badge bg-info">Selesai</span>
                                    @else
                                        <span class="badge bg-secondary">Unknown</span>
                                    @endif
                                </td>
                                {{-- Menampilkan catatan, membatasi panjangnya untuk kerapian --}}
                                <td>{{ Str::limit($consultation->notes, 50) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500">Tidak ada riwayat konsultasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $consultations->links('pagination::bootstrap-4') }}
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md animate__animated animate__fadeInUp animate__delay-1s">
            <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <i class="fa-solid fa-vial text-red-600 text-2xl"></i>
                Tes Laboratorium Terbaru
            </h2>
            <p>Cek hasil laboratorium terbaru Anda.</p>
            <div class="space-y-4 mt-3">
                @forelse ($recentLabTests as $labTest)
                    <div class="border-b border-gray-200 pb-2 mb-2">
                        <p class="text-gray-900 font-semibold mb-1">
                            @if ($labTest->test_type)
                                {{ $labTest->test_type }}
                            @else
                                Data Tes Lab
                            @endif
                        </p>
                        <p class="text-gray-700 text-sm mb-1">
                            <i class="fa-solid fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($labTest->test_date)->translatedFormat('d F Y') }}
                        </p>
                        <p class="text-gray-700 text-sm mb-0">
                            <i class="fa-solid fa-flask-vial me-1"></i> Hasil: {{ $labTest->result }}
                        </p>
                        <p class="text-gray-700 text-sm mb-0">
                            <i class="fa-solid fa-hospital me-1"></i> Lab: {{ $labTest->lab_name ?? 'N/A' }}
                        </p>
                    </div>
                @empty
                    <p class="text-center text-gray-500">Tidak ada data tes lab terbaru.</p>
                @endforelse
            </div>
            <div class="text-right mt-4">
                <a href="{{ route('riwayat-medis') }}" class="text-red-600 hover:text-red-800 text-sm font-semibold">Lihat Semua Tes Lab <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    {{-- Chart and Mini Map Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-md animate__animated animate__fadeInUp animate__delay-1-5s lg:col-span-2">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-red-600"></i>
                Tren Gula Darah (6 Bulan Terakhir)
            </h2>
            <div class="chart-container" style="position: relative; height:300px; width:100%">
                <canvas id="bloodSugarLineChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md animate__animated animate__fadeInUp animate__delay-2s lg:col-span-1">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                <i class="fa-solid fa-map-location-dot text-red-600"></i>
                Mini Map Rumah Sakit
            </h2>
            {{-- Include map view, ensure correct path (e.g., 'partials.map.dashboard' if in partials folder) --}}
            @include('map.dashboard', ['hospitals' => $allHospitals])
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Data from controller
    const bloodSugarData = @json($bloodSugarData);

    document.addEventListener('DOMContentLoaded', function() {
        // Line Chart: Your Blood Sugar Trend
        const bsLineCtx = document.getElementById('bloodSugarLineChart').getContext('2d');
        const bloodSugarLineChart = new Chart(bsLineCtx, {
            type: 'line',
            data: {
                labels: bloodSugarData.labels,
                datasets: [{
                    label: 'Gula Darah (mg/dL)',
                    data: bloodSugarData.data,
                    borderColor: '#17a2b8', // Bootstrap info color (teal/bluish-green)
                    backgroundColor: 'rgba(23, 162, 184, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5,
                    pointBackgroundColor: '#17a2b8',
                    pointBorderColor: 'white',
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                    pointHoverBackgroundColor: 'white',
                    pointHoverBorderColor: '#17a2b8',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: { size: 14, family: 'Inter, sans-serif' },
                            color: '#495057'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw + ' mg/dL';
                            }
                        },
                        backgroundColor: 'rgba(0,0,0,0.75)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: true,
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 13 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'Gula Darah (mg/dL)',
                            font: { size: 15, weight: 'bold', family: 'Inter, sans-serif' },
                            color: '#495057'
                        },
                        grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                        ticks: { color: '#6c757d', font: { family: 'Inter, sans-serif' } },
                        min: 50,
                        max: 200
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Periode',
                            font: { size: 15, weight: 'bold', family: 'Inter, sans-serif' },
                            color: '#495057'
                        },
                        grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                        ticks: { color: '#6c757d', font: { family: 'Inter, sans-serif' } }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
