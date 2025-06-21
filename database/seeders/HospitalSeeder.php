<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hospital;

class HospitalSeeder extends Seeder
{
    public function run(): void
    {
        $hospitals = [
            [
                'nama' => 'RSUD Kota Yogyakarta',
                'alamat' => 'Jl. Pemuda No.1',
                'phone' => '0274-374341',
                'latitude' => -7.8014,
                'longitude' => 110.3735
            ],
            [
                'nama' => 'RS Bethesda Yogyakarta',
                'alamat' => 'Jl. Jend. Sudirman No.70',
                'phone' => '0274-374700',
                'latitude' => -7.7759,
                'longitude' => 110.3679
            ],
                        [
                'nama' => 'RSUP Dr. Sardjito',
                'alamat' => 'Jl. Kesehatan No.1',
                'phone' => '0274-631100',
                'latitude' => -7.7870,
                'longitude' => 110.3882
            ],
            [
                'nama' => 'RS Panti Rapih',
                'alamat' => 'Jl. Cik Di Tiro No.37',
                'phone' => '0274-514809',
                'latitude' => -7.7845,
                'longitude' => 110.3810
            ],
            [
                'nama' => 'PKU Muhammadiyah Yogyakarta',
                'alamat' => 'Jl. KH. Ahmad Dahlan No.20',
                'phone' => '0274-562277',
                'latitude' => -7.8025,
                'longitude' => 110.3576
            ],
            [
                'nama' => 'RS Mata Dr. Yap',
                'alamat' => 'Jl. Cik Di Tiro No.5',
                'phone' => '0274-547448',
                'latitude' => -7.7850,
                'longitude' => 110.3750
            ],
            [
                'nama' => 'RS Jiwa Grhasia',
                'alamat' => 'Jl. Kaliurang KM17, Pakem',
                'phone' => '0274-898888',
                'latitude' => -7.6667,
                'longitude' => 110.3900
            ],
            [
                'nama' => 'Siloam Hospitals Yogyakarta',
                'alamat' => 'Jl. Laksda Adisucipto No.32',
                'phone' => '0274-565000',
                'latitude' => -7.7950,
                'longitude' => 110.3890
            ]
        ];
            // Tambahkan data rumah sakit lainnya sesuai kebutuhan

        foreach ($hospitals as $hospital) {
            Hospital::create($hospital);
        }
    }
}
