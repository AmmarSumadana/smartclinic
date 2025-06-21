<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Doctor extends Model
    {
        protected $table = 'doctors'; // Pastikan ini sesuai dengan nama tabel

        protected $fillable = [
            'hospital_id', 'name', 'specialty', 'phone'
        ];

        public function hospital()
        {
            return $this->belongsTo(Hospital::class);
        }

        public function consultations()
        {
            return $this->hasMany(Consultation::class);
        }
    }
    