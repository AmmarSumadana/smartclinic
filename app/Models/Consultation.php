<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'doctor_id',
        'consultation_date',
        'notes',
        'status',
        'response_notes',
        'responded_by_user_id',
    ];

    protected $casts = [
        'consultation_date' => 'datetime',
    ];

    // Relasi ke Pasien (pengguna yang mengajukan konsultasi)
    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Dokter (pengguna dengan role 'doctor' yang dituju)
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    // Relasi ke Pegawai/Dokter yang merespon konsultasi
    public function responder()
    {
        return $this->belongsTo(User::class, 'responded_by_user_id');
    }

    // Accessor untuk format tanggal yang lebih mudah dibaca
    public function getFormattedConsultationDateAttribute()
    {
        return $this->consultation_date ? $this->consultation_date->format('d F Y, H:i') : 'N/A';
    }
}
