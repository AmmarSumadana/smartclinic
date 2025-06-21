<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Pastikan User model di-import
use App\Models\Hospital; // Pastikan Hospital model di-import

class CekMedis extends Model
{
    use HasFactory;

    protected $table = 'cek_medis'; // Pastikan nama tabel sesuai

    protected $fillable = [
        'user_id', // Penting: Tambahkan user_id di sini
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_identitas',
        'no_hp',
        'email',
        'alamat',
        'penyakit_kronis',
        'obat_rutin',
        'alergi',
        'riwayat_operasi',
        'penyakit_keluarga',
        'merokok',
        'alkohol',
        'olahraga',
        'pola_makan',
        'gejala',
        'lama_gejala',
        'tingkat_keparahan',
        'periksa_di_tempat',
        'tekanan_darah',
        'denyut_nadi',
        'berat_badan',
        'tinggi_badan',
        'imt',
        'suhu',
        'paket',
        'jadwal_tanggal',
        'jadwal_jam',
        'hospital_id',
        'geom',
        'pdf_path',
    ];

    /**
     * Get the user that owns the medical check.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the hospital where the medical check was performed.
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}
