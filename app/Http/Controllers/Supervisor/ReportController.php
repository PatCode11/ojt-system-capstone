<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\DailyWorkLog;
use App\Models\OjtAssignment;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display Supervisor reports.
     */
    public function index(
        Request $request
    ): View {
        $supervisor = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Require Supervisor Account
        |--------------------------------------------------------------------------
        */

        if (
            ! $supervisor instanceof User
            || ! $supervisor->isSupervisor()
        ) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | Assigned Students
        |--------------------------------------------------------------------------
        */

        $assignedStudents = OjtAssignment::query()
            ->where(
                'supervisor_id',
                $supervisor->id
            )
            ->distinct()
            ->count(
                'student_profile_id'
            );

        /*
        |--------------------------------------------------------------------------
        | Validated Attendance
        |--------------------------------------------------------------------------
        */

        $validatedRecords = AttendanceRecord::query()
            ->whereHas(
                'ojtAssignment',
                function ($query) use ($supervisor): void {
                    $query->where(
                        'supervisor_id',
                        $supervisor->id
                    );
                }
            )
            ->where(
                'attendance_records.status',
                AttendanceRecord::STATUS_VALIDATED
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Pending Attendance
        |--------------------------------------------------------------------------
        */

        $pendingRecords = AttendanceRecord::query()
            ->whereHas(
                'ojtAssignment',
                function ($query) use ($supervisor): void {
                    $query->where(
                        'supervisor_id',
                        $supervisor->id
                    );
                }
            )
            ->where(
                'attendance_records.status',
                AttendanceRecord::STATUS_PENDING
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Rejected Attendance
        |--------------------------------------------------------------------------
        */

        $rejectedRecords = AttendanceRecord::query()
            ->whereHas(
                'ojtAssignment',
                function ($query) use ($supervisor): void {
                    $query->where(
                        'supervisor_id',
                        $supervisor->id
                    );
                }
            )
            ->where(
                'attendance_records.status',
                AttendanceRecord::STATUS_REJECTED
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Validated Daily Work Logs
        |--------------------------------------------------------------------------
        */

        $validatedWorkLogs = DailyWorkLog::query()
            ->whereHas(
                'attendanceRecord.ojtAssignment',
                function ($query) use ($supervisor): void {
                    $query->where(
                        'supervisor_id',
                        $supervisor->id
                    );
                }
            )
            ->where(
                'daily_work_logs.status',
                DailyWorkLog::STATUS_VALIDATED
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Pending Daily Work Logs
        |--------------------------------------------------------------------------
        */

        $pendingWorkLogs = DailyWorkLog::query()
            ->whereHas(
                'attendanceRecord.ojtAssignment',
                function ($query) use ($supervisor): void {
                    $query->where(
                        'supervisor_id',
                        $supervisor->id
                    );
                }
            )
            ->where(
                'daily_work_logs.status',
                DailyWorkLog::STATUS_PENDING
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Rejected Daily Work Logs
        |--------------------------------------------------------------------------
        */

        $rejectedWorkLogs = DailyWorkLog::query()
            ->whereHas(
                'attendanceRecord.ojtAssignment',
                function ($query) use ($supervisor): void {
                    $query->where(
                        'supervisor_id',
                        $supervisor->id
                    );
                }
            )
            ->where(
                'daily_work_logs.status',
                DailyWorkLog::STATUS_REJECTED
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Total Validated OJT Minutes
        |--------------------------------------------------------------------------
        */

        $totalValidatedMinutes = (int) AttendanceRecord::query()
            ->whereHas(
                'ojtAssignment',
                function ($query) use ($supervisor): void {
                    $query->where(
                        'supervisor_id',
                        $supervisor->id
                    );
                }
            )
            ->where(
                'attendance_records.status',
                AttendanceRecord::STATUS_VALIDATED
            )
            ->sum(
                'rendered_minutes'
            );

        /*
        |--------------------------------------------------------------------------
        | Total Validated Hours Label
        |--------------------------------------------------------------------------
        */

        $totalValidatedHoursLabel =
            $this->formatMinutes(
                $totalValidatedMinutes
            );

        /*
        |--------------------------------------------------------------------------
        | Student Assignment Progress
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | dailyWorkLogs is a HasManyThrough relationship:
        |
        | ojt_assignments
        |       ↓
        | attendance_records
        |       ↓
        | daily_work_logs
        |
        | Both attendance_records and daily_work_logs contain a "status"
        | column, so we MUST qualify the table name in these subqueries.
        |
        */

        $assignments = OjtAssignment::query()
            ->with([
                'studentProfile.user',
                'company',
            ])

            /*
            |--------------------------------------------------------------------------
            | Attendance Counts
            |--------------------------------------------------------------------------
            */

            ->withCount([
                'attendanceRecords as validated_records_count' =>
                    function ($query): void {
                        $query->where(
                            'attendance_records.status',
                            AttendanceRecord::STATUS_VALIDATED
                        );
                    },

                'attendanceRecords as pending_records_count' =>
                    function ($query): void {
                        $query->where(
                            'attendance_records.status',
                            AttendanceRecord::STATUS_PENDING
                        );
                    },

                /*
                |--------------------------------------------------------------------------
                | Daily Work Log Counts
                |--------------------------------------------------------------------------
                */

                'dailyWorkLogs as validated_work_logs_count' =>
                    function ($query): void {
                        $query->where(
                            'daily_work_logs.status',
                            DailyWorkLog::STATUS_VALIDATED
                        );
                    },

                'dailyWorkLogs as pending_work_logs_count' =>
                    function ($query): void {
                        $query->where(
                            'daily_work_logs.status',
                            DailyWorkLog::STATUS_PENDING
                        );
                    },
            ])

            /*
            |--------------------------------------------------------------------------
            | Validated Attendance Minutes
            |--------------------------------------------------------------------------
            */

            ->withSum(
                [
                    'attendanceRecords as validated_minutes_sum' =>
                        function ($query): void {
                            $query->where(
                                'attendance_records.status',
                                AttendanceRecord::STATUS_VALIDATED
                            );
                        },
                ],
                'rendered_minutes'
            )

            /*
            |--------------------------------------------------------------------------
            | Only Assignments Belonging To This Supervisor
            |--------------------------------------------------------------------------
            */

            ->where(
                'supervisor_id',
                $supervisor->id
            )
            ->latest(
                'start_date'
            )
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Attendance History
        |--------------------------------------------------------------------------
        */

        $recentRecords = AttendanceRecord::query()
            ->with([
                'ojtAssignment.studentProfile.user',
                'ojtAssignment.company',
                'validator',
            ])
            ->whereHas(
                'ojtAssignment',
                function ($query) use ($supervisor): void {
                    $query->where(
                        'supervisor_id',
                        $supervisor->id
                    );
                }
            )
            ->latest(
                'attendance_date'
            )
            ->latest(
                'id'
            )
            ->paginate(
                10,
                ['*'],
                'attendance_page'
            );

        /*
        |--------------------------------------------------------------------------
        | Daily Work Log History
        |--------------------------------------------------------------------------
        */

        $recentWorkLogs = DailyWorkLog::query()
            ->with([
                'attendanceRecord.ojtAssignment.studentProfile.user',
                'attendanceRecord.ojtAssignment.company',
                'validator',
            ])
            ->whereHas(
                'attendanceRecord.ojtAssignment',
                function ($query) use ($supervisor): void {
                    $query->where(
                        'supervisor_id',
                        $supervisor->id
                    );
                }
            )
            ->latest(
                'submitted_at'
            )
            ->paginate(
                10,
                ['*'],
                'work_log_page'
            );

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'supervisor.reports.index',
            compact(
                'assignedStudents',
                'validatedRecords',
                'pendingRecords',
                'rejectedRecords',
                'validatedWorkLogs',
                'pendingWorkLogs',
                'rejectedWorkLogs',
                'totalValidatedMinutes',
                'totalValidatedHoursLabel',
                'assignments',
                'recentRecords',
                'recentWorkLogs'
            )
        );
    }

    /**
     * Convert minutes into hours and minutes.
     */
    private function formatMinutes(
        int $minutes
    ): string {
        $hours = intdiv(
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