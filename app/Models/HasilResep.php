<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilResep extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'medicine_name',
        'dosage',
        'quantity',
        'price', // This 'price' field in hasil_reseps table will store the total price for the item
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
