<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyWorkLog extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Work Log Statuses
    |--------------------------------------------------------------------------
    */

    public const STATUS_PENDING = 'pending';

    public const STATUS_VALIDATED = 'validated';

    public const STATUS_REJECTED = 'rejected';

    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Attributes
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'attendance_record_id',
        'tasks_accomplished',
        'learnings',
        'challenges',
        'student_remarks',
        'submitted_at',
        'status',
        'supervisor_remarks',
        'validated_by',
        'validated_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'submitted_at' => 'immutable_datetime',
            'validated_at' => 'immutable_datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Attendance record associated with this work log.
     */
    public function attendanceRecord(): BelongsTo
    {
        return $this->belongsTo(
            AttendanceRecord::class
        );
    }

    /**
     * Supervisor who validated the work log.
     */
    public function validator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'validated_by'
        );
    }
}