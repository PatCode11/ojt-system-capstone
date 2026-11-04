<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceCorrection extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Immutable Audit Record
    |--------------------------------------------------------------------------
    |
    | A correction should never be silently updated afterward.
    |
    | If another correction is necessary, another AttendanceCorrection
    | record should be created.
    |
    */

    public const UPDATED_AT =
        null;


    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Attributes
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'attendance_record_id',
        'attendance_session_id',
        'ojt_assignment_id',
        'student_user_id',
        'corrected_by',

        'attendance_date',
        'session_number',

        'original_time_in',
        'original_time_out',
        'original_rendered_minutes',

        'corrected_time_in',
        'corrected_time_out',
        'corrected_rendered_minutes',

        'original_daily_rendered_minutes',
        'corrected_daily_rendered_minutes',

        'reason',

        'ip_address',
        'user_agent',
    ];


    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'attendance_date' =>
                'immutable_date',

            'session_number' =>
                'integer',

            'original_time_in' =>
                'immutable_datetime',

            'original_time_out' =>
                'immutable_datetime',

            'corrected_time_in' =>
                'immutable_datetime',

            'corrected_time_out' =>
                'immutable_datetime',

            'original_rendered_minutes' =>
                'integer',

            'corrected_rendered_minutes' =>
                'integer',

            'original_daily_rendered_minutes' =>
                'integer',

            'corrected_daily_rendered_minutes' =>
                'integer',

            'created_at' =>
                'immutable_datetime',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Attendance Record
    |--------------------------------------------------------------------------
    */

    public function attendanceRecord(): BelongsTo
    {
        return $this->belongsTo(
            AttendanceRecord::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Attendance Session
    |--------------------------------------------------------------------------
    */

    public function attendanceSession(): BelongsTo
    {
        return $this->belongsTo(
            AttendanceSession::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | OJT Assignment
    |--------------------------------------------------------------------------
    */

    public function ojtAssignment(): BelongsTo
    {
        return $this->belongsTo(
            OjtAssignment::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Student
    |--------------------------------------------------------------------------
    */

    public function student(): BelongsTo
    {
        return $this
            ->belongsTo(
                User::class,
                'student_user_id'
            )
            ->withTrashed();
    }


    /*
    |--------------------------------------------------------------------------
    | Correcting Administrator
    |--------------------------------------------------------------------------
    */

    public function correctedBy(): BelongsTo
    {
        return $this
            ->belongsTo(
                User::class,
                'corrected_by'
            )
            ->withTrashed();
    }


    /*
    |--------------------------------------------------------------------------
    | Session Label
    |--------------------------------------------------------------------------
    */

    public function sessionLabel(): string
    {
        return match (
            $this->session_number
        ) {
            AttendanceSession::MORNING_SESSION =>
                'Morning Session',

            AttendanceSession::AFTERNOON_SESSION =>
                'Afternoon Session',

            default =>
                'Attendance Session',
        };
    }


    /*
    |--------------------------------------------------------------------------
    | Original Rendered Time Label
    |--------------------------------------------------------------------------
    */

    public function originalRenderedTimeLabel(): string
    {
        return $this->formatMinutes(
            $this->original_rendered_minutes
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Corrected Rendered Time Label
    |--------------------------------------------------------------------------
    */

    public function correctedRenderedTimeLabel(): string
    {
        return $this->formatMinutes(
            $this->corrected_rendered_minutes
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Minute Formatter
    |--------------------------------------------------------------------------
    */

    private function formatMinutes(
        int $minutes
    ): string {
        $minutes =
            max(
                0,
                $minutes
            );

        $hours =
            intdiv(
                $minutes,
                60
            );

        $remainingMinutes =
            $minutes % 60;

        if (
            $hours > 0
            &&
            $remainingMinutes > 0
        ) {
            return
                $hours
                .' hr'
                .($hours !== 1 ? 's' : '')
                .' '
                .$remainingMinutes
                .' min';
        }

        if ($hours > 0) {
            return
                $hours
                .' hr'
                .($hours !== 1 ? 's' : '');
        }

        return
            $remainingMinutes
            .' min';
    }
}