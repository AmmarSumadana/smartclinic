<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    protected $fillable = [
        'patient_name', 'diagnosis', 'treatment', 'recorded_at'
    ];
}
