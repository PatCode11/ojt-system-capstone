<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceSession extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | Session Numbers
    |--------------------------------------------------------------------------
    */

    public const MORNING_SESSION = 1;

    public const AFTERNOON_SESSION = 2;

    public const MAX_SESSIONS_PER_DAY = 2;


    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Fields
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'attendance_record_id',

        'session_number',

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
    ];


    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'session_number' =>
                'integer',

            'time_in' =>
                'immutable_datetime',

            'time_out' =>
                'immutable_datetime',

            'time_in_latitude' =>
                'float',

            'time_in_longitude' =>
                'float',

            'time_in_accuracy' =>
                'float',

            'time_out_latitude' =>
                'float',

            'time_out_longitude' =>
                'float',

            'time_out_accuracy' =>
                'float',

            'rendered_minutes' =>
                'integer',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Daily Attendance Record
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
    | State Helpers
    |--------------------------------------------------------------------------
    */

    public function isOpen(): bool
    {
        return
            $this->time_out
            === null;
    }

    public function isCompleted(): bool
    {
        return
            $this->time_out
            !== null;
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
            self::MORNING_SESSION =>
                'Morning Session',

            self::AFTERNOON_SESSION =>
                'Afternoon Session',

            default =>
                'Session '
                .$this->session_number,
        };
    }


    /*
    |--------------------------------------------------------------------------
    | Rendered Time Label
    |--------------------------------------------------------------------------
    */

    public function renderedTimeLabel(): string
    {
        $minutes =
            max(
                0,
                (int) $this
                    ->rendered_minutes
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
            && $remainingMinutes > 0
        ) {
            return $hours
                .' hr'
                .($hours !== 1 ? 's' : '')
                .' '
                .$remainingMinutes
                .' min'
                .($remainingMinutes !== 1 ? 's' : '');
        }

        if ($hours > 0) {
            return $hours
                .' hr'
                .($hours !== 1 ? 's' : '');
        }

        return $remainingMinutes
            .' min'
            .($remainingMinutes !== 1 ? 's' : '');
    }
}