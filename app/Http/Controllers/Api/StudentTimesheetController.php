<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\OjtAssignment;
use App\Models\StudentProfile;
use App\Models\User;
use App\Services\StudentAssignmentService;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class StudentTimesheetController extends Controller
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
    | Student Timesheet
    |--------------------------------------------------------------------------
    */

    public function show(
        Request $request,
        StudentAssignmentService $assignmentService
    ): JsonResponse {
        $user =
            $request->user();


        /*
        |--------------------------------------------------------------------------
        | Student Security
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | Student Profile
        |--------------------------------------------------------------------------
        */

        $profile =
            $user->studentProfile;


        $assignment =
            null;


        $requestedAssignmentId =
            $request->integer(
                'assignment'
            ) ?: null;


        /*
        |--------------------------------------------------------------------------
        | Selected / Current / Completed Assignment
        |--------------------------------------------------------------------------
        |
        | Reuse the same StudentAssignmentService used by the existing web
        | TimesheetController so mobile and web resolve the same assignment.
        |
        */

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


        /*
        |--------------------------------------------------------------------------
        | Empty Timesheet
        |--------------------------------------------------------------------------
        */

        if (! $assignment) {
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

                'assignment' =>
                    null,

                'summary' =>
                    $this->emptySummary(),

                'monthly' => [
                    'label' =>
                        $now->format(
                            'F Y'
                        ),

                    'year' =>
                        (int) $now->format(
                            'Y'
                        ),

                    'month' =>
                        (int) $now->format(
                            'n'
                        ),

                    'records' =>
                        0,

                    'validated' =>
                        0,

                    'pending' =>
                        0,

                    'rejected' =>
                        0,

                    'in_progress' =>
                        0,
                ],

                'records' => [
                    'data' =>
                        [],

                    'current_page' =>
                        1,

                    'last_page' =>
                        1,

                    'per_page' =>
                        15,

                    'total' =>
                        0,

                    'has_more' =>
                        false,
                ],
            ]);
        }


        $assignment->loadMissing([
            'company',
            'supervisor',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Official Timesheet Summary
        |--------------------------------------------------------------------------
        |
        | Only Supervisor-validated parent AttendanceRecord rendered_minutes
        | contribute to official OJT progress.
        |
        */

        $requiredHours =
            (int) $assignment
                ->required_hours;


        $requiredMinutes =
            $requiredHours
            * 60;


        $validatedMinutes =
            (int)
            AttendanceRecord::query()
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


        $remainingMinutes =
            max(
                0,
                $requiredMinutes
                - $validatedMinutes
            );


        $progressPercentage =
            $requiredMinutes > 0
                ? min(
                    100,
                    round(
                        (
                            $validatedMinutes
                            /
                            $requiredMinutes
                        )
                        * 100,
                        1
                    )
                )
                : 0.0;


        /*
        |--------------------------------------------------------------------------
        | Attendance Counts
        |--------------------------------------------------------------------------
        */

        $baseAttendanceQuery =
            AttendanceRecord::query()
                ->where(
                    'ojt_assignment_id',
                    $assignment->id
                );


        $totalRecords =
            (clone $baseAttendanceQuery)
                ->count();


        $inProgressRecords =
            (clone $baseAttendanceQuery)
                ->where(
                    'status',
                    AttendanceRecord::STATUS_IN_PROGRESS
                )
                ->count();


        $pendingRecords =
            (clone $baseAttendanceQuery)
                ->where(
                    'status',
                    AttendanceRecord::STATUS_PENDING
                )
                ->count();


        $validatedRecords =
            (clone $baseAttendanceQuery)
                ->where(
                    'status',
                    AttendanceRecord::STATUS_VALIDATED
                )
                ->count();


        $rejectedRecords =
            (clone $baseAttendanceQuery)
                ->where(
                    'status',
                    AttendanceRecord::STATUS_REJECTED
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Current Month Snapshot
        |--------------------------------------------------------------------------
        */

        $monthStart =
            $now
                ->startOfMonth()
                ->toDateString();


        $monthEnd =
            $now
                ->endOfMonth()
                ->toDateString();


        $monthlyQuery =
            AttendanceRecord::query()
                ->where(
                    'ojt_assignment_id',
                    $assignment->id
                )
                ->whereBetween(
                    'attendance_date',
                    [
                        $monthStart,
                        $monthEnd,
                    ]
                );


        $monthlyRecords =
            (clone $monthlyQuery)
                ->count();


        $monthlyValidated =
            (clone $monthlyQuery)
                ->where(
                    'status',
                    AttendanceRecord::STATUS_VALIDATED
                )
                ->count();


        $monthlyPending =
            (clone $monthlyQuery)
                ->where(
                    'status',
                    AttendanceRecord::STATUS_PENDING
                )
                ->count();


        $monthlyRejected =
            (clone $monthlyQuery)
                ->where(
                    'status',
                    AttendanceRecord::STATUS_REJECTED
                )
                ->count();


        $monthlyInProgress =
            (clone $monthlyQuery)
                ->where(
                    'status',
                    AttendanceRecord::STATUS_IN_PROGRESS
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Attendance History
        |--------------------------------------------------------------------------
        |
        | Keep the same 15-record page size used by the web Timesheet.
        |
        */

        $records =
            AttendanceRecord::query()
                ->where(
                    'ojt_assignment_id',
                    $assignment->id
                )
                ->latest(
                    'attendance_date'
                )
                ->latest('id')
                ->paginate(15)
                ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Split-Shift Sessions
        |--------------------------------------------------------------------------
        |
        | AttendanceRecord does not need a new relationship for this API.
        | Fetch the existing AttendanceSession rows and group them by parent.
        |
        */

        $attendanceIds =
            $records
                ->getCollection()
                ->pluck('id');


        $sessionsByAttendance =
            collect();


        if (
            $attendanceIds
                ->isNotEmpty()
        ) {
            $sessionsByAttendance =
                AttendanceSession::query()
                    ->whereIn(
                        'attendance_record_id',
                        $attendanceIds
                    )
                    ->orderBy(
                        'attendance_record_id'
                    )
                    ->orderBy(
                        'session_number'
                    )
                    ->get()
                    ->groupBy(
                        'attendance_record_id'
                    );
        }


        $recordData =
            $records
                ->getCollection()
                ->map(
                    function (
                        AttendanceRecord $record
                    ) use (
                        $sessionsByAttendance
                    ): array {
                        $sessions =
                            $sessionsByAttendance
                                ->get(
                                    $record->id,
                                    collect()
                                );


                        $gpsVerified =
                            $record
                                ->time_in_latitude
                                !== null
                            &&
                            $record
                                ->time_in_longitude
                                !== null
                            &&
                            $record
                                ->time_in_selfie_path
                                !== null;


                        return [
                            'id' =>
                                $record->id,

                            'attendance_date' =>
                                $record
                                    ->attendance_date
                                    ?->toDateString(),

                            'time_in' =>
                                $record
                                    ->time_in
                                    ?->toIso8601String(),

                            'time_out' =>
                                $record
                                    ->time_out
                                    ?->toIso8601String(),

                            'rendered_minutes' =>
                                (int) (
                                    $record
                                        ->rendered_minutes
                                    ?? 0
                                ),

                            'status' =>
                                $record->status,

                            'supervisor_remarks' =>
                                $record
                                    ->supervisor_remarks,

                            'validated_at' =>
                                $record
                                    ->validated_at
                                    ?->toIso8601String(),

                            'gps_verified' =>
                                $gpsVerified,

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

                'required_hours' =>
                    $requiredHours,

                'start_date' =>
                    $assignment
                        ->start_date
                        ?->toDateString(),

                'end_date' =>
                    $assignment
                        ->end_date
                        ?->toDateString(),

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

            'summary' => [
                'required_hours' =>
                    $requiredHours,

                'required_minutes' =>
                    $requiredMinutes,

                'validated_minutes' =>
                    $validatedMinutes,

                'validated_hours_label' =>
                    $this->formatMinutes(
                        $validatedMinutes
                    ),

                'remaining_minutes' =>
                    $remainingMinutes,

                'remaining_hours_label' =>
                    $this->formatMinutes(
                        $remainingMinutes
                    ),

                'progress_percentage' =>
                    $progressPercentage,

                'total_records' =>
                    $totalRecords,

                'in_progress_records' =>
                    $inProgressRecords,

                'pending_records' =>
                    $pendingRecords,

                'validated_records' =>
                    $validatedRecords,

                'rejected_records' =>
                    $rejectedRecords,
            ],

            'monthly' => [
                'label' =>
                    $now->format(
                        'F Y'
                    ),

                'year' =>
                    (int) $now->format(
                        'Y'
                    ),

                'month' =>
                    (int) $now->format(
                        'n'
                    ),

                'records' =>
                    $monthlyRecords,

                'validated' =>
                    $monthlyValidated,

                'pending' =>
                    $monthlyPending,

                'rejected' =>
                    $monthlyRejected,

                'in_progress' =>
                    $monthlyInProgress,
            ],

            'records' => [
                'data' =>
                    $recordData,

                'current_page' =>
                    $records
                        ->currentPage(),

                'last_page' =>
                    $records
                        ->lastPage(),

                'per_page' =>
                    $records
                        ->perPage(),

                'total' =>
                    $records
                        ->total(),

                'has_more' =>
                    $records
                        ->hasMorePages(),
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Empty Summary
    |--------------------------------------------------------------------------
    */

    private function emptySummary(): array
    {
        return [
            'required_hours' =>
                0,

            'required_minutes' =>
                0,

            'validated_minutes' =>
                0,

            'validated_hours_label' =>
                '0h 00m',

            'remaining_minutes' =>
                0,

            'remaining_hours_label' =>
                '0h 00m',

            'progress_percentage' =>
                0.0,

            'total_records' =>
                0,

            'in_progress_records' =>
                0,

            'pending_records' =>
                0,

            'validated_records' =>
                0,

            'rejected_records' =>
                0,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Format Minutes
    |--------------------------------------------------------------------------
    */

    private function formatMinutes(
        int $minutes
    ): string {
        $hours =
            intdiv(
                max(
                    0,
                    $minutes
                ),
                60
            );


        $remainingMinutes =
            max(
                0,
                $minutes
            )
            % 60;


        return sprintf(
            '%dh %02dm',
            $hours,
            $remainingMinutes
        );
    }
}
