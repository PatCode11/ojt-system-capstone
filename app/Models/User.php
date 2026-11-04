<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */

    public const ROLE_ADMIN = 'admin';

    public const ROLE_STUDENT = 'student';

    public const ROLE_SUPERVISOR = 'supervisor';


    /*
    |--------------------------------------------------------------------------
    | Account Status
    |--------------------------------------------------------------------------
    */

    public const STATUS_ACTIVE = 'active';

    public const STATUS_INACTIVE = 'inactive';


    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Attributes
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];


    /*
    |--------------------------------------------------------------------------
    | Hidden Attributes
    |--------------------------------------------------------------------------
    */

    protected $hidden = [
        'password',
        'remember_token',
    ];


    /*
    |--------------------------------------------------------------------------
    | Attribute Casts
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'deleted_at' => 'datetime',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Student Profile
    |--------------------------------------------------------------------------
    */

    public function studentProfile(): HasOne
    {
        return $this->hasOne(
            StudentProfile::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Supervised OJT Assignments
    |--------------------------------------------------------------------------
    */

    public function supervisedAssignments(): HasMany
    {
        return $this->hasMany(
            OjtAssignment::class,
            'supervisor_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Role Helpers
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }


    public function isStudent(): bool
    {
        return $this->role === self::ROLE_STUDENT;
    }


    public function isSupervisor(): bool
    {
        return $this->role === self::ROLE_SUPERVISOR;
    }


    /*
    |--------------------------------------------------------------------------
    | Status Helpers
    |--------------------------------------------------------------------------
    */

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }


    public function isInactive(): bool
    {
        return $this->status === self::STATUS_INACTIVE;
    }


    /*
    |--------------------------------------------------------------------------
    | Archive Helpers
    |--------------------------------------------------------------------------
    */

    public function isArchived(): bool
    {
        return $this->trashed();
    }


    public function isNotArchived(): bool
    {
        return ! $this->trashed();
    }
}