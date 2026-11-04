<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\User;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\PersonalAccessToken;


class SupervisorAttendanceController extends Controller
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
    | Attendance Validation List
    |--------------------------------------------------------------------------
    |
    | GET /api/mobile/supervisor/attendance
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
        | Supervisor-Scoped Attendance
        |--------------------------------------------------------------------------
        */

        $baseQuery =
            AttendanceRecord::query()
                ->whereHas(
                    'ojtAssignment',
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
                    AttendanceRecord::STATUS_PENDING
                )
                ->count();


        $validatedCount =
            (clone $baseQuery)
                ->where(
                    'status',
                    AttendanceRecord::STATUS_VALIDATED
                )
                ->count();


        $rejectedCount =
            (clone $baseQuery)
                ->where(
                    'status',
                    AttendanceRecord::STATUS_REJECTED
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Pending Records
        |--------------------------------------------------------------------------
        */

        $pendingRecords =
            (clone $baseQuery)
                ->with([
                    'ojtAssignment.studentProfile.user',
                    'ojtAssignment.company',
                    'validator',
                ])
                ->where(
                    'status',
                    AttendanceRecord::STATUS_PENDING
                )
                ->latest(
                    'attendance_date'
                )
                ->latest(
                    'id'
                )
                ->get()
                ->map(
                    fn (
                        AttendanceRecord $attendance
                    ): array =>
                        $this->attendancePayload(
                            $attendance
                        )
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | Recently Processed Records
        |--------------------------------------------------------------------------
        */

        $recentProcessed =
            (clone $baseQuery)
                ->with([
                    'ojtAssignment.studentProfile.user',
                    'ojtAssignment.company',
                    'validator',
                ])
                ->whereIn(
                    'status',
                    [
                        AttendanceRecord::STATUS_VALIDATED,
                        AttendanceRecord::STATUS_REJECTED,
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
                        AttendanceRecord $attendance
                    ): array =>
                        $this->attendancePayload(
                            $attendance
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

            'pending_records' =>
                $pendingRecords,

            'recent_processed' =>
                $recentProcessed,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Show One Attendance Record
    |--------------------------------------------------------------------------
    |
    | GET /api/mobile/supervisor/attendance/{attendance}
    |
    */

    public function show(
        Request $request,
        AttendanceRecord $attendance
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
                $attendance,
                $supervisor
            )
        ) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'You are not authorized to access this attendance record.',
                ],
                403
            );
        }


        $attendance->load([
            'ojtAssignment.studentProfile.user',
            'ojtAssignment.company',
            'validator',
        ]);


        return response()->json([
            'success' =>
                true,

            'attendance' =>
                $this->attendancePayload(
                    $attendance
                ),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Validate Attendance
    |--------------------------------------------------------------------------
    |
    | PATCH /api/mobile/supervisor/attendance/{attendance}/validate
    |
    */

    public function validateAttendance(
        Request $request,
        AttendanceRecord $attendance
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
                $attendance,
                $supervisor
            )
        ) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'You are not authorized to validate this attendance record.',
                ],
                403
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Attendance Must Be Complete
        |--------------------------------------------------------------------------
        */

        if (
            $attendance->time_out === null
            ||
            $attendance->rendered_minutes === null
        ) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'This attendance record is incomplete and cannot be validated.',
                ],
                422
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Only Pending Attendance Can Be Validated
        |--------------------------------------------------------------------------
        */

        if (
            $attendance->status
            !==
            AttendanceRecord::STATUS_PENDING
        ) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'This attendance record has already been processed.',
                ],
                409
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Optional Supervisor Remarks
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
                    $attendance,
                    $supervisor,
                    $remarks
                ): array {
                    $record =
                        AttendanceRecord::query()
                            ->whereKey(
                                $attendance->id
                            )
                            ->whereHas(
                                'ojtAssignment',
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
                                'You are not authorized to validate this attendance record.',

                            'record' =>
                                null,
                        ];
                    }


                    if (
                        $record->status
                        !==
                        AttendanceRecord::STATUS_PENDING
                    ) {
                        return [
                            'status' =>
                                409,

                            'message' =>
                                'This attendance record has already been processed.',

                            'record' =>
                                null,
                        ];
                    }


                    if (
                        $record->time_out === null
                        ||
                        $record->rendered_minutes === null
                    ) {
                        return [
                            'status' =>
                                422,

                            'message' =>
                                'This attendance record is incomplete and cannot be validated.',

                            'record' =>
                                null,
                        ];
                    }


                    $record->update([
                        'status' =>
                            AttendanceRecord::STATUS_VALIDATED,

                        'supervisor_remarks' =>
                            $remarks,

                        'validated_by' =>
                            $supervisor->id,

                        'validated_at' =>
                            now(),
                    ]);


                    $record->load([
                        'ojtAssignment.studentProfile.user',
                        'ojtAssignment.company',
                        'validator',
                    ]);


                    return [
                        'status' =>
                            200,

                        'message' =>
                            'Attendance validated successfully.',

                        'record' =>
                            $record,
                    ];
                }
            );


        if (
            ! $result['record']
            instanceof AttendanceRecord
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

            'attendance' =>
                $this->attendancePayload(
                    $result['record']
                ),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Reject Attendance
    |--------------------------------------------------------------------------
    |
    | PATCH /api/mobile/supervisor/attendance/{attendance}/reject
    |
    */

    public function reject(
        Request $request,
        AttendanceRecord $attendance
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
                $attendance,
                $supervisor
            )
        ) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'You are not authorized to reject this attendance record.',
                ],
                403
            );
        }


        if (
            $attendance->status
            !==
            AttendanceRecord::STATUS_PENDING
        ) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'This attendance record has already been processed.',
                ],
                409
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Rejection Remarks Are Required
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
                    $attendance,
                    $supervisor,
                    $remarks
                ): array {
                    $record =
                        AttendanceRecord::query()
                            ->whereKey(
                                $attendance->id
                            )
                            ->whereHas(
                                'ojtAssignment',
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
                                'You are not authorized to reject this attendance record.',

                            'record' =>
                                null,
                        ];
                    }


                    if (
                        $record->status
                        !==
                        AttendanceRecord::STATUS_PENDING
                    ) {
                        return [
                            'status' =>
                                409,

                            'message' =>
                                'This attendance record has already been processed.',

                            'record' =>
                                null,
                        ];
                    }


                    $record->update([
                        'status' =>
                            AttendanceRecord::STATUS_REJECTED,

                        'supervisor_remarks' =>
                            $remarks,

                        'validated_by' =>
                            $supervisor->id,

                        'validated_at' =>
                            now(),
                    ]);


                    $record->load([
                        'ojtAssignment.studentProfile.user',
                        'ojtAssignment.company',
                        'validator',
                    ]);


                    return [
                        'status' =>
                            200,

                        'message' =>
                            'Attendance rejected successfully.',

                        'record' =>
                            $record,
                    ];
                }
            );


        if (
            ! $result['record']
            instanceof AttendanceRecord
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

            'attendance' =>
                $this->attendancePayload(
                    $result['record']
                ),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Private Attendance Selfie
    |--------------------------------------------------------------------------
    |
    | GET /api/mobile/supervisor/attendance/{attendance}/selfie/{type}
    |
    | Legacy daily evidence:
    |   /selfie/time-in
    |   /selfie/time-out
    |
    | Session evidence:
    |   /selfie/time-in?session={attendanceSessionId}
    |   /selfie/time-out?session={attendanceSessionId}
    |
    */

    public function selfie(
        Request $request,
        AttendanceRecord $attendance,
        string $type
    ): Response|JsonResponse {
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
                $attendance,
                $supervisor
            )
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'You are not authorized to access this attendance selfie.',
                ],
                403
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Optional Attendance Session
        |--------------------------------------------------------------------------
        |
        | The current Student Attendance workflow stores Morning and
        | Afternoon evidence in attendance_sessions. Keeping the existing
        | route and using a session query parameter avoids exposing a new
        | public image route while remaining backward-compatible with older
        | daily attendance records.
        |
        */

        $sessionId =
            $request->query(
                'session'
            );


        if (
            $sessionId
            !== null
        ) {
            if (
                ! is_string(
                    $sessionId
                )
                ||
                ! ctype_digit(
                    $sessionId
                )
                ||
                (int) $sessionId
                < 1
            ) {
                return response()->json(
                    [
                        'success' =>
                            false,

                        'message' =>
                            'Invalid attendance session.',
                    ],
                    422
                );
            }


            $session =
                AttendanceSession::query()
                    ->whereKey(
                        (int) $sessionId
                    )
                    ->where(
                        'attendance_record_id',
                        $attendance->id
                    )
                    ->first();


            if (! $session) {
                return response()->json(
                    [
                        'success' =>
                            false,

                        'message' =>
                            'Attendance session not found.',
                    ],
                    404
                );
            }


            $path =
                match ($type) {
                    'time-in' =>
                        $session
                            ->time_in_selfie_path,

                    'time-out' =>
                        $session
                            ->time_out_selfie_path,

                    default =>
                        null,
                };
        } else {
            /*
            |--------------------------------------------------------------------------
            | Legacy Daily Attendance Evidence
            |--------------------------------------------------------------------------
            */

            $path =
                match ($type) {
                    'time-in' =>
                        $attendance
                            ->time_in_selfie_path,

                    'time-out' =>
                        $attendance
                            ->time_out_selfie_path,

                    default =>
                        null,
                };
        }


        if (! $path) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'Attendance selfie not found.',
                ],
                404
            );
        }


        return $this->privateImageResponse(
            $path
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Resolve Authenticated Supervisor
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
        AttendanceRecord $attendance,
        User $supervisor
    ): bool {
        $attendance->loadMissing(
            'ojtAssignment'
        );


        $assignment =
            $attendance
                ->ojtAssignment;


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
    | Attendance API Payload
    |--------------------------------------------------------------------------
    */

    private function attendancePayload(
        AttendanceRecord $attendance
    ): array {
        $attendance->loadMissing([
            'ojtAssignment.studentProfile.user',
            'ojtAssignment.company',
            'validator',
        ]);


        $assignment =
            $attendance
                ->ojtAssignment;


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
            $attendance
                ->validator;


        /*
        |--------------------------------------------------------------------------
        | Morning / Afternoon Attendance Sessions
        |--------------------------------------------------------------------------
        */

        $sessions =
            AttendanceSession::query()
                ->where(
                    'attendance_record_id',
                    $attendance->id
                )
                ->orderBy(
                    'session_number'
                )
                ->get();


        return [
            'id' =>
                $attendance->id,

            'status' =>
                $attendance->status,

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

            /*
            |--------------------------------------------------------------------------
            | Time In Evidence
            |--------------------------------------------------------------------------
            */

            'time_in_evidence' => [
                'latitude' =>
                    $attendance
                        ->time_in_latitude
                    !== null
                        ? (float)
                            $attendance
                                ->time_in_latitude
                        : null,

                'longitude' =>
                    $attendance
                        ->time_in_longitude
                    !== null
                        ? (float)
                            $attendance
                                ->time_in_longitude
                        : null,

                'accuracy' =>
                    $attendance
                        ->time_in_accuracy
                    !== null
                        ? (float)
                            $attendance
                                ->time_in_accuracy
                        : null,

                'has_selfie' =>
                    filled(
                        $attendance
                            ->time_in_selfie_path
                    ),
            ],

            /*
            |--------------------------------------------------------------------------
            | Time Out Evidence
            |--------------------------------------------------------------------------
            */

            'time_out_evidence' => [
                'latitude' =>
                    $attendance
                        ->time_out_latitude
                    !== null
                        ? (float)
                            $attendance
                                ->time_out_latitude
                        : null,

                'longitude' =>
                    $attendance
                        ->time_out_longitude
                    !== null
                        ? (float)
                            $attendance
                                ->time_out_longitude
                        : null,

                'accuracy' =>
                    $attendance
                        ->time_out_accuracy
                    !== null
                        ? (float)
                            $attendance
                                ->time_out_accuracy
                        : null,

                'has_selfie' =>
                    filled(
                        $attendance
                            ->time_out_selfie_path
                    ),
            ],

            /*
            |--------------------------------------------------------------------------
            | Morning / Afternoon Session Evidence
            |--------------------------------------------------------------------------
            */

            'sessions' =>
                $sessions
                    ->map(
                        fn (
                            AttendanceSession $session
                        ): array =>
                            $this->attendanceSessionPayload(
                                $session
                            )
                    )
                    ->values()
                    ->all(),

            /*
            |--------------------------------------------------------------------------
            | Student
            |--------------------------------------------------------------------------
            */

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

            /*
            |--------------------------------------------------------------------------
            | Assignment / Company
            |--------------------------------------------------------------------------
            */

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

                    'address' =>
                        $company?->address,
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Supervisor Decision
            |--------------------------------------------------------------------------
            */

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

            'validator' =>
                $validator
                    ? [
                        'id' =>
                            $validator->id,

                        'name' =>
                            $validator->name,
                    ]
                    : null,

            /*
            |--------------------------------------------------------------------------
            | Available Actions
            |--------------------------------------------------------------------------
            */

            'can_validate' =>
                $attendance->status
                ===
                AttendanceRecord::STATUS_PENDING
                &&
                $attendance->time_out
                !==
                null
                &&
                $attendance->rendered_minutes
                !==
                null,

            'can_reject' =>
                $attendance->status
                ===
                AttendanceRecord::STATUS_PENDING,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Attendance Session API Payload
    |--------------------------------------------------------------------------
    */

    private function attendanceSessionPayload(
        AttendanceSession $session
    ): array {
        $renderedMinutes =
            max(
                0,
                (int) (
                    $session
                        ->rendered_minutes
                    ?? 0
                )
            );


        return [
            'id' =>
                $session->id,

            'session_number' =>
                (int) $session
                    ->session_number,

            'session_label' =>
                $session
                    ->sessionLabel(),

            'time_in' =>
                $session
                    ->time_in
                    ?->setTimezone(
                        self::BUSINESS_TIMEZONE
                    )
                    ->toIso8601String(),

            'time_out' =>
                $session
                    ->time_out
                    ?->setTimezone(
                        self::BUSINESS_TIMEZONE
                    )
                    ->toIso8601String(),

            'rendered_minutes' =>
                $renderedMinutes,

            'rendered_hours_label' =>
                $this->minutesLabel(
                    $renderedMinutes
                ),

            'is_open' =>
                $session->time_out
                ===
                null,

            'is_completed' =>
                $session->time_out
                !==
                null,

            'time_in_evidence' => [
                'latitude' =>
                    $session
                        ->time_in_latitude
                    !== null
                        ? (float)
                            $session
                                ->time_in_latitude
                        : null,

                'longitude' =>
                    $session
                        ->time_in_longitude
                    !== null
                        ? (float)
                            $session
                                ->time_in_longitude
                        : null,

                'accuracy' =>
                    $session
                        ->time_in_accuracy
                    !== null
                        ? (float)
                            $session
                                ->time_in_accuracy
                        : null,

                'has_selfie' =>
                    filled(
                        $session
                            ->time_in_selfie_path
                    ),
            ],

            'time_out_evidence' => [
                'latitude' =>
                    $session
                        ->time_out_latitude
                    !== null
                        ? (float)
                            $session
                                ->time_out_latitude
                        : null,

                'longitude' =>
                    $session
                        ->time_out_longitude
                    !== null
                        ? (float)
                            $session
                                ->time_out_longitude
                        : null,

                'accuracy' =>
                    $session
                        ->time_out_accuracy
                    !== null
                        ? (float)
                            $session
                                ->time_out_accuracy
                        : null,

                'has_selfie' =>
                    filled(
                        $session
                            ->time_out_selfie_path
                    ),
            ],
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Secure Private Image Response
    |--------------------------------------------------------------------------
    |
    | The image Content-Type is derived from the validated stored file
    | extension. This is more reliable on Windows than Storage::mimeType()
    | for private mobile-camera uploads.
    |
    */

    private function privateImageResponse(
        string $path
    ): Response|JsonResponse {
        /** @var FilesystemAdapter $disk */
        $disk =
            Storage::disk(
                'local'
            );


        if (
            ! $disk->exists(
                $path
            )
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'Attendance selfie not found.',
                ],
                404
            );
        }


        $extension =
            strtolower(
                pathinfo(
                    $path,
                    PATHINFO_EXTENSION
                )
            );


        $mimeType =
            match ($extension) {
                'jpg',
                'jpeg' =>
                    'image/jpeg',

                'png' =>
                    'image/png',

                'webp' =>
                    'image/webp',

                default =>
                    'application/octet-stream',
            };


        return response(
            $disk->get(
                $path
            ),
            200,
            [
                'Content-Type' =>
                    $mimeType,

                'Content-Disposition' =>
                    'inline',

                'Cache-Control' =>
                    'private, no-store, max-age=0',

                'Pragma' =>
                    'no-cache',

                'X-Content-Type-Options' =>
                    'nosniff',
            ]
        );
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