<?php

namespace App\Observers;

use App\Models\DailyWorkLog;
use App\Services\AuditLogService;

class DailyWorkLogObserver
{
    /**
     * Work Log submitted.
     */
    public function created(
        DailyWorkLog $workLog
    ): void {
        app(AuditLogService::class)
            ->record(
                'work_log.submitted',
                $workLog,
                sprintf(
                    'Daily Work Log #%d submitted.',
                    $workLog->id
                ),
                [
                    'work_log_id' =>
                        $workLog->id,

                    'attendance_record_id' =>
                        $workLog->attendance_record_id,

                    'status' =>
                        $workLog->status,
                ]
            );
    }

    /**
     * Work Log updated.
     */
    public function updated(
        DailyWorkLog $workLog
    ): void {
        if (
            ! $workLog->wasChanged(
                'status'
            )
        ) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Validated
        |--------------------------------------------------------------------------
        */

        if (
            $workLog->status
            === DailyWorkLog::STATUS_VALIDATED
        ) {
            $action =
                'work_log.validated';

            $description =
                sprintf(
                    'Daily Work Log #%d validated.',
                    $workLog->id
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Rejected
        |--------------------------------------------------------------------------
        */

        elseif (
            $workLog->status
            === DailyWorkLog::STATUS_REJECTED
        ) {
            $action =
                'work_log.rejected';

            $description =
                sprintf(
                    'Daily Work Log #%d rejected.',
                    $workLog->id
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Student Resubmission
        |--------------------------------------------------------------------------
        */

        elseif (
            $workLog->status
            === DailyWorkLog::STATUS_PENDING
        ) {
            $action =
                'work_log.resubmitted';

            $description =
                sprintf(
                    'Daily Work Log #%d resubmitted.',
                    $workLog->id
                );
        } else {
            return;
        }

        app(AuditLogService::class)
            ->record(
                $action,
                $workLog,
                $description,
                [
                    'work_log_id' =>
                        $workLog->id,

                    'attendance_record_id' =>
                        $workLog->attendance_record_id,

                    'status' =>
                        $workLog->status,

                    'validated_by' =>
                        $workLog->validated_by,
                ]
            );
    }
}