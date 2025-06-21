<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawatInap extends Model
{
    use HasFactory;

    // Nama tabel yang sesuai dengan migrasi Anda (Schema::create('rawat_inap'))
    protected $table = 'rawat_inap';

    // Kolom-kolom yang bisa diisi (fillable)
    protected $fillable = [
        'user_id',                 // ID pasien yang mengajukan
        'patient_name',            // Nama pasien (dari input form)
        'hospital_name',           // Nama rumah sakit tujuan
        'room_number',             // Nomor kamar (diisi oleh pegawai)
        'reason',                  // Alasan rawat inap
        'status',                  // Status pendaftaran: pending, approved, rejected, admitted, discharged, cancelled
        'admission_date',          // Tanggal masuk yang diinginkan/disetujui
        'discharge_date',          // Tanggal keluar (jika sudah selesai rawat inap)
        'ktp_path',                // Path file KTP
        'surat_pengantar_path',    // Path file Surat Pengantar Dokter
        'kartu_asuransi_path',     // Path file Kartu Asuransi (opsional)
        'notes',                   // Catatan internal pegawai (untuk update status)
    ];

    /**
     * Cast attributes to native types.
     * Mengubah tipe data kolom saat diambil dari database.
     * 'admission_date' akan menjadi objek Carbon.
     *
     * @var array
     */
    protected $casts = [
        'admission_date' => 'date',
        'discharge_date' => 'date',
    ];

    /**
     * Relasi: Sebuah permintaan rawat inap dimiliki oleh seorang User (Pasien).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Sebuah permintaan rawat inap mungkin terkait dengan Rumah Sakit.
     * Jika Anda memiliki tabel `hospitals` dan ingin menghubungkan berdasarkan nama atau ID.
     * Contoh ini menghubungkan berdasarkan `hospital_name` dengan kolom `nama` di tabel `hospitals`.
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_name', 'nama');
    }
}
