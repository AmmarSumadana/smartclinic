<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RawatInap extends Model
{
    use HasFactory;

    protected $table = 'rawat_inap';

    protected $fillable = [
        'user_id',
        'patient_name', // Kolom baru
        'hospital_name',
        'room_number',
        'reason', // Kolom baru
        'status',
        'admission_date',
        'discharge_date',
        'ktp_path', // Kolom baru untuk path file
        'surat_pengantar_path', // Kolom baru untuk path file
        'kartu_asuransi_path', // Kolom baru untuk path file
    ];

    protected $casts = [
        'admission_date' => 'datetime',
        'discharge_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
