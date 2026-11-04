<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DailyWorkLog;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;


class SupervisorWorkLogController extends Controller
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
    | Work Log Validation List
    |--------------------------------------------------------------------------
    |
    | GET /api/mobile/supervisor/work-logs
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
        | Supervisor-Scoped Query
        |--------------------------------------------------------------------------
        */

        $baseQuery =
            DailyWorkLog::query()
                ->whereHas(
                    'attendanceRecord.ojtAssignment',
                    function ($query) use (
                        $supervisor
                    ): void {
                        $query->where(
                            'supervisor_id',
                            $supervisor->id
                        );
                    }
                );


        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        $pendingCount =
            (clone $baseQuery)
                ->where(
                    'status',
                    DailyWorkLog::STATUS_PENDING
                )
                ->count();


        $validatedCount =
            (clone $baseQuery)
                ->where(
                    'status',
                    DailyWorkLog::STATUS_VALIDATED
                )
                ->count();


        $rejectedCount =
            (clone $baseQuery)
                ->where(
                    'status',
                    DailyWorkLog::STATUS_REJECTED
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Pending Work Logs
        |--------------------------------------------------------------------------
        */

        $pendingLogs =
            (clone $baseQuery)
                ->with([
                    'attendanceRecord.ojtAssignment.studentProfile.user',
                    'attendanceRecord.ojtAssignment.company',
                    'validator',
                ])
                ->where(
                    'status',
                    DailyWorkLog::STATUS_PENDING
                )
                ->latest(
                    'submitted_at'
                )
                ->latest(
                    'id'
                )
                ->get()
                ->map(
                    fn (
                        DailyWorkLog $workLog
                    ): array =>
                        $this->workLogPayload(
                            $workLog
                        )
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | Recently Processed
        |--------------------------------------------------------------------------
        */

        $recentProcessed =
            (clone $baseQuery)
                ->with([
                    'attendanceRecord.ojtAssignment.studentProfile.user',
                    'attendanceRecord.ojtAssignment.company',
                    'validator',
                ])
                ->whereIn(
                    'status',
                    [
                        DailyWorkLog::STATUS_VALIDATED,
                        DailyWorkLog::STATUS_REJECTED,
                    ]
                )
                ->latest(
                    'validated_at'
                )
                ->latest(
                    'id'
                )
                ->limit(
                    20
                )
                ->get()
                ->map(
                    fn (
                        DailyWorkLog $workLog
                    ): array =>
                        $this->workLogPayload(
                            $workLog
                        )
                )
                ->values();


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
                'pending' =>
                    $pendingCount,

                'validated' =>
                    $validatedCount,

                'rejected' =>
                    $rejectedCount,

                'processed' =>
                    $validatedCount
                    +
                    $rejectedCount,
            ],

            'pending_logs' =>
                $pendingLogs,

            'recent_processed' =>
                $recentProcessed,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Show One Work Log
    |--------------------------------------------------------------------------
    |
    | GET /api/mobile/supervisor/work-logs/{workLog}
    |
    */

    public function show(
        Request $request,
        DailyWorkLog $workLog
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


        if (
            ! $this->belongsToSupervisor(
                $workLog,
                $supervisor
            )
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'You are not authorized to access this Daily Work Log.',
                ],
                403
            );
        }


        $workLog->load([
            'attendanceRecord.ojtAssignment.studentProfile.user',
            'attendanceRecord.ojtAssignment.company',
            'validator',
        ]);


        return response()->json([
            'success' =>
                true,

            'work_log' =>
                $this->workLogPayload(
                    $workLog
                ),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Validate Daily Work Log
    |--------------------------------------------------------------------------
    |
    | PATCH /api/mobile/supervisor/work-logs/{workLog}/validate
    |
    */

    public function validateWorkLog(
        Request $request,
        DailyWorkLog $workLog
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


        if (
            ! $this->belongsToSupervisor(
                $workLog,
                $supervisor
            )
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'You are not authorized to validate this Daily Work Log.',
                ],
                403
            );
        }


        if (
            $workLog->status
            !==
            DailyWorkLog::STATUS_PENDING
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'This Daily Work Log has already been processed.',
                ],
                409
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Optional Remarks
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([
                'remarks' => [
                    'nullable',
                    'string',
                    'max:2000',
                ],
            ]);


        $remarks =
            isset(
                $validated['remarks']
            )
            &&
            is_string(
                $validated['remarks']
            )
                ? trim(
                    $validated['remarks']
                )
                : null;


        if (
            $remarks === ''
        ) {
            $remarks =
                null;
        }


        /*
        |--------------------------------------------------------------------------
        | Secure State Transition
        |--------------------------------------------------------------------------
        */

        $result =
            DB::transaction(
                function () use (
                    $workLog,
                    $supervisor,
                    $remarks
                ): array {
                    $record =
                        DailyWorkLog::query()
                            ->whereKey(
                                $workLog->id
                            )
                            ->whereHas(
                                'attendanceRecord.ojtAssignment',
                                function ($query) use (
                                    $supervisor
                                ): void {
                                    $query->where(
                                        'supervisor_id',
                                        $supervisor->id
                                    );
                                }
                            )
                            ->lockForUpdate()
                            ->first();


                    if (! $record) {
                        return [
                            'status' =>
                                403,

                            'message' =>
                                'You are not authorized to validate this Daily Work Log.',

                            'record' =>
                                null,
                        ];
                    }


                    if (
                        $record->status
                        !==
                        DailyWorkLog::STATUS_PENDING
                    ) {
                        return [
                            'status' =>
                                409,

                            'message' =>
                                'This Daily Work Log has already been processed.',

                            'record' =>
                                null,
                        ];
                    }


                    $record->update([
                        'status' =>
                            DailyWorkLog::STATUS_VALIDATED,

                        'supervisor_remarks' =>
                            $remarks,

                        'validated_by' =>
                            $supervisor->id,

                        'validated_at' =>
                            now(),
                    ]);


                    $record->load([
                        'attendanceRecord.ojtAssignment.studentProfile.user',
                        'attendanceRecord.ojtAssignment.company',
                        'validator',
                    ]);


                    return [
                        'status' =>
                            200,

                        'message' =>
                            'Daily Work Log validated successfully.',

                        'record' =>
                            $record,
                    ];
                }
            );


        if (
            ! $result['record']
            instanceof DailyWorkLog
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        $result['message'],
                ],
                $result['status']
            );
        }


        return response()->json([
            'success' =>
                true,

            'message' =>
                $result['message'],

            'work_log' =>
                $this->workLogPayload(
                    $result['record']
                ),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Reject Daily Work Log
    |--------------------------------------------------------------------------
    |
    | PATCH /api/mobile/supervisor/work-logs/{workLog}/reject
    |
    */

    public function reject(
        Request $request,
        DailyWorkLog $workLog
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


        if (
            ! $this->belongsToSupervisor(
                $workLog,
                $supervisor
            )
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'You are not authorized to reject this Daily Work Log.',
                ],
                403
            );
        }


        if (
            $workLog->status
            !==
            DailyWorkLog::STATUS_PENDING
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'This Daily Work Log has already been processed.',
                ],
                409
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Rejection Requires Remarks
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([
                'remarks' => [
                    'required',
                    'string',
                    'min:3',
                    'max:2000',
                ],
            ]);


        $remarks =
            trim(
                $validated['remarks']
            );


        /*
        |--------------------------------------------------------------------------
        | Secure State Transition
        |--------------------------------------------------------------------------
        */

        $result =
            DB::transaction(
                function () use (
                    $workLog,
                    $supervisor,
                    $remarks
                ): array {
                    $record =
                        DailyWorkLog::query()
                            ->whereKey(
                                $workLog->id
                            )
                            ->whereHas(
                                'attendanceRecord.ojtAssignment',
                                function ($query) use (
                                    $supervisor
                                ): void {
                                    $query->where(
                                        'supervisor_id',
                                        $supervisor->id
                                    );
                                }
                            )
                            ->lockForUpdate()
                            ->first();


                    if (! $record) {
                        return [
                            'status' =>
                                403,

                            'message' =>
                                'You are not authorized to reject this Daily Work Log.',

                            'record' =>
                                null,
                        ];
                    }


                    if (
                        $record->status
                        !==
                        DailyWorkLog::STATUS_PENDING
                    ) {
                        return [
                            'status' =>
                                409,

                            'message' =>
                                'This Daily Work Log has already been processed.',

                            'record' =>
                                null,
                        ];
                    }


                    $record->update([
                        'status' =>
                            DailyWorkLog::STATUS_REJECTED,

                        'supervisor_remarks' =>
                            $remarks,

                        'validated_by' =>
                            $supervisor->id,

                        'validated_at' =>
                            now(),
                    ]);


                    $record->load([
                        'attendanceRecord.ojtAssignment.studentProfile.user',
                        'attendanceRecord.ojtAssignment.company',
                        'validator',
                    ]);


                    return [
                        'status' =>
                            200,

                        'message' =>
                            'Daily Work Log rejected successfully.',

                        'record' =>
                            $record,
                    ];
                }
            );


        if (
            ! $result['record']
            instanceof DailyWorkLog
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        $result['message'],
                ],
                $result['status']
            );
        }


        return response()->json([
            'success' =>
                true,

            'message' =>
                $result['message'],

            'work_log' =>
                $this->workLogPayload(
                    $result['record']
                ),
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
    | Ownership Check
    |--------------------------------------------------------------------------
    */

    private function belongsToSupervisor(
        DailyWorkLog $workLog,
        User $supervisor
    ): bool {
        $workLog->loadMissing(
            'attendanceRecord.ojtAssignment'
        );


        $attendance =
            $workLog
                ->attendanceRecord;


        $assignment =
            $attendance
                ?->ojtAssignment;


        if (! $assignment) {
            return false;
        }


        return (
            (int) $assignment
                ->supervisor_id
            ===
            (int) $supervisor->id
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Work Log Payload
    |--------------------------------------------------------------------------
    */

    private function workLogPayload(
        DailyWorkLog $workLog
    ): array {
        $workLog->loadMissing([
            'attendanceRecord.ojtAssignment.studentProfile.user',
            'attendanceRecord.ojtAssignment.company',
            'validator',
        ]);


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


        $company =
            $assignment
                ?->company;


        $validator =
            $workLog
                ->validator;


        return [
            'id' =>
                $workLog->id,

            'status' =>
                $workLog->status,

            'attendance_record_id' =>
                $workLog
                    ->attendance_record_id,

            'attendance_date' =>
                $attendance
                    ?->attendance_date
                    ?->format(
                        'Y-m-d'
                    ),

            'attendance_status' =>
                $attendance
                    ?->status,

            'rendered_minutes' =>
                $attendance
                    ?->rendered_minutes,

            'rendered_hours_label' =>
                $attendance
                    ? $attendance
                        ->renderedHoursLabel()
                    : '—',

            'tasks_accomplished' =>
                $workLog
                    ->tasks_accomplished,

            'learnings' =>
                $workLog
                    ->learnings,

            'challenges' =>
                $workLog
                    ->challenges,

            'student_remarks' =>
                $workLog
                    ->student_remarks,

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

            'assignment' => [
                'id' =>
                    $assignment?->id,

                'status' =>
                    $assignment
                        ?->status,

                'company' => [
                    'id' =>
                        $company?->id,

                    'name' =>
                        $company?->name,
                ],
            ],

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

            'validator' =>
                $validator
                    ? [
                        'id' =>
                            $validator->id,

                        'name' =>
                            $validator->name,
                    ]
                    : null,

            'can_validate' =>
                $workLog->status
                ===
                DailyWorkLog::STATUS_PENDING,

            'can_reject' =>
                $workLog->status
                ===
                DailyWorkLog::STATUS_PENDING,
        ];
    }
}