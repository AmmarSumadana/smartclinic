<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabTest;
use App\Models\HasilResep; // Pastikan model HasilResep sudah di-import
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class KesehatankuController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Ambil data tekanan darah dari lab tests (6 bulan terakhir)
        $bloodPressureTests = LabTest::where('user_id', $userId)
            ->where('test_date', '>=', Carbon::now()->subMonths(6))
            ->where(function($query) {
                $query->where('test_type', 'ILIKE', '%tekanan darah%')
                      ->orWhere('test_type', 'ILIKE', '%blood pressure%');
            })
            ->orderBy('test_date', 'asc')
            ->get();

        // Parse data tekanan darah untuk chart
        $bloodPressureData = [
            'labels' => [],
            'data' => []
        ];

        foreach ($bloodPressureTests as $test) {
            $bloodPressureData['labels'][] = Carbon::parse($test->test_date)->format('M Y');

            $result = $test->result;
            $systolic = null;

            if (preg_match('/(\d{2,3})\/\d{2,3}/', $result, $matches)) {
                $systolic = (int)$matches[1];
            } elseif (preg_match('/[Ss]istolik[:\s]*(\d{2,3})/', $result, $matches)) {
                $systolic = (int)$matches[1];
            } elseif (preg_match('/Tekanan Darah[:\s]*(\d{2,3})\/(\d{2,3})/', $result, $matches)) {
                $systolic = (int)$matches[1];
            } elseif (preg_match('/(\d{2,3})\s*mmHg/', $result, $matches)) {
                $systolic = (int)$matches[1];
            }

            $bloodPressureData['data'][] = $systolic ?? 120; // Default ke 120 jika tidak ditemukan
        }

        if (empty($bloodPressureData['labels'])) {
            $bloodPressureData = [
                'labels' => [
                    Carbon::now()->subMonths(5)->format('M Y'),
                    Carbon::now()->subMonths(4)->format('M Y'),
                    Carbon::now()->subMonths(3)->format('M Y'),
                    Carbon::now()->subMonths(2)->format('M Y'),
                    Carbon::now()->subMonths(1)->format('M Y'),
                    Carbon::now()->format('M Y')
                ],
                'data' => [120, 118, 122, 115, 119, 121]
            ];
        }


        // 2. Ambil data gula darah dari lab tests (6 bulan terakhir)
        $bloodSugarTests = LabTest::where('user_id', $userId)
            ->where('test_date', '>=', Carbon::now()->subMonths(6))
            ->where(function($query) {
                $query->where('test_type', 'ILIKE', '%gula darah%')
                      ->orWhere('test_type', 'ILIKE', '%blood sugar%')
                      ->orWhere('test_type', 'ILIKE', '%glukosa%')
                      ->orWhere('test_type', 'ILIKE', '%glucose%');
            })
            ->orderBy('test_date', 'asc')
            ->get();

        $bloodSugarData = [
            'labels' => [],
            'data' => []
        ];

        foreach ($bloodSugarTests as $test) {
            $bloodSugarData['labels'][] = Carbon::parse($test->test_date)->format('M Y');

            $result = $test->result;
            $sugarValue = null;

            if (preg_match('/(\d+(\.\d+)?)\s*(mg\/dL|mmol\/L)?/i', $result, $matches)) {
                $sugarValue = (float)$matches[1];
                if (isset($matches[3]) && strtolower($matches[3]) === 'mmol/l') {
                    $sugarValue = round($sugarValue * 18.0182);
                }
            } elseif (preg_match('/Gula Darah[:\s]*(\d+(\.\d+)?)/i', $result, $matches)) {
                $sugarValue = (float)$matches[1];
            }

            $bloodSugarData['data'][] = $sugarValue;
        }


        // 3. Ambil data obat dari hasil_reseps dan kategorisasi ulang
        $medicines = HasilResep::where('user_id', $userId)->get();

        // Kategori obat disesuaikan dengan EResepSeeder
        $medicineCategories = [
            'Demam & Nyeri' => 0,
            'Batuk & Pilek' => 0,
            'Antibiotik' => 0,
            'Lambung & Pencernaan' => 0,
            'Antidiabetik' => 0,
            'Antihipertensi' => 0,
            'Antihistamin' => 0,
            'Vitamin & Suplemen' => 0,
            'Lainnya' => 0 // Untuk kategori yang tidak cocok
        ];

        foreach ($medicines as $medicine) {
            $medicineName = strtolower($medicine->medicine_name);

            // Logic kategorisasi berdasarkan medicine_name
            if (strpos($medicineName, 'paracetamol') !== false ||
                strpos($medicineName, 'ibuprofen') !== false ||
                strpos($medicineName, 'aspirin') !== false) {
                $medicineCategories['Demam & Nyeri']++;
            } elseif (strpos($medicineName, 'dextromethorphan') !== false ||
                      strpos($medicineName, 'guaifenesin') !== false ||
                      strpos($medicineName, 'pseudoephedrine') !== false) {
                $medicineCategories['Batuk & Pilek']++;
            } elseif (strpos($medicineName, 'amoxicillin') !== false ||
                      strpos($medicineName, 'ciprofloxacin') !== false) {
                $medicineCategories['Antibiotik']++;
            } elseif (strpos($medicineName, 'omeprazole') !== false ||
                      strpos($medicineName, 'domperidone') !== false) {
                $medicineCategories['Lambung & Pencernaan']++;
            } elseif (strpos($medicineName, 'metformin') !== false ||
                      strpos($medicineName, 'glimepiride') !== false) {
                $medicineCategories['Antidiabetik']++;
            } elseif (strpos($medicineName, 'amlodipine') !== false ||
                      strpos($medicineName, 'captopril') !== false) {
                $medicineCategories['Antihipertensi']++;
            } elseif (strpos($medicineName, 'cetirizine') !== false ||
                      strpos($medicineName, 'loratadine') !== false) {
                $medicineCategories['Antihistamin']++;
            } elseif (strpos($medicineName, 'vitamin c') !== false ||
                      strpos($medicineName, 'vitamin b complex') !== false ||
                      strpos($medicineName, 'vitamin') !== false ||
                      strpos($medicineName, 'suplemen') !== false) {
                $medicineCategories['Vitamin & Suplemen']++;
            } else {
                $medicineCategories['Lainnya']++;
            }
        }

        // Filter out categories with 0 count to avoid showing empty slices in pie chart
        $medicineCategories = array_filter($medicineCategories, fn($value) => $value > 0);

        $medicineConsumptionData = [
            'labels' => array_keys($medicineCategories),
            'data' => array_values($medicineCategories)
        ];

        // 4. Statistik tambahan
        $totalLabTests = LabTest::where('user_id', $userId)->count();
        $totalMedicines = HasilResep::where('user_id', $userId)->sum('quantity') ?? HasilResep::where('user_id', $userId)->count();
        $monthlyExpense = HasilResep::where('user_id', $userId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('price');

        return view('pages.kesehatanku', compact(
            'bloodPressureData',
            'bloodSugarData',
            'medicineConsumptionData',
            'totalLabTests',
            'totalMedicines',
            'monthlyExpense'
        ));
    }
}
