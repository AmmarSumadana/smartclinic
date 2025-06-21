<?php

namespace App\Http\Controllers;

use App\Models\LayananAmbulans;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class LayananAmbulansController extends Controller
{
    public function index()
    {
        // Ambil data layanan ambulans milik user yang login
        $layananAmbulans = LayananAmbulans::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil data semua rumah sakit untuk ditampilkan di peta
        $hospitals = Hospital::all();

        return view('pages.layanan-ambulans', compact('layananAmbulans', 'hospitals'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pasien' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'alamat_jemput' => 'required|string',
            'alamat_tujuan' => 'nullable|string',
            'tipe_ambulans' => 'required|in:standar,icu,nicu',
            'tanggal_waktu' => 'required|date|after:now',
            'kondisi_pasien' => 'nullable|string',
            'is_emergency' => 'nullable|boolean'
        ], [
            'nama_pasien.required' => 'Nama pasien wajib diisi',
            'no_telepon.required' => 'Nomor telepon wajib diisi',
            'alamat_jemput.required' => 'Alamat penjemputan wajib diisi',
            'tipe_ambulans.required' => 'Tipe ambulans wajib dipilih',
            'tipe_ambulans.in' => 'Tipe ambulans tidak valid',
            'tanggal_waktu.required' => 'Tanggal dan waktu wajib diisi',
            'tanggal_waktu.after' => 'Tanggal dan waktu harus setelah sekarang'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            LayananAmbulans::create([
                'user_id' => Auth::id(),
                'nama_pasien' => $request->nama_pasien,
                'no_telepon' => $request->no_telepon,
                'alamat_jemput' => $request->alamat_jemput,
                'alamat_tujuan' => $request->alamat_tujuan,
                'tipe_ambulans' => $request->tipe_ambulans,
                'tanggal_waktu' => $request->tanggal_waktu,
                'kondisi_pasien' => $request->kondisi_pasien,
                'is_emergency' => $request->has('is_emergency'),
                'status' => 'pending'
            ]);

            DB::commit();

            return redirect()->route('layanan-ambulans.index')
                ->with('success', 'Pemesanan ambulans berhasil dikirim. Tim kami akan segera menghubungi Anda.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses pemesanan. Silakan coba lagi.')
                ->withInput();
        }
    }

    public function cancel($id)
    {
        try {
            $layananAmbulans = LayananAmbulans::where('id', $id)
                ->where('user_id', Auth::id())
                ->where('status', 'pending')
                ->firstOrFail();

            $layananAmbulans->update(['status' => 'cancelled']);

            return redirect()->route('layanan-ambulans.index')
                ->with('success', 'Pemesanan ambulans berhasil dibatalkan.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Pemesanan tidak dapat dibatalkan atau tidak ditemukan.');
        }
    }

    public function show($id)
    {
        $layananAmbulans = LayananAmbulans::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return response()->json($layananAmbulans);
    }

    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,on_way,completed,cancelled'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Status tidak valid'], 400);
        }

        try {
            $layananAmbulans = LayananAmbulans::findOrFail($id);
            $layananAmbulans->update(['status' => $request->status]);

            return response()->json([
                'message' => 'Status berhasil diperbarui',
                'data' => $layananAmbulans
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui status'], 500);
        }
    }

    // Admin methods
    public function adminIndex()
    {
        $layananAmbulans = LayananAmbulans::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.layanan-ambulans.index', compact('layananAmbulans'));
    }

    public function confirm($id)
    {
        try {
            $layananAmbulans = LayananAmbulans::findOrFail($id);
            $layananAmbulans->update(['status' => 'confirmed']);

            return redirect()->back()
                ->with('success', 'Pemesanan ambulans berhasil dikonfirmasi.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengkonfirmasi pemesanan.');
        }
    }

    public function complete($id)
    {
        try {
            $layananAmbulans = LayananAmbulans::findOrFail($id);
            $layananAmbulans->update(['status' => 'completed']);

            return redirect()->back()
                ->with('success', 'Layanan ambulans berhasil diselesaikan.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyelesaikan layanan.');
        }
    }

    public function destroy($id)
    {
        try {
            $layananAmbulans = LayananAmbulans::findOrFail($id);
            $layananAmbulans->delete();

            return redirect()->back()
                ->with('success', 'Data layanan ambulans berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data.');
        }
    }
}
