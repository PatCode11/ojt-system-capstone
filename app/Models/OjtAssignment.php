<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OjtAssignment extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Assignment Statuses
    |--------------------------------------------------------------------------
    */

    public const STATUS_PENDING = 'pending';

    public const STATUS_ACTIVE = 'active';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_CANCELLED = 'cancelled';


    /*
    |--------------------------------------------------------------------------
    | Open Assignment Statuses
    |--------------------------------------------------------------------------
    */

    public const OPEN_STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_ACTIVE,
    ];


    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Attributes
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'student_profile_id',
        'company_id',
        'supervisor_id',

        'required_hours',

        'start_date',
        'end_date',

        'status',
        'notes',

        'completed_by',
        'completed_at',
        'completion_remarks',
    ];


    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'required_hours' =>
                'integer',

            'start_date' =>
                'date',

            'end_date' =>
                'date',

            'completed_at' =>
                'immutable_datetime',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Student Profile
    |--------------------------------------------------------------------------
    */

    public function studentProfile(): BelongsTo
    {
        return $this->belongsTo(
            StudentProfile::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Company
    |--------------------------------------------------------------------------
    */

    public function company(): BelongsTo
    {
        return $this->belongsTo(
            Company::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Supervisor
    |--------------------------------------------------------------------------
    |
    | withTrashed() is intentional.
    |
    | Historical OJT records must continue to show the Supervisor even
    | after the Supervisor account is archived.
    |
    */

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'supervisor_id'
        )->withTrashed();
    }


    /*
    |--------------------------------------------------------------------------
    | Completing Administrator
    |--------------------------------------------------------------------------
    |
    | Historical completion information should remain readable even if
    | soft-delete support is ever used for that User record.
    |
    */

    public function completedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'completed_by'
        )->withTrashed();
    }


    /*
    |--------------------------------------------------------------------------
    | Attendance Records
    |--------------------------------------------------------------------------
    */

    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(
            AttendanceRecord::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Daily Work Logs
    |--------------------------------------------------------------------------
    */

    public function dailyWorkLogs(): HasManyThrough
    {
        return $this->hasManyThrough(
            DailyWorkLog::class,
            AttendanceRecord::class,
            'ojt_assignment_id',
            'attendance_record_id',
            'id',
            'id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Final Supervisor Evaluation
    |--------------------------------------------------------------------------
    */

    public function finalEvaluation(): HasOne
    {
        return $this->hasOne(
            SupervisorEvaluation::class
        );
    }
}