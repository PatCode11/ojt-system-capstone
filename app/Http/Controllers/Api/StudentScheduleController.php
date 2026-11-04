<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\OjtAssignment;
use App\Models\StudentProfile;
use App\Models\User;
use App\Services\StudentAssignmentService;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class StudentScheduleController extends Controller
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
    | Student Schedule
    |--------------------------------------------------------------------------
    |
    | This endpoint does NOT create or manage OJT schedules.
    |
    | It presents a read-only OJT training calendar using information that
    | already exists in the system:
    |
    | - OJT Assignment start date
    | - OJT Assignment end date
    | - Company
    | - Supervisor
    | - Attendance history
    |
    | This avoids inventing working days or working hours that are not stored
    | in the database.
    |
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
            ||
            ! $user->isStudent()
        ) {
            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'Student access only.',
                ],
                403
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Active Account Protection
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
                    'success' =>
                        false,

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


        /*
        |--------------------------------------------------------------------------
        | Resolve Current Assignment
        |--------------------------------------------------------------------------
        |
        | Use the same assignment service already used by the Timesheet.
        |
        */

        if (
            $profile
            instanceof StudentProfile
        ) {
            $assignment =
                $assignmentService
                    ->displayAssignment(
                        $profile,
                        null
                    );
        }


        $now =
            CarbonImmutable::now(
                self::BUSINESS_TIMEZONE
            );


        /*
        |--------------------------------------------------------------------------
        | No Assignment
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
                        $profile
                            ?->student_number,

                    'program' =>
                        $profile
                            ?->program,
                ],

                'assignment' =>
                    null,

                'summary' => [
                    'period_days' =>
                        0,

                    'days_remaining' =>
                        0,

                    'attendance_days' =>
                        0,

                    'validated_days' =>
                        0,

                    'pending_days' =>
                        0,

                    'rejected_days' =>
                        0,

                    'in_progress_days' =>
                        0,

                    'total_events' =>
                        0,
                ],

                'next_event' =>
                    null,

                'events' =>
                    [],
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Assignment Relationships
        |--------------------------------------------------------------------------
        */

        $assignment->loadMissing([
            'company',
            'supervisor',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Training Period
        |--------------------------------------------------------------------------
        */

        $startDate =
            $assignment
                ->start_date
                ? CarbonImmutable::parse(
                    $assignment
                        ->start_date
                        ->toDateString(),
                    self::BUSINESS_TIMEZONE
                )
                : null;


        $endDate =
            $assignment
                ->end_date
                ? CarbonImmutable::parse(
                    $assignment
                        ->end_date
                        ->toDateString(),
                    self::BUSINESS_TIMEZONE
                )
                : null;


        $today =
            $now->startOfDay();


        $periodDays =
            (
                $startDate
                &&
                $endDate
                &&
                $endDate->greaterThanOrEqualTo(
                    $startDate
                )
            )
                ? (
                    $startDate
                        ->diffInDays(
                            $endDate
                        )
                    + 1
                )
                : 0;


        $daysRemaining =
            (
                $endDate
                &&
                $endDate->greaterThanOrEqualTo(
                    $today
                )
            )
                ? (
                    $today
                        ->diffInDays(
                            $endDate
                        )
                    + 1
                )
                : 0;


        /*
        |--------------------------------------------------------------------------
        | Attendance Records
        |--------------------------------------------------------------------------
        */

        $attendanceRecords =
            AttendanceRecord::query()
                ->where(
                    'ojt_assignment_id',
                    $assignment->id
                )
                ->orderBy(
                    'attendance_date'
                )
                ->orderBy('id')
                ->get([
                    'id',
                    'attendance_date',
                    'time_in',
                    'time_out',
                    'rendered_minutes',
                    'status',
                    'supervisor_remarks',
                ]);


        /*
        |--------------------------------------------------------------------------
        | Attendance Summary
        |--------------------------------------------------------------------------
        */

        $validatedDays =
            $attendanceRecords
                ->where(
                    'status',
                    AttendanceRecord::STATUS_VALIDATED
                )
                ->count();


        $pendingDays =
            $attendanceRecords
                ->where(
                    'status',
                    AttendanceRecord::STATUS_PENDING
                )
                ->count();


        $rejectedDays =
            $attendanceRecords
                ->where(
                    'status',
                    AttendanceRecord::STATUS_REJECTED
                )
                ->count();


        $inProgressDays =
            $attendanceRecords
                ->where(
                    'status',
                    AttendanceRecord::STATUS_IN_PROGRESS
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Calendar Events
        |--------------------------------------------------------------------------
        */

        $events =
            collect();


        /*
        |--------------------------------------------------------------------------
        | OJT Start
        |--------------------------------------------------------------------------
        */

        if ($startDate) {
            $events->push([
                'id' =>
                    'assignment-start-'.$assignment->id,

                'type' =>
                    'placement_start',

                'date' =>
                    $startDate
                        ->toDateString(),

                'title' =>
                    'OJT Training Begins',

                'description' =>
                    'Official beginning of your assigned OJT training period.',

                'time_label' =>
                    null,

                'location' =>
                    $assignment
                        ->company
                        ?->name,

                'company_address' =>
                    $assignment
                        ->company
                        ?->address,

                'status' =>
                    $assignment->status,

                'status_label' =>
                    $this->statusLabel(
                        $assignment->status
                    ),

                'rendered_minutes' =>
                    0,

                'attendance_record_id' =>
                    null,

                'supervisor_remarks' =>
                    null,

                'sort_order' =>
                    1,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Recorded Attendance Days
        |--------------------------------------------------------------------------
        */

        foreach (
            $attendanceRecords
            as $record
        ) {
            $timeIn =
                $record
                    ->time_in
                    ?->timezone(
                        self::BUSINESS_TIMEZONE
                    )
                    ->format(
                        'g:i A'
                    );


            $timeOut =
                $record
                    ->time_out
                    ?->timezone(
                        self::BUSINESS_TIMEZONE
                    )
                    ->format(
                        'g:i A'
                    );


            $timeLabel =
                match (true) {
                    $timeIn !== null
                    &&
                    $timeOut !== null =>
                        $timeIn
                        .' – '
                        .$timeOut,

                    $timeIn !== null =>
                        $timeIn
                        .' – In Progress',

                    default =>
                        null,
                };


            $events->push([
                'id' =>
                    'attendance-'.$record->id,

                'type' =>
                    'attendance',

                'date' =>
                    $record
                        ->attendance_date
                        ?->toDateString(),

                'title' =>
                    'Recorded OJT Day',

                'description' =>
                    'Attendance recorded for your assigned OJT placement.',

                'time_label' =>
                    $timeLabel,

                'location' =>
                    $assignment
                        ->company
                        ?->name,

                'company_address' =>
                    $assignment
                        ->company
                        ?->address,

                'status' =>
                    $record->status,

                'status_label' =>
                    $this->attendanceStatusLabel(
                        $record->status
                    ),

                'rendered_minutes' =>
                    (int) (
                        $record
                            ->rendered_minutes
                        ?? 0
                    ),

                'attendance_record_id' =>
                    $record->id,

                'supervisor_remarks' =>
                    $record
                        ->supervisor_remarks,

                'sort_order' =>
                    2,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | OJT End
        |--------------------------------------------------------------------------
        */

        if ($endDate) {
            $events->push([
                'id' =>
                    'assignment-end-'.$assignment->id,

                'type' =>
                    'placement_end',

                'date' =>
                    $endDate
                        ->toDateString(),

                'title' =>
                    'Expected OJT Completion',

                'description' =>
                    'Expected end of your assigned OJT training period.',

                'time_label' =>
                    null,

                'location' =>
                    $assignment
                        ->company
                        ?->name,

                'company_address' =>
                    $assignment
                        ->company
                        ?->address,

                'status' =>
                    $assignment->status,

                'status_label' =>
                    $this->statusLabel(
                        $assignment->status
                    ),

                'rendered_minutes' =>
                    0,

                'attendance_record_id' =>
                    null,

                'supervisor_remarks' =>
                    null,

                'sort_order' =>
                    3,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Sort Events
        |--------------------------------------------------------------------------
        */

        $events =
            $events
                ->sortBy(
                    function (
                        array $event
                    ): string {
                        return sprintf(
                            '%s-%02d',
                            $event['date']
                                ?? '9999-12-31',
                            $event['sort_order']
                                ?? 9
                        );
                    }
                )
                ->values()
                ->map(
                    function (
                        array $event
                    ): array {
                        unset(
                            $event[
                                'sort_order'
                            ]
                        );


                        return $event;
                    }
                );


        /*
        |--------------------------------------------------------------------------
        | Next Event
        |--------------------------------------------------------------------------
        |
        | "Next" means the first dated milestone on or after today.
        |
        | We do not fabricate future training days.
        |
        */

        $nextEvent =
            $events
                ->first(
                    function (
                        array $event
                    ) use (
                        $today
                    ): bool {
                        if (
                            empty(
                                $event['date']
                            )
                        ) {
                            return false;
                        }


                        $eventDate =
                            CarbonImmutable::parse(
                                $event['date'],
                                self::BUSINESS_TIMEZONE
                            );


                        return $eventDate
                            ->greaterThanOrEqualTo(
                                $today
                            );
                    }
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
                $now
                    ->toIso8601String(),

            'student' => [
                'id' =>
                    $user->id,

                'name' =>
                    $user->name,

                'student_number' =>
                    $profile
                        ?->student_number,

                'program' =>
                    $profile
                        ?->program,
            ],

            'assignment' => [
                'id' =>
                    $assignment->id,

                'status' =>
                    $assignment->status,

                'status_label' =>
                    $this->statusLabel(
                        $assignment->status
                    ),

                'required_hours' =>
                    (int) (
                        $assignment
                            ->required_hours
                        ?? 0
                    ),

                'start_date' =>
                    $startDate
                        ?->toDateString(),

                'end_date' =>
                    $endDate
                        ?->toDateString(),

                'notes' =>
                    $assignment
                        ->notes,

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

            'summary' => [
                'period_days' =>
                    (int) $periodDays,

                'days_remaining' =>
                    (int) $daysRemaining,

                'attendance_days' =>
                    $attendanceRecords
                        ->count(),

                'validated_days' =>
                    $validatedDays,

                'pending_days' =>
                    $pendingDays,

                'rejected_days' =>
                    $rejectedDays,

                'in_progress_days' =>
                    $inProgressDays,

                'total_events' =>
                    $events
                        ->count(),
            ],

            'next_event' =>
                $nextEvent,

            'events' =>
                $events,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Assignment Status Label
    |--------------------------------------------------------------------------
    */

    private function statusLabel(
        ?string $status
    ): string {
        return match ($status) {
            OjtAssignment::STATUS_PENDING =>
                'Pending',

            OjtAssignment::STATUS_ACTIVE =>
                'Active',

            OjtAssignment::STATUS_COMPLETED =>
                'Completed',

            OjtAssignment::STATUS_CANCELLED =>
                'Cancelled',

            default =>
                'Unknown',
        };
    }


    /*
    |--------------------------------------------------------------------------
    | Attendance Status Label
    |--------------------------------------------------------------------------
    */

    private function attendanceStatusLabel(
        ?string $status
    ): string {
        return match ($status) {
            AttendanceRecord::STATUS_IN_PROGRESS =>
                'In Progress',

            AttendanceRecord::STATUS_PENDING =>
                'Pending Review',

            AttendanceRecord::STATUS_VALIDATED =>
                'Validated',

            AttendanceRecord::STATUS_REJECTED =>
                'Rejected',

            default =>
                'Unknown',
        };
    }
}