<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\DailyWorkLog;
use App\Models\OjtAssignment;
use App\Models\SupervisorEvaluation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;


class SupervisorDashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Business Timezone
    |--------------------------------------------------------------------------
    */

    private const BUSINESS_TIMEZONE =
        'Asia/Manila';


    /*
    |--------------------------------------------------------------------------
    | Supervisor Dashboard
    |--------------------------------------------------------------------------
    |
    | GET /api/mobile/supervisor/dashboard
    |
    */

    public function show(
        Request $request
    ): JsonResponse {
        $user =
            $request->user();


        /*
        |--------------------------------------------------------------------------
        | Authenticated User Required
        |--------------------------------------------------------------------------
        */

        if (
            ! $user instanceof User
        ) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'Unauthenticated.',
                ],
                401
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Supervisor Role Required
        |--------------------------------------------------------------------------
        */

        if (
            ! $user->isSupervisor()
        ) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'Supervisor access only.',
                ],
                403
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Active Account Required
        |--------------------------------------------------------------------------
        */

        if (
            ! $user->isActive()
            ||
            $user->isArchived()
        ) {
            $currentAccessToken =
                $user
                    ->currentAccessToken();


            if (
                $currentAccessToken
                instanceof PersonalAccessToken
            ) {
                $currentAccessToken
                    ->delete();
            }


            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'This account is currently unavailable.',
                ],
                403
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Assignment Base Query
        |--------------------------------------------------------------------------
        |
        | All dashboard records are restricted to assignments belonging to
        | the currently authenticated Supervisor.
        |
        */

        $assignmentsQuery =
            OjtAssignment::query()
                ->where(
                    'supervisor_id',
                    $user->id
                );


        /*
        |--------------------------------------------------------------------------
        | Assignment Summary
        |--------------------------------------------------------------------------
        */

        $assignedStudents =
            (clone $assignmentsQuery)
                ->whereIn(
                    'status',
                    OjtAssignment::OPEN_STATUSES
                )
                ->distinct()
                ->count(
                    'student_profile_id'
                );


        $activeAssignments =
            (clone $assignmentsQuery)
                ->where(
                    'status',
                    OjtAssignment::STATUS_ACTIVE
                )
                ->count();


        $pendingAssignments =
            (clone $assignmentsQuery)
                ->where(
                    'status',
                    OjtAssignment::STATUS_PENDING
                )
                ->count();


        $completedAssignments =
            (clone $assignmentsQuery)
                ->where(
                    'status',
                    OjtAssignment::STATUS_COMPLETED
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Pending Attendance
        |--------------------------------------------------------------------------
        */

        $pendingAttendance =
            AttendanceRecord::query()
                ->where(
                    'status',
                    AttendanceRecord::STATUS_PENDING
                )
                ->whereHas(
                    'ojtAssignment',
                    function ($query) use (
                        $user
                    ): void {
                        $query
                            ->where(
                                'supervisor_id',
                                $user->id
                            )
                            ->whereIn(
                                'status',
                                OjtAssignment::OPEN_STATUSES
                            );
                    }
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Pending Daily Work Logs
        |--------------------------------------------------------------------------
        */

        $pendingWorkLogs =
            DailyWorkLog::query()
                ->where(
                    'status',
                    DailyWorkLog::STATUS_PENDING
                )
                ->whereHas(
                    'attendanceRecord.ojtAssignment',
                    function ($query) use (
                        $user
                    ): void {
                        $query
                            ->where(
                                'supervisor_id',
                                $user->id
                            )
                            ->whereIn(
                                'status',
                                OjtAssignment::OPEN_STATUSES
                            );
                    }
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Submitted Evaluations
        |--------------------------------------------------------------------------
        */

        $submittedEvaluations =
            SupervisorEvaluation::query()
                ->whereHas(
                    'ojtAssignment',
                    function ($query) use (
                        $user
                    ): void {
                        $query->where(
                            'supervisor_id',
                            $user->id
                        );
                    }
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Pending Evaluations
        |--------------------------------------------------------------------------
        */

        $pendingEvaluations =
            (clone $assignmentsQuery)
                ->whereIn(
                    'status',
                    OjtAssignment::OPEN_STATUSES
                )
                ->whereDoesntHave(
                    'finalEvaluation'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Recent Assigned Students
        |--------------------------------------------------------------------------
        */

        $recentAssignments =
            OjtAssignment::query()
                ->with([
                    'studentProfile.user',

                    'company',
                ])
                ->withSum(
                    [
                        'attendanceRecords as validated_minutes' =>
                            function ($query): void {
                                $query->where(
                                    'status',
                                    AttendanceRecord::STATUS_VALIDATED
                                );
                            },
                    ],
                    'rendered_minutes'
                )
                ->where(
                    'supervisor_id',
                    $user->id
                )
                ->whereIn(
                    'status',
                    OjtAssignment::OPEN_STATUSES
                )
                ->latest(
                    'start_date'
                )
                ->latest(
                    'id'
                )
                ->limit(
                    5
                )
                ->get()
                ->map(
                    function (
                        OjtAssignment $assignment
                    ): array {
                        $profile =
                            $assignment
                                ->studentProfile;

                        $student =
                            $profile
                                ?->user;


                        $requiredHours =
                            max(
                                0,
                                (int) $assignment
                                    ->required_hours
                            );


                        $requiredMinutes =
                            $requiredHours
                            *
                            60;


                        $validatedMinutes =
                            max(
                                0,
                                (int) (
                                    $assignment
                                        ->validated_minutes
                                    ??
                                    0
                                )
                            );


                        $remainingMinutes =
                            max(
                                0,
                                $requiredMinutes
                                -
                                $validatedMinutes
                            );


                        $progress =
                            $requiredMinutes > 0
                                ? min(
                                    100,
                                    round(
                                        (
                                            $validatedMinutes
                                            /
                                            $requiredMinutes
                                        )
                                        *
                                        100,
                                        1
                                    )
                                )
                                : 0;


                        return [
                            'assignment_id' =>
                                $assignment->id,

                            'status' =>
                                $assignment->status,

                            'student' => [
                                'id' =>
                                    $student?->id,

                                'name' =>
                                    $student?->name,

                                'student_number' =>
                                    $profile
                                        ?->student_number,

                                'program' =>
                                    $profile
                                        ?->program,

                                'year_level' =>
                                    $profile
                                        ?->year_level,

                                'section' =>
                                    $profile
                                        ?->section,
                            ],

                            'company' => [
                                'id' =>
                                    $assignment
                                        ->company
                                        ?->id,

                                'name' =>
                                    $assignment
                                        ->company
                                        ?->name,
                            ],

                            'training' => [
                                'required_hours' =>
                                    $requiredHours,

                                'validated_minutes' =>
                                    $validatedMinutes,

                                'remaining_minutes' =>
                                    $remainingMinutes,

                                'progress_percentage' =>
                                    $progress,

                                'start_date' =>
                                    $assignment
                                        ->start_date
                                        ?->format(
                                            'Y-m-d'
                                        ),

                                'end_date' =>
                                    $assignment
                                        ->end_date
                                        ?->format(
                                            'Y-m-d'
                                        ),
                            ],
                        ];
                    }
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | Recent Pending Attendance
        |--------------------------------------------------------------------------
        */

        $recentPendingAttendance =
            AttendanceRecord::query()
                ->with([
                    'ojtAssignment.studentProfile.user',

                    'ojtAssignment.company',
                ])
                ->where(
                    'status',
                    AttendanceRecord::STATUS_PENDING
                )
                ->whereHas(
                    'ojtAssignment',
                    function ($query) use (
                        $user
                    ): void {
                        $query
                            ->where(
                                'supervisor_id',
                                $user->id
                            )
                            ->whereIn(
                                'status',
                                OjtAssignment::OPEN_STATUSES
                            );
                    }
                )
                ->latest(
                    'attendance_date'
                )
                ->latest(
                    'id'
                )
                ->limit(
                    5
                )
                ->get()
                ->map(
                    function (
                        AttendanceRecord $attendance
                    ): array {
                        $assignment =
                            $attendance
                                ->ojtAssignment;

                        $profile =
                            $assignment
                                ?->studentProfile;

                        $student =
                            $profile
                                ?->user;


                        return [
                            'id' =>
                                $attendance->id,

                            'attendance_date' =>
                                $attendance
                                    ->attendance_date
                                    ?->format(
                                        'Y-m-d'
                                    ),

                            'status' =>
                                $attendance->status,

                            'rendered_minutes' =>
                                max(
                                    0,
                                    (int) (
                                        $attendance
                                            ->rendered_minutes
                                        ??
                                        0
                                    )
                                ),

                            'student' => [
                                'id' =>
                                    $student?->id,

                                'name' =>
                                    $student?->name,

                                'student_number' =>
                                    $profile
                                        ?->student_number,
                            ],

                            'company' => [
                                'id' =>
                                    $assignment
                                        ?->company
                                        ?->id,

                                'name' =>
                                    $assignment
                                        ?->company
                                        ?->name,
                            ],
                        ];
                    }
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | Recent Pending Work Logs
        |--------------------------------------------------------------------------
        */

        $recentPendingWorkLogs =
            DailyWorkLog::query()
                ->with([
                    'attendanceRecord.ojtAssignment.studentProfile.user',

                    'attendanceRecord.ojtAssignment.company',
                ])
                ->where(
                    'status',
                    DailyWorkLog::STATUS_PENDING
                )
                ->whereHas(
                    'attendanceRecord.ojtAssignment',
                    function ($query) use (
                        $user
                    ): void {
                        $query
                            ->where(
                                'supervisor_id',
                                $user->id
                            )
                            ->whereIn(
                                'status',
                                OjtAssignment::OPEN_STATUSES
                            );
                    }
                )
                ->latest(
                    'submitted_at'
                )
                ->latest(
                    'id'
                )
                ->limit(
                    5
                )
                ->get()
                ->map(
                    function (
                        DailyWorkLog $workLog
                    ): array {
                        $attendance =
                            $workLog
                                ->attendanceRecord;

                        $assignment =
                            $attendance
                                ?->ojtAssignment;

                        $profile =
                            $assignment
                                ?->studentProfile;

                        $student =
                            $profile
                                ?->user;


                        return [
                            'id' =>
                                $workLog->id,

                            'attendance_record_id' =>
                                $attendance?->id,

                            'attendance_date' =>
                                $attendance
                                    ?->attendance_date
                                    ?->format(
                                        'Y-m-d'
                                    ),

                            'status' =>
                                $workLog->status,

                            'submitted_at' =>
                                $workLog
                                    ->submitted_at
                                    ?->setTimezone(
                                        self::BUSINESS_TIMEZONE
                                    )
                                    ->toIso8601String(),

                            'student' => [
                                'id' =>
                                    $student?->id,

                                'name' =>
                                    $student?->name,

                                'student_number' =>
                                    $profile
                                        ?->student_number,
                            ],

                            'company' => [
                                'id' =>
                                    $assignment
                                        ?->company
                                        ?->id,

                                'name' =>
                                    $assignment
                                        ?->company
                                        ?->name,
                            ],
                        ];
                    }
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' =>
                true,

            'server_time' =>
                now()
                    ->timezone(
                        self::BUSINESS_TIMEZONE
                    )
                    ->toIso8601String(),

            'supervisor' => [
                'id' =>
                    $user->id,

                'name' =>
                    $user->name,

                'email' =>
                    $user->email,

                'role' =>
                    $user->role,

                'status' =>
                    $user->status,
            ],

            'summary' => [
                'assigned_students' =>
                    $assignedStudents,

                'active_assignments' =>
                    $activeAssignments,

                'pending_assignments' =>
                    $pendingAssignments,

                'completed_assignments' =>
                    $completedAssignments,

                'pending_attendance' =>
                    $pendingAttendance,

                'pending_work_logs' =>
                    $pendingWorkLogs,

                'pending_evaluations' =>
                    $pendingEvaluations,

                'submitted_evaluations' =>
                    $submittedEvaluations,
            ],

            'recent_students' =>
                $recentAssignments,

            'recent_pending_attendance' =>
                $recentPendingAttendance,

            'recent_pending_work_logs' =>
                $recentPendingWorkLogs,
        ]);
    }
}