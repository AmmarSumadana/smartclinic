<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Consultation;
use App\Models\LabTest; // Import model LabTest
use Carbon\Carbon; // Import Carbon untuk manipulasi tanggal
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Untuk logging debug (dapat dihapus setelah debug)

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     * This will now serve as the main dashboard for the user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userId = Auth::id(); // Get the authenticated user's ID

        // Data for Hospital Card
        $hospitals = Hospital::paginate(2); // Adjust pagination as needed

        // Data for Consultation Card (assuming it's per user)
        // PERBAIKAN DI SINI: Mengubah 'date' menjadi 'consultation_date' atau 'created_at'
        // Jika 'user_doctor' adalah relasi, pastikan relasi tersebut didefinisikan dengan benar di model Consultation.
        // Jika Consultation memiliki relasi belongsTo ke User (untuk pasien) dan belongsTo ke Doctor (untuk dokter yang melayani),
        // maka 'user_doctor' adalah nama relasi yang mungkin tidak standar.
        // Asumsi 'user_doctor' adalah relasi ke model Doctor melalui alias `doctor`.
        $consultations = Consultation::where('user_id', $userId)
                                     ->with('doctor') // Asumsi relasi ke dokter bernama 'doctor'
                                     ->orderBy('consultation_date', 'desc') // MENGGUNAKAN KOLOM YANG BENAR
                                     ->paginate(2);

        // Data for Lab Test Card (recent 5 tests)
        $recentLabTests = LabTest::where('user_id', $userId)
                                 ->orderBy('test_date', 'desc')
                                 ->limit(5)
                                 ->get();

        // --- Data for Chart (Only Blood Sugar will be kept) ---

        // Tren Gula Darah (6 bulan terakhir)
        $bloodSugarTests = LabTest::where('user_id', $userId)
            ->where('test_date', '>=', Carbon::now()->subMonths(6))
            ->where(function($query) {
                // HANYA menggunakan 'test_type' untuk query gula darah
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

            $bloodSugarData['data'][] = $sugarValue ?? 90;
        }

        if (empty($bloodSugarData['labels'])) {
            $bloodSugarData = [
                'labels' => $this->generateDummyLabels(),
                'data' => [90, 95, 88, 100, 92, 98]
            ];
        }

        // --- End Data for Chart ---

        // Data for Mini Map (all hospitals, not paginated)
        $allHospitals = Hospital::all();


        // Pass all data to the view
        return view('dashboard', compact(
            'hospitals',
            'consultations',
            'recentLabTests',
            'bloodSugarData', // Only blood sugar data is passed
            'allHospitals' // Used for the mini-map
        ));
    }

    /**
     * Get hospitals data as JSON for map
     */
    public function getHospitalsJson()
    {
        $hospitals = Hospital::all();

        $geoJson = [
            'type' => 'FeatureCollection',
            'features' => []
        ];

        foreach ($hospitals as $hospital) {
            $geoJson['features'][] = [
                'type' => 'Feature',
                'properties' => [
                    'id' => $hospital->id,
                    'name' => $hospital->nama,
                    'address' => $hospital->alamat,
                    'phone' => $hospital->phone
                ],
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [$hospital->longitude, $hospital->latitude]
                ]
            ];
        }

        return response()->json($geoJson);
    }

    /**
     * Helper to generate dummy labels for charts.
     * @return array
     */
    private function generateDummyLabels()
    {
        $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $labels[] = Carbon::now()->subMonths($i)->format('M Y');
        }
        return $labels;
    }
}
