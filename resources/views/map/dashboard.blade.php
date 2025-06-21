<!-- resources/views/map/dashboard.blade.php -->
<!-- Styles -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<style>
    #map {
        width: 100%;
        height: 300px;
        border-radius: 0.5rem;
        z-index: 0;
    }
</style>

<!-- HTML -->
<div id="map"></div>

<!-- Scripts -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- FontAwesome -->

<script>
document.addEventListener("DOMContentLoaded", function () {
    const map = L.map('map').setView([-7.7972, 110.3688], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
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
