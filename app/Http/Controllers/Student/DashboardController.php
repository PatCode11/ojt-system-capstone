<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\OjtAssignment;
use App\Models\User;
use App\Services\StudentAssignmentService;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Philippine business timezone.
     */
    private const BUSINESS_TIMEZONE = 'Asia/Manila';

    /**
     * Display Student dashboard.
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

        $validatedMinutes = 0;

        $remainingMinutes = 0;

        $todayAttendance = null;

        /*
        |--------------------------------------------------------------------------
        | Current / Historical Assignment
        |--------------------------------------------------------------------------
        */

        if ($profile) {
            $assignment =
                $assignmentService
                    ->displayAssignment(
                        $profile
                    );
        }

        /*
        |--------------------------------------------------------------------------
        | Assignment Statistics
        |--------------------------------------------------------------------------
        */

        if ($assignment) {
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

            $requiredMinutes =
                $assignment->required_hours
                * 60;

            $remainingMinutes = max(
                0,
                $requiredMinutes
                - $validatedMinutes
            );

            $today =
                CarbonImmutable::now(
                    self::BUSINESS_TIMEZONE
                )->toDateString();

            $todayAttendance =
                AttendanceRecord::query()
                    ->where(
                        'ojt_assignment_id',
                        $assignment->id
                    )
                    ->where(
                        'attendance_date',
                        $today
                    )
                    ->first();
        }

        $validatedHoursLabel =
            $this->formatMinutes(
                $validatedMinutes
            );

        $remainingHoursLabel =
            $this->formatMinutes(
                $remainingMinutes
            );

        /*
        |--------------------------------------------------------------------------
        | Completed Assignment Status
        |--------------------------------------------------------------------------
        */

        $assignmentCompleted =
            $assignment
            && $assignment->status
                === OjtAssignment::STATUS_COMPLETED;

        $todayAttendanceLabel =
            $assignmentCompleted
                ? 'OJT Completed'
                : $this->attendanceStatusLabel(
                    $todayAttendance
                );

        return view(
            'student.dashboard',
            compact(
                'profile',
                'assignment',
                'assignmentCompleted',
                'validatedMinutes',
                'validatedHoursLabel',
                'remainingMinutes',
                'remainingHoursLabel',
                'todayAttendance',
                'todayAttendanceLabel'
            )
        );
    }

    /**
     * Convert minutes into readable hours.
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

    /**
     * Readable today's attendance status.
     */
    private function attendanceStatusLabel(
        ?AttendanceRecord $attendance
    ): string {
        if (! $attendance) {
            return 'Not Yet';
        }

        if (
            $attendance->time_in
            && ! $attendance->time_out
        ) {
            return 'Timed In';
        }

        return match ($attendance->status) {
            AttendanceRecord::STATUS_PENDING =>
                'Pending',

            AttendanceRecord::STATUS_VALIDATED =>
                'Validated',

            AttendanceRecord::STATUS_REJECTED =>
                'Rejected',

            default =>
                'In Progress',
        };
    }
}