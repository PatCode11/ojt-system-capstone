<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\OjtAssignment;
use App\Models\StudentProfile;
use App\Models\User;
use App\Services\StudentAssignmentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    /**
     * Display Student timesheet.
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

        $pendingRecords = 0;

        $validatedRecords = 0;

        $rejectedRecords = 0;

        $records =
            AttendanceRecord::query()
                ->whereRaw('1 = 0')
                ->paginate(15);

        /*
        |--------------------------------------------------------------------------
        | Selected / Current / Completed Assignment
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

            /*
            |--------------------------------------------------------------------------
            | Invalid / Unauthorized Assignment
            |--------------------------------------------------------------------------
            */

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

            $records =
                AttendanceRecord::query()
                    ->where(
                        'ojt_assignment_id',
                        $assignment->id
                    )
                    ->latest('attendance_date')
                    ->latest('id')
                    ->paginate(15)
                    ->withQueryString();

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

            $pendingRecords =
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

            $validatedRecords =
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

            $rejectedRecords =
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

            $requiredMinutes =
                $requiredHours
                * 60;

            $remainingMinutes = max(
                0,
                $requiredMinutes
                - $validatedMinutes
            );
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
            'student.timesheets.index',
            compact(
                'profile',
                'assignment',
                'assignmentCompleted',
                'records',
                'requiredHours',
                'validatedMinutes',
                'validatedHoursLabel',
                'remainingMinutes',
                'remainingHoursLabel',
                'pendingRecords',
                'validatedRecords',
                'rejectedRecords'
            )
        );
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