<?php

namespace App\Http\Controllers;

use App\Models\RawatInap;
use App\Models\Hospital;
use App\Models\User; // Pastikan User model diimpor
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon; // Diperlukan untuk penanganan tanggal

class RawatInapController extends Controller
{
    /**
     * Menampilkan halaman pendaftaran rawat inap untuk pasien.
     * Menampilkan status pendaftaran terbaru pasien yang login.
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
            // yang statusnya masih aktif (pending, approved, admitted)
            $latestAdmission = RawatInap::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'approved', 'admitted'])
                ->latest() // Mengambil yang paling baru berdasarkan created_at
                ->first();

            if ($latestAdmission) {
                $isAdmitted = true;
                $admissionDetails = [
                    'patient_name' => $user->name,
                    'hospital_name' => $latestAdmission->hospital_name,
                    'room_number' => $latestAdmission->room_number,
                    'status' => $latestAdmission->status,
                ];
            }
        }

        // Ambil semua data rumah sakit dari database untuk dropdown
        $hospitals = Hospital::all();

        return view('pages.rawat-inap', compact('isAdmitted', 'admissionDetails', 'hospitals'));
    }

    /**
     * Menyimpan data pendaftaran rawat inap baru dari pasien.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // 1. Validasi Input
            $validated = $request->validate([
                'patient_name' => 'required|string|max:255',
                'hospital_name' => 'required|string|max:255',
                'reason' => 'required|string|max:1000',
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
            RawatInap::create([
                'user_id' => Auth::id(), // ID pasien yang sedang login
                'patient_name' => $validated['patient_name'],
                'hospital_name' => $validated['hospital_name'],
                'reason' => $validated['reason'],
                'admission_date' => $validated['admission_date'],
                'ktp_path' => $ktpPath,
                'surat_pengantar_path' => $suratPengantarPath,
                'kartu_asuransi_path' => $kartuAsuransiPath,
                'status' => 'pending', // Status awal selalu 'pending'
            ]);

            return response()->json(['message' => 'Permohonan rawat inap Anda berhasil diajukan. Silakan tunggu konfirmasi.'], 200);

        } catch (ValidationException $e) {
            // Jika ada error validasi, kembalikan response JSON dengan error
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Jika terjadi error saat menyimpan, hapus file yang sudah terupload
            Storage::disk('public')->delete($ktpPath ?? null);
            Storage::disk('public')->delete($suratPengantarPath ?? null);
            if ($kartuAsuransiPath) {
                Storage::disk('public')->delete($kartuAsuransiPath);
            }
            return response()->json(['message' => 'Gagal mengajukan permohonan. ' . $e->getMessage()], 500);
        }
    }

    /**
     * Menampilkan daftar semua permintaan rawat inap untuk pegawai (staf/dokter).
     *
     * @return \Illuminate\View\View
     */
    public function indexPegawai()
    {
        // Ambil semua permintaan rawat inap, urutkan dari terbaru
        // Anda bisa menambahkan filter atau paginasi di sini jika datanya banyak
        $rawatInapRequests = RawatInap::with('user') // Eager load relasi user untuk mendapatkan data pasien
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(10); // Contoh paginasi

        // Fungsi pembantu untuk menerjemahkan status (dapat juga dibuat sebagai trait/helper)
        $translateStatus = function ($status) {
            switch ($status) {
                case 'pending': return 'Menunggu Konfirmasi';
                case 'approved': return 'Disetujui';
                case 'admitted': return 'Sedang Dirawat';
                case 'rejected': return 'Ditolak';
                case 'cancelled': return 'Dibatalkan';
                case 'discharged': return 'Selesai Dirawat'; // Tambahan status discharge
                default: return 'Tidak Diketahui';
            }
        };

        // Pastikan nama view ini sesuai dengan lokasi file Anda: resources/views/pegawai/rawat-inap.blade.php
        return view('pegawai.rawat-inap', compact('rawatInapRequests', 'translateStatus'));
    }

    /**
     * Menampilkan detail dari satu permintaan rawat inap tertentu untuk pegawai.
     *
     * @param  \App\Models\RawatInap  $rawatInap
     * @return \Illuminate\View\View
     */
    public function showPegawai(RawatInap $rawatInap)
    {
        // Load relasi user jika belum di-load
        $rawatInap->load('user');

        // Fungsi pembantu untuk menerjemahkan status
        $translateStatus = function ($status) {
            switch ($status) {
                case 'pending': return 'Menunggu Konfirmasi';
                case 'approved': return 'Disetujui';
                case 'admitted': return 'Sedang Dirawat';
                case 'rejected': return 'Ditolak';
                case 'cancelled': return 'Dibatalkan';
                case 'discharged': return 'Selesai Dirawat';
                default: return 'Tidak Diketahui';
            }
        };

        // Pastikan nama view ini sesuai dengan lokasi file Anda: resources/views/pegawai/rawat-inap-detail.blade.php
        return view('pegawai.rawat-inap-detail', compact('rawatInap', 'translateStatus'));
    }

    /**
     * Mengupdate status dan menambahkan catatan respon untuk sebuah permohonan rawat inap.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RawatInap  $rawatInap
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatusPegawai(Request $request, RawatInap $rawatInap)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:pending,approved,rejected,admitted,cancelled,discharged'], // Tambah 'discharged'
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $rawatInap->status = $request->status;
        $rawatInap->notes = $request->notes;
        // Jika status menjadi 'discharged', set discharge_date ke hari ini
        if ($request->status === 'discharged') {
            $rawatInap->discharge_date = Carbon::now();
        } else {
            $rawatInap->discharge_date = null; // Clear if not discharged
        }
        $rawatInap->save();

        return redirect()->route('pegawai.rawat-inap.index')->with('success', 'Status permintaan rawat inap berhasil diperbarui.');
    }

    /**
     * Menugaskan nomor kamar/bed untuk sebuah permohonan rawat inap.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RawatInap  $rawatInap
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignRoom(Request $request, RawatInap $rawatInap)
    {
        $request->validate([
            'room_number' => ['required', 'string', 'max:50'],
        ]);

        $rawatInap->room_number = $request->room_number;
        // Opsional: Otomatis ubah status menjadi 'admitted' jika kamar sudah ditentukan
        if ($rawatInap->status === 'approved') {
            $rawatInap->status = 'admitted';
        }
        $rawatInap->save();

        return redirect()->route('pegawai.rawat-inap.show', $rawatInap->id)->with('success', 'Nomor kamar rawat inap berhasil ditugaskan.');
    }
}
