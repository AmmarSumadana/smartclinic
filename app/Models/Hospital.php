<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'alamat', 'phone', 'latitude', 'longitude'
    ];

    protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
    ];

    public function cekMedis()
    {
        return $this->hasMany(CekMedis::class);
    }
}
