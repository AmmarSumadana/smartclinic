<?php
// database/seeders/DoctorSeeder.php
    namespace Database\Seeders;
    use Illuminate\Database\Seeder;
    use App\Models\Doctor;
    class DoctorSeeder extends Seeder
    {
        public function run()
        {
            Doctor::create([
                'hospital_id' => 1, // Ganti dengan ID rumah sakit yang sesuai
                'name' => 'Dr. John Doe',
                'specialty' => 'Umum',
                'phone' => '1234567890',
            ]);
            // Tambahkan dokter lainnya sesuai kebutuhan
        }
    }
