<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\OjtAssignment;
use App\Models\StudentProfile;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\PersonalAccessToken;
use Throwable;

class StudentAttendanceController extends Controller
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
    | Today's Attendance State
    |--------------------------------------------------------------------------
    */

    public function today(
        Request $request
    ): JsonResponse {
        $context =
            $this->resolveStudentContext(
                $request
            );


        if ($context instanceof JsonResponse) {
            return $context;
        }


        [
            $user,
            $profile,
            $assignment,
        ] = $context;


        if (! $profile) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'Please complete your Student Profile before recording attendance.',
                ],
                422
            );
        }


        if (! $assignment) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'You do not currently have an OJT Assignment.',
                ],
                422
            );
        }


        $now =
            CarbonImmutable::now(
                self::BUSINESS_TIMEZONE
            );


        $today =
            $now->toDateString();


        $attendance =
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


        $sessions =
            collect();


        if ($attendance) {
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
        }


        $sessionCount =
            $sessions->count();


        $openSession =
            $sessions->first(
                function (
                    AttendanceSession $session
                ): bool {
                    return
                        $session->time_out
                        === null;
                }
            );


        $legacyToday =
            $attendance !== null
            && $sessionCount === 0
            && $attendance->time_in !== null;


        $assignmentIsActive =
            $assignment->status
            === OjtAssignment::STATUS_ACTIVE;


        $canTimeIn =
            false;


        $canTimeOut =
            false;


        $nextSessionNumber =
            AttendanceSession::MORNING_SESSION;


        if (
            $assignmentIsActive
            && ! $legacyToday
        ) {
            if ($openSession) {
                $canTimeOut =
                    true;
            } elseif (
                $sessionCount
                <
                AttendanceSession::MAX_SESSIONS_PER_DAY
            ) {
                $canTimeIn =
                    true;

                $nextSessionNumber =
                    $sessionCount + 1;
            }
        }


        $dayComplete =
            $sessionCount
            >=
            AttendanceSession::MAX_SESSIONS_PER_DAY
            && $openSession === null;


        $renderedMinutes =
            (int) $sessions->sum(
                'rendered_minutes'
            );


        $recommendedAction =
            null;


        if ($canTimeOut) {
            $recommendedAction =
                'time-out';
        } elseif ($canTimeIn) {
            $recommendedAction =
                'time-in';
        }


        return response()->json([
            'success' =>
                true,

            'server_time' =>
                $now->toIso8601String(),

            'date' =>
                $today,

            'assignment' => [
                'id' =>
                    $assignment->id,

                'status' =>
                    $assignment->status,

                'company' => [
                    'id' =>
                        $assignment
                            ->company
                            ?->id,

                    'name' =>
                        $assignment
                            ->company
                            ?->name,

                    'address' =>
                        $assignment
                            ->company
                            ?->address,
                ],

                'supervisor' => [
                    'id' =>
                        $assignment
                            ->supervisor
                            ?->id,

                    'name' =>
                        $assignment
                            ->supervisor
                            ?->name,
                ],
            ],

            'attendance' =>
                $attendance
                    ? [
                        'id' =>
                            $attendance->id,

                        'status' =>
                            $attendance->status,

                        'rendered_minutes' =>
                            $renderedMinutes,
                    ]
                    : null,

            'state' => [
                'can_time_in' =>
                    $canTimeIn,

                'can_time_out' =>
                    $canTimeOut,

                'day_complete' =>
                    $dayComplete,

                'legacy_today' =>
                    $legacyToday,

                'session_count' =>
                    $sessionCount,

                'max_sessions' =>
                    AttendanceSession::MAX_SESSIONS_PER_DAY,

                'next_session_number' =>
                    $nextSessionNumber,

                'recommended_action' =>
                    $recommendedAction,
            ],

            'sessions' =>
                $sessions
                    ->map(
                        function (
                            AttendanceSession $session
                        ): array {
                            return [
                                'id' =>
                                    $session->id,

                                'session_number' =>
                                    $session
                                        ->session_number,

                                'session_label' =>
                                    $session
                                        ->sessionLabel(),

                                'time_in' =>
                                    $session
                                        ->time_in
                                        ?->toIso8601String(),

                                'time_out' =>
                                    $session
                                        ->time_out
                                        ?->toIso8601String(),

                                'rendered_minutes' =>
                                    (int) $session
                                        ->rendered_minutes,

                                'is_open' =>
                                    $session
                                        ->isOpen(),

                                'is_completed' =>
                                    $session
                                        ->isCompleted(),
                            ];
                        }
                    )
                    ->values(),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Time In
    |--------------------------------------------------------------------------
    */

    public function timeIn(
        Request $request
    ): JsonResponse {
        $context =
            $this->resolveStudentContext(
                $request
            );


        if ($context instanceof JsonResponse) {
            return $context;
        }


        [
            $user,
            $profile,
            $assignment,
        ] = $context;


        if (! $profile) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'Please complete your Student Profile before recording attendance.',
                ],
                422
            );
        }


        if (! $assignment) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'You do not currently have an OJT Assignment.',
                ],
                422
            );
        }


        if (
            $assignment->status
            !== OjtAssignment::STATUS_ACTIVE
        ) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'Your OJT Assignment is not yet active. Attendance will be available once the assignment is activated.',
                ],
                422
            );
        }


        $validated =
            $this->validateAttendanceInput(
                $request
            );


        $uploadedSelfie =
            $request->file(
                'selfie'
            );


        if (! $uploadedSelfie) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'A selfie is required before recording Time In.',
                ],
                422
            );
        }


        $now =
            CarbonImmutable::now(
                self::BUSINESS_TIMEZONE
            );


        $today =
            $now->toDateString();


        $selfiePath =
            null;


        try {
            $result =
                DB::transaction(
                    function () use (
                        $user,
                        $assignment,
                        $validated,
                        $uploadedSelfie,
                        $today,
                        $now,
                        &$selfiePath
                    ): array {
                        $attendance =
                            AttendanceRecord::query()
                                ->where(
                                    'ojt_assignment_id',
                                    $assignment->id
                                )
                                ->where(
                                    'attendance_date',
                                    $today
                                )
                                ->lockForUpdate()
                                ->first();


                        $sessions =
                            collect();


                        if ($attendance) {
                            $sessions =
                                AttendanceSession::query()
                                    ->where(
                                        'attendance_record_id',
                                        $attendance->id
                                    )
                                    ->orderBy(
                                        'session_number'
                                    )
                                    ->lockForUpdate()
                                    ->get();


                            if (
                                in_array(
                                    $attendance->status,
                                    [
                                        AttendanceRecord::STATUS_PENDING,
                                        AttendanceRecord::STATUS_VALIDATED,
                                        AttendanceRecord::STATUS_REJECTED,
                                    ],
                                    true
                                )
                            ) {
                                return [
                                    'success' =>
                                        false,

                                    'status' =>
                                        409,

                                    'message' =>
                                        'This attendance record has already been submitted or reviewed and can no longer be modified.',
                                ];
                            }


                            if (
                                $sessions->isEmpty()
                                && $attendance->time_in !== null
                            ) {
                                return [
                                    'success' =>
                                        false,

                                    'status' =>
                                        409,

                                    'message' =>
                                        'Today already has a legacy attendance record. Please begin the Morning and Afternoon workflow on your next attendance day.',
                                ];
                            }
                        }


                        $openSession =
                            $sessions->first(
                                function (
                                    AttendanceSession $session
                                ): bool {
                                    return
                                        $session->time_out
                                        === null;
                                }
                            );


                        if ($openSession) {
                            return [
                                'success' =>
                                    false,

                                'status' =>
                                    409,

                                'message' =>
                                    'You already have an active attendance session. Please Time Out before starting another session.',
                            ];
                        }


                        $sessionCount =
                            $sessions->count();


                        if (
                            $sessionCount
                            >=
                            AttendanceSession::MAX_SESSIONS_PER_DAY
                        ) {
                            return [
                                'success' =>
                                    false,

                                'status' =>
                                    409,

                                'message' =>
                                    'You have already completed both attendance sessions for today.',
                            ];
                        }


                        $sessionNumber =
                            $sessionCount + 1;


                        $selfiePath =
                            $uploadedSelfie
                                ->store(
                                    'attendance/'
                                    .$user->id
                                    .'/'
                                    .$today
                                    .'/session-'
                                    .$sessionNumber
                                    .'/time-in',
                                    'local'
                                );


                        if (! $selfiePath) {
                            return [
                                'success' =>
                                    false,

                                'status' =>
                                    500,

                                'message' =>
                                    'Unable to save your Time In selfie.',
                            ];
                        }


                        if (! $attendance) {
                            $attendance =
                                AttendanceRecord::create([
                                    'ojt_assignment_id' =>
                                        $assignment->id,

                                    'attendance_date' =>
                                        $today,

                                    'time_in' =>
                                        $now,

                                    'time_in_latitude' =>
                                        $validated[
                                            'latitude'
                                        ],

                                    'time_in_longitude' =>
                                        $validated[
                                            'longitude'
                                        ],

                                    'time_in_accuracy' =>
                                        $validated[
                                            'accuracy'
                                        ],

                                    'time_in_selfie_path' =>
                                        $selfiePath,

                                    'rendered_minutes' =>
                                        0,

                                    'status' =>
                                        AttendanceRecord::STATUS_IN_PROGRESS,
                                ]);
                        } else {
                            $attendance->update([
                                'time_out' =>
                                    null,

                                'time_out_latitude' =>
                                    null,

                                'time_out_longitude' =>
                                    null,

                                'time_out_accuracy' =>
                                    null,

                                'time_out_selfie_path' =>
                                    null,

                                'status' =>
                                    AttendanceRecord::STATUS_IN_PROGRESS,
                            ]);
                        }


                        $session =
                            AttendanceSession::create([
                                'attendance_record_id' =>
                                    $attendance->id,

                                'session_number' =>
                                    $sessionNumber,

                                'time_in' =>
                                    $now,

                                'time_in_latitude' =>
                                    $validated[
                                        'latitude'
                                    ],

                                'time_in_longitude' =>
                                    $validated[
                                        'longitude'
                                    ],

                                'time_in_accuracy' =>
                                    $validated[
                                        'accuracy'
                                    ],

                                'time_in_selfie_path' =>
                                    $selfiePath,

                                'rendered_minutes' =>
                                    0,
                            ]);


                        return [
                            'success' =>
                                true,

                            'status' =>
                                201,

                            'message' =>
                                $session->sessionLabel()
                                .' Time In recorded successfully.',

                            'attendance_id' =>
                                $attendance->id,

                            'session_id' =>
                                $session->id,

                            'session_number' =>
                                $sessionNumber,

                            'session_label' =>
                                $session
                                    ->sessionLabel(),

                            'recorded_at' =>
                                $now
                                    ->toIso8601String(),
                        ];
                    }
                );
        } catch (Throwable $exception) {
            if ($selfiePath) {
                Storage::disk(
                    'local'
                )->delete(
                    $selfiePath
                );
            }


            report(
                $exception
            );


            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'Unable to record Time In. Please try again.',
                ],
                500
            );
        }


        if (! $result['success']) {
            if ($selfiePath) {
                Storage::disk(
                    'local'
                )->delete(
                    $selfiePath
                );
            }


            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        $result[
                            'message'
                        ],
                ],
                $result['status']
            );
        }


        return response()->json(
            $result,
            $result['status']
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Time Out
    |--------------------------------------------------------------------------
    */

    public function timeOut(
        Request $request
    ): JsonResponse {
        $context =
            $this->resolveStudentContext(
                $request
            );


        if ($context instanceof JsonResponse) {
            return $context;
        }


        [
            $user,
            $profile,
            $assignment,
        ] = $context;


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


        if (! $assignment) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'You do not currently have an OJT Assignment.',
                ],
                422
            );
        }


        if (
            $assignment->status
            !== OjtAssignment::STATUS_ACTIVE
        ) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'Your OJT Assignment is not active. Attendance cannot be recorded.',
                ],
                422
            );
        }


        $validated =
            $this->validateAttendanceInput(
                $request
            );


        $uploadedSelfie =
            $request->file(
                'selfie'
            );


        if (! $uploadedSelfie) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'A selfie is required before recording Time Out.',
                ],
                422
            );
        }


        $now =
            CarbonImmutable::now(
                self::BUSINESS_TIMEZONE
            );


        $today =
            $now->toDateString();


        $selfiePath =
            null;


        try {
            $result =
                DB::transaction(
                    function () use (
                        $user,
                        $assignment,
                        $validated,
                        $uploadedSelfie,
                        $today,
                        $now,
                        &$selfiePath
                    ): array {
                        $attendance =
                            AttendanceRecord::query()
                                ->where(
                                    'ojt_assignment_id',
                                    $assignment->id
                                )
                                ->where(
                                    'attendance_date',
                                    $today
                                )
                                ->lockForUpdate()
                                ->first();


                        if (! $attendance) {
                            return [
                                'success' =>
                                    false,

                                'status' =>
                                    409,

                                'message' =>
                                    'You must Time In before you can Time Out.',
                            ];
                        }


                        if (
                            in_array(
                                $attendance->status,
                                [
                                    AttendanceRecord::STATUS_PENDING,
                                    AttendanceRecord::STATUS_VALIDATED,
                                    AttendanceRecord::STATUS_REJECTED,
                                ],
                                true
                            )
                        ) {
                            return [
                                'success' =>
                                    false,

                                'status' =>
                                    409,

                                'message' =>
                                    'This attendance record has already been submitted or reviewed and can no longer be modified.',
                            ];
                        }


                        $sessions =
                            AttendanceSession::query()
                                ->where(
                                    'attendance_record_id',
                                    $attendance->id
                                )
                                ->orderBy(
                                    'session_number'
                                )
                                ->lockForUpdate()
                                ->get();


                        if (
                            $sessions->isEmpty()
                            && $attendance->time_in !== null
                        ) {
                            return [
                                'success' =>
                                    false,

                                'status' =>
                                    409,

                                'message' =>
                                    'This attendance record was created before the multi-session update and cannot be modified using the new session workflow.',
                            ];
                        }


                        $openSession =
                            $sessions->first(
                                function (
                                    AttendanceSession $session
                                ): bool {
                                    return
                                        $session->time_out
                                        === null;
                                }
                            );


                        if (! $openSession) {
                            return [
                                'success' =>
                                    false,

                                'status' =>
                                    409,

                                'message' =>
                                    'There is no open attendance session to Time Out.',
                            ];
                        }


                        $selfiePath =
                            $uploadedSelfie
                                ->store(
                                    'attendance/'
                                    .$user->id
                                    .'/'
                                    .$today
                                    .'/session-'
                                    .$openSession
                                        ->session_number
                                    .'/time-out',
                                    'local'
                                );


                        if (! $selfiePath) {
                            return [
                                'success' =>
                                    false,

                                'status' =>
                                    500,

                                'message' =>
                                    'Unable to save your Time Out selfie.',
                            ];
                        }


                        $renderedSeconds =
                            max(
                                0,
                                $now->getTimestamp()
                                -
                                $openSession
                                    ->time_in
                                    ->getTimestamp()
                            );


                        $renderedMinutes =
                            intdiv(
                                $renderedSeconds,
                                60
                            );


                        $openSession->update([
                            'time_out' =>
                                $now,

                            'time_out_latitude' =>
                                $validated[
                                    'latitude'
                                ],

                            'time_out_longitude' =>
                                $validated[
                                    'longitude'
                                ],

                            'time_out_accuracy' =>
                                $validated[
                                    'accuracy'
                                ],

                            'time_out_selfie_path' =>
                                $selfiePath,

                            'rendered_minutes' =>
                                $renderedMinutes,
                        ]);


                        $dailyRenderedMinutes =
                            (int)
                            AttendanceSession::query()
                                ->where(
                                    'attendance_record_id',
                                    $attendance->id
                                )
                                ->sum(
                                    'rendered_minutes'
                                );


                        $sessionCount =
                            AttendanceSession::query()
                                ->where(
                                    'attendance_record_id',
                                    $attendance->id
                                )
                                ->count();


                        $dayComplete =
                            $sessionCount
                            >=
                            AttendanceSession::MAX_SESSIONS_PER_DAY;


                        $dailyStatus =
                            $dayComplete
                                ? AttendanceRecord::STATUS_PENDING
                                : AttendanceRecord::STATUS_IN_PROGRESS;


                        $attendance->update([
                            'time_out' =>
                                $now,

                            'time_out_latitude' =>
                                $validated[
                                    'latitude'
                                ],

                            'time_out_longitude' =>
                                $validated[
                                    'longitude'
                                ],

                            'time_out_accuracy' =>
                                $validated[
                                    'accuracy'
                                ],

                            'time_out_selfie_path' =>
                                $selfiePath,

                            'rendered_minutes' =>
                                $dailyRenderedMinutes,

                            'status' =>
                                $dailyStatus,
                        ]);


                        $message =
                            $dayComplete
                                ? 'Afternoon Session Time Out recorded successfully. Today\'s attendance is now waiting for Supervisor validation.'
                                : 'Morning Session Time Out recorded successfully. You may Time In again for your Afternoon Session.';


                        return [
                            'success' =>
                                true,

                            'status' =>
                                200,

                            'message' =>
                                $message,

                            'attendance_id' =>
                                $attendance->id,

                            'session_id' =>
                                $openSession->id,

                            'session_number' =>
                                $openSession
                                    ->session_number,

                            'session_label' =>
                                $openSession
                                    ->sessionLabel(),

                            'rendered_minutes' =>
                                $renderedMinutes,

                            'daily_rendered_minutes' =>
                                $dailyRenderedMinutes,

                            'day_complete' =>
                                $dayComplete,

                            'recorded_at' =>
                                $now
                                    ->toIso8601String(),
                        ];
                    }
                );
        } catch (Throwable $exception) {
            if ($selfiePath) {
                Storage::disk(
                    'local'
                )->delete(
                    $selfiePath
                );
            }


            report(
                $exception
            );


            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'Unable to record Time Out. Please try again.',
                ],
                500
            );
        }


        if (! $result['success']) {
            if ($selfiePath) {
                Storage::disk(
                    'local'
                )->delete(
                    $selfiePath
                );
            }


            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        $result[
                            'message'
                        ],
                ],
                $result['status']
            );
        }


        return response()->json(
            $result,
            $result['status']
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Resolve Student Context
    |--------------------------------------------------------------------------
    */

    private function resolveStudentContext(
        Request $request
    ): array|JsonResponse {
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


        $profile =
            $user->studentProfile;


        $assignment =
            null;


        if (
            $profile instanceof StudentProfile
        ) {
            $assignment =
                $profile
                    ->ojtAssignments()
                    ->with([
                        'company',
                        'supervisor',
                    ])
                    ->where(
                        'status',
                        OjtAssignment::STATUS_ACTIVE
                    )
                    ->latest(
                        'start_date'
                    )
                    ->latest('id')
                    ->first();


            if (! $assignment) {
                $assignment =
                    $profile
                        ->ojtAssignments()
                        ->with([
                            'company',
                            'supervisor',
                        ])
                        ->whereIn(
                            'status',
                            OjtAssignment::OPEN_STATUSES
                        )
                        ->latest(
                            'start_date'
                        )
                        ->latest('id')
                        ->first();
            }
        }


        return [
            $user,
            $profile,
            $assignment,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Validate GPS and Selfie
    |--------------------------------------------------------------------------
    */

    private function validateAttendanceInput(
        Request $request
    ): array {
        return $request->validate([
            'latitude' => [
                'required',
                'numeric',
                'between:-90,90',
            ],

            'longitude' => [
                'required',
                'numeric',
                'between:-180,180',
            ],

            'accuracy' => [
                'required',
                'numeric',
                'min:0',
                'max:100000',
            ],

            'selfie' => [
                'required',
                'file',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);
    }
}