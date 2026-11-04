<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\DailyWorkLog;
use App\Models\OjtAssignment;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the Supervisor dashboard.
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
        |
        | Count unique Students with active/pending assignments
        | belonging to this Supervisor.
        |
        */

        $assignedStudents = OjtAssignment::query()
            ->where(
                'supervisor_id',
                $supervisor->id
            )
            ->whereIn(
                'status',
                OjtAssignment::OPEN_STATUSES
            )
            ->distinct()
            ->count(
                'student_profile_id'
            );

        /*
        |--------------------------------------------------------------------------
        | Pending Attendance Validations
        |--------------------------------------------------------------------------
        */

        $pendingValidations = AttendanceRecord::query()
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
                'status',
                AttendanceRecord::STATUS_PENDING
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
                'status',
                DailyWorkLog::STATUS_PENDING
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Validated Attendance
        |--------------------------------------------------------------------------
        */

        $validatedAttendance = AttendanceRecord::query()
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
                'status',
                AttendanceRecord::STATUS_VALIDATED
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
                'status',
                DailyWorkLog::STATUS_VALIDATED
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Total Validated OJT Minutes
        |--------------------------------------------------------------------------
        */

        $validatedMinutes = (int) AttendanceRecord::query()
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
                'status',
                AttendanceRecord::STATUS_VALIDATED
            )
            ->sum(
                'rendered_minutes'
            );

        $validatedHoursLabel =
            $this->formatMinutes(
                $validatedMinutes
            );

        /*
        |--------------------------------------------------------------------------
        | Recent Pending Attendance
        |--------------------------------------------------------------------------
        */

        $recentPendingAttendance = AttendanceRecord::query()
            ->with([
                'ojtAssignment.studentProfile.user',
                'ojtAssignment.company',
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
            ->where(
                'status',
                AttendanceRecord::STATUS_PENDING
            )
            ->latest('attendance_date')
            ->latest('id')
            ->limit(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Recent Pending Daily Work Logs
        |--------------------------------------------------------------------------
        */

        $recentPendingWorkLogs = DailyWorkLog::query()
            ->with([
                'attendanceRecord.ojtAssignment.studentProfile.user',
                'attendanceRecord.ojtAssignment.company',
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
            ->where(
                'status',
                DailyWorkLog::STATUS_PENDING
            )
            ->latest('submitted_at')
            ->limit(5)
            ->get();

        return view(
            'supervisor.dashboard',
            compact(
                'assignedStudents',
                'pendingValidations',
                'pendingWorkLogs',
                'validatedAttendance',
                'validatedWorkLogs',
                'validatedMinutes',
                'validatedHoursLabel',
                'recentPendingAttendance',
                'recentPendingWorkLogs'
            )
        );
    }

    /**
     * Convert minutes to a human-readable label.
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