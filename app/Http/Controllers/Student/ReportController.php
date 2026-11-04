<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\DailyWorkLog;
use App\Models\OjtAssignment;
use App\Models\StudentProfile;
use App\Models\User;
use App\Services\StudentAssignmentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display Student OJT report.
     */
    public function index(
        Request $request,
        StudentAssignmentService $assignmentService
    ): View {
        $user = $request->user();

        if (
            ! $user instanceof User
            || ! $user->isStudent()
        ) {
            abort(403);
        }

        $profile =
            $user->studentProfile;

        $assignment = null;

        $requiredHours = 0;

        $validatedMinutes = 0;

        $remainingMinutes = 0;

        $completionPercentage = 0;

        $validatedAttendance = 0;
        $pendingAttendance = 0;
        $rejectedAttendance = 0;

        $validatedWorkLogs = 0;
        $pendingWorkLogs = 0;
        $rejectedWorkLogs = 0;

        $attendanceRecords =
            AttendanceRecord::query()
                ->whereRaw('1 = 0')
                ->paginate(
                    10,
                    ['*'],
                    'attendance_page'
                );

        $workLogs =
            DailyWorkLog::query()
                ->whereRaw('1 = 0')
                ->paginate(
                    10,
                    ['*'],
                    'work_log_page'
                );

        /*
        |--------------------------------------------------------------------------
        | Selected / Current / Historical Assignment
        |--------------------------------------------------------------------------
        */

        if ($profile instanceof StudentProfile) {
            $requestedAssignmentId =
                $request->integer(
                    'assignment'
                ) ?: null;

            $assignment =
                $assignmentService
                    ->displayAssignment(
                        $profile,
                        $requestedAssignmentId
                    );

            if (
                $requestedAssignmentId !== null
                && ! $assignment
            ) {
                abort(404);
            }
        }

        if ($assignment) {
            $requiredHours =
                (int) $assignment->required_hours;

            $validatedAttendance =
                AttendanceRecord::query()
                    ->where(
                        'ojt_assignment_id',
                        $assignment->id
                    )
                    ->where(
                        'status',
                        AttendanceRecord::STATUS_VALIDATED
                    )
                    ->count();

            $pendingAttendance =
                AttendanceRecord::query()
                    ->where(
                        'ojt_assignment_id',
                        $assignment->id
                    )
                    ->where(
                        'status',
                        AttendanceRecord::STATUS_PENDING
                    )
                    ->count();

            $rejectedAttendance =
                AttendanceRecord::query()
                    ->where(
                        'ojt_assignment_id',
                        $assignment->id
                    )
                    ->where(
                        'status',
                        AttendanceRecord::STATUS_REJECTED
                    )
                    ->count();

            $validatedMinutes =
                (int) AttendanceRecord::query()
                    ->where(
                        'ojt_assignment_id',
                        $assignment->id
                    )
                    ->where(
                        'status',
                        AttendanceRecord::STATUS_VALIDATED
                    )
                    ->sum(
                        'rendered_minutes'
                    );

            /*
            |--------------------------------------------------------------------------
            | Daily Work Logs
            |--------------------------------------------------------------------------
            */

            $validatedWorkLogs =
                DailyWorkLog::query()
                    ->whereHas(
                        'attendanceRecord',
                        function ($query) use ($assignment): void {
                            $query->where(
                                'ojt_assignment_id',
                                $assignment->id
                            );
                        }
                    )
                    ->where(
                        'status',
                        DailyWorkLog::STATUS_VALIDATED
                    )
                    ->count();

            $pendingWorkLogs =
                DailyWorkLog::query()
                    ->whereHas(
                        'attendanceRecord',
                        function ($query) use ($assignment): void {
                            $query->where(
                                'ojt_assignment_id',
                                $assignment->id
                            );
                        }
                    )
                    ->where(
                        'status',
                        DailyWorkLog::STATUS_PENDING
                    )
                    ->count();

            $rejectedWorkLogs =
                DailyWorkLog::query()
                    ->whereHas(
                        'attendanceRecord',
                        function ($query) use ($assignment): void {
                            $query->where(
                                'ojt_assignment_id',
                                $assignment->id
                            );
                        }
                    )
                    ->where(
                        'status',
                        DailyWorkLog::STATUS_REJECTED
                    )
                    ->count();

            /*
            |--------------------------------------------------------------------------
            | Progress
            |--------------------------------------------------------------------------
            */

            $requiredMinutes =
                $requiredHours
                * 60;

            $remainingMinutes = max(
                0,
                $requiredMinutes
                - $validatedMinutes
            );

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
            | Histories
            |--------------------------------------------------------------------------
            */

            $attendanceRecords =
                AttendanceRecord::query()
                    ->where(
                        'ojt_assignment_id',
                        $assignment->id
                    )
                    ->latest('attendance_date')
                    ->paginate(
                        10,
                        ['*'],
                        'attendance_page'
                    )
                    ->withQueryString();

            $workLogs =
                DailyWorkLog::query()
                    ->with([
                        'attendanceRecord',
                    ])
                    ->whereHas(
                        'attendanceRecord',
                        function ($query) use ($assignment): void {
                            $query->where(
                                'ojt_assignment_id',
                                $assignment->id
                            );
                        }
                    )
                    ->latest('submitted_at')
                    ->paginate(
                        10,
                        ['*'],
                        'work_log_page'
                    )
                    ->withQueryString();
        }

        $validatedHoursLabel =
            $this->formatMinutes(
                $validatedMinutes
            );

        $remainingHoursLabel =
            $this->formatMinutes(
                $remainingMinutes
            );

        $assignmentCompleted =
            $assignment
            && $assignment->status
                === OjtAssignment::STATUS_COMPLETED;

        return view(
            'student.reports.index',
            compact(
                'profile',
                'assignment',
                'assignmentCompleted',
                'requiredHours',
                'validatedMinutes',
                'validatedHoursLabel',
                'remainingMinutes',
                'remainingHoursLabel',
                'completionPercentage',
                'validatedAttendance',
                'pendingAttendance',
                'rejectedAttendance',
                'validatedWorkLogs',
                'pendingWorkLogs',
                'rejectedWorkLogs',
                'attendanceRecords',
                'workLogs'
            )
        );
    }

    /**
     * Convert minutes to readable time.
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