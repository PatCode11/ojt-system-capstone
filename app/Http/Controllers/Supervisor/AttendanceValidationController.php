<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AttendanceValidationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Attendance Validation Dashboard
    |--------------------------------------------------------------------------
    |
    | Loads all attendance records belonging to Students supervised by the
    | authenticated Supervisor.
    |
    | This includes:
    | - In Progress
    | - Pending
    | - Validated
    | - Rejected
    |
    | Morning and Afternoon Attendance Sessions are attached separately.
    |
    */

    public function index(
        Request $request
    ): View {
        $supervisor =
            $this->supervisor(
                $request
            );


        /*
        |--------------------------------------------------------------------------
        | Supervisor Attendance Records
        |--------------------------------------------------------------------------
        */

        $attendanceRecords =
            AttendanceRecord::query()
                ->with([
                    'ojtAssignment.studentProfile.user',
                    'ojtAssignment.company',
                    'validator',
                ])
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
                ->latest(
                    'attendance_date'
                )
                ->latest('id')
                ->get();


        /*
        |--------------------------------------------------------------------------
        | Attach Morning / Afternoon Sessions
        |--------------------------------------------------------------------------
        |
        | We load AttendanceSession directly instead of depending on the
        | AttendanceRecord model relationship. This keeps this controller
        | compatible even with older attendance records.
        |
        */

        $this->attachSessions(
            $attendanceRecords
        );


        /*
        |--------------------------------------------------------------------------
        | Status Collections
        |--------------------------------------------------------------------------
        */

        $pendingRecords =
            $attendanceRecords
                ->where(
                    'status',
                    AttendanceRecord::STATUS_PENDING
                )
                ->values();

        $validatedRecords =
            $attendanceRecords
                ->where(
                    'status',
                    AttendanceRecord::STATUS_VALIDATED
                )
                ->values();

        $rejectedRecords =
            $attendanceRecords
                ->where(
                    'status',
                    AttendanceRecord::STATUS_REJECTED
                )
                ->values();

        $inProgressRecords =
            $attendanceRecords
                ->where(
                    'status',
                    AttendanceRecord::STATUS_IN_PROGRESS
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | Validated Rendered Minutes
        |--------------------------------------------------------------------------
        |
        | Only Supervisor-validated attendance contributes to this dashboard
        | total.
        |
        */

        $validatedMinutes =
            (int)
            $validatedRecords
                ->sum(
                    'rendered_minutes'
                );

        $validatedHours =
            $validatedMinutes / 60;


        /*
        |--------------------------------------------------------------------------
        | Supervised OJT Placements
        |--------------------------------------------------------------------------
        */

        $supervisedAssignmentCount =
            $supervisor
                ->supervisedAssignments()
                ->count();


        return view(
            'supervisor.validations.index',
            compact(
                'supervisor',
                'attendanceRecords',
                'pendingRecords',
                'validatedRecords',
                'rejectedRecords',
                'inProgressRecords',
                'validatedMinutes',
                'validatedHours',
                'supervisedAssignmentCount'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Display One Attendance Submission
    |--------------------------------------------------------------------------
    */

    public function show(
        Request $request,
        AttendanceRecord $attendance
    ): View {
        $supervisor =
            $this->supervisor(
                $request
            );

        $this->authorizeAttendance(
            $attendance,
            $supervisor
        );


        /*
        |--------------------------------------------------------------------------
        | Attendance Relationships
        |--------------------------------------------------------------------------
        */

        $attendance->load([
            'ojtAssignment.studentProfile.user',
            'ojtAssignment.company',
            'validator',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Attach Morning / Afternoon Sessions
        |--------------------------------------------------------------------------
        */

        $this->attachSessions(
            collect([
                $attendance,
            ])
        );


        return view(
            'supervisor.validations.show',
            compact(
                'attendance'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Approve Attendance
    |--------------------------------------------------------------------------
    |
    | Approval remains DAILY.
    |
    | Morning and Afternoon are evidence sessions underneath the same daily
    | AttendanceRecord.
    |
    */

    public function approve(
        Request $request,
        AttendanceRecord $attendance
    ): RedirectResponse {
        $supervisor =
            $this->supervisor(
                $request
            );

        $this->authorizeAttendance(
            $attendance,
            $supervisor
        );


        /*
        |--------------------------------------------------------------------------
        | Normalize Remarks
        |--------------------------------------------------------------------------
        |
        | Supports both:
        |
        | supervisor_remarks
        | remarks
        |
        | This maintains compatibility with older Supervisor views.
        |
        */

        $this->normalizeRemarks(
            $request
        );


        /*
        |--------------------------------------------------------------------------
        | Optional Supervisor Remarks
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([
                'supervisor_remarks' => [
                    'nullable',
                    'string',
                    'max:2000',
                ],
            ]);


        /*
        |--------------------------------------------------------------------------
        | Validate Attendance Safely
        |--------------------------------------------------------------------------
        */

        $result =
            DB::transaction(
                function () use (
                    $attendance,
                    $supervisor,
                    $validated
                ): array {

                    /*
                    |--------------------------------------------------------------------------
                    | Lock Daily Attendance
                    |--------------------------------------------------------------------------
                    */

                    $record =
                        AttendanceRecord::query()
                            ->where(
                                'id',
                                $attendance->id
                            )
                            ->lockForUpdate()
                            ->firstOrFail();


                    /*
                    |--------------------------------------------------------------------------
                    | Only Pending Attendance Can Be Processed
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $record->status
                        !==
                        AttendanceRecord::STATUS_PENDING
                    ) {
                        return [
                            'success' =>
                                false,

                            'message' =>
                                'This attendance record has already been processed.',
                        ];
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Lock Attendance Sessions
                    |--------------------------------------------------------------------------
                    */

                    $sessions =
                        AttendanceSession::query()
                            ->where(
                                'attendance_record_id',
                                $record->id
                            )
                            ->orderBy(
                                'session_number'
                            )
                            ->lockForUpdate()
                            ->get();


                    /*
                    |--------------------------------------------------------------------------
                    | New Morning / Afternoon Workflow
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $sessions->isNotEmpty()
                    ) {

                        /*
                        |--------------------------------------------------------------------------
                        | Require Both Sessions
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $sessions->count()
                            <
                            AttendanceSession::MAX_SESSIONS_PER_DAY
                        ) {
                            return [
                                'success' =>
                                    false,

                                'message' =>
                                    'This attendance day is incomplete. Both Morning and Afternoon Sessions must be completed before validation.',
                            ];
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Every Session Must Have Time Out
                        |--------------------------------------------------------------------------
                        */

                        $hasOpenSession =
                            $sessions->contains(
                                function (
                                    AttendanceSession $session
                                ): bool {
                                    return
                                        $session->time_out
                                        === null;
                                }
                            );

                        if ($hasOpenSession) {
                            return [
                                'success' =>
                                    false,

                                'message' =>
                                    'This attendance day still contains an open session and cannot be validated.',
                            ];
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Recalculate Daily Rendered Time
                        |--------------------------------------------------------------------------
                        |
                        | Do not blindly trust a stale parent total.
                        |
                        */

                        $dailyRenderedMinutes =
                            (int)
                            $sessions->sum(
                                'rendered_minutes'
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | Synchronize Daily Parent
                        |--------------------------------------------------------------------------
                        */

                        $lastSession =
                            $sessions
                                ->sortByDesc(
                                    'session_number'
                                )
                                ->first();

                        $record->rendered_minutes =
                            $dailyRenderedMinutes;

                        if ($lastSession) {
                            $record->time_out =
                                $lastSession->time_out;

                            $record->time_out_latitude =
                                $lastSession
                                    ->time_out_latitude;

                            $record->time_out_longitude =
                                $lastSession
                                    ->time_out_longitude;

                            $record->time_out_accuracy =
                                $lastSession
                                    ->time_out_accuracy;

                            $record->time_out_selfie_path =
                                $lastSession
                                    ->time_out_selfie_path;
                        }

                    } else {

                        /*
                        |--------------------------------------------------------------------------
                        | Legacy Attendance
                        |--------------------------------------------------------------------------
                        |
                        | Older records created before AttendanceSession was
                        | introduced remain validatable.
                        |
                        */

                        if (
                            $record->time_out
                            === null
                            ||
                            $record->rendered_minutes
                            === null
                        ) {
                            return [
                                'success' =>
                                    false,

                                'message' =>
                                    'This attendance record is incomplete and cannot be validated.',
                            ];
                        }
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Final Approval
                    |--------------------------------------------------------------------------
                    */

                    $record->status =
                        AttendanceRecord::STATUS_VALIDATED;

                    $record->supervisor_remarks =
                        $validated[
                            'supervisor_remarks'
                        ]
                        ?? null;

                    $record->validated_by =
                        $supervisor->id;

                    $record->validated_at =
                        now();

                    $record->save();


                    return [
                        'success' =>
                            true,

                        'message' =>
                            'Attendance validated successfully. The rendered time is now approved.',
                    ];
                }
            );


        if (
            ! $result['success']
        ) {
            return back()->with(
                'error',
                $result['message']
            );
        }


        return redirect()
            ->route(
                'supervisor.validations.index'
            )
            ->with(
                'success',
                $result['message']
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Reject Attendance
    |--------------------------------------------------------------------------
    */

    public function reject(
        Request $request,
        AttendanceRecord $attendance
    ): RedirectResponse {
        $supervisor =
            $this->supervisor(
                $request
            );

        $this->authorizeAttendance(
            $attendance,
            $supervisor
        );


        /*
        |--------------------------------------------------------------------------
        | Normalize Remarks
        |--------------------------------------------------------------------------
        */

        $this->normalizeRemarks(
            $request
        );


        /*
        |--------------------------------------------------------------------------
        | Rejection Requires Explanation
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([
                'supervisor_remarks' => [
                    'required',
                    'string',
                    'min:3',
                    'max:2000',
                ],
            ]);


        /*
        |--------------------------------------------------------------------------
        | Reject Safely
        |--------------------------------------------------------------------------
        */

        $result =
            DB::transaction(
                function () use (
                    $attendance,
                    $supervisor,
                    $validated
                ): array {

                    $record =
                        AttendanceRecord::query()
                            ->where(
                                'id',
                                $attendance->id
                            )
                            ->lockForUpdate()
                            ->firstOrFail();


                    /*
                    |--------------------------------------------------------------------------
                    | Only Pending Records Can Be Rejected
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $record->status
                        !==
                        AttendanceRecord::STATUS_PENDING
                    ) {
                        return [
                            'success' =>
                                false,

                            'message' =>
                                'This attendance record has already been processed.',
                        ];
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Reject Daily Attendance
                    |--------------------------------------------------------------------------
                    */

                    $record->update([
                        'status' =>
                            AttendanceRecord::STATUS_REJECTED,

                        'supervisor_remarks' =>
                            $validated[
                                'supervisor_remarks'
                            ],

                        'validated_by' =>
                            $supervisor->id,

                        'validated_at' =>
                            now(),
                    ]);


                    return [
                        'success' =>
                            true,

                        'message' =>
                            'Attendance rejected successfully.',
                    ];
                }
            );


        if (
            ! $result['success']
        ) {
            return back()->with(
                'error',
                $result['message']
            );
        }


        return redirect()
            ->route(
                'supervisor.validations.index'
            )
            ->with(
                'success',
                $result['message']
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Legacy Daily Attendance Selfie
    |--------------------------------------------------------------------------
    |
    | Keeps old attendance records accessible to the assigned Supervisor.
    |
    */

    public function selfie(
        Request $request,
        AttendanceRecord $attendance,
        string $type
    ): Response {
        $supervisor =
            $this->supervisor(
                $request
            );

        $this->authorizeAttendance(
            $attendance,
            $supervisor
        );


        /*
        |--------------------------------------------------------------------------
        | Select Legacy Selfie
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


        if (! $path) {
            abort(404);
        }


        return $this->privateImageResponse(
            $path
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Attendance Session Selfie
    |--------------------------------------------------------------------------
    |
    | Securely displays Morning / Afternoon Time In and Time Out selfies.
    |
    */

    public function sessionSelfie(
        Request $request,
        AttendanceSession $session,
        string $type
    ): Response {
        $supervisor =
            $this->supervisor(
                $request
            );


        /*
        |--------------------------------------------------------------------------
        | Resolve Parent Attendance
        |--------------------------------------------------------------------------
        */

        $attendance =
            AttendanceRecord::query()
                ->with(
                    'ojtAssignment'
                )
                ->where(
                    'id',
                    $session
                        ->attendance_record_id
                )
                ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Supervisor Ownership Protection
        |--------------------------------------------------------------------------
        */

        $this->authorizeAttendance(
            $attendance,
            $supervisor
        );


        /*
        |--------------------------------------------------------------------------
        | Select Session Selfie
        |--------------------------------------------------------------------------
        */

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


        if (! $path) {
            abort(404);
        }


        return $this->privateImageResponse(
            $path
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Private Image Response
    |--------------------------------------------------------------------------
    |
    | Attendance selfies are stored on the private local disk.
    |
    | IMPORTANT:
    | We deliberately DO NOT call Storage::mimeType().
    |
    */

    private function privateImageResponse(
        string $path
    ): Response {
        $disk =
            Storage::disk(
                'local'
            );


        if (
            ! $disk->exists(
                $path
            )
        ) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | Safe MIME Mapping
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | Secure Inline Response
        |--------------------------------------------------------------------------
        */

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
    | Attach Attendance Sessions
    |--------------------------------------------------------------------------
    |
    | This avoids an N+1 query and supports AttendanceRecord instances even
    | when older code does not yet eager-load the sessions relationship.
    |
    */

    private function attachSessions(
        Collection $attendanceRecords
    ): void {
        if (
            $attendanceRecords->isEmpty()
        ) {
            return;
        }


        $attendanceIds =
            $attendanceRecords
                ->pluck('id')
                ->filter()
                ->values();


        if (
            $attendanceIds->isEmpty()
        ) {
            return;
        }


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


        foreach (
            $attendanceRecords
            as
            $attendance
        ) {
            $attendance->setRelation(
                'sessions',
                $sessionsByAttendance
                    ->get(
                        $attendance->id,
                        collect()
                    )
                    ->values()
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Normalize Supervisor Remarks
    |--------------------------------------------------------------------------
    |
    | Previous pages may submit:
    |
    | remarks
    |
    | while newer pages submit:
    |
    | supervisor_remarks
    |
    | Accepting both prevents an unnecessary breaking change.
    |
    */

    private function normalizeRemarks(
        Request $request
    ): void {
        $remarks =
            $request->input(
                'supervisor_remarks',
                $request->input(
                    'remarks'
                )
            );


        if (
            is_string(
                $remarks
            )
        ) {
            $remarks =
                trim(
                    $remarks
                );
        }


        $request->merge([
            'supervisor_remarks' =>
                $remarks === ''
                    ? null
                    : $remarks,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Resolve Authenticated Supervisor
    |--------------------------------------------------------------------------
    */

    private function supervisor(
        Request $request
    ): User {
        $user =
            $request->user();


        if (
            ! $user instanceof User
            ||
            ! $user->isSupervisor()
        ) {
            abort(403);
        }


        return $user;
    }


    /*
    |--------------------------------------------------------------------------
    | Attendance Authorization
    |--------------------------------------------------------------------------
    |
    | Prevents one Supervisor from accessing attendance belonging to another
    | Supervisor by changing an Attendance ID in the URL.
    |
    */

    private function authorizeAttendance(
        AttendanceRecord $attendance,
        User $supervisor
    ): void {
        $attendance->loadMissing(
            'ojtAssignment'
        );


        /*
        |--------------------------------------------------------------------------
        | Missing Assignment
        |--------------------------------------------------------------------------
        */

        if (
            ! $attendance
                ->ojtAssignment
        ) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | Ownership Check
        |--------------------------------------------------------------------------
        */

        if (
            (int)
            $attendance
                ->ojtAssignment
                ->supervisor_id
            !==
            (int)
            $supervisor
                ->id
        ) {
            abort(403);
        }
    }
}