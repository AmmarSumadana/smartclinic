<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LabTest extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lab_tests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'test_type',
        'test_date',
        'result',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'test_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the user that owns the lab test.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Get the test date formatted for Indonesia.
     *
     * @return string
     */
    public function getFormattedTestDateAttribute(): string
    {
        // Ensure test_date is a Carbon instance due to casting
        return $this->test_date ? $this->test_date->format('d/m/Y') : '';
    }

    /**
     * Get the creation timestamp formatted.
     *
     * @return string
     */
    public function getFormattedCreatedAtAttribute(): string
    {
        // Ensure created_at is a Carbon instance due to casting
        return $this->created_at ? $this->created_at->format('d/m/Y H:i') : '';
    }

    /**
     * Get the status of the lab test result.
     *
     * @return string 'normal', 'tinggi', 'rendah', or 'unknown'
     */
    public function getStatusAttribute(): string
    {
        $result = strtolower($this->result);

        if (str_contains($result, 'normal')) {
            return 'normal';
        } elseif (str_contains($result, 'tinggi') || str_contains($result, 'high')) {
            return 'tinggi';
        } elseif (str_contains($result, 'rendah') || str_contains($result, 'low')) {
            return 'rendah';
        } else {
            return 'unknown';
        }
    }

    /**
     * Get the CSS badge class based on the test status.
     *
     * @return string
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'normal' => 'badge-success',
            'tinggi' => 'badge-danger',
            'rendah' => 'badge-warning',
            default => 'badge-secondary',
        };
    }

    /**
     * Get the Font Awesome icon based on the test type.
     *
     * @return string
     */
    public function getTestTypeIconAttribute(): string
    {
        $icons = [
            'Darah Lengkap' => 'fas fa-tint',
            'Gula Darah' => 'fas fa-cube', // Consider if 'fas fa-glucose' or 'fas fa-sugar' might be more specific, if available.
            'Kolesterol' => 'fas fa-heartbeat',
            'Fungsi Hati' => 'fas fa-liver', // This assumes 'fas fa-liver' exists, often 'fas fa-diagnoses' or a more general medical icon is used.
            'Fungsi Ginjal' => 'fas fa-kidneys', // Assumes 'fas fa-kidneys' exists.
            'Urin Lengkap' => 'fas fa-flask',
            'Asam Urat' => 'fas fa-dna',
            'Thyroid' => 'fas fa-user-md',
            'HIV' => 'fas fa-shield-virus',
            'Hepatitis' => 'fas fa-virus',
        ];

        return $icons[$this->test_type] ?? 'fas fa-vial';
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to only include lab tests for a specific user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include lab tests of a specific type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $testType
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByTestType($query, string $testType)
    {
        return $query->where('test_type', $testType);
    }

    /**
     * Scope a query to only include lab tests within a specific date range.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInDateRange($query, string $startDate, string $endDate)
    {
        return $query->whereBetween('test_date', [$startDate, $endDate]);
    }

    /**
     * Scope a query to retrieve the most recent lab tests.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query, int $limit = 10)
    {
        return $query->orderBy('test_date', 'desc')->limit($limit);
    }

    /**
     * Scope a query to only include lab tests from the current month.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('test_date', now()->month)
                     ->whereYear('test_date', now()->year);
    }

    /**
     * Scope a query to only include lab tests from the current year.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeThisYear($query)
    {
        return $query->whereYear('test_date', now()->year);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods for Statistics
    |--------------------------------------------------------------------------
    */

    /**
     * Get monthly statistics for lab tests of a specific user for the current year.
     *
     * @param int $userId
     * @return \Illuminate\Support\Collection
     */
    public static function getMonthlyStats(int $userId)
    {
        return self::forUser($userId)
            ->selectRaw('MONTH(test_date) as month, COUNT(*) as count')
            ->whereYear('test_date', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    /**
     * Get statistics for lab tests by type for a specific user.
     *
     * @param int $userId
     * @return \Illuminate\Support\Collection
     */
    public static function getTestTypeStats(int $userId)
    {
        return self::forUser($userId)
            ->selectRaw('test_type, COUNT(*) as count')
            ->groupBy('test_type')
            ->orderBy('count', 'desc')
            ->get();
    }

    /**
     * Get the total number of lab tests for a user in the current month.
     *
     * @param int $userId
     * @return int
     */
    public static function getTotalTestsThisMonth(int $userId): int
    {
        return self::forUser($userId)->thisMonth()->count();
    }

    /**
     * Get the total number of lab tests for a user in the current year.
     *
     * @param int $userId
     * @return int
     */
    public static function getTotalTestsThisYear(int $userId): int
    {
        return self::forUser($userId)->thisYear()->count();
    }

    /**
     * Determine if the test result falls within a normal range.
     * This is a simplified example; real-world implementation would be more complex.
     *
     * @return bool|null True if normal, false if not, null if range not defined.
     */
    public function isNormalRange(): ?bool
    {
        // Define normal ranges. In a real application, these might be stored in a database
        // or a configuration file, potentially per test_type and even per age/gender.
        $normalRanges = [
            'Gula Darah' => ['min' => 70, 'max' => 140],
            'Kolesterol' => ['min' => 0, 'max' => 200],
            'Asam Urat' => ['min' => 2.5, 'max' => 7.0],
        ];

        if (isset($normalRanges[$this->test_type])) {
            // Safely extract the numerical value from the result string.
            // This handles cases where 'result' might be "120 mg/dL" or "7.5 mmol/L".
            $value = (float) filter_var($this->result, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $range = $normalRanges[$this->test_type];

            return $value >= $range['min'] && $value <= $range['max'];
        }

        return null; // Cannot determine if the range is not defined for the test type.
    }
}
