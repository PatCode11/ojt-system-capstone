<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\DailyWorkLog;
use App\Models\OjtAssignment;
use App\Models\StudentProfile;
use App\Models\User;
use App\Services\StudentAssignmentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WorkLogController extends Controller
{
    /**
     * Display Work Log history.
     */
    public function index(
        Request $request,
        StudentAssignmentService $assignmentService
    ): View {
        $user =
            $this->student(
                $request
            );

        $profile =
            $user->studentProfile;

        $assignment = null;

        $workLogs =
            DailyWorkLog::query()
                ->whereRaw('1 = 0')
                ->paginate(10);

        $availableAttendanceCount = 0;

        $canCreateWorkLog = false;

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

            if (
                $requestedAssignmentId !== null
                && ! $assignment
            ) {
                abort(404);
            }
        }

        if ($assignment) {
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
                    ->latest('submitted_at')
                    ->paginate(10)
                    ->withQueryString();

            /*
            |--------------------------------------------------------------------------
            | Only ACTIVE Assignments Can Create Work Logs
            |--------------------------------------------------------------------------
            */

            $canCreateWorkLog =
                $assignment->status
                === OjtAssignment::STATUS_ACTIVE;

            if ($canCreateWorkLog) {
                $availableAttendanceCount =
                    AttendanceRecord::query()
                        ->where(
                            'ojt_assignment_id',
                            $assignment->id
                        )
                        ->whereNotNull('time_out')
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
                        ->count();
            }
        }

        return view(
            'student.work-logs.index',
            compact(
                'profile',
                'assignment',
                'workLogs',
                'availableAttendanceCount',
                'canCreateWorkLog'
            )
        );
    }

    /**
     * Create Work Log.
     */
    public function create(
        Request $request,
        StudentAssignmentService $assignmentService
    ): View|RedirectResponse {
        $user =
            $this->student(
                $request
            );

        $profile =
            $user->studentProfile;

        if (! $profile) {
            return redirect()
                ->route(
                    'student.profile.edit'
                )
                ->with(
                    'error',
                    'Please complete your Student Profile first.'
                );
        }

        $assignment =
            $assignmentService
                ->activeAssignment(
                    $profile
                );

        if (! $assignment) {
            return redirect()
                ->route(
                    'student.work-logs.index'
                )
                ->with(
                    'error',
                    'New Daily Work Logs are only allowed while your OJT Assignment is Active.'
                );
        }

        $attendanceRecords =
            AttendanceRecord::query()
                ->where(
                    'ojt_assignment_id',
                    $assignment->id
                )
                ->whereNotNull('time_out')
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
                ->latest('attendance_date')
                ->get();

        return view(
            'student.work-logs.create',
            compact(
                'assignment',
                'attendanceRecords'
            )
        );
    }

    /**
     * Store Work Log.
     */
    public function store(
        Request $request,
        StudentAssignmentService $assignmentService
    ): RedirectResponse {
        $user =
            $this->student(
                $request
            );

        $profile =
            $user->studentProfile;

        if (! $profile) {
            return back()->with(
                'error',
                'Please complete your Student Profile first.'
            );
        }

        $assignment =
            $assignmentService
                ->activeAssignment(
                    $profile
                );

        if (! $assignment) {
            return redirect()
                ->route(
                    'student.work-logs.index'
                )
                ->with(
                    'error',
                    'Your OJT Assignment is not Active. New Work Logs are disabled.'
                );
        }

        $validated =
            $this->validateWorkLog(
                $request
            );

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
                ->whereNotNull('time_out')
                ->whereIn(
                    'status',
                    [
                        AttendanceRecord::STATUS_PENDING,
                        AttendanceRecord::STATUS_VALIDATED,
                    ]
                )
                ->first();

        if (! $attendance) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'The selected Attendance Record cannot be used.'
                );
        }

        if (
            $attendance
                ->dailyWorkLog()
                ->exists()
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'A Daily Work Log already exists for this attendance record.'
                );
        }

        DailyWorkLog::create([
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

        return redirect()
            ->route(
                'student.work-logs.index'
            )
            ->with(
                'success',
                'Daily Work Log submitted successfully.'
            );
    }

    /**
     * Edit rejected Work Log.
     */
    public function edit(
        Request $request,
        DailyWorkLog $workLog,
        StudentAssignmentService $assignmentService
    ): View {
        $user =
            $this->student(
                $request
            );

        $profile =
            $user->studentProfile;

        if (! $profile) {
            abort(403);
        }

        $assignment =
            $assignmentService
                ->activeAssignment(
                    $profile
                );

        /*
        |--------------------------------------------------------------------------
        | Completed Assignments Are Read-Only
        |--------------------------------------------------------------------------
        */

        if (! $assignment) {
            abort(
                403,
                'Completed or inactive OJT Assignment records are read-only.'
            );
        }

        $this->authorizeWorkLog(
            $workLog,
            $assignment
        );

        if (
            $workLog->status
            !== DailyWorkLog::STATUS_REJECTED
        ) {
            abort(403);
        }

        $workLog->load(
            'attendanceRecord'
        );

        return view(
            'student.work-logs.edit',
            compact(
                'workLog',
                'assignment'
            )
        );
    }

    /**
     * Resubmit rejected Work Log.
     */
    public function update(
        Request $request,
        DailyWorkLog $workLog,
        StudentAssignmentService $assignmentService
    ): RedirectResponse {
        $user =
            $this->student(
                $request
            );

        $profile =
            $user->studentProfile;

        if (! $profile) {
            abort(403);
        }

        $assignment =
            $assignmentService
                ->activeAssignment(
                    $profile
                );

        if (! $assignment) {
            abort(
                403,
                'Completed or inactive OJT Assignment records are read-only.'
            );
        }

        $this->authorizeWorkLog(
            $workLog,
            $assignment
        );

        if (
            $workLog->status
            !== DailyWorkLog::STATUS_REJECTED
        ) {
            abort(403);
        }

        $validated =
            $request->validate([
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
            ]);

        $workLog->update([
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

        return redirect()
            ->route(
                'student.work-logs.index'
            )
            ->with(
                'success',
                'Daily Work Log corrected and resubmitted successfully.'
            );
    }

    /**
     * Validate new Work Log input.
     */
    private function validateWorkLog(
        Request $request
    ): array {
        return $request->validate([
            'attendance_record_id' => [
                'required',
                'integer',
                'exists:attendance_records,id',
            ],

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
        ]);
    }

    /**
     * Authenticated Student.
     */
    private function student(
        Request $request
    ): User {
        $user = $request->user();

        if (
            ! $user instanceof User
            || ! $user->isStudent()
        ) {
            abort(403);
        }

        return $user;
    }

    /**
     * Work Log ownership.
     */
    private function authorizeWorkLog(
        DailyWorkLog $workLog,
        OjtAssignment $assignment
    ): void {
        $workLog->loadMissing(
            'attendanceRecord'
        );

        if (
            (int) $workLog
                ->attendanceRecord
                ->ojt_assignment_id
            !==
            (int) $assignment->id
        ) {
            abort(403);
        }
    }
}