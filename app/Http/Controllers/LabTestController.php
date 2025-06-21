<?php

namespace App\Http\Controllers;

use App\Models\LabTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LabTestController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menggunakan view pages.tes-lab yang sudah ada
     */
    public function index()
    {
        // Ambil data lab tests untuk user yang sedang login
        $labTests = LabTest::where('user_id', Auth::id())
            ->orderBy('test_date', 'desc')
            ->paginate(10);

        // Return ke view yang sudah ada: pages.tes-lab
        return view('pages.tes-lab', compact('labTests'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'test_type' => 'required|string|max:255',
            'test_date' => 'required|date|before_or_equal:today',
            'result' => 'required|string',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Data yang dimasukkan tidak valid');
        }

        try {
            $labTest = LabTest::create([
                'user_id' => Auth::id(),
                'test_type' => $request->test_type,
                'test_date' => $request->test_date,
                'result' => $request->result,
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Hasil tes laboratorium berhasil disimpan',
                    'data' => $labTest
                ]);
            }

            return redirect()->route('tes-lab')
                ->with('success', 'Hasil tes laboratorium berhasil disimpan');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data')
                ->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LabTest $labTest)
    {
        // Pastikan user hanya bisa edit data miliknya sendiri
        if ($labTest->user_id !== Auth::id()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak diizinkan mengakses data ini'
                ], 403);
            }

            return redirect()->route('tes-lab')
                ->with('error', 'Tidak diizinkan mengakses data ini');
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'test_type' => 'required|string|max:255',
            'test_date' => 'required|date|before_or_equal:today',
            'result' => 'required|string',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Data yang dimasukkan tidak valid');
        }

        try {
            $labTest->update([
                'test_type' => $request->test_type,
                'test_date' => $request->test_date,
                'result' => $request->result,
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Hasil tes laboratorium berhasil diperbarui',
                    'data' => $labTest
                ]);
            }

            return redirect()->route('tes-lab')
                ->with('success', 'Hasil tes laboratorium berhasil diperbarui');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memperbarui data',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LabTest $labTest)
    {
        // Pastikan user hanya bisa hapus data miliknya sendiri
        if ($labTest->user_id !== Auth::id()) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak diizinkan mengakses data ini'
                ], 403);
            }

            return redirect()->route('tes-lab')
                ->with('error', 'Tidak diizinkan mengakses data ini');
        }

        try {
            $labTest->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Hasil tes laboratorium berhasil dihapus'
                ]);
            }

            return redirect()->route('tes-lab')
                ->with('success', 'Hasil tes laboratorium berhasil dihapus');

        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghapus data',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data');
        }
    }

    /**
     * Get lab test data for AJAX
     */
    public function getData(Request $request)
    {
        $query = LabTest::where('user_id', Auth::id())
            ->orderBy('test_date', 'desc');

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('test_type', 'ILIKE', "%{$search}%")
                  ->orWhere('result', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->has('test_type') && $request->test_type) {
            $query->where('test_type', $request->test_type);
        }

        $labTests = $query->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'data' => $labTests
        ]);
    }

    /**
     * Get specific lab test for AJAX (untuk edit modal)
     */
    public function getLabTest(LabTest $labTest)
    {
        // Pastikan user hanya bisa akses data miliknya sendiri
        if ($labTest->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak diizinkan mengakses data ini'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $labTest
        ]);
    }

    /**
     * Get statistics summary
     */
    public function getStatsSummary()
    {
        $userId = Auth::id();

        $stats = [
            'total_tests' => LabTest::where('user_id', $userId)->count(),
            'this_month' => LabTest::where('user_id', $userId)
                ->whereMonth('test_date', now()->month)
                ->whereYear('test_date', now()->year)
                ->count(),
            'last_test_date' => LabTest::where('user_id', $userId)
                ->latest('test_date')
                ->value('test_date'),
            'most_common_test' => LabTest::where('user_id', $userId)
                ->select('test_type')
                ->groupBy('test_type')
                ->orderByRaw('COUNT(*) DESC')
                ->first()?->test_type
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get monthly statistics
     */
    public function getMonthlyStats()
    {
        $userId = Auth::id();

        $monthlyStats = LabTest::where('user_id', $userId)
            ->selectRaw('EXTRACT(MONTH FROM test_date) as month, COUNT(*) as count')
            ->groupByRaw('EXTRACT(MONTH FROM test_date)')
            ->orderByRaw('EXTRACT(MONTH FROM test_date)')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $monthlyStats
        ]);
    }

    /**
     * Get statistics by test type
     */
    public function getStatsByType()
    {
        $userId = Auth::id();

        $typeStats = LabTest::where('user_id', $userId)
            ->select('test_type')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('test_type')
            ->orderBy('count', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $typeStats
        ]);
    }

    /**
     * Get recent tests
     */
    public function getRecentTests($limit = 5)
    {
        $recentTests = LabTest::where('user_id', Auth::id())
            ->orderBy('test_date', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $recentTests
        ]);
    }

    /**
     * Validate lab test data untuk real-time validation
     */
    public function validateData(Request $request)
    {
        $rules = [
            'test_type' => 'required|string|max:255',
            'test_date' => 'required|date|before_or_equal:today',
            'result' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data valid'
        ]);
    }

    /**
     * Get available test types untuk dropdown
     */
    public function getTestTypes()
    {
        $testTypes = [
            'Darah Lengkap',
            'Kolesterol',
            'Gula Darah',
            'Asam Urat',
            'Fungsi Hati',
            'Fungsi Ginjal',
            'Urine Lengkap',
            'Lainnya'
        ];

        return response()->json([
            'success' => true,
            'data' => $testTypes
        ]);
    }

    /**
     * Print test result (jika diperlukan)
     */
    public function printResult(LabTest $labTest)
    {
        if ($labTest->user_id !== Auth::id()) {
            return redirect()->route('tes-lab')
                ->with('error', 'Tidak diizinkan mengakses data ini');
        }

        return view('pages.lab-tests.print', compact('labTest'));
    }

    /**
     * Download test result as PDF (jika diperlukan)
     */
    public function downloadResult(LabTest $labTest)
    {
        if ($labTest->user_id !== Auth::id()) {
            return redirect()->route('tes-lab')
                ->with('error', 'Tidak diizinkan mengakses data ini');
        }

        // Implementasi download PDF jika diperlukan
        // return PDF::loadView('pages.lab-tests.pdf', compact('labTest'))->download();

        return response()->json([
            'success' => false,
            'message' => 'Fitur download PDF belum diimplementasikan'
        ]);
    }
}
