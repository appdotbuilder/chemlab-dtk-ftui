<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PasswordHelpTicket
 *
 * @property int $id
 * @property string $ticket_number
 * @property string $email
 * @property string $name
 * @property string|null $message
 * @property string $status
 * @property string|null $resolution_notes
 * @property int|null $resolved_by
 * @property \Illuminate\Support\Carbon|null $resolved_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $resolvedBy
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHelpTicket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHelpTicket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHelpTicket query()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHelpTicket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHelpTicket whereTicketNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHelpTicket whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHelpTicket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHelpTicket pending()

 * 
 * @mixin \Eloquent
 */
class PasswordHelpTicket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'ticket_number',
        'email',
        'name',
        'message',
        'status',
        'resolution_notes',
        'resolved_by',
        'resolved_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    /**
     * Ticket statuses.
     */
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_IN_PROGRESS = 'IN_PROGRESS';
    public const STATUS_RESOLVED = 'RESOLVED';
    public const STATUS_REJECTED = 'REJECTED';

    /**
     * Get the user who resolved this ticket.
     */
    public function resolvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Scope a query to only include pending tickets.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Generate unique ticket number.
     */
    public static function generateTicketNumber(): string
    {
        $date = now()->format('Ymd');
        $count = static::whereDate('created_at', now())->count() + 1;
        return "TKT-{$date}-" . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'yellow',
            self::STATUS_IN_PROGRESS => 'blue',
            self::STATUS_RESOLVED => 'green',
            self::STATUS_REJECTED => 'red',
            default => 'gray'
        };
    }
}