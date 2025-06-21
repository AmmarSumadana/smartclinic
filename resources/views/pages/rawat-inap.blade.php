@extends('layouts.app')

@section('title', 'Pendaftaran Rawat Inap Online')
@section('page-title', 'Pendaftaran Rawat Inap Online')

@push('head')
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Animate.css untuk animasi -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    {{-- Asumsi Tailwind CSS sudah dimuat di layouts/app.blade.php --}}

    <style>
        /* Gaya tambahan untuk loading spinner di tengah modal */
        .loading-spinner {
            border: 4px solid #f3f3f3;
            /* Light grey */
            border-top: 4px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Tidak lagi menggunakan CSS Neumorphism kustom di sini, mengandalkan Tailwind CSS untuk kartu putih */

        /* Gaya untuk container input file dan preview */
        .file-input-preview-group {
            display: flex;
            align-items: center;
            gap: 1rem;
            /* Spasi antara input dan preview */
        }

        .file-preview {
            width: 80px;
            /* Ukuran lebar yang sama dengan input file */
            height: 80px;
            /* Ukuran tinggi yang sama dengan input file */
            border: 1px solid #e2e8f0;
            /* border-gray-300 */
            border-radius: 0.375rem;
            /* rounded-md */
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            /* Mencegah preview mengecil */
            background-color: #f7fafc;
            /* bg-gray-50 */
            color: #a0a8b3;
            /* text-gray-400 */
        }

        .file-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Memastikan gambar mengisi area tanpa terdistorsi */
        }
    </style>
@endpush

@section('content')
    {{-- Mengatur background div utama menjadi abu-abu terang sesuai Tailwind --}}
    <div class="p-6 md:p-8 lg:p-10 bg-gray-100 min-h-screen">
        {{-- Header Halaman --}}
        <div class="text-center mb-6 animate__animated animate__fadeInDown">
            <h2 class="text-2xl font-semibold text-center">Rawat Inap Online</h2>
            <p class="text-center text-gray-600">Silahkan melakukan pendaftaran rawat inap pada rumah sakit terdekat melalui
                sistem online kami</p>
        </div>

        {{-- Bagian Status Rawat Inap (Kartu Pertama) --}}
        <div class="grid grid-cols-1 ">
            <div class="col-span-1">
                @php
                    // Fungsi pembantu untuk menerjemahkan status
                    $translateStatus = function ($status) {
                        switch ($status) {
                            case 'pending':
                                return 'Menunggu Konfirmasi';
                            case 'approved':
                                return 'Disetujui';
                            case 'admitted':
                                return 'Sedang Dirawat';
                            case 'rejected':
                                return 'Ditolak';
                            case 'cancelled':
                                return 'Dibatalkan';
                            default:
                                return 'Tidak Diketahui';
                        }
                    };
                @endphp

                @if (isset($isAdmitted) && $isAdmitted)
                    {{-- Kartu berwarna putih dan shadow standar --}}
                    <div class="bg-white p-6 rounded-xl shadow-md mb-4 animate__animated animate__fadeInUp">
                        <i class="fa-solid fa-hourglass-half text-red-600 text-4xl mb-3"></i> {{-- Icon menunggu, warna merah --}}
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">Status Pendaftaran Rawat Inap Anda</h4>
                        <p class="text-gray-600 mb-1">
                            Anda telah mendaftar rawat inap di **{{ $admissionDetails['hospital_name'] }}**.
                            @if ($admissionDetails['room_number'])
                                <br>Nomor Kamar: **{{ $admissionDetails['room_number'] }}**
                            @endif
                            <br>Status Saat Ini: **{{ $translateStatus($admissionDetails['status']) }}**
                        </p>
                    </div>
                @else
                    {{-- Kartu berwarna putih dan shadow standar --}}
                    <div class="bg-white p-6 rounded-xl shadow-md mb-4 animate__animated animate__fadeInUp">
                        <i class="fa-solid fa-hourglass-half text-red-600 text-4xl mb-3"></i> {{-- Icon menunggu, warna merah --}}
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">Siap Mendaftar Rawat Inap Online?</h4>
                        <p class="text-gray-600 mb-0">Ikuti langkah-langkah mudah di bawah ini untuk mengajukan permohonan
                            rawat inap baru.
                            <br>Status: <span class="font-bold text-gray-700">Belum Ada Pendaftaran Aktif</span>
                        </p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Bagian Panduan Pendaftaran (Kartu Kedua) - Menggunakan kelas kartu putih standar --}}
        <div class="grid grid-cols-1 ">
            <div class="col-span-1">
                {{-- Menggunakan kelas kartu putih standar --}}
                <div class="bg-white p-6 rounded-xl shadow-md animate__animated animate__fadeInUp animate__delay-1s">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-6 text-center">Panduan Pendaftaran Mudah</h3>

                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex items-center justify-center w-14 h-14 bg-red-100 rounded-full text-red-600 text-2xl flex-shrink-0 shadow-sm">
                                <i class="fa-solid fa-clipboard-list"></i>
                            </div>
                            <div>
                                <h5 class="text-lg font-semibold text-gray-900 mb-2">1. Siapkan Dokumen Pendukung</h5>
                                <p class="text-gray-600">Pastikan Anda memiliki KTP/Identitas, Surat Pengantar Dokter
                                    (PDF/JPG), dan Kartu Asuransi/BPJS (jika menggunakan) untuk mempercepat proses
                                    verifikasi.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div
                                class="flex items-center justify-center w-14 h-14 bg-red-100 rounded-full text-red-600 text-2xl flex-shrink-0 shadow-sm">
                                <i class="fa-solid fa-file-alt"></i>
                            </div>
                            <div>
                                <h5 class="text-lg font-semibold text-gray-900 mb-2">2. Isi Formulir Online</h5>
                                <p class="text-gray-600">Klik tombol "Mulai Pendaftaran" di bawah ini dan lengkapi semua
                                    informasi pribadi serta detail medis yang diperlukan pada formulir online kami.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div
                                class="flex items-center justify-center w-14 h-14 bg-red-100 rounded-full text-red-600 text-2xl flex-shrink-0 shadow-sm">
                                <i class="fa-solid fa-check-circle"></i>
                            </div>
                            <div>
                                <h5 class="text-lg font-semibold text-gray-900 mb-2">3. Konfirmasi & Tunggu Verifikasi</h5>
                                <p class="text-gray-600">Setelah pengajuan, tim administrasi kami akan segera memverifikasi
                                    data Anda. Notifikasi status akan dikirimkan langsung ke email atau nomor telepon Anda.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-8">
                        {{-- Tombol utama: Menggunakan gaya yang diminta --}}
                        <button type="button"
                            class="bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700 animate__animated animate__pulse animate__infinite"
                            data-bs-toggle="modal" data-bs-target="#registrationModal">
                            <i class="fa-solid fa-arrow-alt-circle-right me-3"></i> Mulai Pendaftaran Rawat Inap Sekarang!
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Modal untuk Formulir Pendaftaran -->
    <div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-xl shadow-lg"> {{-- Tetap gunakan shadow-lg untuk modal content --}}
                <div class="modal-header bg-gray-50 border-b border-gray-200 p-4 rounded-t-xl">
                    <h5 class="modal-title text-xl font-bold text-gray-900" id="registrationModalLabel">Formulir Pendaftaran
                        Rawat Inap</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="registrationForm" enctype="multipart/form-data">
                    @csrf {{-- CSRF token untuk keamanan Laravel --}}
                    <div class="modal-body p-6 space-y-5">
                        {{-- Nama Pasien (default dari Auth::user()->name) --}}
                        <div>
                            <label for="patient_name" class="block text-gray-700 text-sm font-semibold mb-2">Nama
                                Pasien</label>
                            <input type="text" id="patient_name" name="patient_name"
                                class="block w-full border border-gray-300 rounded-md py-2 px-3 shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                value="{{ Auth::user()->name ?? '' }}" required readonly>
                            <div class="text-red-500 text-sm mt-1" id="error-patient_name"></div>
                        </div>

                        {{-- Nama Rumah Sakit (SEKARANG DROPDOWN) --}}
                        <div>
                            <label for="hospital_name" class="block text-gray-700 text-sm font-semibold mb-2">Nama Rumah
                                Sakit</label>
                            <select id="hospital_name" name="hospital_name"
                                class="block w-full border border-gray-300 rounded-md py-2 px-3 shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                required>
                                <option value="">Pilih Rumah Sakit</option>
                                @foreach ($hospitals as $hospital)
                                    <option value="{{ $hospital->nama }}">{{ $hospital->nama }}</option>
                                @endforeach
                            </select>
                            <div class="text-red-500 text-sm mt-1" id="error-hospital_name"></div>
                        </div>

                        {{-- Alasan Rawat Inap --}}
                        <div>
                            <label for="reason" class="block text-gray-700 text-sm font-semibold mb-2">Alasan Rawat
                                Inap</label>
                            <textarea id="reason" name="reason" rows="3"
                                class="block w-full border border-gray-300 rounded-md py-2 px-3 shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Jelaskan alasan Anda memerlukan rawat inap (contoh: Demam tinggi, nyeri perut, dll.)" required></textarea>
                            <div class="text-red-500 text-sm mt-1" id="error-reason"></div>
                        </div>

                        {{-- Tanggal Masuk (Admission Date) --}}
                        <div>
                            <label for="admission_date" class="block text-gray-700 text-sm font-semibold mb-2">Tanggal Masuk
                                yang Diinginkan</label>
                            <input type="date" id="admission_date" name="admission_date"
                                class="block w-full border border-gray-300 rounded-md py-2 px-3 shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <div class="text-red-500 text-sm mt-1" id="error-admission_date"></div>
                        </div>

                        {{-- Upload Dokumen --}}
                        <div class="border-t border-gray-200 pt-5 mt-5 space-y-4">
                            <h6 class="text-lg font-semibold text-gray-800">Upload Dokumen Pendukung (PDF/JPG)</h6>

                            {{-- KTP File Input with Preview --}}
                            <div>
                                <label for="ktp_file" class="block text-gray-700 text-sm font-semibold mb-2">Scan
                                    KTP/Identitas</label>
                                <div class="file-input-preview-group">
                                    <input type="file" id="ktp_file" name="ktp_file" accept=".pdf,.jpg,.jpeg,.png"
                                        class="block w-full text-gray-600 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500
                                           file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold
                                           file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 cursor-pointer"
                                        required>
                                    <div class="file-preview" id="ktp_preview">
                                        <i class="fa-solid fa-image text-gray-400 text-2xl"></i>
                                    </div>
                                </div>
                                <div class="text-red-500 text-sm mt-1" id="error-ktp_file"></div>
                            </div>

                            {{-- Surat Pengantar File Input with Preview --}}
                            <div>
                                <label for="surat_pengantar_file"
                                    class="block text-gray-700 text-sm font-semibold mb-2">Surat Pengantar Dokter</label>
                                <div class="file-input-preview-group">
                                    <input type="file" id="surat_pengantar_file" name="surat_pengantar_file"
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        class="block w-full text-gray-600 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500
                                           file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold
                                           file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 cursor-pointer"
                                        required>
                                    <div class="file-preview" id="surat_pengantar_preview">
                                        <i class="fa-solid fa-image text-gray-400 text-2xl"></i>
                                    </div>
                                </div>
                                <div class="text-red-500 text-sm mt-1" id="error-surat_pengantar_file"></div>
                            </div>

                            {{-- Kartu Asuransi File Input with Preview (Opsional) --}}
                            <div>
                                <label for="kartu_asuransi_file"
                                    class="block text-gray-700 text-sm font-semibold mb-2">Scan Kartu Asuransi/BPJS
                                    (Opsional)</label>
                                <div class="file-input-preview-group">
                                    <input type="file" id="kartu_asuransi_file" name="kartu_asuransi_file"
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        class="block w-full text-gray-600 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500
                                           file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold
                                           file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 cursor-pointer">
                                    <div class="file-preview" id="kartu_asuransi_preview">
                                        <i class="fa-solid fa-image text-gray-400 text-2xl"></i>
                                    </div>
                                </div>
                                <div class="text-red-500 text-sm mt-1" id="error-kartu_asuransi_file"></div>
                            </div>
                        </div>

                        {{-- Area Pesan (Sukses/Error) --}}
                        <div id="form-message" class="mt-4 p-3 text-sm rounded-md hidden" role="alert"></div>
                        <div id="loading-indicator" class="hidden text-center mt-4">
                            <div class="loading-spinner"></div>
                            <p class="text-gray-600 mt-2">Mengirim permohonan...</p>
                        </div>
                    </div>
                    <div class="modal-footer bg-gray-50 border-t border-gray-200 p-4 rounded-b-xl flex justify-end gap-3">
                        <button type="button"
                            class="bg-gray-300 text-gray-800 py-2 px-4 rounded-lg shadow-sm hover:bg-gray-400 transition duration-200"
                            data-bs-dismiss="modal">Batal</button>
                        {{-- Tombol Kirim Permohonan: Menggunakan gaya yang diminta --}}
                        <button type="submit" id="submitBtn"
                            class="bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700">Kirim Permohonan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script untuk AJAX Form Submission --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const registrationForm = document.getElementById('registrationForm');
                const submitBtn = document.getElementById('submitBtn');
                const formMessage = document.getElementById('form-message');
                const loadingIndicator = document.getElementById('loading-indicator');
                const registrationModal = new bootstrap.Modal(document.getElementById('registrationModal'));

                // Elemen input file dan preview-nya
                const ktpFile = document.getElementById('ktp_file');
                const ktpPreview = document.getElementById('ktp_preview');
                const suratPengantarFile = document.getElementById('surat_pengantar_file');
                const suratPengantarPreview = document.getElementById('surat_pengantar_preview');
                const kartuAsuransiFile = document.getElementById('kartu_asuransi_file');
                const kartuAsuransiPreview = document.getElementById('kartu_asuransi_preview');

                // Fungsi untuk menampilkan preview gambar
                function showFilePreview(input, previewElement) {
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            // Hapus konten sebelumnya (ikon atau gambar lama)
                            previewElement.innerHTML = '';
                            // Buat elemen gambar baru
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            // Tambahkan kelas untuk object-fit
                            img.classList.add('object-cover', 'w-full', 'h-full');
                            previewElement.appendChild(img);
                        };
                        reader.readAsDataURL(input.files[0]);
                    } else {
                        // Jika tidak ada file, tampilkan ikon default
                        previewElement.innerHTML = '<i class="fa-solid fa-image text-gray-400 text-2xl"></i>';
                    }
                }

                // Event listener untuk setiap input file
                ktpFile.addEventListener('change', function() {
                    showFilePreview(this, ktpPreview);
                });
                suratPengantarFile.addEventListener('change', function() {
                    showFilePreview(this, suratPengantarPreview);
                });
                kartuAsuransiFile.addEventListener('change', function() {
                    showFilePreview(this, kartuAsuransiPreview);
                });

                // Clear messages and errors when modal is closed
                document.getElementById('registrationModal').addEventListener('hidden.bs.modal', function() {
                    formMessage.classList.add('hidden');
                    formMessage.innerHTML = '';
                    clearErrors();
                    registrationForm.reset(); // Reset form fields
                    // Reset previews to default icon
                    ktpPreview.innerHTML = '<i class="fa-solid fa-image text-gray-400 text-2xl"></i>';
                    suratPengantarPreview.innerHTML =
                        '<i class="fa-solid fa-image text-gray-400 text-2xl"></i>';
                    kartuAsuransiPreview.innerHTML = '<i class="fa-solid fa-image text-gray-400 text-2xl"></i>';
                });

                function clearErrors() {
                    document.querySelectorAll('.text-red-500').forEach(el => el.innerHTML = '');
                }

                registrationForm.addEventListener('submit', async function(e) {
                    e.preventDefault(); // Mencegah submit form default

                    clearErrors(); // Hapus pesan error sebelumnya
                    formMessage.classList.add('hidden');
                    loadingIndicator.classList.remove('hidden'); // Tampilkan loading spinner
                    submitBtn.disabled = true; // Nonaktifkan tombol submit

                    const formData = new FormData(this); // Ambil semua data form, termasuk file

                    try {
                        const response = await fetch("{{ route('rawat-inap.store') }}", {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'Accept': 'application/json', // Penting untuk menerima JSON response
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        });

                        loadingIndicator.classList.add('hidden'); // Sembunyikan loading spinner
                        submitBtn.disabled = false; // Aktifkan kembali tombol submit

                        const data = await response.json();

                        if (response.ok) { // Status 200 OK
                            formMessage.classList.remove('hidden', 'bg-red-100', 'text-red-800');
                            formMessage.classList.add('bg-green-100', 'text-green-800');
                            formMessage.innerHTML =
                                `<i class="fa-solid fa-check-circle me-2"></i> ${data.message}`;
                            registrationForm.reset(); // Reset form setelah sukses

                            setTimeout(() => {
                                registrationModal
                                    .hide(); // Sembunyikan modal setelah beberapa detik
                                location
                                    .reload(); // Muat ulang halaman untuk menampilkan status baru
                            }, 2000);

                        } else if (response.status === 422) { // Validasi error (Unprocessable Entity)
                            formMessage.classList.remove('hidden', 'bg-green-100', 'text-green-800');
                            formMessage.classList.add('bg-red-100', 'text-red-800');
                            formMessage.innerHTML =
                                `<i class="fa-solid fa-exclamation-circle me-2"></i> Mohon perbaiki kesalahan input Anda.`;

                            // Tampilkan error di bawah masing-masing field
                            for (const field in data.errors) {
                                const errorDiv = document.getElementById(`error-${field}`);
                                if (errorDiv) {
                                    errorDiv.innerHTML = data.errors[field][0];
                                }
                            }
                        } else { // Error lain dari server
                            formMessage.classList.remove('hidden', 'bg-green-100', 'text-green-800');
                            formMessage.classList.add('bg-red-100', 'text-red-800');
                            formMessage.innerHTML =
                                `<i class="fa-solid fa-times-circle me-2"></i> Terjadi kesalahan: ${data.message || 'Server error.'}`;
                        }

                    } catch (error) {
                        loadingIndicator.classList.add('hidden');
                        submitBtn.disabled = false;
                        formMessage.classList.remove('hidden', 'bg-green-100', 'text-green-800');
                        formMessage.classList.add('bg-red-100', 'text-red-800');
                        formMessage.innerHTML =
                            `<i class="fa-solid fa-times-circle me-2"></i> Gagal terhubung ke server: ${error.message}`;
                    }
                });
            });
        </script>
    @endpush
@endsection
