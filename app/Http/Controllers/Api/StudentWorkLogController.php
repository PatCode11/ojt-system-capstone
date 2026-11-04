<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\DailyWorkLog;
use App\Models\OjtAssignment;
use App\Models\StudentProfile;
use App\Models\User;
use App\Services\StudentAssignmentService;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;
use Throwable;

class StudentWorkLogController extends Controller
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
    | Work Log History + Creation State
    |--------------------------------------------------------------------------
    */

    public function index(
        Request $request,
        StudentAssignmentService $assignmentService
    ): JsonResponse {
        $user =
            $this->student(
                $request
            );


        if ($user instanceof JsonResponse) {
            return $user;
        }


        $profile =
            $user->studentProfile;


        $requestedAssignmentId =
            $request->integer(
                'assignment'
            ) ?: null;


        $assignment =
            null;


        if (
            $profile instanceof StudentProfile
        ) {
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
                return response()->json(
                    [
                        'success' => false,

                        'message' =>
                            'The requested OJT Assignment could not be found.',
                    ],
                    404
                );
            }
        }


        $now =
            CarbonImmutable::now(
                self::BUSINESS_TIMEZONE
            );


        if (! $assignment) {
            return response()->json(
                $this->emptyResponse(
                    $user,
                    $profile,
                    $now
                )
            );
        }


        $assignment->loadMissing([
            'company',
            'supervisor',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Work Log History
        |--------------------------------------------------------------------------
        */

        $workLogs =
            DailyWorkLog::query()
                ->with([
                    'attendanceRecord',
                    'validator',
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
                ->latest(
                    'submitted_at'
                )
                ->latest('id')
                ->paginate(10);


        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        $baseWorkLogQuery =
            DailyWorkLog::query()
                ->whereHas(
                    'attendanceRecord',
                    function ($query) use ($assignment): void {
                        $query->where(
                            'ojt_assignment_id',
                            $assignment->id
                        );
                    }
                );


        $totalWorkLogs =
            (clone $baseWorkLogQuery)
                ->count();


        $pendingWorkLogs =
            (clone $baseWorkLogQuery)
                ->where(
                    'status',
                    DailyWorkLog::STATUS_PENDING
                )
                ->count();


        $validatedWorkLogs =
            (clone $baseWorkLogQuery)
                ->where(
                    'status',
                    DailyWorkLog::STATUS_VALIDATED
                )
                ->count();


        $rejectedWorkLogs =
            (clone $baseWorkLogQuery)
                ->where(
                    'status',
                    DailyWorkLog::STATUS_REJECTED
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Eligible Attendance Records
        |--------------------------------------------------------------------------
        |
        | This matches the existing web WorkLogController:
        |
        | - Assignment must be ACTIVE.
        | - Attendance must already have Time Out.
        | - Attendance status must be pending or validated.
        | - The attendance record must not already have a Daily Work Log.
        |
        */

        $canCreateWorkLog =
            $assignment->status
            === OjtAssignment::STATUS_ACTIVE;


        $availableAttendance =
            collect();


        if ($canCreateWorkLog) {
            $availableAttendance =
                AttendanceRecord::query()
                    ->where(
                        'ojt_assignment_id',
                        $assignment->id
                    )
                    ->whereNotNull(
                        'time_out'
                    )
                    ->whereIn(
                        'status',
                        [
                            AttendanceRecord::STATUS_PENDING,
                            AttendanceRecord::STATUS_VALIDATED,
                        ]
                    )
                    ->whereDoesntHave(
                        'dailyWorkLog'
                    )
                    ->latest(
                        'attendance_date'
                    )
                    ->latest('id')
                    ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | Today's Work Log State
        |--------------------------------------------------------------------------
        */

        $today =
            $now->toDateString();


        $todayAttendance =
            AttendanceRecord::query()
                ->with(
                    'dailyWorkLog'
                )
                ->where(
                    'ojt_assignment_id',
                    $assignment->id
                )
                ->where(
                    'attendance_date',
                    $today
                )
                ->first();


        $todayWorkLog =
            $todayAttendance
                ?->dailyWorkLog;


        return response()->json([
            'success' =>
                true,

            'server_time' =>
                $now->toIso8601String(),

            'student' => [
                'id' =>
                    $user->id,

                'name' =>
                    $user->name,

                'student_number' =>
                    $profile?->student_number,

                'program' =>
                    $profile?->program,
            ],

            'assignment' => [
                'id' =>
                    $assignment->id,

                'status' =>
                    $assignment->status,

                'completed' =>
                    $assignment->status
                    === OjtAssignment::STATUS_COMPLETED,

                'company' => [
                    'id' =>
                        $assignment->company?->id,

                    'name' =>
                        $assignment->company?->name,
                ],

                'supervisor' => [
                    'id' =>
                        $assignment->supervisor?->id,

                    'name' =>
                        $assignment->supervisor?->name,
                ],
            ],

            'can_create_work_log' =>
                $canCreateWorkLog,

            'available_attendance_count' =>
                $availableAttendance->count(),

            'available_attendance' =>
                $availableAttendance
                    ->map(
                        fn (AttendanceRecord $attendance): array => [
                            'id' =>
                                $attendance->id,

                            'attendance_date' =>
                                $attendance
                                    ->attendance_date
                                    ?->toDateString(),

                            'time_out' =>
                                $attendance
                                    ->time_out
                                    ?->toIso8601String(),

                            'rendered_minutes' =>
                                (int) ($attendance->rendered_minutes ?? 0),

                            'status' =>
                                $attendance->status,
                        ]
                    )
                    ->values(),

            'today' => [
                'date' =>
                    $today,

                'attendance_record_id' =>
                    $todayAttendance?->id,

                'attendance_status' =>
                    $todayAttendance?->status,

                'work_log_status' =>
                    $todayWorkLog?->status,

                'can_submit' =>
                    $availableAttendance
                        ->contains(
                            fn (AttendanceRecord $attendance): bool =>
                                (int) $attendance->id
                                ===
                                (int) ($todayAttendance?->id ?? 0)
                        ),
            ],

            'summary' => [
                'total' =>
                    $totalWorkLogs,

                'pending' =>
                    $pendingWorkLogs,

                'validated' =>
                    $validatedWorkLogs,

                'rejected' =>
                    $rejectedWorkLogs,
            ],

            'work_logs' => [
                'data' =>
                    $workLogs
                        ->getCollection()
                        ->map(
                            fn (DailyWorkLog $workLog): array =>
                                $this->workLogData(
                                    $workLog,
                                    $canCreateWorkLog
                                )
                        )
                        ->values(),

                'current_page' =>
                    $workLogs->currentPage(),

                'last_page' =>
                    $workLogs->lastPage(),

                'per_page' =>
                    $workLogs->perPage(),

                'total' =>
                    $workLogs->total(),

                'has_more' =>
                    $workLogs->hasMorePages(),
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Submit New Work Log
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request,
        StudentAssignmentService $assignmentService
    ): JsonResponse {
        $user =
            $this->student(
                $request
            );


        if ($user instanceof JsonResponse) {
            return $user;
        }


        $profile =
            $user->studentProfile;


        if (! $profile) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'Please complete your Student Profile first.',
                ],
                422
            );
        }


        $assignment =
            $assignmentService
                ->activeAssignment(
                    $profile
                );


        if (! $assignment) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'Your OJT Assignment is not Active. New Work Logs are disabled.',
                ],
                422
            );
        }


        $validated =
            $this->validateWorkLog(
                $request,
                true
            );


        try {
            $workLog =
                DB::transaction(
                    function () use (
                        $assignment,
                        $validated
                    ): DailyWorkLog {
                        $attendance =
                            AttendanceRecord::query()
                                ->whereKey(
                                    $validated[
                                        'attendance_record_id'
                                    ]
                                )
                                ->where(
                                    'ojt_assignment_id',
                                    $assignment->id
                                )
                                ->whereNotNull(
                                    'time_out'
                                )
                                ->whereIn(
                                    'status',
                                    [
                                        AttendanceRecord::STATUS_PENDING,
                                        AttendanceRecord::STATUS_VALIDATED,
                                    ]
                                )
                                ->lockForUpdate()
                                ->first();


                        if (! $attendance) {
                            abort(
                                422,
                                'The selected Attendance Record cannot be used.'
                            );
                        }


                        $existingWorkLog =
                            DailyWorkLog::query()
                                ->where(
                                    'attendance_record_id',
                                    $attendance->id
                                )
                                ->lockForUpdate()
                                ->first();


                        if ($existingWorkLog) {
                            abort(
                                409,
                                'A Daily Work Log already exists for this attendance record.'
                            );
                        }


                        return DailyWorkLog::create([
                            'attendance_record_id' =>
                                $attendance->id,

                            'tasks_accomplished' =>
                                $validated[
                                    'tasks_accomplished'
                                ],

                            'learnings' =>
                                $validated[
                                    'learnings'
                                ] ?? null,

                            'challenges' =>
                                $validated[
                                    'challenges'
                                ] ?? null,

                            'student_remarks' =>
                                $validated[
                                    'student_remarks'
                                ] ?? null,

                            'submitted_at' =>
                                now(),

                            'status' =>
                                DailyWorkLog::STATUS_PENDING,
                        ]);
                    }
                );
        } catch (Throwable $exception) {
            if (
                method_exists(
                    $exception,
                    'getStatusCode'
                )
            ) {
                $status =
                    (int) $exception
                        ->getStatusCode();


                if (
                    $status >= 400
                    && $status < 500
                ) {
                    return response()->json(
                        [
                            'success' => false,

                            'message' =>
                                $exception->getMessage(),
                        ],
                        $status
                    );
                }
            }


            report(
                $exception
            );


            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'Unable to submit the Daily Work Log. Please try again.',
                ],
                500
            );
        }


        $workLog->load([
            'attendanceRecord',
            'validator',
        ]);


        return response()->json(
            [
                'success' => true,

                'message' =>
                    'Daily Work Log submitted successfully.',

                'work_log' =>
                    $this->workLogData(
                        $workLog,
                        true
                    ),
            ],
            201
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Correct + Resubmit Rejected Work Log
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        DailyWorkLog $workLog,
        StudentAssignmentService $assignmentService
    ): JsonResponse {
        $user =
            $this->student(
                $request
            );


        if ($user instanceof JsonResponse) {
            return $user;
        }


        $profile =
            $user->studentProfile;


        if (! $profile) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'Student Profile is required.',
                ],
                403
            );
        }


        $assignment =
            $assignmentService
                ->activeAssignment(
                    $profile
                );


        if (! $assignment) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'Completed or inactive OJT Assignment records are read-only.',
                ],
                403
            );
        }


        $workLog->loadMissing(
            'attendanceRecord'
        );


        if (
            ! $workLog->attendanceRecord
            ||
            (int) $workLog
                ->attendanceRecord
                ->ojt_assignment_id
            !==
            (int) $assignment->id
        ) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'You are not authorized to update this Daily Work Log.',
                ],
                403
            );
        }


        if (
            $workLog->status
            !== DailyWorkLog::STATUS_REJECTED
        ) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'Only rejected Daily Work Logs can be corrected and resubmitted.',
                ],
                409
            );
        }


        $validated =
            $this->validateWorkLog(
                $request,
                false
            );


        try {
            $updatedWorkLog =
                DB::transaction(
                    function () use (
                        $workLog,
                        $assignment,
                        $validated
                    ): DailyWorkLog {
                        $record =
                            DailyWorkLog::query()
                                ->whereKey(
                                    $workLog->id
                                )
                                ->lockForUpdate()
                                ->firstOrFail();


                        $record->loadMissing(
                            'attendanceRecord'
                        );


                        if (
                            ! $record->attendanceRecord
                            ||
                            (int) $record
                                ->attendanceRecord
                                ->ojt_assignment_id
                            !==
                            (int) $assignment->id
                        ) {
                            abort(
                                403,
                                'You are not authorized to update this Daily Work Log.'
                            );
                        }


                        if (
                            $record->status
                            !== DailyWorkLog::STATUS_REJECTED
                        ) {
                            abort(
                                409,
                                'Only rejected Daily Work Logs can be corrected and resubmitted.'
                            );
                        }


                        $record->update([
                            'tasks_accomplished' =>
                                $validated[
                                    'tasks_accomplished'
                                ],

                            'learnings' =>
                                $validated[
                                    'learnings'
                                ] ?? null,

                            'challenges' =>
                                $validated[
                                    'challenges'
                                ] ?? null,

                            'student_remarks' =>
                                $validated[
                                    'student_remarks'
                                ] ?? null,

                            'submitted_at' =>
                                now(),

                            'status' =>
                                DailyWorkLog::STATUS_PENDING,

                            'supervisor_remarks' =>
                                null,

                            'validated_by' =>
                                null,

                            'validated_at' =>
                                null,
                        ]);


                        return $record;
                    }
                );
        } catch (Throwable $exception) {
            if (
                method_exists(
                    $exception,
                    'getStatusCode'
                )
            ) {
                $status =
                    (int) $exception
                        ->getStatusCode();


                if (
                    $status >= 400
                    && $status < 500
                ) {
                    return response()->json(
                        [
                            'success' => false,

                            'message' =>
                                $exception->getMessage(),
                        ],
                        $status
                    );
                }
            }


            report(
                $exception
            );


            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'Unable to resubmit the Daily Work Log. Please try again.',
                ],
                500
            );
        }


        $updatedWorkLog->load([
            'attendanceRecord',
            'validator',
        ]);


        return response()->json([
            'success' =>
                true,

            'message' =>
                'Daily Work Log corrected and resubmitted successfully.',

            'work_log' =>
                $this->workLogData(
                    $updatedWorkLog,
                    true
                ),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Student Security
    |--------------------------------------------------------------------------
    */

    private function student(
        Request $request
    ): User|JsonResponse {
        $user =
            $request->user();


        if (
            ! $user instanceof User
            || ! $user->isStudent()
        ) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'Student access only.',
                ],
                403
            );
        }


        if (
            ! $user->isActive()
            || $user->isArchived()
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


        return $user;
    }


    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    private function validateWorkLog(
        Request $request,
        bool $requireAttendance
    ): array {
        $rules = [
            'tasks_accomplished' => [
                'required',
                'string',
                'min:10',
                'max:5000',
            ],

            'learnings' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'challenges' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'student_remarks' => [
                'nullable',
                'string',
                'max:3000',
            ],
        ];


        if ($requireAttendance) {
            $rules[
                'attendance_record_id'
            ] = [
                'required',
                'integer',
            ];
        }


        return $request->validate(
            $rules
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Work Log JSON Shape
    |--------------------------------------------------------------------------
    */

    private function workLogData(
        DailyWorkLog $workLog,
        bool $assignmentIsActive
    ): array {
        $workLog->loadMissing([
            'attendanceRecord',
            'validator',
        ]);


        return [
            'id' =>
                $workLog->id,

            'attendance_record_id' =>
                $workLog->attendance_record_id,

            'attendance_date' =>
                $workLog
                    ->attendanceRecord
                    ?->attendance_date
                    ?->toDateString(),

            'tasks_accomplished' =>
                $workLog->tasks_accomplished,

            'learnings' =>
                $workLog->learnings,

            'challenges' =>
                $workLog->challenges,

            'student_remarks' =>
                $workLog->student_remarks,

            'status' =>
                $workLog->status,

            'supervisor_remarks' =>
                $workLog->supervisor_remarks,

            'submitted_at' =>
                $workLog
                    ->submitted_at
                    ?->toIso8601String(),

            'validated_at' =>
                $workLog
                    ->validated_at
                    ?->toIso8601String(),

            'validator' =>
                $workLog->validator
                    ? [
                        'id' =>
                            $workLog->validator->id,

                        'name' =>
                            $workLog->validator->name,
                    ]
                    : null,

            'can_resubmit' =>
                $assignmentIsActive
                && $workLog->status
                    === DailyWorkLog::STATUS_REJECTED,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Empty State
    |--------------------------------------------------------------------------
    */

    private function emptyResponse(
        User $user,
        ?StudentProfile $profile,
        CarbonImmutable $now
    ): array {
        return [
            'success' =>
                true,

            'server_time' =>
                $now->toIso8601String(),

            'student' => [
                'id' =>
                    $user->id,

                'name' =>
                    $user->name,

                'student_number' =>
                    $profile?->student_number,

                'program' =>
                    $profile?->program,
            ],

            'assignment' =>
                null,

            'can_create_work_log' =>
                false,

            'available_attendance_count' =>
                0,

            'available_attendance' =>
                [],

            'today' => [
                'date' =>
                    $now->toDateString(),

                'attendance_record_id' =>
                    null,

                'attendance_status' =>
                    null,

                'work_log_status' =>
                    null,

                'can_submit' =>
                    false,
            ],

            'summary' => [
                'total' =>
                    0,

                'pending' =>
                    0,

                'validated' =>
                    0,

                'rejected' =>
                    0,
            ],

            'work_logs' => [
                'data' =>
                    [],

                'current_page' =>
                    1,

                'last_page' =>
                    1,

                'per_page' =>
                    10,

                'total' =>
                    0,

                'has_more' =>
                    false,
            ],
        ];
    }
}
