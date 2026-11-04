<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AttendanceRecord extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Attendance Statuses
    |--------------------------------------------------------------------------
    */

    public const STATUS_IN_PROGRESS = 'in_progress';

    public const STATUS_PENDING = 'pending';

    public const STATUS_VALIDATED = 'validated';

    public const STATUS_REJECTED = 'rejected';

    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Attributes
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'ojt_assignment_id',
        'attendance_date',

        'time_in',
        'time_in_latitude',
        'time_in_longitude',
        'time_in_accuracy',
        'time_in_selfie_path',

        'time_out',
        'time_out_latitude',
        'time_out_longitude',
        'time_out_accuracy',
        'time_out_selfie_path',

        'rendered_minutes',

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
            'attendance_date' => 'date',

            'time_in' => 'immutable_datetime',
            'time_out' => 'immutable_datetime',

            'time_in_latitude' => 'decimal:7',
            'time_in_longitude' => 'decimal:7',
            'time_in_accuracy' => 'decimal:2',

            'time_out_latitude' => 'decimal:7',
            'time_out_longitude' => 'decimal:7',
            'time_out_accuracy' => 'decimal:2',

            'rendered_minutes' => 'integer',

            'validated_at' => 'immutable_datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function ojtAssignment(): BelongsTo
    {
        return $this->belongsTo(
            OjtAssignment::class
        );
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'validated_by'
        );
    }

    /**
     * Daily Work Log associated with this attendance.
     */
    public function dailyWorkLog(): HasOne
    {
        return $this->hasOne(
            DailyWorkLog::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function renderedHoursLabel(): string
    {
        if ($this->rendered_minutes === null) {
            return '—';
        }

        $hours = intdiv(
            $this->rendered_minutes,
            60
        );

        $minutes =
            $this->rendered_minutes % 60;

        return sprintf(
            '%dh %02dm',
            $hours,
            $minutes
        );
    }
}