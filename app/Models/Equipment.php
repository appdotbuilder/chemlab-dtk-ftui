<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Equipment
 *
 * @property int $id
 * @property int $lab_id
 * @property string $name
 * @property string $asset_code
 * @property string|null $serial_number
 * @property string $category
 * @property string|null $brand
 * @property string|null $specifications
 * @property string|null $image_url
 * @property array|null $documents
 * @property string $status
 * @property string $risk_level
 * @property \Illuminate\Support\Carbon|null $next_maintenance_date
 * @property \Illuminate\Support\Carbon|null $next_calibration_date
 * @property string|null $notes
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Lab $lab
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LoanRequest> $loanRequests
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment whereAssetCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment whereLabId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment available()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment active()
 * @method static \Database\Factories\EquipmentFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Equipment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'lab_id',
        'name',
        'asset_code',
        'serial_number',
        'category',
        'brand',
        'specifications',
        'image_url',
        'documents',
        'status',
        'risk_level',
        'next_maintenance_date',
        'next_calibration_date',
        'notes',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'documents' => 'array',
        'is_active' => 'boolean',
        'next_maintenance_date' => 'date',
        'next_calibration_date' => 'date',
    ];

    /**
     * Available equipment statuses.
     */
    public const STATUS_AVAILABLE = 'AVAILABLE';
    public const STATUS_BORROWED = 'BORROWED';
    public const STATUS_BOOKED = 'BOOKED';
    public const STATUS_MAINTENANCE = 'MAINTENANCE';
    public const STATUS_CALIBRATION = 'CALIBRATION';
    public const STATUS_INACTIVE = 'INACTIVE';

    /**
     * Risk levels.
     */
    public const RISK_LOW = 'LOW';
    public const RISK_MEDIUM = 'MEDIUM';
    public const RISK_HIGH = 'HIGH';

    /**
     * Get the lab that owns this equipment.
     */
    public function lab(): BelongsTo
    {
        return $this->belongsTo(Lab::class);
    }

    /**
     * Get the loan requests for this equipment.
     */
    public function loanRequests(): HasMany
    {
        return $this->hasMany(LoanRequest::class);
    }

    /**
     * Scope a query to only include available equipment.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', self::STATUS_AVAILABLE);
    }

    /**
     * Scope a query to only include active equipment.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if equipment can be borrowed.
     */
    public function canBeBorrowed(): bool
    {
        return $this->is_active && 
               in_array($this->status, [self::STATUS_AVAILABLE, self::STATUS_BOOKED]);
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_AVAILABLE => 'green',
            self::STATUS_BORROWED => 'blue',
            self::STATUS_BOOKED => 'yellow',
            self::STATUS_MAINTENANCE => 'orange',
            self::STATUS_CALIBRATION => 'purple',
            self::STATUS_INACTIVE => 'red',
            default => 'gray'
        };
    }
}