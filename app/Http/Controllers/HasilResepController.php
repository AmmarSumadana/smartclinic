<?php

namespace App\Http\Controllers;

use App\Models\HasilResep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasilResepController extends Controller
{
    /**
     * Store a new prescription.
     */
    public function store(Request $request)
    {
        $request->validate([
            'prescriptions' => 'required|array',
            'prescriptions.*.medicine_name' => 'required|string|max:255',
            'prescriptions.*.dosage' => 'required|string|max:255',
            'prescriptions.*.quantity' => 'required|integer|min:1',
        ]);

        foreach ($request->prescriptions as $prescription) {
            HasilResep::create([
                'user_id' => Auth::id(),
                'medicine_name' => $prescription['medicine_name'],
                'dosage' => $prescription['dosage'],
                'quantity' => $prescription['quantity'],
                'price' => 0, // Anda bisa menambahkan logika untuk menghitung harga jika diperlukan
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Resep berhasil disimpan']);
    }

    /**
     * Get user's prescription history.
     */
    public function getHistory()
    {
        $history = HasilResep::where('user_id', Auth::id())->latest()->get();
        return response()->json(['success' => true, 'data' => $history]);
    }
}
