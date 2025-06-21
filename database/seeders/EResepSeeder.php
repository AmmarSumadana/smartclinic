<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EResep;

class EResepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medicines = [
            // Obat Demam & Nyeri
            [
                'medicine_name' => 'Paracetamol 500mg',
                'generic_name' => 'Acetaminophen',
                'form' => 'Tablet',
                'indication' => 'demam, sakit kepala, nyeri ringan',
                'dosage' => '1-2 tablet, 3-4 kali sehari sesudah makan',
                'price' => 5000,
                'category' => 'Analgesik'
            ],
            [
                'medicine_name' => 'Ibuprofen 400mg',
                'generic_name' => 'Ibuprofen',
                'form' => 'Tablet',
                'indication' => 'demam, nyeri, inflamasi',
                'dosage' => '1 tablet, 3 kali sehari sesudah makan',
                'price' => 8000,
                'category' => 'NSAID'
            ],
            [
                'medicine_name' => 'Aspirin 80mg',
                'generic_name' => 'Asam Asetilsalisilat',
                'form' => 'Tablet',
                'indication' => 'demam, nyeri, pencegahan stroke',
                'dosage' => '1 tablet sehari sesudah makan',
                'price' => 3000,
                'category' => 'Antiplatelet'
            ],

            // Obat Batuk & Pilek
            [
                'medicine_name' => 'Dextromethorphan 15mg',
                'generic_name' => 'Dextromethorphan HBr',
                'form' => 'Sirup',
                'indication' => 'batuk kering, batuk tidak berdahak',
                'dosage' => '1-2 sendok teh, 3-4 kali sehari',
                'price' => 12000,
                'category' => 'Antitusif'
            ],
            [
                'medicine_name' => 'Guaifenesin 100mg',
                'generic_name' => 'Guaifenesin',
                'form' => 'Sirup',
                'indication' => 'batuk berdahak, ekspektoran',
                'dosage' => '1-2 sendok teh, 3 kali sehari',
                'price' => 15000,
                'category' => 'Ekspektoran'
            ],
            [
                'medicine_name' => 'Pseudoephedrine 60mg',
                'generic_name' => 'Pseudoephedrine HCl',
                'form' => 'Tablet',
                'indication' => 'hidung tersumbat, pilek, sinusitis',
                'dosage' => '1 tablet, 2-3 kali sehari',
                'price' => 10000,
                'category' => 'Dekongestan'
            ],

            // Antibiotik
            [
                'medicine_name' => 'Amoxicillin 500mg',
                'generic_name' => 'Amoxicillin',
                'form' => 'Kapsul',
                'indication' => 'infeksi bakteri, pneumonia, bronkitis',
                'dosage' => '1 kapsul, 3 kali sehari selama 7-10 hari',
                'price' => 25000,
                'category' => 'Antibiotik'
            ],
            [
                'medicine_name' => 'Ciprofloxacin 500mg',
                'generic_name' => 'Ciprofloxacin HCl',
                'form' => 'Tablet',
                'indication' => 'infeksi saluran kemih, diare bakteri',
                'dosage' => '1 tablet, 2 kali sehari selama 3-7 hari',
                'price' => 35000,
                'category' => 'Antibiotik'
            ],

            // Obat Lambung & Pencernaan
            [
                'medicine_name' => 'Omeprazole 20mg',
                'generic_name' => 'Omeprazole',
                'form' => 'Kapsul',
                'indication' => 'maag, GERD, tukak lambung',
                'dosage' => '1 kapsul sehari sebelum makan pagi',
                'price' => 20000,
                'category' => 'PPI'
            ],
            [
                'medicine_name' => 'Domperidone 10mg',
                'generic_name' => 'Domperidone',
                'form' => 'Tablet',
                'indication' => 'mual, muntah, perut kembung',
                'dosage' => '1 tablet, 3 kali sehari sebelum makan',
                'price' => 15000,
                'category' => 'Antiemetik'
            ],

            // Obat Diabetes
            [
                'medicine_name' => 'Metformin 500mg',
                'generic_name' => 'Metformin HCl',
                'form' => 'Tablet',
                'indication' => 'diabetes tipe 2, resistensi insulin',
                'dosage' => '1-2 tablet, 2-3 kali sehari sesudah makan',
                'price' => 18000,
                'category' => 'Antidiabetik'
            ],
            [
                'medicine_name' => 'Glimepiride 2mg',
                'generic_name' => 'Glimepiride',
                'form' => 'Tablet',
                'indication' => 'diabetes tipe 2',
                'dosage' => '1 tablet sehari sebelum sarapan',
                'price' => 22000,
                'category' => 'Sulfonilurea'
            ],

            // Obat Hipertensi
            [
                'medicine_name' => 'Amlodipine 5mg',
                'generic_name' => 'Amlodipine Besylate',
                'form' => 'Tablet',
                'indication' => 'hipertensi, tekanan darah tinggi',
                'dosage' => '1 tablet sehari pagi hari',
                'price' => 12000,
                'category' => 'ACE Inhibitor'
            ],
            [
                'medicine_name' => 'Captopril 25mg',
                'generic_name' => 'Captopril',
                'form' => 'Tablet',
                'indication' => 'hipertensi, gagal jantung',
                'dosage' => '1 tablet, 2-3 kali sehari sebelum makan',
                'price' => 8000,
                'category' => 'ACE Inhibitor'
            ],

            // Obat Alergi
            [
                'medicine_name' => 'Cetirizine 10mg',
                'generic_name' => 'Cetirizine HCl',
                'form' => 'Tablet',
                'indication' => 'alergi, gatal-gatal, rhinitis',
                'dosage' => '1 tablet sehari malam hari',
                'price' => 6000,
                'category' => 'Antihistamin'
            ],
            [
                'medicine_name' => 'Loratadine 10mg',
                'generic_name' => 'Loratadine',
                'form' => 'Tablet',
                'indication' => 'alergi musiman, bersin-bersin',
                'dosage' => '1 tablet sehari (pagi atau malam)',
                'price' => 7000,
                'category' => 'Antihistamin'
            ],

            // Vitamin & Suplemen
            [
                'medicine_name' => 'Vitamin C 500mg',
                'generic_name' => 'Asam Askorbat',
                'form' => 'Tablet',
                'indication' => 'daya tahan tubuh, sariawan, antioksidan',
                'dosage' => '1 tablet sehari sesudah makan',
                'price' => 4000,
                'category' => 'Vitamin'
            ],
            [
                'medicine_name' => 'Vitamin B Complex',
                'generic_name' => 'B1, B2, B6, B12',
                'form' => 'Tablet',
                'indication' => 'kelelahan, stress, metabolisme',
                'dosage' => '1 tablet sehari sesudah makan',
                'price' => 8000,
                'category' => 'Vitamin'
            ]
        ];

        foreach ($medicines as $medicine) {
            EResep::create([
                'user_id' => 1, // Default user ID atau bisa null
                'medicine_name' => $medicine['medicine_name'],
                'generic_name' => $medicine['generic_name'],
                'form' => $medicine['form'],
                'indication' => $medicine['indication'],
                'dosage' => $medicine['dosage'],
                'quantity' => 1,
                'price' => $medicine['price'],
                'total_price' => $medicine['price'],
                'category' => $medicine['category'],
                'notes' => 'Data obat untuk pencarian',
                'status' => 'template' // Status khusus untuk template obat
            ]);
        }
    }
}
