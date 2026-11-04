<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\OjtAssignment;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class StudentDashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Student Dashboard
    |--------------------------------------------------------------------------
    */

    public function show(
        Request $request
    ): JsonResponse {
        $user = $request->user();


        /*
        |--------------------------------------------------------------------------
        | Student Access Only
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


        /*
        |--------------------------------------------------------------------------
        | Active Account Only
        |--------------------------------------------------------------------------
        */

        if (
            ! $user->isActive()
            || $user->isArchived()
        ) {
            $currentAccessToken =
                $user->currentAccessToken();


            if (
                $currentAccessToken
                instanceof PersonalAccessToken
            ) {
                $currentAccessToken->delete();
            }


            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'This account is no longer available.',
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
            $user
                ->studentProfile()
                ->first();


        if (! $profile) {
            return response()->json(
                [
                    'success' => false,

                    'message' =>
                        'Student profile not found.',
                ],
                404
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Current / Most Relevant OJT Assignment
        |--------------------------------------------------------------------------
        |
        | Priority:
        |
        | 1. Active
        | 2. Pending
        | 3. Completed
        |
        | Cancelled assignments are not shown as the current assignment.
        |
        */

        $assignment =
            $profile
                ->ojtAssignments()
                ->with([
                    'company',
                    'supervisor',
                ])
                ->where(
                    'status',
                    '!=',
                    OjtAssignment::STATUS_CANCELLED
                )
                ->orderByRaw(
                    '
                        CASE
                            WHEN status = ? THEN 0
                            WHEN status = ? THEN 1
                            WHEN status = ? THEN 2
                            ELSE 3
                        END
                    ',
                    [
                        OjtAssignment::STATUS_ACTIVE,
                        OjtAssignment::STATUS_PENDING,
                        OjtAssignment::STATUS_COMPLETED,
                    ]
                )
                ->orderByDesc('id')
                ->first();


        /*
        |--------------------------------------------------------------------------
        | Student Information
        |--------------------------------------------------------------------------
        */

        $studentData = [
            'id' =>
                $user->id,

            'name' =>
                $user->name,

            'email' =>
                $user->email,

            'student_number' =>
                $profile->student_number,

            'program' =>
                $profile->program,

            'year_level' =>
                $profile->year_level,

            'section' =>
                $profile->section,

            'contact_number' =>
                $profile->contact_number,
        ];


        /*
        |--------------------------------------------------------------------------
        | No OJT Assignment
        |--------------------------------------------------------------------------
        */

        if (! $assignment) {
            return response()->json([
                'success' => true,

                'student' =>
                    $studentData,

                'assignment' =>
                    null,

                'attendance_summary' => [
                    'total_records' => 0,

                    'validated' => 0,

                    'pending' => 0,

                    'in_progress' => 0,

                    'rejected' => 0,
                ],

                'today_attendance' =>
                    null,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Attendance Query
        |--------------------------------------------------------------------------
        */

        $attendanceQuery =
            AttendanceRecord::query()
                ->where(
                    'ojt_assignment_id',
                    $assignment->id
                );


        /*
        |--------------------------------------------------------------------------
        | Official Validated OJT Progress
        |--------------------------------------------------------------------------
        |
        | Only Supervisor-validated attendance contributes to the official
        | rendered OJT progress.
        |
        */

        $validatedMinutes =
            (int) (
                clone $attendanceQuery
            )
                ->where(
                    'status',
                    AttendanceRecord::STATUS_VALIDATED
                )
                ->sum(
                    'rendered_minutes'
                );


        $requiredMinutes =
            max(
                0,
                (
                    (int) $assignment->required_hours
                ) * 60
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
                            / $requiredMinutes
                        ) * 100,
                        1
                    )
                )
                : 0;


        /*
        |--------------------------------------------------------------------------
        | Attendance Summary
        |--------------------------------------------------------------------------
        */

        $totalRecords =
            (clone $attendanceQuery)
                ->count();


        $validatedCount =
            (clone $attendanceQuery)
                ->where(
                    'status',
                    AttendanceRecord::STATUS_VALIDATED
                )
                ->count();


        $pendingCount =
            (clone $attendanceQuery)
                ->where(
                    'status',
                    AttendanceRecord::STATUS_PENDING
                )
                ->count();


        $inProgressCount =
            (clone $attendanceQuery)
                ->where(
                    'status',
                    AttendanceRecord::STATUS_IN_PROGRESS
                )
                ->count();


        $rejectedCount =
            (clone $attendanceQuery)
                ->where(
                    'status',
                    AttendanceRecord::STATUS_REJECTED
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Today's Attendance
        |--------------------------------------------------------------------------
        */

        $today =
            now(
                'Asia/Manila'
            )->toDateString();


        $todayAttendance =
            (clone $attendanceQuery)
                ->whereDate(
                    'attendance_date',
                    $today
                )
                ->first();


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'student' =>
                $studentData,

            'assignment' => [
                'id' =>
                    $assignment->id,

                'status' =>
                    $assignment->status,

                'required_hours' =>
                    (int) $assignment->required_hours,

                'start_date' =>
                    $assignment
                        ->start_date
                        ?->format('Y-m-d'),

                'end_date' =>
                    $assignment
                        ->end_date
                        ?->format('Y-m-d'),

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

                    'contact_person' =>
                        $assignment
                            ->company
                            ?->contact_person,

                    'contact_number' =>
                        $assignment
                            ->company
                            ?->contact_number,
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

                    'email' =>
                        $assignment
                            ->supervisor
                            ?->email,
                ],

                'progress' => [
                    'validated_minutes' =>
                        $validatedMinutes,

                    'required_minutes' =>
                        $requiredMinutes,

                    'remaining_minutes' =>
                        $remainingMinutes,

                    'percentage' =>
                        $progressPercentage,
                ],
            ],

            'attendance_summary' => [
                'total_records' =>
                    $totalRecords,

                'validated' =>
                    $validatedCount,

                'pending' =>
                    $pendingCount,

                'in_progress' =>
                    $inProgressCount,

                'rejected' =>
                    $rejectedCount,
            ],

            'today_attendance' =>
                $todayAttendance
                    ? [
                        'id' =>
                            $todayAttendance->id,

                        'attendance_date' =>
                            $todayAttendance
                                ->attendance_date
                                ?->format('Y-m-d'),

                        'status' =>
                            $todayAttendance->status,

                        'rendered_minutes' =>
                            $todayAttendance
                                ->rendered_minutes,
                    ]
                    : null,
        ]);
    }
}