<?php

namespace App\Observers;

use App\Models\AttendanceRecord;
use App\Services\AuditLogService;

class AttendanceRecordObserver
{
    /**
     * Time In creates the Attendance Record.
     */
    public function created(
        AttendanceRecord $attendance
    ): void {
        app(AuditLogService::class)
            ->record(
                'attendance.time_in',
                $attendance,
                sprintf(
                    'Time In recorded for Attendance #%d.',
                    $attendance->id
                ),
                [
                    'attendance_id' =>
                        $attendance->id,

                    'assignment_id' =>
                        $attendance->ojt_assignment_id,

                    'attendance_date' =>
                        $attendance
                            ->attendance_date
                            ?->format('Y-m-d'),

                    'status' =>
                        $attendance->status,
                ]
            );
    }

    /**
     * Attendance updated.
     */
    public function updated(
        AttendanceRecord $attendance
    ): void {
        /*
        |--------------------------------------------------------------------------
        | Supervisor Validated
        |--------------------------------------------------------------------------
        */

        if (
            $attendance->wasChanged('status')
            && $attendance->status
                === AttendanceRecord::STATUS_VALIDATED
        ) {
            app(AuditLogService::class)
                ->record(
                    'attendance.validated',
                    $attendance,
                    sprintf(
                        'Attendance #%d validated.',
                        $attendance->id
                    ),
                    [
                        'attendance_id' =>
                            $attendance->id,

                        'assignment_id' =>
                            $attendance->ojt_assignment_id,

                        'rendered_minutes' =>
                            $attendance->rendered_minutes,

                        'status' =>
                            $attendance->status,

                        'validated_by' =>
                            $attendance->validated_by,
                    ]
                );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Supervisor Rejected
        |--------------------------------------------------------------------------
        */

        if (
            $attendance->wasChanged('status')
            && $attendance->status
                === AttendanceRecord::STATUS_REJECTED
        ) {
            app(AuditLogService::class)
                ->record(
                    'attendance.rejected',
                    $attendance,
                    sprintf(
                        'Attendance #%d rejected.',
                        $attendance->id
                    ),
                    [
                        'attendance_id' =>
                            $attendance->id,

                        'assignment_id' =>
                            $attendance->ojt_assignment_id,

                        'status' =>
                            $attendance->status,

                        'validated_by' =>
                            $attendance->validated_by,
                    ]
                );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Student Time Out
        |--------------------------------------------------------------------------
        */

        if (
            $attendance->wasChanged(
                'time_out'
            )
        ) {
            app(AuditLogService::class)
                ->record(
                    'attendance.time_out',
                    $attendance,
                    sprintf(
                        'Time Out recorded for Attendance #%d.',
                        $attendance->id
                    ),
                    [
                        'attendance_id' =>
                            $attendance->id,

                        'assignment_id' =>
                            $attendance->ojt_assignment_id,

                        'rendered_minutes' =>
                            $attendance->rendered_minutes,

                        'status' =>
                            $attendance->status,
                    ]
                );
        }
    }
}