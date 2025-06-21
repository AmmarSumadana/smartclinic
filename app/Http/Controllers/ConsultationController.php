<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    public function create()
    {
        $doctors = Doctor::all(); // Ambil data dokter dari database
        return view('pages.konsul-dokter', compact('doctors'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'notes' => 'nullable|string',
            'consultation_date' => 'required|date',
        ]);
        // Buat record baru
        Consultation::create([
            'user_id' => auth()->id(), // Mengambil ID pengguna yang sedang login
            'doctor_id' => $validated['doctor_id'],
            'consultation_date' => $validated['consultation_date'],
            'notes' => $validated['notes'],
        ]);
        // Redirect ke halaman dashboard
        return redirect()->route('dashboard')->with('success', 'Konsultasi berhasil dijadwalkan!');
    }

    public function index()
    {
        // Ambil semua konsultasi untuk pasien yang sedang login
        $consultations = Consultation::where('user_id', Auth::id())->get(); // Menggunakan user_id
        return view('dashboard', compact('consultations')); // Pastikan nama variabel konsisten
    }
    public function indexPegawai()
    {
        // Logika untuk menampilkan daftar semua konsultasi yang perlu dikelola pegawai
        $consultations = Consultation::with('user', 'doctor')->orderBy('created_at', 'desc')->paginate(10);
        return view('pegawai.consultations.index', compact('consultations'));
    }

    public function showPegawai(Consultation $consultation)
    {
        // Logika untuk menampilkan detail konsultasi tunggal untuk pegawai
        return view('pegawai.consultations.show', compact('consultation'));
    }

    public function updateStatusPegawai(Request $request, Consultation $consultation)
    {
        // Logika untuk mengupdate status konsultasi (misal: 'pending' -> 'approved'/'rejected'/'completed')
        $request->validate(['status' => 'required|in:pending,approved,rejected,completed']);
        $consultation->update(['status' => $request->status]);
        return back()->with('success', 'Status konsultasi berhasil diperbarui.');
    }
}
