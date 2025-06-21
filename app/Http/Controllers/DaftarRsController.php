<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class DaftarRsController extends Controller
{
   public function index()
{
    $hospitals = Hospital::all(); // Ambil data rumah sakit dari database
    return view('pages.daftar-rs', compact('hospitals'));
}

}
