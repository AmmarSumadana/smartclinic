<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\User; // Penting: Import model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    /**
     * Menampilkan form untuk pasien membuat permintaan konsultasi baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Ambil semua user dengan role 'doctor' untuk ditampilkan di dropdown
        $doctors = User::where('role', 'doctor')->get();

        // Mengarahkan ke view form pembuatan konsultasi baru untuk pasien
        return view('pages.konsul-dokter.konsul-dokter', compact('doctors'));
    }

    /**
     * Menyimpan permintaan konsultasi baru dari pasien.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Memastikan doctor_id ada di tabel 'users'
            'doctor_id' => 'required|exists:users,id',
            'notes' => 'nullable|string|max:1000',
            // Memastikan tanggal konsultasi tidak di masa lalu
            'consultation_date' => 'required|date|after_or_equal:now',
        ]);

        Consultation::create([
            'user_id' => Auth::id(), // ID pasien yang sedang login
            'doctor_id' => $validated['doctor_id'], // ID dokter yang dipilih
            'consultation_date' => $validated['consultation_date'],
            'notes' => $validated['notes'],
            'status' => 'pending', // Status awal selalu 'pending'
        ]);

        return redirect()->route('consultations.index')->with('success', 'Permintaan konsultasi berhasil diajukan! Silakan tunggu konfirmasi.');
    }

    /**
     * Menampilkan riwayat semua konsultasi yang diajukan oleh pasien yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua konsultasi pasien yang sedang login, beserta detail dokter dan siapa yang merespon
        // Sudah diurutkan dari yang terbaru ditambahkan dengan latest()
        $consultations = Consultation::with(['doctor', 'responder'])
                                     ->where('user_id', Auth::id())
                                     ->latest() // Urutkan berdasarkan created_at DESC (terbaru)
                                     ->paginate(5); // Paginasi untuk tampilan

        // Mengarahkan ke view riwayat konsultasi pasien
        return view('pages.konsul-dokter.index', compact('consultations'));
    }
}
