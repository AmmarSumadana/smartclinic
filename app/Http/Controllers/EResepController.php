<?php

namespace App\Http\Controllers;

use App\Models\EResep;
use App\Models\HasilResep; // Import the HasilResep model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // For logging errors

class EResepController extends Controller
{
    /**
     * Display the e-resep page.
     */
    public function index()
    {
        // This method will now be primarily for showing the initial page.
        // History will be loaded via AJAX after the page loads.
        return view('pages.e-resep');
    }

    /**
     * Show the e-resep page. (Redundant with index, can be removed if index handles both)
     */
    public function show()
    {
        return view('pages.e-resep'); // Pastikan nama view sesuai dengan file
    }

    /**
     * Search medicines by name or indication
     */
    public function searchMedicines(Request $request)
    {
        $query = $request->get('query');

        if (empty($query)) {
            return response()->json([]);
        }

        $medicines = EResep::where('status', 'template') // Ensure only template medicines are searchable
            ->where(function($q) use ($query) {
                $q->where('medicine_name', 'LIKE', "%{$query}%")
                  ->orWhere('generic_name', 'LIKE', "%{$query}%")
                  ->orWhere('indication', 'LIKE', "%{$query}%")
                  ->orWhere('category', 'LIKE', "%{$query}%");
            })
            ->select('id', 'medicine_name', 'generic_name', 'form', 'indication', 'dosage', 'price', 'category', 'notes') // Added notes for completeness if needed
            ->limit(10)
            ->get();

        return response()->json($medicines);
    }

    /**
     * Get medicine details by ID (Not directly used by current frontend, but good to have)
     */
    public function getMedicineDetails($id)
    {
        $medicine = EResep::where('id', $id)
                          ->where('status', 'template')
                          ->first();

        if (!$medicine) {
            return response()->json(['error' => 'Medicine not found'], 404);
        }

        return response()->json($medicine);
    }

    /**
     * Store a new e-resep from the user's selected items.
     */
    public function store(Request $request)
    {
        $request->validate([
            'prescriptions' => 'required|array',
            'prescriptions.*.medicine_name' => 'required|string|max:255',
            'prescriptions.*.dosage' => 'required|string|max:255',
            'prescriptions.*.quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'User not authenticated.'], 401);
        }

        try {
            foreach ($request->prescriptions as $item) {
                // Find the price from EResep templates or default to 0 if not found
                $medicineTemplate = EResep::where('medicine_name', $item['medicine_name'])
                                          ->where('status', 'template')
                                          ->first();
                $price = $medicineTemplate ? $medicineTemplate->price : 0;

                HasilResep::create([
                    'user_id' => $userId,
                    'medicine_name' => $item['medicine_name'],
                    'dosage' => $item['dosage'],
                    'quantity' => $item['quantity'],
                    'price' => $price * $item['quantity'], // Store total price for this item
                ]);
            }
            return response()->json(['success' => true, 'message' => 'Resep berhasil disimpan!']);
        } catch (\Exception $e) {
            Log::error('Error saving prescription: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan resep. ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get prescription history for the authenticated user.
     */
    public function getPrescriptionHistory()
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'User not authenticated.'], 401);
        }

        $history = HasilResep::where('user_id', $userId)
                             ->orderBy('created_at', 'desc')
                             ->get();

        return response()->json(['success' => true, 'data' => $history]);
    }
}
