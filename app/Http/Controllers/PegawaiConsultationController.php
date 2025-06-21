<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Str; // Tidak diperlukan di controller, hanya di Blade jika digunakan

class PegawaiConsultationController extends Controller
{
    /**
     * Menampilkan daftar semua permintaan konsultasi untuk pegawai (staff/dokter).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua konsultasi dengan eager loading relasi 'patient', 'doctor', dan 'responder'.
        // Urutkan berdasarkan status 'pending' agar muncul di paling atas, kemudian tanggal dibuat terbaru.
        $consultations = Consultation::with(['patient', 'doctor', 'responder'])
                                    ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END") // Prioritaskan 'pending'
                                    ->orderBy('created_at', 'desc') // Lalu urutkan yang terbaru di setiap status
                                    ->paginate(5); // Paginasi data

        // Mengarahkan ke view daftar konsultasi untuk pegawai
        // Pastikan path view sudah benar sesuai struktur folder: resources/views/pegawai/consultations/index.blade.php
        return view('pegawai.consultations.index', compact('consultations'));
    }

    /**
     * Menampilkan detail dari satu permintaan konsultasi tertentu.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\View\View
     */
    public function show(Consultation $consultation)
    {
        // Pastikan semua relasi yang diperlukan (patient, doctor, responder) dimuat
        $consultation->load('patient', 'doctor', 'responder');

        // Mengarahkan ke view detail konsultasi untuk pegawai
        // Pastikan path view sudah benar sesuai struktur folder: resources/views/pegawai/consultations/show.blade.php
        return view('pegawai.consultations.show', compact('consultation'));
    }

    /**
     * Mengupdate status dan menambahkan catatan respon untuk sebuah konsultasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Consultation $consultation)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed', // Validasi status yang diizinkan
            'response_notes' => 'nullable|string|max:1000', // Validasi catatan respon
        ]);

        $consultation->update([
            'status' => $request->status,
            'response_notes' => $request->response_notes,
            'responded_by_user_id' => Auth::id(), // Simpan ID user (pegawai/dokter) yang melakukan update
        ]);

        return back()->with('success', 'Status konsultasi berhasil diperbarui.');
    }

    /**
     * Menghapus sebuah permintaan konsultasi.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Consultation $consultation)
    {
        try {
            $consultation->delete();
            return redirect()->route('pegawai.consultations.index')->with('success', 'Konsultasi berhasil dihapus.');
        } catch (\Exception $e) {
            // Tangani error jika terjadi masalah saat menghapus
            return redirect()->back()->with('error', 'Gagal menghapus konsultasi: ' . $e->getMessage());
        }
    }
}
