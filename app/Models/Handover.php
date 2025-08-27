<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Handover
 *
 * @property int $id
 * @property int $loan_request_id
 * @property string $type
 * @property int $handled_by
 * @property array|null $condition_photos
 * @property array|null $accessory_checklist
 * @property string|null $notes
 * @property string|null $damage_report
 * @property string|null $qr_code_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\LoanRequest $loanRequest
 * @property-read \App\Models\User $handledBy
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Handover newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Handover newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Handover query()
 * @method static \Illuminate\Database\Eloquent\Builder|Handover whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Handover whereLoanRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Handover whereType($value)

 * 
 * @mixin \Eloquent
 */
class Handover extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'loan_request_id',
        'type',
        'handled_by',
        'condition_photos',
        'accessory_checklist',
        'notes',
        'damage_report',
        'qr_code_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'condition_photos' => 'array',
        'accessory_checklist' => 'array',
    ];

    /**
     * Handover types.
     */
    public const TYPE_CHECK_OUT = 'CHECK_OUT';
    public const TYPE_CHECK_IN = 'CHECK_IN';

    /**
     * Get the loan request for this handover.
     */
    public function loanRequest(): BelongsTo
    {
        return $this->belongsTo(LoanRequest::class);
    }

    /**
     * Get the user who handled this handover.
     */
    public function handledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}