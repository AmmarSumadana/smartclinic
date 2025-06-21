<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\TesLabController;
use App\Http\Controllers\LabTestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CekMedisController;
use App\Http\Controllers\DaftarRsController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\KesehatankuController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\EResepController;
use App\Http\Controllers\RawatInapController;
use App\Http\Controllers\RiwayatMedisController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\LayananAmbulansController;
use App\Http\Middleware\CheckUserRole; // Import middleware secara eksplisit

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Rute Autentikasi (menggunakan Breeze/Fortify)
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Rute yang memerlukan autentikasi
Route::middleware(['auth', 'verified'])->group(function () {
    // Rute Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // =========================================================
    // Rute untuk Pasien
    // =========================================================
    Route::middleware(CheckUserRole::class . ':pasien')->group(function () { // Perbaikan peran: 'pasien'
        // Dashboard Pasien
        Route::get('/dashboard', [HospitalController::class, 'index'])->name('dashboard');

        // E-Resep routes
        Route::get('/e-resep', [EResepController::class, 'index'])->name('e-resep');
        Route::post('/e-resep', [EResepController::class, 'store'])->name('e-resep.store');
        Route::get('/e-resep/search', [EResepController::class, 'searchMedicines'])->name('e-resep.search');
        Route::get('/e-resep/history', [EResepController::class, 'getPrescriptionHistory'])->name('e-resep.history');

        // Layanan Ambulans routes
        Route::get('/layanan-ambulans', [LayananAmbulansController::class, 'index'])->name('layanan-ambulans.index');
        Route::post('/layanan-ambulans', [LayananAmbulansController::class, 'store'])->name('layanan-ambulans.store');
        Route::patch('/layanan-ambulans/{id}/cancel', [LayananAmbulansController::class, 'cancel'])->name('layanan-ambulans.cancel');
        Route::get('/api/layanan-ambulans/{id}', [LayananAmbulansController::class, 'show'])->name('layanan-ambulans.show');
        Route::patch('/api/layanan-ambulans/{id}/status', [LayananAmbulansController::class, 'updateStatus'])->name('layanan-ambulans.update-status');

        // Kesehatanku Dashboard
        Route::get('/kesehatanku', [KesehatankuController::class, 'index'])->name('kesehatanku');

        // Rawat Inap (untuk pasien mengajukan permohonan)
        Route::get('/rawat-inap', [RawatInapController::class, 'index'])->name('rawat-inap.index');
        Route::post('/rawat-inap', [RawatInapController::class, 'store'])->name('rawat-inap.store');


        // Riwayat Medis (untuk pasien)
        Route::get('/riwayat-medis', [RiwayatMedisController::class, 'index'])->name('riwayat-medis');

        // Hospital routes (mungkin hanya untuk melihat daftar RS)
        Route::resource('hospitals', HospitalController::class)->only(['index', 'show']);
        Route::get('/hospitals-json', [HospitalController::class, 'getHospitalsJson'])->name('hospitals.json');

        // Daftar Rumah Sakit (alias dari hospitals.index)
        Route::get('/daftar-rs', [DaftarRsController::class, 'index'])->name('daftar-rs');

        // Cek Medis
        Route::get('/cek-medis', [CekMedisController::class, 'create'])->name('cek-medis.form');
        Route::post('/cek-medis', [CekMedisController::class, 'store'])->name('cek-medis.submit');
        Route::get('/cek-medis/{id}/pdf', [CekMedisController::class, 'downloadPdf'])->name('cek-medis.pdf');

        // Konsultasi Dokter
        Route::get('/konsul-dokter', [ConsultationController::class, 'create'])->name('konsul-dokter');
        Route::post('/consultation', [ConsultationController::class, 'store'])->name('consultations.store');
        Route::get('/consultations', [ConsultationController::class, 'index'])->name('consultations.index');

        // LAB TEST ROUTES (untuk pasien)
        Route::get('/tes-lab', [LabTestController::class, 'index'])->name('tes-lab');
        Route::resource('lab-tests', LabTestController::class)->except(['show', 'create', 'edit'])->names([
            'index' => 'lab-tests.index',
            'store' => 'lab-tests.store',
            'update' => 'lab-tests.update',
            'destroy' => 'lab-tests.destroy'
        ]);
        Route::prefix('api/lab-tests')->name('api.lab-tests.')->group(function () {
            Route::get('/', [LabTestController::class, 'getData'])->name('data');
            Route::get('/{labTest}', [LabTestController::class, 'getLabTest'])->name('get');
            Route::get('/stats/summary', [LabTestController::class, 'getStatsSummary'])->name('stats.summary');
            Route::get('/stats/monthly', [LabTestController::class, 'getMonthlyStats'])->name('stats.monthly');
            Route::get('/stats/by-type', [LabTestController::class, 'getStatsByType'])->name('stats.by-type');
            Route::get('/recent/{limit?}', [LabTestController::class, 'getRecentTests'])->name('recent');
        });
        Route::post('/tes-lab/request', [TesLabController::class, 'request'])->name('tes-lab.request');
        Route::prefix('lab-tests')->name('lab-tests.')->group(function () {
            Route::get('/{labTest}/print', [LabTestController::class, 'printResult'])->name('print');
            Route::get('/{labTest}/download', [LabTestController::class, 'downloadResult'])->name('download');
        });
        Route::get('/lab-test-types', [LabTestController::class, 'getTestTypes'])->name('lab-test-types');
        Route::post('/lab-tests/validate', [LabTestController::class, 'validateData'])->name('lab-tests.validate');
    });


    // =========================================================
    // Rute untuk Pegawai Rumah Sakit (Staf & Dokter)
    // =========================================================
    Route::middleware(CheckUserRole::class . ':staff,doctor')->group(function () { // Perbaikan peran: 'staff', 'doctor'
        // Dashboard Pegawai
        Route::get('/dashboard-pegawai', function () {
            return view('dashboard-pegawai'); // Ini akan me-render dashboard-pegawai.blade.php
        })->name('dashboard.pegawai'); // Nama rute yang sudah ada

        // Halaman untuk Menerima Konsultasi (BARU untuk pegawai)
        Route::get('/pegawai/konsultasi', [ConsultationController::class, 'indexPegawai'])->name('pegawai.consultations.index');
        Route::get('/pegawai/konsultasi/{consultation}', [ConsultationController::class, 'showPegawai'])->name('pegawai.consultations.show');
        Route::patch('/pegawai/konsultasi/{consultation}/update-status', [ConsultationController::class, 'updateStatusPegawai'])->name('pegawai.consultations.update-status');

        // Halaman untuk Menerima Pendaftaran Rawat Inap (BARU untuk pegawai)
        Route::get('/pegawai/rawat-inap', [RawatInapController::class, 'indexPegawai'])->name('pegawai.rawat-inap.index');
        Route::get('/pegawai/rawat-inap/{rawatInap}', [RawatInapController::class, 'showPegawai'])->name('pegawai.rawat-inap.show');
        Route::patch('/pegawai/rawat-inap/{rawatInap}/update-status', [RawatInapController::class, 'updateStatusPegawai'])->name('pegawai.rawat-inap.update-status');
        Route::patch('/pegawai/rawat-inap/{rawatInap}/assign-room', [RawatInapController::class, 'assignRoom'])->name('pegawai.rawat-inap.assign-room');

        // Manajemen Data Pasien (Placeholder)
        Route::get('/pegawai/pasien', function () {
            return view('pegawai.patients.index');
        })->name('pegawai.patients.index');
        Route::get('/pegawai/pasien/{user}', function () {
            return view('pegawai.patients.show');
        })->name('pegawai.patients.show');

        // Manajemen Dokter (Placeholder)
        Route::get('/pegawai/dokter', [DoctorController::class, 'indexPegawai'])->name('pegawai.doctors.index');
        Route::get('/pegawai/dokter/create', [DoctorController::class, 'createPegawai'])->name('pegawai.doctors.create');
        Route::post('/pegawai/dokter', [DoctorController::class, 'storePegawai'])->name('pegawai.doctors.store');
        Route::get('/pegawai/dokter/{doctor}/edit', [DoctorController::class, 'editPegawai'])->name('pegawai.doctors.edit');
        Route::patch('/pegawai/dokter/{doctor}', [DoctorController::class, 'updatePegawai'])->name('pegawai.doctors.update');
        Route::delete('/pegawai/dokter/{doctor}', [DoctorController::class, 'destroyPegawai'])->name('pegawai.doctors.destroy');

        // Manajemen Hasil Lab (Placeholder)
        Route::get('/pegawai/lab-test', [LabTestController::class, 'indexPegawai'])->name('pegawai.lab-tests.index');
        Route::get('/pegawai/lab-test/{labTest}', [LabTestController::class, 'showPegawai'])->name('pegawai.lab-tests.show');
        Route::post('/pegawai/lab-test/{labTest}/upload-result', [LabTestController::class, 'uploadResultPegawai'])->name('pegawai.lab-tests.upload-result');

        // Manajemen E-Resep (Placeholder)
        Route::get('/pegawai/e-resep', [EResepController::class, 'indexPegawai'])->name('pegawai.e-resep.index');
        Route::get('/pegawai/e-resep/create', [EResepController::class, 'createPegawai'])->name('pegawai.e-resep.create');
        Route::post('/pegawai/e-resep', [EResepController::class, 'storePegawai'])->name('pegawai.e-resep.store');

        // Manajemen Rumah Sakit (Untuk daftar RS bagi pegawai)
        Route::get('/pegawai/hospitals', [HospitalController::class, 'indexPegawai'])->name('pegawai.hospitals.index');
        Route::get('/pegawai/hospitals/{hospital}', [HospitalController::class, 'showPegawai'])->name('pegawai.hospitals.show');
        Route::resource('hospitals', HospitalController::class)->except(['index', 'show'])->names([
            'create' => 'pegawai.hospitals.create',
            'store' => 'pegawai.hospitals.store',
            'edit' => 'pegawai.hospitals.edit',
            'update' => 'pegawai.hospitals.update',
            'destroy' => 'pegawai.hospitals.destroy'
        ]);

        // Manajemen Layanan Ambulans (untuk pegawai)
        Route::get('/pegawai/ambulans', [LayananAmbulansController::class, 'indexPegawai'])->name('pegawai.ambulances.index');
        Route::get('/pegawai/ambulans/{ambulanceRequest}', [LayananAmbulansController::class, 'showPegawai'])->name('pegawai.ambulances.show');
        Route::patch('/pegawai/ambulans/{ambulanceRequest}/update-status', [LayananAmbulansController::class, 'updateStatusPegawai'])->name('pegawai.ambulances.update-status');

        // Statistik & Laporan (Placeholder)
        Route::get('/pegawai/laporan', function () {
            return view('pegawai.reports.index');
        })->name('pegawai.reports.index');

        // Pengaturan Sistem (Placeholder)
        Route::get('/pegawai/pengaturan', function () {
            return view('pegawai.settings.index');
        })->name('pegawai.settings.index');
    });

    // =========================================================
    // Routes for Hospital Employees (Staff & Doctors)
    // =========================================================
    Route::middleware(CheckUserRole::class . ':staff,doctor')->group(function () {
        // Employee Dashboard
        Route::get('/dashboard-pegawai', function () {
            return view('dashboard-pegawai'); // This will render dashboard-pegawai.blade.php
        })->name('dashboard.pegawai');

        // Consultation Management Page (for employees)
        Route::get('/pegawai/konsultasi', function () {
            return view('pegawai.consultations');
        })->name('pegawai.consultations.index');
        Route::get('/pegawai/konsultasi/{consultation}', [ConsultationController::class, 'showPegawai'])->name('pegawai.consultations.show');
        Route::patch('/pegawai/konsultasi/{consultation}/update-status', [ConsultationController::class, 'updateStatusPegawai'])->name('pegawai.consultations.update-status');

        // Inpatient Registration Management Page (for employees)
        Route::get('/pegawai/rawat-inap', function () {
            return view('pegawai.rawat-inap');
        })->name('pegawai.rawat-inap.index');
        Route::get('/pegawai/rawat-inap/{rawatInap}', [RawatInapController::class, 'showPegawai'])->name('pegawai.rawat-inap.show');
        Route::patch('/pegawai/rawat-inap/{rawatInap}/update-status', [RawatInapController::class, 'updateStatusPegawai'])->name('pegawai.rawat-inap.update-status');
        Route::patch('/pegawai/rawat-inap/{rawatInap}/assign-room', [RawatInapController::class, 'assignRoom'])->name('pegawai.rawat-inap.assign-room');

        // Patient Data Management
        Route::get('/pegawai/pasien', function () {
            return view('pegawai.patients');
        })->name('pegawai.patients.index');
        Route::get('/pegawai/pasien/{user}', function () {
            return view('pegawai.patients.show');
        })->name('pegawai.patients.show');

        // Doctor Management
        Route::get('/pegawai/dokter', function () {
            return view('pegawai.doctors');
        })->name('pegawai.doctors.index');
        Route::get('/pegawai/dokter/create', [DoctorController::class, 'createPegawai'])->name('pegawai.doctors.create');
        Route::post('/pegawai/dokter', [DoctorController::class, 'storePegawai'])->name('pegawai.doctors.store');
        Route::get('/pegawai/dokter/{doctor}/edit', [DoctorController::class, 'editPegawai'])->name('pegawai.doctors.edit');
        Route::patch('/pegawai/dokter/{doctor}', [DoctorController::class, 'updatePegawai'])->name('pegawai.doctors.update');
        Route::delete('/pegawai/dokter/{doctor}', [DoctorController::class, 'destroyPegawai'])->name('pegawai.doctors.destroy');

        // Lab Test Results Management
        Route::get('/pegawai/hasil-lab', function () {
            return view('pegawai.lab-tests');
        })->name('pegawai.lab-tests.index');
        Route::get('/pegawai/hasil-lab/{labTest}', [LabTestController::class, 'showPegawai'])->name('pegawai.lab-tests.show');
        Route::post('/pegawai/hasil-lab/{labTest}/unggah-hasil', [LabTestController::class, 'uploadResultPegawai'])->name('pegawai.lab-tests.upload-result');

        // E-Resep Management
        Route::get('/pegawai/e-resep', function () {
            return view('pegawai.e-resep');
        })->name('pegawai.e-resep.index');
        Route::get('/pegawai/e-resep/buat', [EResepController::class, 'createPegawai'])->name('pegawai.e-resep.create');
        Route::post('/pegawai/e-resep', [EResepController::class, 'storePegawai'])->name('pegawai.e-resep.store');

        // Hospital Data Management (for employees to view/manage hospitals)
        Route::get('/pegawai/rumah-sakit', function () {
            return view('pegawai.hospitals');
        })->name('pegawai.hospitals.index');
        Route::get('/pegawai/rumah-sakit/{hospital}', [HospitalController::class, 'showPegawai'])->name('pegawai.hospitals.show');
        Route::resource('hospitals', HospitalController::class)->except(['index', 'show'])->names([
            'create' => 'pegawai.hospitals.create',
            'store' => 'pegawai.hospitals.store',
            'edit' => 'pegawai.hospitals.edit',
            'update' => 'pegawai.hospitals.update',
            'destroy' => 'pegawai.hospitals.destroy'
        ]);

        // Ambulance Service Management (for employees)
        Route::get('/pegawai/ambulans', function () {
            return view('pegawai.ambulances');
        })->name('pegawai.ambulances.index');
        Route::get('/pegawai/ambulans/{ambulanceRequest}', [LayananAmbulansController::class, 'showPegawai'])->name('pegawai.ambulances.show');
        Route::patch('/pegawai/ambulans/{ambulanceRequest}/update-status', [LayananAmbulansController::class, 'updateStatusPegawai'])->name('pegawai.ambulances.update-status');

        // Statistics & Reports
        Route::get('/pegawai/laporan', function () {
            return view('pegawai.reports');
        })->name('pegawai.reports.index');
    });
});

require __DIR__ . '/auth.php';
