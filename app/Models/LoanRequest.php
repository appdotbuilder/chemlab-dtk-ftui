<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\LoanRequest
 *
 * @property int $id
 * @property string $request_number
 * @property int $user_id
 * @property int $equipment_id
 * @property int|null $supervisor_id
 * @property \Illuminate\Support\Carbon $start_at
 * @property \Illuminate\Support\Carbon $end_at
 * @property string|null $purpose
 * @property string|null $jsa_document_path
 * @property string $status
 * @property string|null $rejection_reason
 * @property string|null $repair_notes
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property int|null $approved_by
 * @property \Illuminate\Support\Carbon|null $checked_out_at
 * @property int|null $checked_out_by
 * @property \Illuminate\Support\Carbon|null $returned_at
 * @property int|null $returned_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Equipment $equipment
 * @property-read \App\Models\User|null $supervisor
 * @property-read \App\Models\User|null $approvedBy
 * @property-read \App\Models\User|null $checkedOutBy
 * @property-read \App\Models\User|null $returnedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Handover> $handovers
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|LoanRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanRequest whereRequestNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanRequest whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanRequest pending()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanRequest overdue()
 * @method static \Database\Factories\LoanRequestFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class LoanRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'request_number',
        'user_id',
        'equipment_id',
        'supervisor_id',
        'start_at',
        'end_at',
        'purpose',
        'jsa_document_path',
        'status',
        'rejection_reason',
        'repair_notes',
        'approved_at',
        'approved_by',
        'checked_out_at',
        'checked_out_by',
        'returned_at',
        'returned_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'approved_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    /**
     * Loan request statuses.
     */
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_APPROVED = 'APPROVED';
    public const STATUS_REJECTED = 'REJECTED';
    public const STATUS_NEEDS_REPAIR = 'NEEDS_REPAIR';
    public const STATUS_CHECKED_OUT = 'CHECKED_OUT';
    public const STATUS_RETURNED = 'RETURNED';
    public const STATUS_OVERDUE = 'OVERDUE';

    /**
     * Get the user who made the request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the equipment being requested.
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    /**
     * Get the supervisor for this request.
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    /**
     * Get the user who approved this request.
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the user who checked out this request.
     */
    public function checkedOutBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_out_by');
    }

    /**
     * Get the user who processed the return.
     */
    public function returnedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'returned_by');
    }

    /**
     * Get the handovers for this loan request.
     */
    public function handovers(): HasMany
    {
        return $this->hasMany(Handover::class);
    }

    /**
     * Scope a query to only include pending requests.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope a query to only include overdue requests.
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', self::STATUS_OVERDUE);
    }

    /**
     * Check if request is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->status === self::STATUS_CHECKED_OUT && 
               $this->end_at->isPast();
    }

    /**
     * Generate unique request number.
     */
    public static function generateRequestNumber(): string
    {
        $date = now()->format('Ymd');
        $count = static::whereDate('created_at', now())->count() + 1;
        return "REQ-{$date}-" . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'yellow',
            self::STATUS_APPROVED => 'green',
            self::STATUS_REJECTED => 'red',
            self::STATUS_NEEDS_REPAIR => 'orange',
            self::STATUS_CHECKED_OUT => 'blue',
            self::STATUS_RETURNED => 'gray',
            self::STATUS_OVERDUE => 'red',
            default => 'gray'
        };
    }
}