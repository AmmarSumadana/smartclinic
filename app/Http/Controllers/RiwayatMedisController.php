<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CekMedis;       // Asumsi nama model Anda untuk Cek Medis
use App\Models\Consultation;   // Asumsi nama model Anda untuk Konsultasi Dokter
use App\Models\LabTest;        // Asumsi nama model Anda untuk Tes Lab
use App\Models\HasilResep;    // Asumsi nama model Anda untuk E-Resep/Pembelian Obat
use App\Models\RawatInap;      // Asumsi nama model Anda untuk Rawat Inap
use Carbon\Carbon;

class RiwayatMedisController extends Controller
{
    /**
     * Menampilkan daftar riwayat medis yang digabungkan untuk pengguna yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userId = Auth::id();
        $allMedicalRecords = collect(); // Buat koleksi kosong untuk menampung semua riwayat

        // Ambil data Tes Lab
        $labTests = LabTest::where('user_id', $userId)->get()->map(function($record) {
            $record['type_category'] = 'Tes Lab';
            return $record;
        });
        $allMedicalRecords = $allMedicalRecords->merge($labTests);

        // Ambil data Cek Medis
        // Asumsi 'medical_checks' adalah tabel, dan 'CekMedis' adalah modelnya
        $medicalChecks = CekMedis::where('user_id', $userId)->get()->map(function($record) {
            $record['type_category'] = 'Cek Medis';
            return $record;
        });
        $allMedicalRecords = $allMedicalRecords->merge($medicalChecks);

        // Ambil data Pembelian Obat (E-Resep)
        $medicinePurchases = HasilResep::where('user_id', $userId)->get()->map(function($record) {
            $record['type_category'] = 'Pembelian Obat';
            // Tambahkan data harga total di sini jika belum ada di model HasilResep secara langsung
            // atau pastikan ada field 'price' atau 'total_price'
            if (!isset($record['total_price']) && isset($record['quantity']) && isset($record['price_per_unit'])) {
                $record['total_price'] = $record['quantity'] * $record['price_per_unit'];
            } else if (!isset($record['total_price']) && isset($record['price'])) {
                // Asumsi 'price' adalah harga total per item jika HasilResep menyimpan per item
                $record['total_price'] = $record['price'];
            }
            return $record;
        });
        $allMedicalRecords = $allMedicalRecords->merge($medicinePurchases);

        // Ambil data Rawat Inap
        $inpatientStays = RawatInap::where('user_id', $userId)->get()->map(function($record) {
            $record['type_category'] = 'Rawat Inap';
            // Sesuaikan field yang diperlukan dari model RawatInap
            return $record;
        });
        $allMedicalRecords = $allMedicalRecords->merge($inpatientStays);

        // Ambil data Konsultasi Dokter
        $doctorConsultations = Consultation::where('user_id', $userId)->get()->map(function($record) {
            $record['type_category'] = 'Konsultasi Dokter';
            // Sesuaikan field yang diperlukan dari model Consultation
            return $record;
        });
        $allMedicalRecords = $allMedicalRecords->merge($doctorConsultations);


        // Urutkan semua riwayat berdasarkan tanggal terbaru
        // Asumsi semua model memiliki kolom 'created_at' atau 'date'
        // Anda mungkin perlu menyesuaikan nama kolom tanggal di sini
        $allMedicalRecords = $allMedicalRecords->sortByDesc(function($record) {
            // Coba beberapa nama kolom tanggal yang umum
            return Carbon::parse($record->date ?? $record->created_at ?? null);
        })->values(); // Reset keys setelah pengurutan

        return view('pages.riwayat-medis', compact('allMedicalRecords'));
    }
}
