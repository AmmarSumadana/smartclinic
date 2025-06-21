<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EResep extends Model
{
    use HasFactory;

    // Adjusted fillable for template medicines
    protected $fillable = [
        // 'user_id', // Removed as it's primarily for templates now
        'medicine_name',
        'generic_name',
        'form',
        'indication',
        'dosage',
        'quantity', // quantity here refers to per unit in template, not prescribed quantity
        'price',
        // 'total_price', // Removed as total price is calculated per user prescription
        'category',
        'notes',
        'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relationship with User (if a template was created by a specific admin user, for example)
     * Keep if you want to track who added the template medicine, otherwise remove.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Removed the boot method for total_price calculation as it belongs to HasilResep.
    // The quantity in EResep would be a default or base unit quantity for the template,
    // not the quantity in a user's prescription.

    /**
     * Scope for template medicines only
     */
    public function scopeTemplate($query)
    {
        return $query->where('status', 'template');
    }

    /**
     * Search medicines by various criteria
     */
    public function scopeSearchMedicines($query, $searchTerm)
    {
        return $query->where('status', 'template')
            ->where(function($q) use ($searchTerm) {
                $q->where('medicine_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('generic_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('indication', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('category', 'LIKE', "%{$searchTerm}%");
            });
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get medicines by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category)->where('status', 'template');
    }

    // The 'popular' scope is also more relevant for actual user prescriptions in HasilResep.
    // Removed from here.

    /**
     * Get status badge color (mostly for internal use if EResep instances have various statuses)
     */
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'active' => 'bg-green-100 text-green-800',
            'completed' => 'bg-blue-100 text-blue-800',
            'cancelled' => 'bg-red-100 text-red-800',
            'template' => 'bg-gray-100 text-gray-800'
        ];

        return $colors[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Get medicine categories
     */
    public static function getCategories()
    {
        return [
            'Analgesik' => 'Pereda Nyeri',
            'NSAID' => 'Anti Inflamasi',
            'Antiplatelet' => 'Pengencer Darah',
            'Antitusif' => 'Obat Batuk Kering',
            'Ekspektoran' => 'Obat Batuk Berdahak',
            'Dekongestan' => 'Pelega Hidung',
            'Antibiotik' => 'Anti Bakteri',
            'PPI' => 'Obat Lambung',
            'Antiemetik' => 'Anti Mual',
            'Antidiabetik' => 'Obat Diabetes',
            'Sulfonilurea' => 'Obat Diabetes',
            'ACE Inhibitor' => 'Obat Hipertensi',
            'Antihistamin' => 'Obat Alergi',
            'Vitamin' => 'Suplemen'
        ];
    }
}
