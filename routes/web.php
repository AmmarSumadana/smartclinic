<?php

use Illuminate\Support\Facades\Route;
// Hapus atau komentari ini jika tidak ada lagi rute DoctorController yang digunakan
// use App\Http\Controllers\DoctorController;
use App\Http\Controllers\TesLabController; // Ini sepertinya LabTestController versi lama atau untuk fungsi spesifik, tetap pertahankan jika digunakan
use App\Http\Controllers\LabTestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CekMedisController;
use App\Http\Controllers\DaftarRsController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\KesehatankuController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\PegawaiConsultationController;
use App\Http\Controllers\EResepController;
use App\Http\Controllers\RawatInapController;
use App\Http\Controllers\RiwayatMedisController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\LayananAmbulansController;
use App\Http\Controllers\PegawaiPatientController;
use App\Http\Middleware\CheckUserRole;

// Import controller yang baru ditambahkan/dibutuhkan
use App\Http\Controllers\PegawaiDashboardController; // Tambahkan ini
use App\Http\Controllers\HospitalReportController;   // Tambahkan ini

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(CheckUserRole::class . ':pasien')->group(function () {
        Route::get('/dashboard', [HospitalController::class, 'index'])->name('dashboard');

        Route::get('/konsul-dokter/create', [ConsultationController::class, 'create'])->name('consultations.create');
        Route::get('/konsul-dokter', [ConsultationController::class, 'index'])->name('konsul-dokter');
        Route::post('/consultation', [ConsultationController::class, 'store'])->name('consultations.store');
        Route::get('/consultations', [ConsultationController::class, 'index'])->name('consultations.index');

        Route::get('/e-resep', [EResepController::class, 'index'])->name('e-resep');
        Route::post('/e-resep', [EResepController::class, 'store'])->name('e-resep.store');
        Route::get('/e-resep/search', [EResepController::class, 'searchMedicines'])->name('e-resep.search');
        Route::get('/e-resep/history', [EResepController::class, 'getPrescriptionHistory'])->name('e-resep.history');
        Route::get('/e-resep/{eresep}', [EResepController::class, 'show'])->name('e-resep.show');

        Route::get('/layanan-ambulans', [LayananAmbulansController::class, 'index'])->name('layanan-ambulans.index');
        Route::post('/layanan-ambulans', [LayananAmbulansController::class, 'store'])->name('layanan-ambulans.store');
        Route::patch('/layanan-ambulans/{id}/cancel', [LayananAmbulansController::class, 'cancel'])->name('layanan-ambulans.cancel');
        Route::get('/api/layanan-ambulans/{id}', [LayananAmbulansController::class, 'show'])->name('layanan-ambulans.show');
        Route::patch('/api/layanan-ambulans/{id}/status', [LayananAmbulansController::class, 'updateStatus'])->name('layanan-ambulans.update-status');

        Route::get('/kesehatanku', [KesehatankuController::class, 'index'])->name('kesehatanku');

        Route::get('/rawat-inap', [RawatInapController::class, 'index'])->name('rawat-inap.index');
        Route::post('/rawat-inap', [RawatInapController::class, 'store'])->name('rawat-inap.store');

        Route::get('/riwayat-medis', [RiwayatMedisController::class, 'index'])->name('riwayat-medis');

        Route::resource('hospitals', HospitalController::class)->only(['index', 'show']);
        Route::get('/hospitals-json', [HospitalController::class, 'getHospitalsJson'])->name('hospitals.json');
        Route::get('/daftar-rs', [DaftarRsController::class, 'index'])->name('daftar-rs');

        Route::get('/cek-medis', [CekMedisController::class, 'create'])->name('cek-medis.form');
        Route::post('/cek-medis', [CekMedisController::class, 'store'])->name('cek-medis.submit');
        Route::get('/cek-medis/{id}/pdf', [CekMedisController::class, 'downloadPdf'])->name('cek-medis.pdf');

        // TES LAB ROUTES FOR PASIEN (TETAP ADA KARENA INI UNTUK PASIEN)
        Route::get('/tes-lab', [LabTestController::class, 'index'])->name('tes-lab');
        Route::post('/tes-lab/store', [LabTestController::class, 'store'])->name('lab-tests.store');

        Route::prefix('lab-tests')->name('lab-tests.')->group(function () {
            Route::get('/{labTest}/print', [LabTestController::class, 'printResult'])->name('print');
            Route::get('/{labTest}/download', [LabTestController::class, 'downloadResult'])->name('download');
            Route::get('/types', [LabTestController::class, 'getTestTypes'])->name('types');
            Route::post('/validate', [LabTestController::class, 'validateData'])->name('validate');
            Route::delete('/{labTest}', [LabTestController::class, 'destroy'])->name('destroy');
            Route::get('/data', [LabTestController::class, 'getData'])->name('data');
            Route::get('/{labTest}/get', [LabTestController::class, 'getLabTest'])->name('get');
            Route::get('/stats/summary', [LabTestController::class, 'getStatsSummary'])->name('stats.summary');
            Route::get('/stats/monthly', [LabTestController::class, 'getMonthlyStats'])->name('stats.monthly');
            Route::get('/stats/by-type', [LabTestController::class, 'getStatsByType'])->name('stats.by-type');
            Route::get('/recent/{limit?}', [LabTestController::class, 'getRecentTests'])->name('recent');
            Route::patch('/{labTest}', [LabTestController::class, 'update'])->name('update');
        });
    });

    // Rute untuk Peran Pegawai Rumah Sakit (Staf & Dokter)
    Route::middleware(CheckUserRole::class . ':staff,doctor')->group(function () {
        // Rute Dashboard Pegawai
        // Mengarahkan ke PegawaiDashboardController
        Route::get('/dashboard-pegawai', [PegawaiDashboardController::class, 'index'])->name('dashboard.pegawai');

        Route::get('/pegawai/konsultasi', [PegawaiConsultationController::class, 'index'])->name('pegawai.consultations.index');
        Route::get('/pegawai/konsultasi/{consultation}', [PegawaiConsultationController::class, 'show'])->name('pegawai.consultations.show');
        Route::patch('/pegawai/konsultasi/{consultation}/update-status', [PegawaiConsultationController::class, 'updateStatus'])->name('pegawai.consultations.update-status');
        Route::delete('/pegawai/konsultasi/{consultation}', [PegawaiConsultationController::class, 'destroy'])->name('pegawai.consultations.destroy');

        Route::get('/pegawai/rawat-inap', [RawatInapController::class, 'indexPegawai'])->name('pegawai.rawat-inap.index');
        Route::get('/pegawai/rawat-inap/{rawatInap}', [RawatInapController::class, 'showPegawai'])->name('pegawai.rawat-inap.show');
        Route::patch('/pegawai/rawat-inap/{rawatInap}/update-status', [RawatInapController::class, 'updateStatusPegawai'])->name('pegawai.rawat-inap.update-status');
        Route::patch('/pegawai/rawat-inap/{rawatInap}/assign-room', [RawatInapController::class, 'assignRoom'])->name('pegawai.rawat-inap.assign-room');

        Route::get('/pegawai/pasien', [PegawaiPatientController::class, 'index'])->name('pegawai.patients.index');
        Route::get('/pegawai/pasien/{user}', [PegawaiPatientController::class, 'show'])->name('pegawai.patients.show');

        // ROUTE YANG DIHAPUS DARI SINI (DATA DOKTER): Sudah dihapus
        // Route::get('/pegawai/dokter', [DoctorController::class, 'indexPegawai'])->name('pegawai.doctors.index');
        // ... dst

        Route::get('/pegawai/pengaturan', function () {
            return view('pegawai.settings.index');
        })->name('pegawai.settings.index');
    });
});

require __DIR__ . '/auth.php';
