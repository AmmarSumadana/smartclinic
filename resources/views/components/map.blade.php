{{-- resources/views/components/map.blade.php --}}
{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>

<div id="map" style="height: 300px; width: 100%; border-radius: 8px;"></div>

{{-- Leaflet JavaScript --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Koordinat Yogyakarta (SmartClinic Hospital - Default Location)
    const defaultLat = -7.7956;
    const defaultLng = 110.3695;

    // Inisialisasi peta dengan center di Yogyakarta
    const map = L.map('map').setView([defaultLat, defaultLng], 12);

    // Menambahkan tile layer OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);

    // Custom icon untuk rumah sakit utama (SmartClinic)
    const mainHospitalIcon = L.divIcon({
        html: '<i class="fas fa-hospital" style="color: #dc3545; font-size: 28px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);"></i>',
        iconSize: [35, 35],
        className: 'custom-div-icon'
    });

    // Custom icon untuk rumah sakit lain
    const otherHospitalIcon = L.divIcon({
        html: '<i class="fas fa-plus-square" style="color: #0066cc; font-size: 22px; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);"></i>',
        iconSize: [28, 28],
        className: 'custom-div-icon'
    });

    // Marker untuk SmartClinic Hospital (rumah sakit utama) - Set di lokasi RSUP Dr. Sardjito
    const mainHospital = L.marker([-7.7870, 110.3882], {icon: mainHospitalIcon})
        .addTo(map)
        .bindPopup(`
            <div style="text-align: center; padding: 8px; min-width: 220px;">
                <h6 style="margin: 0 0 10px 0; color: #dc3545; font-weight: bold; font-size: 14px;">
                    <i class="fas fa-hospital me-2"></i>SmartClinic Hospital
                </h6>
                <div style="border-bottom: 2px solid #dc3545; margin: 8px 0;"></div>
                <div style="text-align: left; font-size: 12px; line-height: 1.5;">
                    <p style="margin: 5px 0;">
                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                        <strong>Alamat:</strong><br>
                        Jl. Kesehatan No.1, Yogyakarta
                    </p>
                    <p style="margin: 5px 0;">
                        <i class="fas fa-phone text-success me-2"></i>
                        <strong>Telepon:</strong> (0274) 631-100
                    </p>
                    <p style="margin: 5px 0;">
                        <i class="fas fa-ambulance text-warning me-2"></i>
                        <strong>Emergency:</strong> 119
                    </p>
                </div>
                <div style="margin-top: 10px;">
                    <span class="badge bg-success">24 Jam</span>
                    <span class="badge bg-info">Layanan Ambulans</span>
                    <span class="badge bg-warning">Pusat Rujukan</span>
                </div>
            </div>
        `, {
            maxWidth: 280
        });

    // Data rumah sakit dari database (akan di-populate dari backend)
    @if(isset($hospitals) && $hospitals->count() > 0)
        const hospitalData = @json($hospitals);

        // Filter rumah sakit utama dan yang lain
        const mainHospitalData = hospitalData.find(h => h.nama === 'RSUP Dr. Sardjito');
        const otherHospitals = hospitalData.filter(h => h.nama !== 'RSUP Dr. Sardjito');

        // Menambahkan marker untuk rumah sakit lain
        otherHospitals.forEach(hospital => {
            // Menentukan jenis layanan berdasarkan nama rumah sakit
            let services = ['UGD', 'Rawat Jalan'];
            let hospitalType = 'Rumah Sakit';
            let badgeColor = 'bg-secondary';

            if (hospital.nama.toLowerCase().includes('mata')) {
                services = ['Spesialis Mata', 'Operasi Mata'];
                hospitalType = 'RS Spesialis Mata';
                badgeColor = 'bg-info';
            } else if (hospital.nama.toLowerCase().includes('jiwa')) {
                services = ['Kesehatan Jiwa', 'Rehabilitasi'];
                hospitalType = 'RS Jiwa';
                badgeColor = 'bg-purple';
            } else if (hospital.nama.toLowerCase().includes('bethesda')) {
                services = ['UGD', 'Rawat Inap', 'ICU'];
                hospitalType = 'RS Umum';
                badgeColor = 'bg-primary';
            } else if (hospital.nama.toLowerCase().includes('pku') || hospital.nama.toLowerCase().includes('muhammadiyah')) {
                services = ['UGD', 'Rawat Inap', 'Poliklinik'];
                hospitalType = 'RS Umum';
                badgeColor = 'bg-success';
            } else if (hospital.nama.toLowerCase().includes('siloam')) {
                services = ['VIP', 'Spesialis', 'Emergency'];
                hospitalType = 'RS Swasta';
                badgeColor = 'bg-warning';
            } else if (hospital.nama.toLowerCase().includes('rsud') || hospital.nama.toLowerCase().includes('pemerintah')) {
                services = ['UGD', 'Rawat Inap', 'BPJS'];
                hospitalType = 'RS Pemerintah';
                badgeColor = 'bg-success';
            } else {
                services = ['UGD', 'Rawat Inap', 'Rawat Jalan'];
                hospitalType = 'RS Umum';
            }

            L.marker([hospital.latitude, hospital.longitude], {icon: otherHospitalIcon})
                .addTo(map)
                .bindPopup(`
                    <div style="text-align: center; padding: 8px; min-width: 200px;">
                        <h6 style="margin: 0 0 8px 0; color: #0066cc; font-weight: bold; font-size: 13px;">
                            <i class="fas fa-plus-square me-2"></i>${hospital.nama}
                        </h6>
                        <div style="border-bottom: 2px solid #0066cc; margin: 6px 0;"></div>
                        <div style="text-align: left; font-size: 11px; line-height: 1.4;">
                            <p style="margin: 4px 0;">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                <strong>Alamat:</strong><br>
                                ${hospital.alamat}, Yogyakarta
                            </p>
                            <p style="margin: 4px 0;">
                                <i class="fas fa-phone text-success me-2"></i>
                                <strong>Telepon:</strong> ${hospital.phone}
                            </p>
                        </div>
                        <div style="margin-top: 8px;">
                            <span class="badge ${badgeColor}">${hospitalType}</span><br>
                            <div style="margin-top: 4px;">
                                ${services.map(service => `<span class="badge bg-light text-dark me-1" style="font-size: 9px;">${service}</span>`).join('')}
                            </div>
                        </div>
                    </div>
                `, {
                    maxWidth: 250
                });
        });
    @endif

    // Menambahkan multiple radius untuk area cakupan layanan ambulans
    const radiusOptions = [
        { radius: 3000, color: '#dc3545', fillOpacity: 0.15, label: '3 km - Priority Zone' },
        { radius: 7000, color: '#fd7e14', fillOpacity: 0.1, label: '7 km - Extended Coverage' },
        { radius: 12000, color: '#ffc107', fillOpacity: 0.05, label: '12 km - Maximum Range' }
    ];

    radiusOptions.forEach((option, index) => {
        L.circle([-7.7870, 110.3882], {
            color: option.color,
            fillColor: option.color,
            fillOpacity: option.fillOpacity,
            radius: option.radius,
            weight: index === 0 ? 3 : 2,
            dashArray: index === 0 ? '10, 5' : '15, 10'
        }).addTo(map).bindPopup(`
            <div style="text-align: center; padding: 5px;">
                <strong style="color: ${option.color}">${option.label}</strong><br>
                <small>Waktu Respons: ${index === 0 ? '5-10 menit' : index === 1 ? '10-20 menit' : '20-30 menit'}</small>
            </div>
        `);
    });

    // Control untuk scale
    L.control.scale({
        position: 'bottomright',
        metric: true,
        imperial: false
    }).addTo(map);

    // Custom control untuk legend yang lebih informatif
    const info = L.control({position: 'topright'});
    info.onAdd = function (map) {
        const div = L.DomUtil.create('div', 'info legend');
        div.innerHTML = `
            <div style="background: white; padding: 12px; border-radius: 8px; box-shadow: 0 3px 10px rgba(0,0,0,0.2); font-size: 11px; line-height: 1.4;">
                <h6 style="margin: 0 0 8px 0; font-weight: bold; color: #333;">Peta Rumah Sakit Yogyakarta</h6>
                <div style="border-bottom: 1px solid #ddd; margin-bottom: 8px;"></div>

                <div style="margin-bottom: 6px;">
                    <i class="fas fa-hospital" style="color: #dc3545; font-size: 16px; margin-right: 8px;"></i>
                    <strong>SmartClinic Hospital</strong>
                </div>

                <div style="margin-bottom: 6px;">
                    <i class="fas fa-plus-square" style="color: #0066cc; font-size: 14px; margin-right: 8px;"></i>
                    <strong>Rumah Sakit Lain</strong>
                </div>

                <div style="border-bottom: 1px solid #ddd; margin: 8px 0;"></div>
                <strong style="font-size: 10px;">Area Layanan Ambulans:</strong><br>

                <div style="margin: 4px 0;">
                    <span style="color: #dc3545; font-size: 14px;">⭕</span>
                    <span style="font-size: 10px;">Priority (3km)</span>
                </div>

                <div style="margin: 4px 0;">
                    <span style="color: #fd7e14; font-size: 14px;">⭕</span>
                    <span style="font-size: 10px;">Extended (7km)</span>
                </div>

                <div style="margin: 4px 0;">
                    <span style="color: #ffc107; font-size: 14px;">⭕</span>
                    <span style="font-size: 10px;">Maximum (12km)</span>
                </div>
            </div>
        `;
        return div;
    };
    info.addTo(map);

    // Automatically open main hospital popup after 1 second
    setTimeout(() => {
        mainHospital.openPopup();
    }, 1000);
});
</script>

<style>
.custom-div-icon {
    background: transparent;
    border: none;
    text-align: center;
}

.leaflet-popup-content-wrapper {
    border-radius: 8px;
}

.leaflet-popup-content {
    margin: 8px 12px;
}

.info.legend {
    background: transparent;
    box-shadow: none;
}
</style>
