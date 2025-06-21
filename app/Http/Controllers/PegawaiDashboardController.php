<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Consultation; // Pastikan model Consultation sudah ada
use App\Models\RawatInap;    // Pastikan model RawatInap sudah ada
use App\Models\User;         // Pastikan model User sudah ada (untuk menghitung pasien)

class PegawaiDashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk pegawai dengan statistik ringkas.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mendapatkan jumlah pasien konsultasi
        // Anda mungkin ingin memfilter berdasarkan status 'completed' atau 'scheduled'
        $totalConsultations = Consultation::count();

        // Mendapatkan jumlah pasien yang sedang rawat inap aktif
        // Mengasumsikan ada kolom 'discharge_date' di tabel 'rawat_inap'
        // Jika tidak ada, Anda perlu menyesuaikan kriteria status aktif rawat inap
        $totalRawatInap = RawatInap::whereNull('discharge_date')->count();

        // Mendapatkan jumlah total pasien (user dengan role 'pasien')
        // Ini mengasumsikan ada kolom 'role' di tabel 'users'
        $totalPatients = User::where('role', 'pasien')->count();

        // Mengirim data ke view dashboard-pegawai.blade.php
        return view('dashboard-pegawai', compact('totalConsultations', 'totalRawatInap', 'totalPatients'));
    }
}
