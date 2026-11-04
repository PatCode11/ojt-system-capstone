<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentProfile extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'user_id',
        'student_number',
        'program',
        'year_level',
        'section',
        'contact_number',
        'address',
        'emergency_contact_name',
        'emergency_contact_number',
        'emergency_contact_relationship',
        'emergency_contact_address',
    ];

    /**
     * Get the User account belonging to this profile.
     *
     * withTrashed() is intentional so historical OJT records
     * can still display the Student's account information
     * even after the Student account has been archived.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        )->withTrashed();
    }

    /**
     * Get all OJT assignments belonging to this student.
     */
    public function ojtAssignments(): HasMany
    {
        return $this->hasMany(
            OjtAssignment::class
        );
    }
}