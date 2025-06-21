@extends('layouts.app')

@section('title', 'Kesehatanku')
@section('page-title', 'Kesehatanku')

@push('head')
    <!-- Pastikan Font Awesome, Bootstrap Icons, dan Animate.css sudah dimuat di layouts/app.blade.php atau di sini -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    {{-- Asumsi Tailwind CSS sudah dimuat di layouts/app.blade.php --}}
@endpush

@section('content')

{{-- Main Content Wrapper - Ganti container dengan padding dan background yang konsisten --}}
<div class="p-6 md:p-8 lg:p-10 bg-gray-100 min-h-screen">

    {{-- Hero/Intro Section --}}
    <div class="text-center mb-6 animate__animated animate__fadeInDown">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Kesehatanku</h2>
        <p class="text-gray-600 text-base md:text-lg">Mencegah Penyakit Lebih Baik Dari Mengobati</p>
    </div>

    {{-- Main Content - Graphs Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8"> {{-- Menggunakan grid 2 kolom untuk grafik --}}

        {{-- Statistik Kesehatan Section - Line Chart (Gula Darah) --}}
        <div class="col-span-1 animate__animated animate__fadeInUp animate__delay-1s">
            <div class="bg-white p-6 rounded-xl shadow-md h-full flex flex-col"> {{-- Gaya kartu dashboard --}}
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Tren Gula Darah (6 Bulan Terakhir)</h3>
                <div class="flex-grow flex items-center justify-center" style="position: relative; height:40vh; width:100%">
                    <canvas id="bloodSugarLineChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Distribusi Konsumsi Jenis Obat Section - Pie Chart --}}
        <div class="col-span-1 animate__animated animate__fadeInUp animate__delay-1s">
            <div class="bg-white p-6 rounded-xl shadow-md h-full flex flex-col"> {{-- Gaya kartu dashboard --}}
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Konsumsi Jenis Obat</h3>
                <div class="flex-grow flex items-center justify-center" style="position: relative; height:40vh; width:100%">
                    <canvas id="medicineTypePieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Tambahan --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8"> {{-- Menggunakan grid 3 kolom untuk statistik mini --}}
        <div class="col-span-1 animate__animated animate__fadeInUp animate__delay-2s">
            <div class="bg-white p-6 rounded-xl shadow-md text-center h-full"> {{-- Gaya kartu dashboard --}}
                <div class="text-red-600 mb-2 text-3xl"> {{-- Warna ikon merah seperti dashboard --}}
                    <i class="fa-solid fa-flask"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalLabTests }}</h4>
                <p class="text-gray-600 text-sm md:text-base mb-0">Total Tes Lab</p>
            </div>
        </div>

        <div class="col-span-1 animate__animated animate__fadeInUp animate__delay-2s">
            <div class="bg-white p-6 rounded-xl shadow-md text-center h-full"> {{-- Gaya kartu dashboard --}}
                <div class="text-red-600 mb-2 text-3xl"> {{-- Warna ikon merah seperti dashboard --}}
                    <i class="fa-solid fa-pills"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalMedicines }}</h4>
                <p class="text-gray-600 text-sm md:text-base mb-0">Total Obat</p>
            </div>
        </div>

        <div class="col-span-1 animate__animated animate__fadeInUp animate__delay-2s">
            <div class="bg-white p-6 rounded-xl shadow-md text-center h-full"> {{-- Gaya kartu dashboard --}}
                <div class="text-red-600 mb-2 text-3xl"> {{-- Warna ikon merah seperti dashboard --}}
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-900 mb-1">Rp {{ number_format($monthlyExpense, 0, ',', '.') }}</h4>
                <p class="text-gray-600 text-sm md:text-base mb-0">Pengeluaran Bulan Ini</p>
            </div>
        </div>
    </div>

</div>

{{-- Custom CSS dihapus karena sudah menggunakan Tailwind --}}
<style>
    /* Custom styles for Chart.js to integrate with Tailwind/Dashboard look */
    .chart-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .chart-container canvas {
        /* No specific Neumorphism shadow, just regular rounded corners */
        border-radius: 0.75rem; /* rounded-xl equivalent */
        max-width: 100%;
        max-height: 100%;
    }
    /* Override Bootstrap/default Chart.js font for consistent look */
    canvas {
        font-family: 'Inter', sans-serif !important;
    }
</style>

{{-- Chart.js Script (Tidak diubah dari sisi backend, hanya styling Chart.js options) --}}
<script>
    // Data dari controller
    const bloodSugarData = @json($bloodSugarData);
    const medicineData = @json($medicineConsumptionData);

    // Line Chart: Tren Gula Darah Anda
    const lineCtx = document.getElementById('bloodSugarLineChart').getContext('2d');
    const healthLineChart = new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: bloodSugarData.labels,
            datasets: [{
                label: 'Gula Darah (mg/dL)',
                data: bloodSugarData.data,
                borderColor: '#EF4444', // Tailwind red-500/600
                backgroundColor: 'rgba(239, 68, 68, 0.1)', // Light red fill
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointBackgroundColor: '#EF4444', // Red for points
                pointBorderColor: 'white', // White border for points
                pointBorderWidth: 2,
                pointHoverRadius: 7,
                pointHoverBackgroundColor: 'white',
                pointHoverBorderColor: '#EF4444',
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
                        color: '#4B5563' // Tailwind gray-700
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            if (context.raw !== null) {
                                return context.dataset.label + ': ' + context.raw + ' mg/dL';
                            }
                            return context.dataset.label + ': Data tidak tersedia';
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
                        color: '#4B5563' // Tailwind gray-700
                    },
                    grid: { color: 'rgba(209, 213, 219, 0.5)', drawBorder: false }, // Soft gray grid
                    ticks: { color: '#6B7280', font: { family: 'Inter, sans-serif' } }, // Tailwind gray-500
                    min: 50,
                    max: 200
                },
                x: {
                    title: {
                        display: true,
                        text: 'Periode',
                        font: { size: 15, weight: 'bold', family: 'Inter, sans-serif' },
                        color: '#4B5563' // Tailwind gray-700
                    },
                    grid: { color: 'rgba(209, 213, 219, 0.5)', drawBorder: false }, // Soft gray grid
                    ticks: { color: '#6B7280', font: { family: 'Inter, sans-serif' } } // Tailwind gray-500
                }
            }
        }
    });

    // Pie Chart: Distribusi Konsumsi Jenis Obat
    const pieCtx = document.getElementById('medicineTypePieChart').getContext('2d');
    const medicineTypePieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: medicineData.labels,
            datasets: [{
                label: 'Jenis Obat',
                data: medicineData.data,
                backgroundColor: [
                    '#3B82F6', // Tailwind blue-500
                    '#F59E0B', // Tailwind yellow-500
                    '#10B981', // Tailwind green-500
                    '#EF4444', // Tailwind red-500
                    '#6B7280'  // Tailwind gray-500
                ],
                borderColor: 'white', // White border around slices for clean look
                borderWidth: 5,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'right',
                    labels: {
                        font: { size: 14, family: 'Inter, sans-serif' },
                        color: '#4B5563', // Tailwind gray-700
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed !== null) {
                                label += context.parsed + '%';
                            }
                            return label;
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
            layout: {
                padding: {
                    left: 10,
                    right: 10,
                    top: 10,
                    bottom: 10
                }
            }
        }
    });
</script>
@endsection
