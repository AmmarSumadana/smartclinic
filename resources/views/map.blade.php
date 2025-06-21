<!-- resources/views/map.blade.php -->

<!-- Styles -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<style>
    #map {
        width: 100%;
        height: 300px;
        border-radius: 0.5rem;
        z-index: 0;
    }

    .popup-content {
        font-size: 14px;
        line-height: 1.4;
    }

    .popup-content button {
        margin-top: 8px;
        background-color: #dc2626;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
    }

    .popup-content button:hover {
        background-color: #b91c1c;
    }

    #resetSelection {
        margin-left: 10px;
        background-color: #f3f4f6;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        display: inline-block;
    }

    #resetSelection:hover {
        background-color: #e5e7eb;
    }
</style>

<!-- Peta -->
<div id="map"></div>
<div id="selectedHospital" class="mt-3 text-sm"></div>

<!-- Scripts -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const map = L.map('map').setView([-7.7972, 110.3688], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        const drawControl = new L.Control.Draw({
            edit: {
                featureGroup: drawnItems
            },
            draw: {
                circle: false,
                circlemarker: false
            }
        });
        map.addControl(drawControl);

        let selectedMarker = null;
        let hospitalLayerGroup = L.layerGroup().addTo(map);

        function confirmSelection(hospitalId, hospitalName, marker) {
            const select = document.getElementById('hospitalSelect');
            const label = document.getElementById('selectedHospital');
            const geomInput = document.querySelector('input[name="geom"]');

            if (select) select.value = hospitalId;
            if (geomInput && marker) {
                const latlng = marker.getLatLng();
                geomInput.value = JSON.stringify(latlng);
            }

            label.innerHTML = `
            <span class="bg-green-100 px-3 py-1 rounded-full">Rumah Sakit yang Dipilih: ${hospitalName}</span>
            <span id="resetSelection">Ganti Pilihan</span>
        `;

            if (selectedMarker && selectedMarker._icon) {
                selectedMarker._icon.querySelector('i').style.color = '#dc2626';
            }
            if (marker && marker._icon) {
                marker._icon.querySelector('i').style.color = '#15803d';
                selectedMarker = marker;
            }

            map.closePopup();

            document.getElementById('resetSelection').onclick = () => {
                if (select) select.value = "";
                label.innerHTML = "";
                if (selectedMarker && selectedMarker._icon) {
                    selectedMarker._icon.querySelector('i').style.color = '#dc2626';
                }
                selectedMarker = null;
                if (geomInput) geomInput.value = '';
            };
        }

        // Fetch hospitals from database instead of JSON file
        fetch('{{ route("hospitals.json") }}')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('hospitalSelect');

                L.geoJSON(data, {
                    onEachFeature: function(feature, layer) {
                        const props = feature.properties;
                        const hospitalId = props.id;
                        const hospitalName = props.name.replace(/'/g, "\\'");
                        const popupHTML = `
                        <div class="popup-content">
                            <strong>${props.name}</strong><br>
                            ${props.address}<br>
                            Telp: ${props.phone}<br>
                            <button class="choose-hospital-btn" data-id="${hospitalId}" data-name="${hospitalName}">Pilih</button>
                        </div>
                    `;

                        layer.bindPopup(popupHTML);
                        layer._popup._markerRef = layer;

                        layer.on('click', function() {
                            layer.openPopup();
                        });
                    },
                    pointToLayer: function(feature, latlng) {
                        return L.marker(latlng, {
                            icon: L.divIcon({
                                html: '<i class="fas fa-hospital" style="color:#dc2626;"></i>',
                                iconSize: [24, 24],
                                iconAnchor: [12, 12],
                                className: 'leaflet-div-icon'
                            })
                        });
                    }
                }).eachLayer(layer => hospitalLayerGroup.addLayer(layer));

                map.getContainer().addEventListener('click', function(e) {
                    if (e.target.classList.contains('choose-hospital-btn')) {
                        e.preventDefault();
                        const id = e.target.dataset.id;
                        const name = e.target.dataset.name;
                        const marker = e.target.closest('.leaflet-popup')._source;
                        confirmSelection(id, name, marker);
                    }
                });
            })
            .catch(error => console.error('Gagal memuat data rumah sakit:', error));
    });
</script>
