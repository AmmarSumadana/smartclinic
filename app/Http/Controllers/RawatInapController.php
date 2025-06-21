<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RawatInap;
use App\Models\Hospital; // Import model Hospital
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon; // Pastikan Carbon di-import jika belum

class RawatInapController extends Controller
{
    /**
     * Menampilkan halaman pendaftaran rawat inap dengan status pengguna.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $isAdmitted = false;
        $admissionDetails = null;

        $user = Auth::user();

        if ($user) {
            // Ambil pendaftaran rawat inap terbaru untuk pengguna ini
            $latestAdmission = RawatInap::where('user_id', $user->id)
                ->latest() // Mengambil yang paling baru berdasarkan created_at
                ->first();

            if ($latestAdmission) {
                $isAdmitted = true;
                $admissionDetails = [
                    'patient_name' => $user->name,
                    'hospital_name' => $latestAdmission->hospital_name,
                    'room_number' => $latestAdmission->room_number,
                    'status' => $latestAdmission->status, // Mengambil status dari pendaftaran terbaru
                ];
            }
        }

        // Ambil semua data rumah sakit dari database
        $hospitals = Hospital::all();

        return view('pages.rawat-inap', compact('isAdmitted', 'admissionDetails', 'hospitals')); // Teruskan data rumah sakit ke view
    }

    /**
     * Menyimpan data pendaftaran rawat inap baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'hospital_name' => 'required|string|max:255',
            'reason' => 'required|string',
            'admission_date' => 'required|date|after_or_equal:today', // Tanggal masuk harus hari ini atau di masa depan
            'ktp_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2MB
            'surat_pengantar_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kartu_asuransi_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // 2. Upload Dokumen
        $ktpPath = $request->file('ktp_file')->store('rawat_inap_documents/ktp', 'public');
        $suratPengantarPath = $request->file('surat_pengantar_file')->store('rawat_inap_documents/surat_pengantar', 'public');
        $kartuAsuransiPath = null;
        if ($request->hasFile('kartu_asuransi_file')) {
            $kartuAsuransiPath = $request->file('kartu_asuransi_file')->store('rawat_inap_documents/kartu_asuransi', 'public');
        }

        // 3. Simpan Data ke Database
        try {
            RawatInap::create([
                'user_id' => Auth::id(), // Dapatkan ID user yang sedang login
                'patient_name' => $request->patient_name,
                'hospital_name' => $request->hospital_name,
                'reason' => $request->reason,
                'admission_date' => $request->admission_date,
                'ktp_path' => $ktpPath,
                'surat_pengantar_path' => $suratPengantarPath,
                'kartu_asuransi_path' => $kartuAsuransiPath,
                'status' => 'pending', // Status awal 'pending'
            ]);

            return response()->json(['message' => 'Permohonan rawat inap Anda berhasil diajukan. Silakan tunggu konfirmasi.'], 200);
        } catch (\Exception $e) {
            // Jika terjadi error saat menyimpan, hapus file yang sudah terupload
            Storage::disk('public')->delete($ktpPath);
            Storage::disk('public')->delete($suratPengantarPath);
            if ($kartuAsuransiPath) {
                Storage::disk('public')->delete($kartuAsuransiPath);
            }

            return response()->json(['message' => 'Gagal mengajukan permohonan. ' . $e->getMessage()], 500);
        }
    }
    public function indexPegawai()
    {
        // Logika untuk menampilkan daftar semua permohonan rawat inap yang perlu dikelola pegawai
        $rawatInaps = RawatInap::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('pegawai.rawat-inap.index', compact('rawatInaps'));
    }

    public function showPegawai(RawatInap $rawatInap)
    {
        // Logika untuk menampilkan detail permohonan rawat inap tunggal untuk pegawai
        return view('pegawai.rawat-inap.show', compact('rawatInap'));
    }

    public function updateStatusPegawai(Request $request, RawatInap $rawatInap)
    {
        // Logika untuk mengupdate status permohonan rawat inap
        $request->validate(['status' => 'required|in:pending,approved,rejected,admitted,discharged,cancelled']);
        $rawatInap->update(['status' => $request->status]);
        return back()->with('success', 'Status permohonan rawat inap berhasil diperbarui.');
    }

    public function assignRoom(Request $request, RawatInap $rawatInap)
    {
        // Logika untuk menugaskan nomor kamar/bed
        $request->validate(['room_number' => 'required|string|max:50']);
        $rawatInap->update(['room_number' => $request->room_number]);
        return back()->with('success', 'Nomor kamar rawat inap berhasil ditugaskan.');
    }
}
