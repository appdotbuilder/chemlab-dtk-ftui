<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property int|null $lab_id
 * @property string|null $phone
 * @property string|null $study_program
 * @property string|null $batch_year
 * @property bool $is_verified
 * @property bool $is_active
 * @property bool $must_change_password
 * @property \Illuminate\Support\Carbon|null $last_login_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Lab|null $lab
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LoanRequest> $loanRequests
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LoanRequest> $supervisedRequests
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User active()
 * @method static \Illuminate\Database\Eloquent\Builder|User verified()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'lab_id',
        'phone',
        'study_program',
        'batch_year',
        'is_verified',
        'is_active',
        'must_change_password',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
            'is_active' => 'boolean',
            'must_change_password' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Get the lab associated with this user.
     */
    public function lab(): BelongsTo
    {
        return $this->belongsTo(Lab::class);
    }

    /**
     * Get the loan requests made by this user.
     */
    public function loanRequests(): HasMany
    {
        return $this->hasMany(LoanRequest::class);
    }

    /**
     * Get the loan requests supervised by this user.
     */
    public function supervisedRequests(): HasMany
    {
        return $this->hasMany(LoanRequest::class, 'supervisor_id');
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include verified users.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Check if user is a student (temporary implementation).
     */
    public function isStudent(): bool
    {
        return str_ends_with($this->email, '@ui.ac.id');
    }

    /**
     * Check if user is a lecturer (temporary implementation).
     */
    public function isLecturer(): bool
    {
        return str_ends_with($this->email, '@che.ui.ac.id') && str_contains($this->name, 'Prof.');
    }

    /**
     * Check if user is a lab technician (temporary implementation).
     */
    public function isLabTechnician(): bool
    {
        return str_ends_with($this->email, '@che.ui.ac.id') && !is_null($this->lab_id) && !$this->isLecturer() && !$this->isAdmin();
    }

    /**
     * Check if user is a lab head (temporary implementation).
     */
    public function isLabHead(): bool
    {
        return str_ends_with($this->email, '@che.ui.ac.id') && !is_null($this->lab_id) && str_contains($this->name, 'Prof.');
    }

    /**
     * Check if user is an admin (temporary implementation).
     */
    public function isAdmin(): bool
    {
        return str_ends_with($this->email, '@che.ui.ac.id') && str_contains($this->name, 'Administrator');
    }

    /**
     * Get user roles as array (temporary implementation).
     */
    public function getRoles(): array
    {
        $roles = [];
        
        if ($this->isAdmin()) {
            $roles[] = 'admin';
        } elseif ($this->isLabHead()) {
            $roles[] = 'kepala_lab';
        } elseif ($this->isLabTechnician()) {
            $roles[] = 'laboran';
        } elseif ($this->isLecturer()) {
            $roles[] = 'dosen';
        } elseif ($this->isStudent()) {
            $roles[] = 'mahasiswa';
        }

        return $roles;
    }

    /**
     * Check if user has a specific role (temporary implementation).
     */
    public function hasRole($role): bool
    {
        if (is_array($role)) {
            return !empty(array_intersect($role, $this->getRoles()));
        }
        
        return in_array($role, $this->getRoles());
    }
}