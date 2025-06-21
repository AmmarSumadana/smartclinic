<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard')</title>

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Bootstrap 5.3.3 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    {{-- Leaflet CSS (optional if using maps) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    {{-- Leaflet Draw CSS (optional if using drawing) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />

    {{-- Tailwind CSS via Vite --}}
    @vite('resources/css/app.css')

    <style>
        /* Sembunyikan scrollbar untuk WebKit browsers (Chrome, Safari, Edge) */
        aside nav::-webkit-scrollbar {
            width: 6px; /* Sesuai dengan template-pegawai */
            background: transparent;
        }

        aside nav::-webkit-scrollbar-track {
            background: transparent;
        }

        aside nav::-webkit-scrollbar-thumb {
            background-color: transparent;
            border-radius: 10px;
        }

        aside nav:hover::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.4);
        }

        /* Untuk Firefox */
        aside nav {
            scrollbar-width: thin;
            scrollbar-color: transparent transparent;
        }

        aside nav:hover {
            scrollbar-color: rgba(255, 255, 255, 0.4) transparent;
        }

        /* Gaya tambahan untuk Bootstrap dropdown agar sesuai tema Tailwind/App */
        .dropdown-item {
            padding: 0.75rem 1rem;
            color: #343a40;
            transition: background-color 0.2s ease;
        }
        .dropdown-item:hover {
            background-color: #f0f2f5;
            color: #ef4444; /* red-600 */
        }
        .dropdown-menu {
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: none;
            overflow: hidden;
        }

        /* CSS untuk sidebar yang bisa dikecilkan - Disalin dari template-pegawai.blade.php */
        .sidebar {
            transition: width 0.3s ease-in-out;
            flex-shrink: 0;
            overflow: visible; /* Penting untuk menjaga scrollbar tetap di dalam area */
            width: 16rem; /* w-64 = 256px = 16rem */
        }

        /* State saat sidebar dikecilkan */
        .sidebar.collapsed {
            width: 5rem; /* Lebar yang cukup untuk menampilkan icon dengan nyaman */
        }

        /* Menyembunyikan teks saat sidebar dikecilkan */
        .sidebar-text {
            opacity: 1;
            transition: opacity 0.2s ease-out;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar.collapsed .sidebar-text {
            opacity: 0;
            width: 0; /* Mengurangi lebar yang diambil oleh teks */
        }

        /* Menu items styling normal state */
        nav a {
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem; /* Jarak antara ikon dan teks */
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            position: relative;
        }

        /* Menu items styling saat collapsed */
        .sidebar.collapsed nav a {
            justify-content: center !important; /* Memusatkan ikon */
            padding: 0.75rem !important; /* Padding lebih besar agar icon lebih terlihat */
            gap: 0 !important; /* Hapus gap antar ikon dan teks */
        }

        /* Icon styling - selalu terlihat */
        nav a i {
            font-size: 1.125rem !important; /* text-lg equivalent */
            flex-shrink: 0 !important;
            width: 1.25rem !important; /* Lebar tetap untuk konsistensi ikon */
            text-align: center !important;
        }

        /* Pastikan icon tetap terlihat saat collapsed */
        .sidebar.collapsed nav a i {
            margin: 0 !important;
            width: auto !important;
        }

        /* Tombol toggle - Disalin dari template-pegawai.blade.php */
        .sidebar-toggle {
            background-color: #ef4444;
            color: white;
            border: none;
            width: 2rem; /* Ukuran tombol toggle */
            height: 2rem;
            border-radius: 0.375rem; /* Rounded corners */
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
            flex-shrink: 0;
        }

        .sidebar-toggle:hover {
            background-color: #dc2626;
            transform: scale(1.05);
        }

        .sidebar-toggle i {
            transition: transform 0.3s ease;
        }

        /* Rotasi ikon toggle saat sidebar collapsed */
        .sidebar.collapsed .sidebar-toggle i {
            transform: rotate(180deg);
        }

        /* Header sidebar - Disalin dari template-pegawai.blade.php */
        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between; /* Logo kiri, toggle kanan */
            margin-bottom: 1.5rem;
        }

        /* Header saat collapsed - tumpuk vertikal dan rata kiri */
        .sidebar.collapsed .sidebar-header {
            flex-direction: column; /* Menumpuk vertikal */
            gap: 0.5rem; /* Jarak antara ikon dan tombol toggle saat bertumpuk */
            align-items: flex-start; /* Rata kiri saat bertumpuk */
        }

        /* Logo section dalam header sidebar - Disalin dari template-pegawai.blade.php */
        .sidebar-header .logo-section {
            display: flex;
            align-items: center;
            min-width: 0; /* Penting untuk menyusut */
        }

        .sidebar-header .logo-section i {
            font-size: 1.5rem;
            margin-right: 0.5rem;
            flex-shrink: 0;
        }

        /* Sesuaikan ikon logo saat collapsed - Disalin dari template-pegawai.blade.php */
        .sidebar.collapsed .sidebar-header .logo-section i {
            margin-right: 0; /* Hapus margin kanan ikon saat collapsed */
        }

        /* Sembunyikan teks logo saat collapsed - Disalin dari template-pegawai.blade.php */
        .sidebar.collapsed .sidebar-header .sidebar-text {
            display: none; /* Lebih efektif menyembunyikan teks logo sepenuhnya */
        }

        /* Footer sidebar saat collapsed - Disalin dari template-pegawai.blade.php */
        .sidebar.collapsed .sidebar-footer {
            text-align: center;
            padding-top: 1rem;
        }

        /* Tooltip untuk menu items saat collapsed - Disalin dari template-pegawai.blade.php */
        .sidebar.collapsed nav a {
            position: relative;
        }

        .sidebar.collapsed nav a:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background-color: #1f2937;
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            white-space: nowrap;
            margin-left: 0.5rem;
            font-size: 0.875rem;
            z-index: 1000;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Arrow untuk tooltip - Disalin dari template-pegawai.blade.php */
        .sidebar.collapsed nav a:hover::before {
            content: '';
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 5px 5px 5px 0;
            border-color: transparent #1f2937 transparent transparent;
            margin-left: 0.25rem;
            z-index: 1000;
        }
    </style>

    @stack('head')
</head>

<body class="bg-gray-100 text-gray-900">

    <div id="main-layout-container" class="flex h-screen p-4 gap-4">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar bg-red-600 text-white p-4 rounded-2xl shadow-lg flex flex-col">
            <!-- Header dengan logo dan toggle -->
            <div class="sidebar-header">
                <div class="logo-section">
                    <i class="fa-solid fa-heart-circle-bolt"></i>
                    <span class="text-xl font-bold sidebar-text">e-Health</span>
                </div>
                <!-- Tombol Toggle -->
                <button id="sidebar-toggle" class="sidebar-toggle">
                    <i class="fa-solid fa-chevron-left text-sm"></i>
                </button>
            </div>

            {{-- Bagian Navigasi Menu yang Akan di-scroll --}}
            <nav class="flex-1 space-y-2 overflow-y-auto">
                @php
                    $menu = [
                        ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fa-solid fa-chart-line'],
                        ['label' => 'Cek Medis', 'route' => 'cek-medis', 'icon' => 'fa-solid fa-stethoscope'],
                        ['label' => 'Daftar RS', 'route' => 'daftar-rs', 'icon' => 'fa-solid fa-hospital'],
                        ['label' => 'Konsul Dokter', 'route' => 'konsul-dokter', 'icon' => 'fa-solid fa-user-doctor'],
                        ['label' => 'Tes Lab', 'route' => 'tes-lab', 'icon' => 'fa-solid fa-vial'],
                        ['label' => 'E-Resep', 'route' => 'e-resep', 'icon' => 'fa-solid fa-prescription-bottle'],
                        [
                            'label' => 'Layanan Ambulans',
                            'route' => 'layanan-ambulans',
                            'icon' => 'fa-solid fa-truck-medical',
                        ],
                        ['label' => 'Kesehatanku', 'route' => 'kesehatanku', 'icon' => 'fa-solid fa-heart-pulse'],
                        ['label' => 'Rawat Inap', 'route' => 'rawat-inap', 'icon' => 'fa-solid fa-bed-pulse'],
                        ['label' => 'Riwayat Medis', 'route' => 'riwayat-medis', 'icon' => 'fa-solid fa-notes-medical'],
                    ];
                    $current = request()->segment(1);
                @endphp

                @foreach ($menu as $item)
                    <a href="/{{ $item['route'] }}"
                        class="transition-all
                        {{ $current == $item['route'] ? 'bg-white text-red-600 font-semibold' : 'hover:bg-red-500 hover:text-white' }}"
                        data-tooltip="{{ $item['label'] }}"> {{-- Tambahkan data-tooltip untuk tooltip --}}
                        <i class="{{ $item['icon'] }}"></i>
                        <span class="sidebar-text">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            {{-- Footer sidebar --}}
            <div class="sidebar-footer mt-auto pt-4 border-t border-red-500 text-xs text-center sidebar-text">
                &copy; {{ date('Y') }} SmartClinic
            </div>
        </aside>

        <!-- Main Area -->
        <div id="main-area" class="flex-1 flex flex-col">
            <!-- Navbar -->
            <header class="bg-white p-4 rounded-2xl shadow flex items-center justify-between mb-4">
                <div class="text-xl font-semibold">Welcome to SmartClinic</div>

                <!-- Icons -->
                <div class="flex items-center gap-4">
                    <i class="fa-solid fa-bell cursor-pointer hover:text-red-600 text-lg"></i>
                    <i class="fa-solid fa-envelope cursor-pointer hover:text-red-600 text-lg"></i>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    {{ __('Profile') }}
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- jQuery (Load before Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Bundle (JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Leaflet JS (optional) -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Leaflet Draw JS (optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar'); // Target elemen sidebar

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed'); // Toggle class 'collapsed' pada sidebar
                });
            } else {
                console.error("Elemen sidebar-toggle atau sidebar tidak ditemukan.");
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
