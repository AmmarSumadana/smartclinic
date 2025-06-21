<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CekMedis;
use App\Models\Hospital; // Import model Hospital untuk dropdown rumah sakit
use Illuminate\Support\Facades\Auth;
use PDF; // Pastikan Anda telah menginstal dan mengkonfigurasi library PDF jika ini digunakan
use Illuminate\Support\Facades\Storage; // Untuk upload file

class CekMedisController extends Controller
{
    /**
     * Display a listing of the medical checks (if needed for a list view).
     * This might be redundant if riwayat-medis.blade.php handles the listing.
     * For now, it serves as the 'create' method for the form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $hospitals = Hospital::all(); // Mengambil semua rumah sakit untuk dropdown
        return view('pages.cek-medis', compact('hospitals'));
    }

    /**
     * Store a newly created medical check in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'no_identitas' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string|max:500',
            'penyakit_kronis' => 'nullable|string',
            'obat_rutin' => 'nullable|string',
            'alergi' => 'nullable|string',
            'riwayat_operasi' => 'nullable|string',
            'penyakit_keluarga' => 'nullable|string',
            'merokok' => 'nullable|in:Ya,Tidak',
            'alkohol' => 'nullable|in:Ya,Tidak',
            'olahraga' => 'nullable|string|max:255',
            'pola_makan' => 'nullable|string',
            'gejala' => 'nullable|string',
            'lama_gejala' => 'nullable|string|max:255',
            'tingkat_keparahan' => 'nullable|in:Ringan,Sedang,Parah',
            'periksa_di_tempat' => 'boolean',
            'tekanan_darah' => 'nullable|string|max:255',
            'denyut_nadi' => 'nullable|string|max:255',
            'berat_badan' => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
            'imt' => 'nullable|numeric',
            'suhu' => 'nullable|numeric',
            'paket' => 'required|string|max:255',
            'jadwal_tanggal' => 'required|date',
            'jadwal_jam' => 'required',
            'hospital_id' => 'required|exists:hospitals,id',
            'geom' => 'nullable|string', // Untuk menyimpan koordinat geografis
        ]);

        // Tambahkan user_id dari user yang sedang login
        $validatedData['user_id'] = Auth::id();
        $validatedData['periksa_di_tempat'] = $request->has('periksa_di_tempat'); // Checkbox

        try {
            $cekMedis = CekMedis::create($validatedData);

            // Jika Anda memiliki fungsionalitas PDF Generation
            // Contoh sederhana pembuatan PDF (membutuhkan library seperti dompdf/barryvdh/laravel-dompdf)
            // Ini adalah contoh placeholder, sesuaikan dengan implementasi PDF Anda
            $pdfFileName = 'cek_medis_' . $cekMedis->id . '.pdf';
            // Simpan PDF ke storage
            // Storage::disk('public')->put('medical_checks_pdf/' . $pdfFileName, $pdfContent);
            // $cekMedis->pdf_path = 'medical_checks_pdf/' . $pdfFileName;
            // $cekMedis->save();

            // Redirect dengan pesan sukses dan id untuk download PDF
            return redirect()->route('cek-medis.form')->with([
                'success' => 'Form pemeriksaan medis berhasil disimpan!',
                'download_pdf' => $cekMedis->id // Kirim ID untuk download PDF
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan form pemeriksaan medis: ' . $e->getMessage());
        }
    }

    /**
     * Download PDF for a specific medical check record.
     * Example placeholder - replace with actual PDF generation logic.
     *
     * @param  int  $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function downloadPdf($id)
    {
        $cekMedis = CekMedis::findOrFail($id);

        // Pastikan pengguna yang login memiliki hak untuk mengunduh PDF ini
        if (Auth::id() !== $cekMedis->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Ini adalah contoh pembuatan PDF sederhana, Anda harus mengganti ini
        // dengan logika pembuatan PDF yang sebenarnya dari data $cekMedis
        $data = [
            'title' => 'Hasil Pemeriksaan Medis',
            'cekMedis' => $cekMedis,
            'user' => $cekMedis->user, // Load user data
            'hospital' => $cekMedis->hospital, // Load hospital data
        ];

        // Contoh menggunakan Barryvdh\DomPDF\Facade\Pdf
        // Pastikan Anda sudah menginstallnya: composer require barryvdh/laravel-dompdf
        // $pdf = PDF::loadView('pdf.cek_medis_template', $data);
        // return $pdf->download('hasil_pemeriksaan_medis_' . $cekMedis->id . '.pdf');

        // Untuk tujuan placeholder, akan mengembalikan respons HTTP sederhana
        return response("Ini adalah placeholder untuk PDF hasil pemeriksaan medis ID: {$cekMedis->id}. Silakan implementasikan generasi PDF yang sebenarnya.", 200)
                ->header('Content-Type', 'text/plain')
                ->header('Content-Disposition', 'attachment; filename="hasil_pemeriksaan_medis_' . $cekMedis->id . '.txt"');

        // Jika Anda menyimpan file PDF di storage, Anda bisa mengembalikan seperti ini:
        // return Storage::disk('public')->download($cekMedis->pdf_path);
    }
}
