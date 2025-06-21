<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate; // Untuk Gate/Authorization jika diperlukan

class PegawaiPatientController extends Controller
{
    /**
     * Menampilkan daftar semua pasien.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Pastikan hanya user dengan role 'pasien' yang diambil
        // Anda mungkin memiliki kolom 'role' di tabel 'users'
        // Jika tidak, Anda perlu menyesuaikan cara mengidentifikasi pasien
        $patients = User::where('role', 'pasien')
                        ->orderBy('name')
                        ->paginate(10); // Paginasi untuk data yang banyak

        return view('pegawai.patients.index', compact('patients'));
    }

    /**
     * Menampilkan detail lengkap seorang pasien, termasuk riwayat medisnya.
     *
     * @param  \App\Models\User  $user (Route Model Binding akan otomatis menemukan user berdasarkan ID)
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        // Pastikan user yang diminta adalah seorang pasien
        if ($user->role !== 'pasien') {
            abort(404, 'Data pasien tidak ditemukan.'); // Atau redirect
        }

        // Eager load semua relasi yang diperlukan untuk ditampilkan di halaman detail pasien
        // Pastikan relasi ini sudah didefinisikan di model User (lihat bagian selanjutnya)
        $user->load([
            'rawatInaps',      // Relasi ke pendaftaran rawat inap
            'labTests',        // Relasi ke tes lab
            'consultations',   // Relasi ke konsultasi dokter
            'eReseps',         // Relasi ke resep elektronik
        ]);

        return view('pegawai.patients.show', compact('user'));
    }

    // Anda bisa menambahkan metode lain di sini jika ada CRUD untuk data pasien dari sisi pegawai
    // Namun, biasanya hanya melihat dan mungkin mengelola akun mereka (reset password, dll)
}
