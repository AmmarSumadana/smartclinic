@extends('layouts.app')

@section('title', 'Daftar Rumah Sakit')
@section('page-title', 'Daftar Rumah Sakit')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-4 text-center">Daftar Rumah Sakit Daerah Istimewa Yogyakarta</h2>

        <table class="table table-bordered border-dark">
            <thead>
                <tr class="table-danger">
                    <th class="bg-danger text-white">Nama Rumah Sakit</th>
                    <th class="bg-danger text-white">Alamat</th>
                    <th class="bg-danger text-white">Telepon</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hospitals as $index => $hospital)
                    <tr class="{{ $index % 2 == 0 ? 'table-light' : 'table-danger' }}">
                        <td>{{ $hospital->nama }}</td>
                        <td>{{ $hospital->alamat }}</td>
                        <td>{{ $hospital->phone }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div id="map" style="height: 400px;"></div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const map = L.map('map').setView([-7.7972, 110.3688], 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'OpenStreetMap contributors'
            }).addTo(map);

            // Add markers for hospitals
            const hospitals = @json($hospitals); // Mengambil data rumah sakit dari controller

            hospitals.forEach(hospital => {
                L.marker([hospital.latitude, hospital.longitude], {
                    icon: L.divIcon({
                        html: '<i class="fas fa-hospital" style="color:#dc2626; font-size: 24px;"></i>',
                        className: 'leaflet-div-icon',
                        iconSize: [24, 24],
                        iconAnchor: [12, 12]
                    })
                }).addTo(map)
                .bindPopup(`
                    <strong>${hospital.nama}</strong><br>
                    ${hospital.alamat}<br>
                    Telp: ${hospital.phone}
                `);
            });
        });
    </script>
@endsection
