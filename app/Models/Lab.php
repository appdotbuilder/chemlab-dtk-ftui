<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Lab
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $location
 * @property int $capacity
 * @property array|null $operating_hours
 * @property string|null $head_name
 * @property string|null $technician_name
 * @property string|null $contact_email
 * @property string|null $contact_phone
 * @property array|null $gallery
 * @property array|null $documents
 * @property string|null $rules
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Equipment> $equipment
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Lab newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lab newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lab query()
 * @method static \Illuminate\Database\Eloquent\Builder|Lab whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lab whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lab whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lab active()
 * @method static \Database\Factories\LabFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Lab extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'location',
        'capacity',
        'operating_hours',
        'head_name',
        'technician_name',
        'contact_email',
        'contact_phone',
        'gallery',
        'documents',
        'rules',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'operating_hours' => 'array',
        'gallery' => 'array',
        'documents' => 'array',
        'is_active' => 'boolean',
        'capacity' => 'integer',
    ];

    /**
     * Get the equipment that belongs to this lab.
     */
    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }

    /**
     * Get the users that belong to this lab.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Scope a query to only include active labs.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get available equipment count.
     */
    public function getAvailableEquipmentCountAttribute(): int
    {
        return $this->equipment()->where('status', 'AVAILABLE')->count();
    }

    /**
     * Get total equipment count.
     */
    public function getTotalEquipmentCountAttribute(): int
    {
        return $this->equipment()->count();
    }
}