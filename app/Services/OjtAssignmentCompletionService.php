<?php

namespace App\Services;

use App\Models\AttendanceRecord;
use App\Models\DailyWorkLog;
use App\Models\OjtAssignment;
use App\Models\SupervisorEvaluation;

class OjtAssignmentCompletionService
{
    /**
     * Build the official completion status
     * of an OJT Assignment.
     */
    public function summary(
        OjtAssignment $assignment
    ): array {
        /*
        |--------------------------------------------------------------------------
        | Required Time
        |--------------------------------------------------------------------------
        */

        $requiredMinutes =
            (int) $assignment->required_hours
            * 60;

        /*
        |--------------------------------------------------------------------------
        | Validated Attendance
        |--------------------------------------------------------------------------
        */

        $validatedMinutes =
            (int) $assignment
                ->attendanceRecords()
                ->where(
                    'attendance_records.status',
                    AttendanceRecord::STATUS_VALIDATED
                )
                ->sum(
                    'rendered_minutes'
                );

        $validatedAttendanceCount =
            $assignment
                ->attendanceRecords()
                ->where(
                    'attendance_records.status',
                    AttendanceRecord::STATUS_VALIDATED
                )
                ->count();

        /*
        |--------------------------------------------------------------------------
        | Attendance Requiring Resolution
        |--------------------------------------------------------------------------
        */

        $inProgressAttendanceCount =
            $assignment
                ->attendanceRecords()
                ->where(
                    'attendance_records.status',
                    AttendanceRecord::STATUS_IN_PROGRESS
                )
                ->count();

        $pendingAttendanceCount =
            $assignment
                ->attendanceRecords()
                ->where(
                    'attendance_records.status',
                    AttendanceRecord::STATUS_PENDING
                )
                ->count();

        $rejectedAttendanceCount =
            $assignment
                ->attendanceRecords()
                ->where(
                    'attendance_records.status',
                    AttendanceRecord::STATUS_REJECTED
                )
                ->count();

        /*
        |--------------------------------------------------------------------------
        | Daily Work Logs
        |--------------------------------------------------------------------------
        */

        $validatedAttendanceWithoutValidatedWorkLog =
            $assignment
                ->attendanceRecords()
                ->where(
                    'attendance_records.status',
                    AttendanceRecord::STATUS_VALIDATED
                )
                ->whereDoesntHave(
                    'dailyWorkLog',
                    function ($query): void {
                        $query->where(
                            'daily_work_logs.status',
                            DailyWorkLog::STATUS_VALIDATED
                        );
                    }
                )
                ->count();

        $pendingWorkLogs =
            $assignment
                ->dailyWorkLogs()
                ->where(
                    'daily_work_logs.status',
                    DailyWorkLog::STATUS_PENDING
                )
                ->count();

        $validatedWorkLogs =
            $assignment
                ->dailyWorkLogs()
                ->where(
                    'daily_work_logs.status',
                    DailyWorkLog::STATUS_VALIDATED
                )
                ->count();

        $rejectedWorkLogs =
            $assignment
                ->dailyWorkLogs()
                ->where(
                    'daily_work_logs.status',
                    DailyWorkLog::STATUS_REJECTED
                )
                ->count();

        /*
        |--------------------------------------------------------------------------
        | Remaining Time
        |--------------------------------------------------------------------------
        */

        $remainingMinutes = max(
            0,
            $requiredMinutes
            - $validatedMinutes
        );

        /*
        |--------------------------------------------------------------------------
        | Completion Percentage
        |--------------------------------------------------------------------------
        */

        $completionPercentage =
            $requiredMinutes > 0
                ? min(
                    100,
                    round(
                        (
                            $validatedMinutes
                            / $requiredMinutes
                        ) * 100
                    )
                )
                : 0;

        /*
        |--------------------------------------------------------------------------
        | Operational Requirements
        |--------------------------------------------------------------------------
        |
        | These must be resolved BEFORE the Supervisor can submit
        | the Final Evaluation.
        |
        */

        $evaluationBlockers = [];

        if (
            $assignment->status
            === OjtAssignment::STATUS_COMPLETED
        ) {
            $evaluationBlockers[] =
                'This OJT Assignment has already been completed.';
        }

        if (
            $assignment->status
            === OjtAssignment::STATUS_CANCELLED
        ) {
            $evaluationBlockers[] =
                'A cancelled OJT Assignment cannot be evaluated for completion.';
        }

        if (
            $assignment->status
            === OjtAssignment::STATUS_PENDING
        ) {
            $evaluationBlockers[] =
                'The OJT Assignment must be Active before final evaluation.';
        }

        if (
            $validatedMinutes
            < $requiredMinutes
        ) {
            $evaluationBlockers[] =
                'The Student has not yet reached the required validated OJT hours.';
        }

        if (
            $inProgressAttendanceCount > 0
        ) {
            $evaluationBlockers[] =
                $inProgressAttendanceCount
                . ' attendance record(s) are still in progress.';
        }

        if (
            $pendingAttendanceCount > 0
        ) {
            $evaluationBlockers[] =
                $pendingAttendanceCount
                . ' attendance record(s) are still waiting for Supervisor validation.';
        }

        if (
            $pendingWorkLogs > 0
        ) {
            $evaluationBlockers[] =
                $pendingWorkLogs
                . ' Daily Work Log(s) are still waiting for Supervisor validation.';
        }

        if (
            $validatedAttendanceWithoutValidatedWorkLog
            > 0
        ) {
            $evaluationBlockers[] =
                $validatedAttendanceWithoutValidatedWorkLog
                . ' validated attendance record(s) do not yet have a validated Daily Work Log.';
        }

        /*
        |--------------------------------------------------------------------------
        | Evaluation Ready
        |--------------------------------------------------------------------------
        */

        $evaluationReady =
            $assignment->status
                === OjtAssignment::STATUS_ACTIVE
            && count(
                $evaluationBlockers
            ) === 0;

        /*
        |--------------------------------------------------------------------------
        | Final Evaluation
        |--------------------------------------------------------------------------
        */

        $evaluation =
            $assignment
                ->finalEvaluation()
                ->with('evaluator')
                ->first();

        /*
        |--------------------------------------------------------------------------
        | Formal Completion Blockers
        |--------------------------------------------------------------------------
        */

        $blockers =
            $evaluationBlockers;

        /*
        |--------------------------------------------------------------------------
        | Only Apply New Evaluation Requirement To Active Assignments
        |--------------------------------------------------------------------------
        |
        | Existing assignments already completed in earlier phases
        | remain valid and are not retroactively broken.
        |
        */

        if (
            $assignment->status
            === OjtAssignment::STATUS_ACTIVE
            && count($evaluationBlockers) === 0
        ) {
            if (! $evaluation) {
                $blockers[] =
                    'The Final Supervisor Evaluation has not yet been submitted.';
            } elseif (
                $evaluation->recommendation
                !== SupervisorEvaluation::RECOMMENDATION_RECOMMENDED
            ) {
                $blockers[] =
                    'The Supervisor has not recommended this Student for formal OJT completion.';
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Ready For Admin Completion
        |--------------------------------------------------------------------------
        */

        $eligible =
            $assignment->status
                === OjtAssignment::STATUS_ACTIVE
            && count($blockers) === 0;

        return [
            'requiredMinutes' =>
                $requiredMinutes,

            'validatedMinutes' =>
                $validatedMinutes,

            'remainingMinutes' =>
                $remainingMinutes,

            'requiredHoursLabel' =>
                $this->formatMinutes(
                    $requiredMinutes
                ),

            'validatedHoursLabel' =>
                $this->formatMinutes(
                    $validatedMinutes
                ),

            'remainingHoursLabel' =>
                $this->formatMinutes(
                    $remainingMinutes
                ),

            'completionPercentage' =>
                $completionPercentage,

            'validatedAttendanceCount' =>
                $validatedAttendanceCount,

            'inProgressAttendanceCount' =>
                $inProgressAttendanceCount,

            'pendingAttendanceCount' =>
                $pendingAttendanceCount,

            'rejectedAttendanceCount' =>
                $rejectedAttendanceCount,

            'validatedWorkLogs' =>
                $validatedWorkLogs,

            'pendingWorkLogs' =>
                $pendingWorkLogs,

            'rejectedWorkLogs' =>
                $rejectedWorkLogs,

            'missingValidatedWorkLogs' =>
                $validatedAttendanceWithoutValidatedWorkLog,

            /*
            |--------------------------------------------------------------------------
            | Evaluation
            |--------------------------------------------------------------------------
            */

            'evaluationReady' =>
                $evaluationReady,

            'evaluationBlockers' =>
                $evaluationBlockers,

            'evaluationSubmitted' =>
                $evaluation !== null,

            'evaluation' =>
                $evaluation,

            /*
            |--------------------------------------------------------------------------
            | Completion
            |--------------------------------------------------------------------------
            */

            'eligible' =>
                $eligible,

            'blockers' =>
                $blockers,
        ];
    }

    /**
     * Convert minutes to readable hours.
     */
    private function formatMinutes(
        int $minutes
    ): string {
        $hours =
            intdiv(
                $minutes,
                60
            );

        $remainingMinutes =
            $minutes % 60;

        return sprintf(
            '%dh %02dm',
            $hours,
            $remainingMinutes
        );
    }
}