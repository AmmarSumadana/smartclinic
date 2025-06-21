<?php
// app/Models/LayananAmbulans.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class LayananAmbulans extends Model
{
    use HasFactory;

    protected $table = 'layanan_ambulans';

    protected $fillable = [
        'user_id',
        'hospital_id',
        'nama_pasien',
        'nomor_telepon',
        'alamat_penjemputan',
        'latitude',
        'longitude',
        'tingkat_urgensi',
        'deskripsi_kondisi',
        'status',
        'waktu_permintaan',
        'estimasi_tiba'
    ];

    protected $casts = [
        'waktu_permintaan' => 'datetime',
        'estimasi_tiba' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    // Accessors & Mutators
    public function getStatusLabelAttribute()
    {
        $labels = [
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
            'dikonfirmasi' => 'Dikonfirmasi',
            'dalam_perjalanan' => 'Dalam Perjalanan',
            'tiba_di_lokasi' => 'Tiba di Lokasi',
            'menuju_rumah_sakit' => 'Menuju Rumah Sakit',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan'
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function getUrgencyLabelAttribute()
    {
        $labels = [
            'rendah' => 'Rendah',
            'sedang' => 'Sedang',
            'tinggi' => 'Tinggi',
            'darurat' => 'Darurat'
        ];

        return $labels[$this->tingkat_urgensi] ?? $this->tingkat_urgensi;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'menunggu_konfirmasi' => 'warning',
            'dikonfirmasi' => 'info',
            'dalam_perjalanan' => 'primary',
            'tiba_di_lokasi' => 'success',
            'menuju_rumah_sakit' => 'primary',
            'selesai' => 'success',
            'dibatalkan' => 'danger'
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    public function getUrgencyColorAttribute()
    {
        $colors = [
            'rendah' => 'success',
            'sedang' => 'warning',
            'tinggi' => 'danger',
            'darurat' => 'danger'
        ];

        return $colors[$this->tingkat_urgensi] ?? 'secondary';
    }

    // Scopes
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['selesai', 'dibatalkan']);
    }

    // Methods
    public function updateStatus($status)
    {
        $this->update(['status' => $status]);

        // Set estimasi tiba jika status dikonfirmasi
        if ($status === 'dikonfirmasi' && !$this->estimasi_tiba) {
            $this->update([
                'estimasi_tiba' => Carbon::now()->addMinutes(15) // Default 15 menit
            ]);
        }
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['menunggu_konfirmasi', 'dikonfirmasi']);
    }
}
