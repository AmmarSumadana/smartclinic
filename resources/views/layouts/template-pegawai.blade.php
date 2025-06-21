<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'SmartClinic Dashboard Pegawai')</title>

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

    {{-- Animate.css for animations (Keeping this for dashboard-pegawai animations) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    {{-- Tailwind CSS via Vite (Assuming resources/css/app.css contains Tailwind directives) --}}
    @vite('resources/css/app.css')

    <style>
        /* Hide scrollbar for WebKit browsers (Chrome, Safari, Edge) */
        aside nav::-webkit-scrollbar {
            width: 6px;
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

        /* For Firefox */
        aside nav {
            scrollbar-width: thin;
            scrollbar-color: transparent transparent;
        }

        aside nav:hover {
            scrollbar-color: rgba(255, 255, 255, 0.4) transparent;
        }

        /* Base styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            color: #343a40;
        }

        /* Custom styles from dashboard-pegawai.blade.php */
        .neumo-card-small {
            background-color: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease-in-out;
            padding: 1.5rem;
        }
        .neumo-card-small:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .btn-custom-primary {
            background-color: #ef4444;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 600;
            transition: background-color 0.2s ease-in-out;
            display: inline-flex;
            align-items: center;
        }
        .btn-custom-primary:hover {
            background-color: #dc2626;
        }
        .icon-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            border-radius: 9999px;
            font-size: 1.5rem;
            color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            flex-shrink: 0;
        }

        /* Dropdown styles */
        .dropdown-item {
            padding: 0.75rem 1rem;
            color: #343a40;
            transition: background-color 0.2s ease;
        }
        .dropdown-item:hover {
            background-color: #f0f2f5;
            color: #ef4444;
        }
        .dropdown-menu {
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: none;
            overflow: hidden;
        }

        /* CSS for collapsible sidebar */
        .sidebar {
            transition: width 0.3s ease-in-out;
            flex-shrink: 0;
            overflow: visible;
            width: 16rem; /* w-64 = 256px = 16rem */
        }

        /* State when sidebar is collapsed */
        .sidebar.collapsed {
            width: 5rem; /* Enough width to comfortably display icons */
        }

        /* Hide text when sidebar is collapsed */
        .sidebar-text {
            opacity: 1;
            transition: opacity 0.2s ease-out;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar.collapsed .sidebar-text {
            opacity: 0;
            width: 0;
        }

        /* Menu items styling normal state */
        nav a {
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            position: relative;
        }

        /* Menu items styling when collapsed */
        .sidebar.collapsed nav a {
            justify-content: center !important;
            padding: 0.75rem !important;
            gap: 0 !important;
        }

        /* Icon styling - always visible */
        nav a i {
            font-size: 1.125rem !important; /* text-lg equivalent */
            flex-shrink: 0 !important;
            width: 1.25rem !important;
            text-align: center !important;
        }

        /* Ensure icon remains visible when collapsed */
        .sidebar.collapsed nav a i {
            margin: 0 !important;
            width: auto !important;
        }

        /* Toggle button */
        .sidebar-toggle {
            background-color: #ef4444;
            color: white;
            border: none;
            width: 2rem;
            height: 2rem;
            border-radius: 0.375rem;
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

        /* Rotate toggle icon when sidebar is closed */
        .sidebar.collapsed .sidebar-toggle i {
            transform: rotate(180deg);
        }

        /* Sidebar header */
        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        /* Header when collapsed - vertical stack and left align */
        .sidebar.collapsed .sidebar-header {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start; /* Left align when stacked */
        }

        /* Logo section in sidebar header */
        .sidebar-header .logo-section {
            display: flex;
            align-items: center;
            min-width: 0;
        }

        .sidebar-header .logo-section i {
            font-size: 1.5rem;
            margin-right: 0.5rem;
            flex-shrink: 0;
        }

        /* Adjust logo icon when collapsed */
        .sidebar.collapsed .sidebar-header .logo-section i {
            margin-right: 0;
        }

        /* Hide logo text when collapsed */
        .sidebar.collapsed .sidebar-header .sidebar-text {
            display: none; /* More effective to completely hide logo text */
        }

        /* Sidebar footer when collapsed */
        .sidebar.collapsed .sidebar-footer {
            text-align: center;
            padding-top: 1rem;
        }

        /* Tooltip for menu items when collapsed */
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

        /* Arrow for tooltip */
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
        <aside id="sidebar" class="sidebar bg-red-600 text-white p-4 rounded-2xl shadow-lg flex flex-col">
            <div class="sidebar-header">
                <div class="logo-section">
                    <i class="fa-solid fa-heart-circle-bolt"></i>
                    <span class="text-xl font-bold sidebar-text">e-Health</span>
                </div>
                <button id="sidebar-toggle" class="sidebar-toggle">
                    <i class="fa-solid fa-chevron-left text-sm"></i>
                </button>
            </div>

            {{-- Scrollable Navigation Menu --}}
            <nav class="flex-1 space-y-2 overflow-y-auto">
                @php
                    // Employee-specific menu list
                    $employeeMenu = [
                        ['label' => 'Dashboard', 'route' => 'dashboard.pegawai', 'icon' => 'fa-solid fa-chart-line'],
                        ['label' => 'Konsultasi', 'route' => 'pegawai.consultations.index', 'icon' => 'fa-solid fa-notes-medical'],
                        ['label' => 'Rawat Inap', 'route' => 'pegawai.rawat-inap.index', 'icon' => 'fa-solid fa-bed-pulse'],
                        ['label' => 'Data Pasien', 'route' => 'pegawai.patients.index', 'icon' => 'fa-solid fa-user-injured'],
                    ];

                    $currentRoute = Request::route()->getName();
                @endphp

                @foreach ($employeeMenu as $item)
                    <a href="{{ route($item['route']) }}"
                        class="transition-all
                        {{ Request::routeIs($item['route']) || Str::startsWith($currentRoute, $item['route'] . '.') ? 'bg-white text-red-600 font-semibold' : 'hover:bg-red-500 hover:text-white' }}"
                        data-tooltip="{{ $item['label'] }}">
                        <i class="{{ $item['icon'] }}"></i>
                        <span class="sidebar-text">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            {{-- Sidebar Footer --}}
            <div class="sidebar-footer mt-auto pt-4 border-t border-red-500 text-xs text-center sidebar-text">
                &copy; {{ date('Y') }} SmartClinic
            </div>
        </aside>

        <div id="main-area" class="flex-1 flex flex-col">
            <header class="bg-white p-4 rounded-2xl shadow flex items-center justify-between mb-4">
                <div class="text-xl font-semibold">@yield('page-title', 'Welcome to SmartClinic')</div>

                <div class="flex items-center gap-4">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
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

            <main class="flex-1 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                });
            } else {
                console.error("Sidebar toggle or sidebar element not found.");
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
