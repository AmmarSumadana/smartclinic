<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
}
