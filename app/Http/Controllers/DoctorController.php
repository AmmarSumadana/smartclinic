<?php

namespace App\Http\Controllers;

    use App\Models\Doctor;

    class DoctorController extends Controller
    {
        public function index()
        {
            $doctors = Doctor::all(); // Mengambil semua dokter
            return view('doctors.index', compact('doctors'));
        }
    }
    
