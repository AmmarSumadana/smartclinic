@extends('layouts.app')

@section('title', 'Cek Medis')
@section('page-title', 'Cek Medis')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        @if (session('download_pdf'))
            <script>
                window.onload = function() {
                    window.location.href = "{{ route('cek-medis.pdf', session('download_pdf')) }}";
                };
            </script>
        @endif
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div x-data="cekMedisForm()" class="bg-white p-6 rounded shadow space-y-6">
        <h2 class="text-2xl font-semibold mb-4">Form Pemeriksaan Medis</h2>

        <form action="{{ route('cek-medis.submit') }}" method="POST" enctype="multipart/form-data" id="cekMedisForm">
            @csrf

            <!-- 1. Data Diri Pasien -->
            <div>
                <h3 class="font-semibold mb-2">1. Data Diri Pasien</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="nama" placeholder="Nama Lengkap" class="form-input"
                        value="{{ old('nama') }}" required>
                    <input type="date" name="tanggal_lahir" class="form-input" value="{{ old('tanggal_lahir') }}"
                        required>
                    <select name="jenis_kelamin" class="form-input" required>
                        <option value="">Jenis Kelamin</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <input type="text" name="no_identitas" placeholder="Nomor Identitas" class="form-input"
                        value="{{ old('no_identitas') }}">
                    <input type="tel" name="no_hp" placeholder="Nomor HP" class="form-input"
                        value="{{ old('no_hp') }}">
                    <input type="email" name="email" placeholder="Email" class="form-input"
                        value="{{ old('email') }}">
                    <input type="text" name="alamat" placeholder="Alamat Lengkap" class="form-input col-span-2"
                        value="{{ old('alamat') }}">
                </div>
            </div>

            <!-- 2. Riwayat Kesehatan -->
            <div>
                <h3 class="font-semibold mb-2">2. Riwayat Kesehatan</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <textarea name="penyakit_kronis" class="form-textarea" placeholder="Penyakit kronis yang dimiliki">{{ old('penyakit_kronis') }}</textarea>
                    <textarea name="obat_rutin" class="form-textarea" placeholder="Obat yang dikonsumsi secara rutin">{{ old('obat_rutin') }}</textarea>
                    <textarea name="alergi" class="form-textarea" placeholder="Alergi terhadap makanan/obat">{{ old('alergi') }}</textarea>
                    <textarea name="riwayat_operasi" class="form-textarea" placeholder="Riwayat operasi yang pernah dijalani">{{ old('riwayat_operasi') }}</textarea>
                    <textarea name="penyakit_keluarga" class="form-textarea" placeholder="Penyakit yang menurun dalam keluarga">{{ old('penyakit_keluarga') }}</textarea>
                </div>
            </div>

            <!-- 3. Gaya Hidup & Kebiasaan -->
            <div>
                <h3 class="font-semibold mb-2">3. Gaya Hidup & Kebiasaan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <select name="merokok" class="form-input">
                        <option value="">Apakah merokok?</option>
                        <option value="Ya" {{ old('merokok') == 'Ya' ? 'selected' : '' }}>Ya</option>
                        <option value="Tidak" {{ old('merokok') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <select name="alkohol" class="form-input">
                        <option value="">Apakah konsumsi alkohol?</option>
                        <option value="Ya" {{ old('alkohol') == 'Ya' ? 'selected' : '' }}>Ya</option>
                        <option value="Tidak" {{ old('alkohol') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <input type="text" name="olahraga" class="form-input" placeholder="Frekuensi olahraga"
                        value="{{ old('olahraga') }}">
                    <textarea name="pola_makan" class="form-textarea" placeholder="Deskripsikan pola makan Anda">{{ old('pola_makan') }}</textarea>
                </div>
            </div>

            <!-- 4. Gejala Saat Ini -->
            <div>
                <h3 class="font-semibold mb-2">4. Gejala Saat Ini</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <textarea name="gejala" class="form-textarea" placeholder="Gejala yang dirasakan">{{ old('gejala') }}</textarea>
                    <input type="text" name="lama_gejala" class="form-input" placeholder="Sejak kapan muncul?"
                        value="{{ old('lama_gejala') }}">
                    <select name="tingkat_keparahan" class="form-input">
                        <option value="">Tingkat keparahan</option>
                        <option value="Ringan" {{ old('tingkat_keparahan') == 'Ringan' ? 'selected' : '' }}>Ringan
                        </option>
                        <option value="Sedang" {{ old('tingkat_keparahan') == 'Sedang' ? 'selected' : '' }}>Sedang
                        </option>
                        <option value="Parah" {{ old('tingkat_keparahan') == 'Parah' ? 'selected' : '' }}>Parah</option>
                    </select>
                </div>
            </div>

            <!-- 5. Pemeriksaan Fisik -->
            <div>
                <h3 class="font-semibold mb-2">5. Pemeriksaan Fisik</h3>
                <label class="flex items-center mb-4">
                    <input type="checkbox" id="periksaDiTempat" name="periksa_di_tempat" value="1" class="mr-2"
                        {{ old('periksa_di_tempat') ? 'checked' : '' }}>
                    Ingin diperiksa langsung di tempat
                </label>
                <div id="pemeriksaanFisikFields" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="tekanan_darah" class="form-input" placeholder="Tekanan darah"
                        value="{{ old('tekanan_darah') }}">
                    <input type="text" name="denyut_nadi" class="form-input" placeholder="Denyut nadi (BPM)"
                        value="{{ old('denyut_nadi') }}">
                    <input type="text" name="berat_badan" class="form-input" placeholder="Berat badan (kg)"
                        value="{{ old('berat_badan') }}">
                    <input type="text" name="tinggi_badan" class="form-input" placeholder="Tinggi badan (cm)"
                        value="{{ old('tinggi_badan') }}">
                    <input type="text" name="imt" class="form-input" placeholder="Indeks Massa Tubuh (IMT)"
                        value="{{ old('imt') }}">
                    <input type="text" name="suhu" class="form-input" placeholder="Suhu tubuh (°C)"
                        value="{{ old('suhu') }}">
                </div>
            </div>

            <!-- 6. Paket Pemeriksaan -->
            <div>
                <h3 class="font-semibold mb-2">6. Paket Pemeriksaan</h3>
                <select name="paket" class="form-input" required>
                    <option value="">Pilih Paket</option>
                    <option value="Dasar" {{ old('paket') == 'Dasar' ? 'selected' : '' }}>Dasar</option>
                    <option value="Lengkap" {{ old('paket') == 'Lengkap' ? 'selected' : '' }}>Lengkap</option>
                    <option value="Khusus" {{ old('paket') == 'Khusus' ? 'selected' : '' }}>Khusus</option>
                </select>
            </div>

            <!-- 7. Jadwal Pemeriksaan -->
            <div>
                <h3 class="font-semibold mb-2">7. Jadwal Pemeriksaan</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input type="date" name="jadwal_tanggal" class="form-input" value="{{ old('jadwal_tanggal') }}"
                        required>
                    <input type="time" name="jadwal_jam" class="form-input" value="{{ old('jadwal_jam') }}"
                        required>
                    <select name="hospital_id" id="hospitalSelect" class="form-input" required>
                        <option value="">Pilih Klinik/Rumah Sakit</option>
                        @foreach ($hospitals as $hospital)
                            <option value="{{ $hospital->id }}" data-lat="{{ $hospital->latitude }}"
                                data-lng="{{ $hospital->longitude }}" data-alamat="{{ $hospital->alamat }}"
                                {{ old('hospital_id') == $hospital->id ? 'selected' : '' }}>
                                {{ $hospital->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <h4 class="font-semibold mb-2">Peta Lokasi Rumah Sakit</h4>
                    <div id="mapContainer" style="height: 400px; width: 100%;">
                        <!-- Map will be loaded here -->
                    </div>
                </div>
            </div>

            <input type="hidden" name="geom" value="{{ old('geom') }}">

            <div>
                <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700" id="submitBtn">
                    <span id="submitText">Kirim dan Cetak</span>
                    <span id="loadingText" class="hidden">Sedang memproses...</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Modal Bootstrap -->
    <div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="konfirmasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Pemeriksaan di Tempat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    Jika Anda memilih diperiksa langsung di tempat, maka kolom pemeriksaan fisik akan dikosongkan                     dan tidak bisa diisi. Lanjutkan?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="modalCancel"
                        data-bs-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-primary" id="modalConfirm">Ya, lanjutkan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoL1xVZKqvZlMN4j6c5Am3C1pXw5LkS9C+Z9kk53n0yA05q" crossorigin="anonymous">
    </script>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        function cekMedisForm() {
            return {
                geom: null,
                periksa: false,
            };
        }

        document.addEventListener('DOMContentLoaded', () => {
            const sel = document.getElementById('hospitalSelect');
            const hidden = document.querySelector('input[name="geom"]');
            const form = document.getElementById('cekMedisForm');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const loadingText = document.getElementById('loadingText');

            // Initialize map
            let map = L.map('mapContainer').setView([-7.797068, 110.370529], 13); // Yogyakarta coordinates
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            let currentMarker = null;

            // Load hospital data from database
            @if (isset($hospitals) && count($hospitals) > 0)
                const hospitalsData = [
                    @foreach ($hospitals as $hospital)
                        {
                            id: {{ $hospital->id }},
                            nama: "{{ $hospital->nama }}",
                            alamat: "{{ $hospital->alamat }}",
                            latitude: {{ $hospital->latitude ?? 0 }},
                            longitude: {{ $hospital->longitude ?? 0 }},
                            no_telp: "{{ $hospital->phone ?? '' }}"
                        },
                    @endforeach
                ];

                // Add markers to map
                hospitalsData.forEach(hospital => {
                    if (hospital.latitude && hospital.longitude) {
                        L.marker([hospital.latitude, hospital.longitude], {
                                icon: L.divIcon({
                                    html: '<i class="fas fa-hospital" style="color:#dc2626; font-size: 24px;"></i>',
                                    className: 'leaflet-div-icon',
                                    iconSize: [24, 24],
                                    iconAnchor: [12, 12]
                                })
                            })
                            .addTo(map)
                            .bindPopup(`
                            <div>
                                <h6>${hospital.nama}</h6>
                                <p><small>${hospital.alamat}</small></p>
                                ${hospital.no_telp ? `<p><small>Telp: ${hospital.no_telp}</small></p>` : ''}
                                <button onclick="selectHospital(${hospital.id}, '${hospital.nama}', [${hospital.latitude}, ${hospital.longitude}])"
                                        class="btn btn-sm btn-primary">Pilih</button>
                            </div>
                        `);
                    }
                });
            @endif

            // Handle hospital selection from dropdown
            sel.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    const lat = parseFloat(selectedOption.dataset.lat);
                    const lng = parseFloat(selectedOption.dataset.lng);

                    if (lat && lng) {
                        map.setView([lat, lng], 15);

                        if (currentMarker) {
                            map.removeLayer(currentMarker);
                        }

                        currentMarker = L.marker([lat, lng], {
                                icon: L.divIcon({
                                    html: '<i class="fas fa-hospital" style="color:#dc2626; font-size: 24px;"></i>',
                                    className: 'leaflet-div-icon',
                                    iconSize: [24, 24],
                                    iconAnchor: [12, 12]
                                })
                            })
                            .addTo(map)
                            .bindPopup(selectedOption.text)
                            .openPopup();

                        // Update hidden field
                        hidden.value = JSON.stringify({
                            lat: lat,
                            lng: lng
                        });
                    }
                }
            });

            // Global function for selecting hospital from map popup
            window.selectHospital = (id, name, coords) => {
                sel.value = id;
                map.setView(coords, 15);

                if (currentMarker) {
                    map.removeLayer(currentMarker);
                }

                currentMarker = L.marker(coords, {
                        icon: L.divIcon({
                            html: '<i class="fas fa-hospital" style="color:#dc2626; font-size: 24px;"></i>',
                            className: 'leaflet-div-icon',
                            iconSize: [24, 24],
                            iconAnchor: [12, 12]
                        })
                    })
                    .addTo(map)
                    .bindPopup(name)
                    .openPopup();

                hidden.value = JSON.stringify({
                    lat: coords[0],
                    lng: coords[1]
                });
            };

            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            document.querySelector('input[name="jadwal_tanggal"]').setAttribute('min', today);

            // Handle form submission
            form.addEventListener('submit', function(e) {
                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                loadingText.classList.remove('hidden');
            });

            const checkbox = document.getElementById('periksaDiTempat');
            const fields = document.querySelectorAll('#pemeriksaanFisikFields input');
            const modal = new bootstrap.Modal(document.getElementById('konfirmasiModal'));

            // Restore checkbox state on page load
            if (checkbox.checked) {
                fields.forEach(i => {
                    i.value = '';
                    i.disabled = true;
                });
            }

            checkbox.addEventListener('change', (e) => {
                if (e.target.checked) {
                    modal.show();
                } else {
                    fields.forEach(i => i.disabled = false);
                }
            });

            document.getElementById('modalConfirm').addEventListener('click', () => {
                fields.forEach(i => {
                    i.value = '';
                    i.disabled = true;
                });
                modal.hide();
            });

            document.getElementById('modalCancel').addEventListener('click', () => {
                checkbox.checked = false;
                fields.forEach(i => i.disabled = false);
            });

            // Auto-calculate BMI
            const beratBadan = document.querySelector('input[name="berat_badan"]');
            const tinggiBadan = document.querySelector('input[name="tinggi_badan"]');
            const imt = document.querySelector('input[name="imt"]');

            function calculateBMI() {
                const berat = parseFloat(beratBadan.value);
                const tinggi = parseFloat(tinggiBadan.value) / 100; // convert cm to m

                if (berat && tinggi) {
                    const bmi = (berat / (tinggi * tinggi)).toFixed(2);
                    imt.value = bmi;
                }
            }

            beratBadan.addEventListener('input', calculateBMI);
            tinggiBadan.addEventListener('input', calculateBMI);
        });
    </script>
@endsection

