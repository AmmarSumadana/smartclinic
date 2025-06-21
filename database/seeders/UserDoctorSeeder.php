<?php

// database/seeders/UserDoctorSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Penting: Import model User
use Illuminate\Support\Facades\Hash;

class UserDoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contoh dokter 1
        User::create([
            'name' => 'Dr. Budi Santoso',
            'email' => 'budi.santoso@example.com',
            'password' => Hash::make('password'), // Ganti dengan password yang aman
            'role' => 'doctor', // KUNCI: Set role sebagai 'doctor'
            // Tambahkan kolom lain yang relevan di tabel users Anda (misal: phone, address, etc.)
        ]);

        // Contoh dokter 2
        User::create([
            'name' => 'Dr. Siti Nurjanah',
            'email' => 'siti.nurjanah@example.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);

        // Anda bisa menambahkan data lain untuk staff jika diperlukan
        User::create([
            'name' => 'Staff Admin',
            'email' => 'staff.admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'staff', // Contoh role staff
        ]);
    }
}
