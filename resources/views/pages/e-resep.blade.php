@extends('layouts.app')

@section('title', 'E-Resep')
@section('page-title', 'E-Resep')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold text-center">E-Resep</h2>
    <p class="text-center text-gray-600">Silahkan mencari obat yang sesuai dengan penyakit anda</p>


    <div class="mb-4">
        <label for="search" class="form-label">Cari Obat</label>
        <input type="text" id="search" class="form-control" placeholder="Masukkan nama obat atau kategori" oninput="searchMedicine()">
    </div>

    <div id="medicineList" class="mt-4">
        <h3 class="text-xl font-semibold">Daftar Obat</h3>
        <ul id="medicineResults" class="list-group mt-2">
            </ul>
    </div>

    <div id="selectedMedicine" class="mt-4">
        <h3 class="text-xl font-semibold">Obat yang Dipilih</h3>
        <form id="prescriptionForm">
            <div class="mb-3">
                <label for="medicineName" class="form-label">Nama Obat</label>
                <input type="text" id="medicineName" class="form-control" readonly>
            </div>
            <div class="mb-3">
                <label for="dosage" class="form-label">Dosis</label>
                <input type="text" id="dosage" class="form-control" placeholder="Masukkan dosis">
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Jumlah</label>
                <input type="number" id="quantity" class="form-control" placeholder="Masukkan jumlah" min="1">
            </div>
            <button type="button" class="btn btn-success" onclick="addToPrescription()">Tambahkan ke Resep</button>
        </form>
    </div>

    <div id="prescriptionList" class="mt-4">
        <h3 class="text-xl font-semibold">Resep Anda</h3>
        <ul id="prescriptionResults" class="list-group mt-2">
            </ul>
        <button type="button" class="btn btn-primary mt-3" onclick="savePrescription()" id="saveButton">Simpan Resep</button>
    </div>

    <div id="prescriptionHistory" class="mt-4">
        <h3 class="text-xl font-semibold">Riwayat E-Resep</h3>
        <table class="table table-striped mt-2">
            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Dosis</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th> {{-- Added for clarity --}}
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody id="historyResults">
                </tbody>
        </table>
    </div>
</div>

<script>
    // Set up CSRF token for AJAX requests (hanya jika jQuery tersedia)
    if (typeof $ !== 'undefined') {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    let prescriptions = [];
    let selectedMedicineTemplate = null; // Store the full selected medicine object

    function searchMedicine() {
        const query = document.getElementById('search').value.toLowerCase();

        fetch(`/e-resep/search?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                displayResults(data);
            })
            .catch(error => {
                console.error('Error fetching medicines:', error);
            });
    }

    function displayResults(results) {
        const resultsContainer = document.getElementById('medicineResults');
        resultsContainer.innerHTML = '';

        if (results.length === 0) {
            resultsContainer.innerHTML = '<li class="list-group-item text-muted">Tidak ada obat ditemukan.</li>';
            return;
        }

        results.forEach(medicine => {
            const li = document.createElement('li');
            li.className = 'list-group-item list-group-item-action';
            li.style.cursor = 'pointer';
            li.innerHTML = `
                <strong>${medicine.medicine_name}</strong> (${medicine.category}) - Rp ${medicine.price}
                <br><small class="text-muted">${medicine.description || medicine.indication}</small>
            `;
            li.onclick = () => selectMedicine(medicine);
            resultsContainer.appendChild(li);
        });
    }

    function selectMedicine(medicine) {
        selectedMedicineTemplate = medicine; // Store the entire medicine object
        document.getElementById('medicineName').value = medicine.medicine_name;
        document.getElementById('dosage').value = medicine.dosage; // Pre-fill dosage if available
        document.getElementById('quantity').value = 1; // Default quantity
    }

    function addToPrescription() {
        if (!selectedMedicineTemplate) {
            alert('Silakan pilih obat terlebih dahulu.');
            return;
        }

        const medicineName = document.getElementById('medicineName').value;
        const dosage = document.getElementById('dosage').value;
        const quantity = parseInt(document.getElementById('quantity').value);

        if (medicineName && dosage && quantity && !isNaN(quantity) && quantity > 0) {
            const prescription = {
                medicine_name: medicineName,
                dosage: dosage,
                quantity: quantity,
                // We'll get the price from the template during the save operation on the backend
                // or you can add selectedMedicineTemplate.price here if you want to calculate total client-side
                price_per_unit: selectedMedicineTemplate.price // Storing price per unit for display
            };

            prescriptions.push(prescription);
            updatePrescriptionDisplay();

            // Clear the form for the next entry
            document.getElementById('medicineName').value = '';
            document.getElementById('dosage').value = '';
            document.getElementById('quantity').value = '';
            selectedMedicineTemplate = null; // Clear selected medicine
        } else {
            alert('Silakan lengkapi semua informasi obat dengan benar (jumlah harus angka positif).');
        }
    }

    function updatePrescriptionDisplay() {
        const prescriptionList = document.getElementById('prescriptionResults');
        prescriptionList.innerHTML = '';

        if (prescriptions.length === 0) {
            prescriptionList.innerHTML = '<li class="list-group-item text-muted">Belum ada obat dalam resep Anda.</li>';
            return;
        }

        prescriptions.forEach((prescription, index) => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            const totalPriceItem = (prescription.price_per_unit * prescription.quantity).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });

            li.innerHTML = `
                <div>
                    <strong>${prescription.medicine_name}</strong><br>
                    <small>Dosis: ${prescription.dosage}, Jumlah: ${prescription.quantity}</small><br>
                    <small>Harga: ${totalPriceItem}</small>
                </div>
                <button type="button" class="btn btn-sm btn-danger" onclick="removePrescription(${index})">
                    <i class="fa fa-trash"></i>
                </button>
            `;
            prescriptionList.appendChild(li);
        });
    }

    function removePrescription(index) {
        prescriptions.splice(index, 1);
        updatePrescriptionDisplay();
    }

    function savePrescription() {
        if (prescriptions.length === 0) {
            alert('Tidak ada resep untuk disimpan.');
            return;
        }

        const saveButton = document.getElementById('saveButton');
        saveButton.disabled = true;
        saveButton.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Menyimpan...';

        fetch('/e-resep', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                prescriptions: prescriptions // Send the array of prescription items
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Resep berhasil disimpan!');
                prescriptions = []; // Clear current prescription after successful save
                updatePrescriptionDisplay();
                loadPrescriptionHistory(); // Reload history to show the new entry
            } else {
                alert('Gagal menyimpan resep: ' + (data.message || 'Terjadi kesalahan'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan resep.');
        })
        .finally(() => {
            saveButton.disabled = false;
            saveButton.innerHTML = 'Simpan Resep';
        });
    }

    function loadPrescriptionHistory() {
        fetch('/e-resep/history')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayHistory(data.data);
                } else {
                    console.error('Failed to load history:', data.message);
                }
            })
            .catch(error => {
                console.error('Error loading history:', error);
            });
    }

    function displayHistory(history) {
        const historyResults = document.getElementById('historyResults');
        historyResults.innerHTML = '';

        if (history.length === 0) {
            historyResults.innerHTML = '<tr><td colspan="5" class="text-center text-muted">Belum ada riwayat resep.</td></tr>';
            return;
        }

        history.forEach(item => {
            const row = document.createElement('tr');
            const itemPriceFormatted = parseFloat(item.price).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
            const dateOptions = { year: 'numeric', month: '2-digit', day: '2-digit' };
            const formattedDate = new Date(item.created_at).toLocaleDateString('id-ID', dateOptions);

            row.innerHTML = `
                <td>${item.medicine_name}</td>
                <td>${item.dosage}</td>
                <td>${item.quantity}</td>
                <td>${itemPriceFormatted}</td>
                <td>${formattedDate}</td>
            `;
            historyResults.appendChild(row);
        });
    }

    // Initialize the page
    document.addEventListener('DOMContentLoaded', function() {
        loadPrescriptionHistory(); // Load existing prescription history
    });
</script>
@endsection
