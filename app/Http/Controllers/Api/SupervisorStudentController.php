<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\DailyWorkLog;
use App\Models\OjtAssignment;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;


class SupervisorStudentController extends Controller
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
    | Assigned Students
    |--------------------------------------------------------------------------
    |
    | GET /api/mobile/supervisor/students
    |
    | Each item represents one OJT Assignment.
    |
    */

    public function index(
        Request $request
    ): JsonResponse {
        $supervisor =
            $this->authenticatedSupervisor(
                $request
            );


        if (
            $supervisor
            instanceof JsonResponse
        ) {
            return $supervisor;
        }


        /*
        |--------------------------------------------------------------------------
        | Supervisor-Scoped Assignments
        |--------------------------------------------------------------------------
        */

        $assignments =
            OjtAssignment::query()
                ->with([
                    'studentProfile.user',
                    'company',
                    'finalEvaluation',
                ])

                ->withCount([
                    'attendanceRecords as total_attendance_count',

                    'attendanceRecords as in_progress_attendance_count' =>
                        function ($query): void {
                            $query->where(
                                'status',
                                AttendanceRecord::STATUS_IN_PROGRESS
                            );
                        },

                    'attendanceRecords as pending_attendance_count' =>
                        function ($query): void {
                            $query->where(
                                'status',
                                AttendanceRecord::STATUS_PENDING
                            );
                        },

                    'attendanceRecords as validated_attendance_count' =>
                        function ($query): void {
                            $query->where(
                                'status',
                                AttendanceRecord::STATUS_VALIDATED
                            );
                        },

                    'attendanceRecords as rejected_attendance_count' =>
                        function ($query): void {
                            $query->where(
                                'status',
                                AttendanceRecord::STATUS_REJECTED
                            );
                        },

                    'dailyWorkLogs as total_work_logs_count',

                    'dailyWorkLogs as pending_work_logs_count' =>
                        function ($query): void {
                            $query->where(
                                'daily_work_logs.status',
                                DailyWorkLog::STATUS_PENDING
                            );
                        },

                    'dailyWorkLogs as validated_work_logs_count' =>
                        function ($query): void {
                            $query->where(
                                'daily_work_logs.status',
                                DailyWorkLog::STATUS_VALIDATED
                            );
                        },

                    'dailyWorkLogs as rejected_work_logs_count' =>
                        function ($query): void {
                            $query->where(
                                'daily_work_logs.status',
                                DailyWorkLog::STATUS_REJECTED
                            );
                        },
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
                    $supervisor->id
                )

                ->latest(
                    'start_date'
                )

                ->latest(
                    'id'
                )

                ->get();


        /*
        |--------------------------------------------------------------------------
        | Sort Important Assignments First
        |--------------------------------------------------------------------------
        |
        | active
        | pending
        | completed
        | cancelled
        |
        */

        $assignments =
            $assignments
                ->sortBy(
                    function (
                        OjtAssignment $assignment
                    ): int {
                        return match (
                            $assignment->status
                        ) {
                            OjtAssignment::STATUS_ACTIVE =>
                                1,

                            OjtAssignment::STATUS_PENDING =>
                                2,

                            OjtAssignment::STATUS_COMPLETED =>
                                3,

                            OjtAssignment::STATUS_CANCELLED =>
                                4,

                            default =>
                                5,
                        };
                    }
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        $uniqueStudentCount =
            $assignments
                ->pluck(
                    'student_profile_id'
                )
                ->filter()
                ->unique()
                ->count();


        $activeCount =
            $assignments
                ->where(
                    'status',
                    OjtAssignment::STATUS_ACTIVE
                )
                ->count();


        $pendingCount =
            $assignments
                ->where(
                    'status',
                    OjtAssignment::STATUS_PENDING
                )
                ->count();


        $completedCount =
            $assignments
                ->where(
                    'status',
                    OjtAssignment::STATUS_COMPLETED
                )
                ->count();


        $cancelledCount =
            $assignments
                ->where(
                    'status',
                    OjtAssignment::STATUS_CANCELLED
                )
                ->count();


        $pendingAttendance =
            $assignments
                ->sum(
                    fn (
                        OjtAssignment $assignment
                    ): int =>
                        (int) (
                            $assignment
                                ->pending_attendance_count
                            ?? 0
                        )
                );


        $pendingWorkLogs =
            $assignments
                ->sum(
                    fn (
                        OjtAssignment $assignment
                    ): int =>
                        (int) (
                            $assignment
                                ->pending_work_logs_count
                            ?? 0
                        )
                );


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

            'summary' => [
                'assigned_students' =>
                    $uniqueStudentCount,

                'assignments' =>
                    $assignments->count(),

                'active' =>
                    $activeCount,

                'pending' =>
                    $pendingCount,

                'completed' =>
                    $completedCount,

                'cancelled' =>
                    $cancelledCount,

                'pending_attendance' =>
                    $pendingAttendance,

                'pending_work_logs' =>
                    $pendingWorkLogs,
            ],

            'students' =>
                $assignments
                    ->map(
                        fn (
                            OjtAssignment $assignment
                        ): array =>
                            $this->assignmentPayload(
                                $assignment
                            )
                    )
                    ->values(),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Student Monitoring Detail
    |--------------------------------------------------------------------------
    |
    | GET /api/mobile/supervisor/students/{assignment}
    |
    */

    public function show(
        Request $request,
        OjtAssignment $assignment
    ): JsonResponse {
        $supervisor =
            $this->authenticatedSupervisor(
                $request
            );


        if (
            $supervisor
            instanceof JsonResponse
        ) {
            return $supervisor;
        }


        /*
        |--------------------------------------------------------------------------
        | Ownership Protection
        |--------------------------------------------------------------------------
        */

        if (
            (int) $assignment
                ->supervisor_id
            !==
            (int) $supervisor->id
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'You are not authorized to monitor this Student assignment.',
                ],
                403
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Main Assignment Information
        |--------------------------------------------------------------------------
        */

        $assignment->load([
            'studentProfile.user',
            'company',
            'finalEvaluation',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Attendance Summary
        |--------------------------------------------------------------------------
        */

        $attendanceBase =
            AttendanceRecord::query()
                ->where(
                    'ojt_assignment_id',
                    $assignment->id
                );


        $totalAttendance =
            (clone $attendanceBase)
                ->count();


        $inProgressAttendance =
            (clone $attendanceBase)
                ->where(
                    'status',
                    AttendanceRecord::STATUS_IN_PROGRESS
                )
                ->count();


        $pendingAttendance =
            (clone $attendanceBase)
                ->where(
                    'status',
                    AttendanceRecord::STATUS_PENDING
                )
                ->count();


        $validatedAttendance =
            (clone $attendanceBase)
                ->where(
                    'status',
                    AttendanceRecord::STATUS_VALIDATED
                )
                ->count();


        $rejectedAttendance =
            (clone $attendanceBase)
                ->where(
                    'status',
                    AttendanceRecord::STATUS_REJECTED
                )
                ->count();


        $validatedMinutes =
            (int) (
                (clone $attendanceBase)
                    ->where(
                        'status',
                        AttendanceRecord::STATUS_VALIDATED
                    )
                    ->sum(
                        'rendered_minutes'
                    )
                ?? 0
            );


        /*
        |--------------------------------------------------------------------------
        | Daily Work Log Summary
        |--------------------------------------------------------------------------
        */

        $workLogBase =
            DailyWorkLog::query()
                ->whereHas(
                    'attendanceRecord',
                    function ($query) use (
                        $assignment
                    ): void {
                        $query->where(
                            'ojt_assignment_id',
                            $assignment->id
                        );
                    }
                );


        $totalWorkLogs =
            (clone $workLogBase)
                ->count();


        $pendingWorkLogs =
            (clone $workLogBase)
                ->where(
                    'status',
                    DailyWorkLog::STATUS_PENDING
                )
                ->count();


        $validatedWorkLogs =
            (clone $workLogBase)
                ->where(
                    'status',
                    DailyWorkLog::STATUS_VALIDATED
                )
                ->count();


        $rejectedWorkLogs =
            (clone $workLogBase)
                ->where(
                    'status',
                    DailyWorkLog::STATUS_REJECTED
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Recent Attendance
        |--------------------------------------------------------------------------
        */

        $recentAttendance =
            AttendanceRecord::query()
                ->with(
                    'validator'
                )
                ->where(
                    'ojt_assignment_id',
                    $assignment->id
                )
                ->latest(
                    'attendance_date'
                )
                ->latest(
                    'id'
                )
                ->limit(
                    10
                )
                ->get()
                ->map(
                    function (
                        AttendanceRecord $attendance
                    ): array {
                        return [
                            'id' =>
                                $attendance->id,

                            'attendance_date' =>
                                $attendance
                                    ->attendance_date
                                    ?->format(
                                        'Y-m-d'
                                    ),

                            'time_in' =>
                                $attendance
                                    ->time_in
                                    ?->setTimezone(
                                        self::BUSINESS_TIMEZONE
                                    )
                                    ->toIso8601String(),

                            'time_out' =>
                                $attendance
                                    ->time_out
                                    ?->setTimezone(
                                        self::BUSINESS_TIMEZONE
                                    )
                                    ->toIso8601String(),

                            'rendered_minutes' =>
                                $attendance
                                    ->rendered_minutes,

                            'rendered_hours_label' =>
                                $attendance
                                    ->renderedHoursLabel(),

                            'status' =>
                                $attendance
                                    ->status,

                            'supervisor_remarks' =>
                                $attendance
                                    ->supervisor_remarks,

                            'validated_at' =>
                                $attendance
                                    ->validated_at
                                    ?->setTimezone(
                                        self::BUSINESS_TIMEZONE
                                    )
                                    ->toIso8601String(),
                        ];
                    }
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | Recent Daily Work Logs
        |--------------------------------------------------------------------------
        */

        $recentWorkLogs =
            DailyWorkLog::query()
                ->with([
                    'attendanceRecord',
                    'validator',
                ])
                ->whereHas(
                    'attendanceRecord',
                    function ($query) use (
                        $assignment
                    ): void {
                        $query->where(
                            'ojt_assignment_id',
                            $assignment->id
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
                    10
                )
                ->get()
                ->map(
                    function (
                        DailyWorkLog $workLog
                    ): array {
                        return [
                            'id' =>
                                $workLog->id,

                            'attendance_date' =>
                                $workLog
                                    ->attendanceRecord
                                    ?->attendance_date
                                    ?->format(
                                        'Y-m-d'
                                    ),

                            'tasks_accomplished' =>
                                $workLog
                                    ->tasks_accomplished,

                            'status' =>
                                $workLog
                                    ->status,

                            'submitted_at' =>
                                $workLog
                                    ->submitted_at
                                    ?->setTimezone(
                                        self::BUSINESS_TIMEZONE
                                    )
                                    ->toIso8601String(),

                            'supervisor_remarks' =>
                                $workLog
                                    ->supervisor_remarks,

                            'validated_at' =>
                                $workLog
                                    ->validated_at
                                    ?->setTimezone(
                                        self::BUSINESS_TIMEZONE
                                    )
                                    ->toIso8601String(),
                        ];
                    }
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | Main Payload
        |--------------------------------------------------------------------------
        */

        $payload =
            $this->assignmentPayload(
                $assignment,
                $validatedMinutes,
                [
                    'total' =>
                        $totalAttendance,

                    'in_progress' =>
                        $inProgressAttendance,

                    'pending' =>
                        $pendingAttendance,

                    'validated' =>
                        $validatedAttendance,

                    'rejected' =>
                        $rejectedAttendance,
                ],
                [
                    'total' =>
                        $totalWorkLogs,

                    'pending' =>
                        $pendingWorkLogs,

                    'validated' =>
                        $validatedWorkLogs,

                    'rejected' =>
                        $rejectedWorkLogs,
                ]
            );


        return response()->json([
            'success' =>
                true,

            'server_time' =>
                now()
                    ->timezone(
                        self::BUSINESS_TIMEZONE
                    )
                    ->toIso8601String(),

            'student' =>
                $payload,

            'recent_attendance' =>
                $recentAttendance,

            'recent_work_logs' =>
                $recentWorkLogs,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Authenticated Supervisor
    |--------------------------------------------------------------------------
    */

    private function authenticatedSupervisor(
        Request $request
    ): User|JsonResponse {
        $user =
            $request->user();


        if (
            ! $user instanceof User
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'Unauthenticated.',
                ],
                401
            );
        }


        if (
            ! $user->isSupervisor()
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'Supervisor access only.',
                ],
                403
            );
        }


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
                    'success' =>
                        false,

                    'message' =>
                        'This account is currently unavailable.',
                ],
                403
            );
        }


        return $user;
    }


    /*
    |--------------------------------------------------------------------------
    | Assignment Payload
    |--------------------------------------------------------------------------
    */

    private function assignmentPayload(
        OjtAssignment $assignment,
        ?int $validatedMinutesOverride = null,
        ?array $attendanceSummaryOverride = null,
        ?array $workLogSummaryOverride = null
    ): array {
        $assignment->loadMissing([
            'studentProfile.user',
            'company',
            'finalEvaluation',
        ]);


        $profile =
            $assignment
                ->studentProfile;


        $student =
            $profile
                ?->user;


        $company =
            $assignment
                ->company;


        /*
        |--------------------------------------------------------------------------
        | Validated Minutes
        |--------------------------------------------------------------------------
        */

        if (
            $validatedMinutesOverride
            !== null
        ) {
            $validatedMinutes =
                max(
                    0,
                    $validatedMinutesOverride
                );
        } elseif (
            isset(
                $assignment
                    ->validated_minutes
            )
        ) {
            $validatedMinutes =
                max(
                    0,
                    (int) $assignment
                        ->validated_minutes
                );
        } else {
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
        }


        /*
        |--------------------------------------------------------------------------
        | Required / Remaining
        |--------------------------------------------------------------------------
        */

        $requiredHours =
            max(
                0,
                (int) (
                    $assignment
                        ->required_hours
                    ?? 0
                )
            );


        $requiredMinutes =
            $requiredHours
            *
            60;


        $remainingMinutes =
            max(
                0,
                $requiredMinutes
                -
                $validatedMinutes
            );


        $progressPercentage =
            $requiredMinutes >
            0
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


        /*
        |--------------------------------------------------------------------------
        | Attendance Summary
        |--------------------------------------------------------------------------
        */

        $attendanceSummary =
            $attendanceSummaryOverride
            ??
            [
                'total' =>
                    (int) (
                        $assignment
                            ->total_attendance_count
                        ?? 0
                    ),

                'in_progress' =>
                    (int) (
                        $assignment
                            ->in_progress_attendance_count
                        ?? 0
                    ),

                'pending' =>
                    (int) (
                        $assignment
                            ->pending_attendance_count
                        ?? 0
                    ),

                'validated' =>
                    (int) (
                        $assignment
                            ->validated_attendance_count
                        ?? 0
                    ),

                'rejected' =>
                    (int) (
                        $assignment
                            ->rejected_attendance_count
                        ?? 0
                    ),
            ];


        /*
        |--------------------------------------------------------------------------
        | Work Log Summary
        |--------------------------------------------------------------------------
        */

        $workLogSummary =
            $workLogSummaryOverride
            ??
            [
                'total' =>
                    (int) (
                        $assignment
                            ->total_work_logs_count
                        ?? 0
                    ),

                'pending' =>
                    (int) (
                        $assignment
                            ->pending_work_logs_count
                        ?? 0
                    ),

                'validated' =>
                    (int) (
                        $assignment
                            ->validated_work_logs_count
                        ?? 0
                    ),

                'rejected' =>
                    (int) (
                        $assignment
                            ->rejected_work_logs_count
                        ?? 0
                    ),
            ];


        /*
        |--------------------------------------------------------------------------
        | Evaluation
        |--------------------------------------------------------------------------
        */

        $evaluation =
            $assignment
                ->finalEvaluation;


        return [
            'assignment' => [
                'id' =>
                    $assignment->id,

                'status' =>
                    $assignment->status,

                'required_hours' =>
                    $requiredHours,

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


            /*
            |--------------------------------------------------------------------------
            | Student Information
            |--------------------------------------------------------------------------
            */

            'student' => [
                'id' =>
                    $student?->id,

                'name' =>
                    $student?->name,

                'email' =>
                    $student?->email,

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

                'contact_number' =>
                    $profile
                        ?->contact_number,
            ],


            /*
            |--------------------------------------------------------------------------
            | Company
            |--------------------------------------------------------------------------
            */

            'company' => [
                'id' =>
                    $company?->id,

                'name' =>
                    $company?->name,

                'address' =>
                    $company?->address,

                'contact_person' =>
                    $company
                        ?->contact_person,

                'contact_number' =>
                    $company
                        ?->contact_number,
            ],


            /*
            |--------------------------------------------------------------------------
            | OJT Progress
            |--------------------------------------------------------------------------
            */

            'progress' => [
                'required_hours' =>
                    $requiredHours,

                'required_minutes' =>
                    $requiredMinutes,

                'validated_minutes' =>
                    $validatedMinutes,

                'validated_hours_label' =>
                    $this->minutesLabel(
                        $validatedMinutes
                    ),

                'remaining_minutes' =>
                    $remainingMinutes,

                'remaining_hours_label' =>
                    $this->minutesLabel(
                        $remainingMinutes
                    ),

                'percentage' =>
                    $progressPercentage,
            ],


            /*
            |--------------------------------------------------------------------------
            | Attendance
            |--------------------------------------------------------------------------
            */

            'attendance' =>
                $attendanceSummary,


            /*
            |--------------------------------------------------------------------------
            | Daily Work Logs
            |--------------------------------------------------------------------------
            */

            'work_logs' =>
                $workLogSummary,


            /*
            |--------------------------------------------------------------------------
            | Final Evaluation
            |--------------------------------------------------------------------------
            */

            'evaluation' => [
                'submitted' =>
                    $evaluation
                    !== null,

                'recommendation' =>
                    $evaluation
                        ?->recommendation,

                'evaluated_at' =>
                    $evaluation
                        ?->evaluated_at
                        ?->setTimezone(
                            self::BUSINESS_TIMEZONE
                        )
                        ->toIso8601String(),
            ],
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Minutes Label
    |--------------------------------------------------------------------------
    */

    private function minutesLabel(
        int $minutes
    ): string {
        $safeMinutes =
            max(
                0,
                $minutes
            );


        $hours =
            intdiv(
                $safeMinutes,
                60
            );


        $remainingMinutes =
            $safeMinutes
            %
            60;


        return sprintf(
            '%dh %02dm',
            $hours,
            $remainingMinutes
        );
    }
}