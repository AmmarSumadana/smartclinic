<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// Import model-model yang terkait untuk definisi relasi
use App\Models\RawatInap;
use App\Models\Consultation;
use App\Models\MedicalHistory;
use App\Models\LabTest;
use App\Models\EResep;
use App\Models\HasilResep;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_user');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isDoctor()
    {
        return $this->role === 'doctor';
    }

    /**
     * Memeriksa apakah pengguna adalah pasien (menggunakan 'pasien' sebagai nilai peran)
     */
    public function isPatient()
    {
        return $this->role === 'pasien'; // Perbaikan di sini
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function isHospitalEmployee()
    {
        return $this->isStaff() || $this->isDoctor();
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Define a one-to-many relationship with RawatInap.
     */
    public function rawatInaps()
    {
        // Asumsi: Tabel 'rawat_inap' memiliki kolom 'user_id'
        // yang mengacu pada 'id' di tabel 'users'.
        return $this->hasMany(RawatInap::class, 'user_id');
    }

    /**
     * Define a one-to-many relationship with Consultation.
     */
    public function index()
    {
        return $this->hasMany(Consultation::class, 'user_id');
    }
    /**
     * Define a one-to-many relationship with LabTest.
     */
    public function labTests()
    {
        return $this->hasMany(LabTest::class, 'user_id');
    }

    /**
     * Define a one-to-many relationship with EResep.
     */
    public function eReseps()
    {
        return $this->hasMany(EResep::class, 'user_id');
    }

    /**
     * Define a one-to-many relationship with HasilResep.
     */
    public function hasilReseps()
    {
        return $this->hasMany(HasilResep::class, 'user_id');
    }
}
