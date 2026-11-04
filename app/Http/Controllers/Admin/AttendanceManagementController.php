<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceCorrection;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\OjtAssignment;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AttendanceManagementController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Business Timezone
    |--------------------------------------------------------------------------
    */

    private const BUSINESS_TIMEZONE = 'Asia/Manila';


    /*
    |--------------------------------------------------------------------------
    | Attendance Management Index
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        $search = trim(
            (string) $request->query(
                'search',
                ''
            )
        );

        $status = trim(
            (string) $request->query(
                'status',
                ''
            )
        );

        $attendanceDate = trim(
            (string) $request->query(
                'date',
                ''
            )
        );


        /*
        |--------------------------------------------------------------------------
        | Attendance Query
        |--------------------------------------------------------------------------
        */

        $query = AttendanceRecord::query()
            ->with([
                'ojtAssignment.studentProfile.user',
                'ojtAssignment.company',
                'ojtAssignment.supervisor',
                'validator',
            ]);


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {
            $query->where(
                function ($attendanceQuery) use ($search): void {
                    $attendanceQuery
                        ->whereHas(
                            'ojtAssignment.studentProfile.user',
                            function ($userQuery) use ($search): void {
                                $userQuery->where(
                                    'name',
                                    'like',
                                    '%'.$search.'%'
                                );
                            }
                        )
                        ->orWhereHas(
                            'ojtAssignment.studentProfile',
                            function ($profileQuery) use ($search): void {
                                $profileQuery->where(
                                    'student_number',
                                    'like',
                                    '%'.$search.'%'
                                );
                            }
                        )
                        ->orWhereHas(
                            'ojtAssignment.company',
                            function ($companyQuery) use ($search): void {
                                $companyQuery->where(
                                    'name',
                                    'like',
                                    '%'.$search.'%'
                                );
                            }
                        );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        $allowedStatuses = [
            AttendanceRecord::STATUS_IN_PROGRESS,
            AttendanceRecord::STATUS_PENDING,
            AttendanceRecord::STATUS_VALIDATED,
            AttendanceRecord::STATUS_REJECTED,
        ];

        if (
            $status !== ''
            &&
            in_array(
                $status,
                $allowedStatuses,
                true
            )
        ) {
            $query->where(
                'status',
                $status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        */

        if (
            $attendanceDate !== ''
            &&
            preg_match(
                '/^\d{4}-\d{2}-\d{2}$/',
                $attendanceDate
            ) === 1
        ) {
            $query->whereDate(
                'attendance_date',
                $attendanceDate
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $attendanceRecords = $query
            ->latest('attendance_date')
            ->latest('id')
            ->paginate(20)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Attach Morning / Afternoon Sessions
        |--------------------------------------------------------------------------
        */

        $this->attachSessionsToPaginator(
            $attendanceRecords
        );


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalRecords = AttendanceRecord::query()
            ->count();

        $inProgressCount = AttendanceRecord::query()
            ->where(
                'status',
                AttendanceRecord::STATUS_IN_PROGRESS
            )
            ->count();

        $pendingCount = AttendanceRecord::query()
            ->where(
                'status',
                AttendanceRecord::STATUS_PENDING
            )
            ->count();

        $validatedCount = AttendanceRecord::query()
            ->where(
                'status',
                AttendanceRecord::STATUS_VALIDATED
            )
            ->count();

        $rejectedCount = AttendanceRecord::query()
            ->where(
                'status',
                AttendanceRecord::STATUS_REJECTED
            )
            ->count();

        $correctionCount = AttendanceCorrection::query()
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Return Page
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.attendance.index',
            compact(
                'attendanceRecords',
                'search',
                'status',
                'attendanceDate',
                'totalRecords',
                'inProgressCount',
                'pendingCount',
                'validatedCount',
                'rejectedCount',
                'correctionCount'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Show One Attendance Record
    |--------------------------------------------------------------------------
    */

    public function show(
        AttendanceRecord $attendance
    ): View {
        /*
        |--------------------------------------------------------------------------
        | Load Relationships
        |--------------------------------------------------------------------------
        */

        $attendance->load([
            'ojtAssignment.studentProfile.user',
            'ojtAssignment.company',
            'ojtAssignment.supervisor',
            'validator',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Attach Sessions
        |--------------------------------------------------------------------------
        */

        $this->attachSessions(
            collect([
                $attendance,
            ])
        );


        /*
        |--------------------------------------------------------------------------
        | Correction History
        |--------------------------------------------------------------------------
        */

        $corrections = AttendanceCorrection::query()
            ->with([
                'correctedBy',
            ])
            ->where(
                'attendance_record_id',
                $attendance->id
            )
            ->latest('created_at')
            ->latest('id')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Assignment Progress
        |--------------------------------------------------------------------------
        */

        $assignment = $attendance->ojtAssignment;

        $validatedMinutes = 0;
        $requiredMinutes = 0;
        $remainingMinutes = 0;
        $progressPercentage = 0.0;


        if ($assignment) {
            /*
            |--------------------------------------------------------------------------
            | Only Validated Attendance Counts
            |--------------------------------------------------------------------------
            */

            $validatedMinutes = (int) $assignment
                ->attendanceRecords()
                ->where(
                    'status',
                    AttendanceRecord::STATUS_VALIDATED
                )
                ->sum(
                    'rendered_minutes'
                );


            /*
            |--------------------------------------------------------------------------
            | Required Minutes
            |--------------------------------------------------------------------------
            */

            $requiredMinutes = max(
                0,
                (int) $assignment->required_hours * 60
            );


            /*
            |--------------------------------------------------------------------------
            | Remaining Minutes
            |--------------------------------------------------------------------------
            */

            $remainingMinutes = max(
                0,
                $requiredMinutes - $validatedMinutes
            );


            /*
            |--------------------------------------------------------------------------
            | Progress Percentage
            |--------------------------------------------------------------------------
            */

            if ($requiredMinutes > 0) {
                $progressPercentage = min(
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
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Return Detail Page
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.attendance.show',
            compact(
                'attendance',
                'corrections',
                'validatedMinutes',
                'requiredMinutes',
                'remainingMinutes',
                'progressPercentage'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Attendance Session
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    |
    | This method can return either:
    |
    | - View
    | - RedirectResponse
    |
    | That is why the return type is:
    |
    | View|RedirectResponse
    |
    */

    public function editSession(
        AttendanceSession $session
    ): View|RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Load Parent Attendance
        |--------------------------------------------------------------------------
        */

        $session->load([
            'attendanceRecord.ojtAssignment.studentProfile.user',
            'attendanceRecord.ojtAssignment.company',
            'attendanceRecord.ojtAssignment.supervisor',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Attendance Record
        |--------------------------------------------------------------------------
        */

        $attendance = $session->attendanceRecord;

        if (! $attendance) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | OJT Assignment
        |--------------------------------------------------------------------------
        */

        $assignment = $attendance->ojtAssignment;

        if (! $assignment) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | Completed Assignments Are Locked
        |--------------------------------------------------------------------------
        */

        if (
            $assignment->status
            ===
            OjtAssignment::STATUS_COMPLETED
        ) {
            return redirect()
                ->route(
                    'admin.attendance.show',
                    $attendance
                )
                ->with(
                    'error',
                    'This OJT Assignment has already been completed. Its attendance history is locked from correction.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Do Not Modify Live Attendance
        |--------------------------------------------------------------------------
        */

        if (
            $attendance->status
            ===
            AttendanceRecord::STATUS_IN_PROGRESS
        ) {
            return redirect()
                ->route(
                    'admin.attendance.show',
                    $attendance
                )
                ->with(
                    'error',
                    'This attendance day is still in progress. Wait until the Student has completed the attendance day before making an administrative correction.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Session Must Be Completed
        |--------------------------------------------------------------------------
        */

        if (
            $session->time_out
            === null
        ) {
            return redirect()
                ->route(
                    'admin.attendance.show',
                    $attendance
                )
                ->with(
                    'error',
                    'An open attendance session cannot be administratively corrected.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Session Correction History
        |--------------------------------------------------------------------------
        */

        $correctionHistory = AttendanceCorrection::query()
            ->with([
                'correctedBy',
            ])
            ->where(
                'attendance_session_id',
                $session->id
            )
            ->latest('created_at')
            ->latest('id')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Return Edit Page
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.attendance.edit-session',
            compact(
                'session',
                'attendance',
                'assignment',
                'correctionHistory'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Attendance Session
    |--------------------------------------------------------------------------
    */

    public function updateSession(
        Request $request,
        AttendanceSession $session
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Normalize Reason
        |--------------------------------------------------------------------------
        */

        $request->merge([
            'reason' => trim(
                (string) $request->input(
                    'reason'
                )
            ),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Validate Admin Input
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'time_in' => [
                'required',
                'date_format:H:i',
            ],

            'time_out' => [
                'required',
                'date_format:H:i',
            ],

            'reason' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Perform Correction Inside Transaction
        |--------------------------------------------------------------------------
        */

        $attendanceId = DB::transaction(
            function () use (
                $request,
                $session,
                $validated
            ): int {
                /*
                |--------------------------------------------------------------------------
                | Lock Session
                |--------------------------------------------------------------------------
                */

                $lockedSession = AttendanceSession::query()
                    ->where(
                        'id',
                        $session->id
                    )
                    ->lockForUpdate()
                    ->firstOrFail();


                /*
                |--------------------------------------------------------------------------
                | Lock Attendance Record
                |--------------------------------------------------------------------------
                */

                $attendance = AttendanceRecord::query()
                    ->where(
                        'id',
                        $lockedSession->attendance_record_id
                    )
                    ->lockForUpdate()
                    ->firstOrFail();


                /*
                |--------------------------------------------------------------------------
                | Lock OJT Assignment
                |--------------------------------------------------------------------------
                */

                $assignment = OjtAssignment::query()
                    ->with([
                        'studentProfile.user',
                    ])
                    ->where(
                        'id',
                        $attendance->ojt_assignment_id
                    )
                    ->lockForUpdate()
                    ->firstOrFail();


                /*
                |--------------------------------------------------------------------------
                | Completed Assignment Protection
                |--------------------------------------------------------------------------
                */

                if (
                    $assignment->status
                    ===
                    OjtAssignment::STATUS_COMPLETED
                ) {
                    throw ValidationException::withMessages([
                        'time_in' =>
                            'This OJT Assignment has already been completed. Attendance corrections are locked.',
                    ]);
                }


                /*
                |--------------------------------------------------------------------------
                | Live Attendance Protection
                |--------------------------------------------------------------------------
                */

                if (
                    $attendance->status
                    ===
                    AttendanceRecord::STATUS_IN_PROGRESS
                ) {
                    throw ValidationException::withMessages([
                        'time_in' =>
                            'This attendance day is still in progress and cannot be corrected yet.',
                    ]);
                }


                /*
                |--------------------------------------------------------------------------
                | Open Session Protection
                |--------------------------------------------------------------------------
                */

                if (
                    $lockedSession->time_out
                    === null
                ) {
                    throw ValidationException::withMessages([
                        'time_out' =>
                            'An open attendance session cannot be corrected.',
                    ]);
                }


                /*
                |--------------------------------------------------------------------------
                | Attendance Date
                |--------------------------------------------------------------------------
                */

                $attendanceDate = CarbonImmutable::parse(
                    $attendance->attendance_date,
                    self::BUSINESS_TIMEZONE
                )->format(
                    'Y-m-d'
                );


                /*
                |--------------------------------------------------------------------------
                | Corrected Time In
                |--------------------------------------------------------------------------
                */

                $correctedTimeIn =
                    CarbonImmutable::createFromFormat(
                        'Y-m-d H:i',
                        $attendanceDate
                        .' '
                        .$validated['time_in'],
                        self::BUSINESS_TIMEZONE
                    );


                /*
                |--------------------------------------------------------------------------
                | Corrected Time Out
                |--------------------------------------------------------------------------
                */

                $correctedTimeOut =
                    CarbonImmutable::createFromFormat(
                        'Y-m-d H:i',
                        $attendanceDate
                        .' '
                        .$validated['time_out'],
                        self::BUSINESS_TIMEZONE
                    );


                /*
                |--------------------------------------------------------------------------
                | Time Out Must Be Later
                |--------------------------------------------------------------------------
                */

                if (
                    $correctedTimeOut
                        ->lessThanOrEqualTo(
                            $correctedTimeIn
                        )
                ) {
                    throw ValidationException::withMessages([
                        'time_out' =>
                            'Time Out must be later than Time In.',
                    ]);
                }


                /*
                |--------------------------------------------------------------------------
                | Prevent Future Timestamps
                |--------------------------------------------------------------------------
                */

                $now = CarbonImmutable::now(
                    self::BUSINESS_TIMEZONE
                );

                if (
                    $correctedTimeIn->greaterThan($now)
                    ||
                    $correctedTimeOut->greaterThan($now)
                ) {
                    throw ValidationException::withMessages([
                        'time_out' =>
                            'Attendance timestamps cannot be set in the future.',
                    ]);
                }


                /*
                |--------------------------------------------------------------------------
                | Lock Other Sessions
                |--------------------------------------------------------------------------
                */

                $otherSessions = AttendanceSession::query()
                    ->where(
                        'attendance_record_id',
                        $attendance->id
                    )
                    ->where(
                        'id',
                        '<>',
                        $lockedSession->id
                    )
                    ->orderBy(
                        'session_number'
                    )
                    ->lockForUpdate()
                    ->get();


                /*
                |--------------------------------------------------------------------------
                | Prevent Session Overlap
                |--------------------------------------------------------------------------
                */

                foreach ($otherSessions as $otherSession) {
                    if (
                        ! $otherSession->time_in
                        ||
                        ! $otherSession->time_out
                    ) {
                        continue;
                    }

                    $otherTimeIn = CarbonImmutable::parse(
                        $otherSession->time_in
                    );

                    $otherTimeOut = CarbonImmutable::parse(
                        $otherSession->time_out
                    );

                    $overlaps =
                        $correctedTimeIn->lessThan(
                            $otherTimeOut
                        )
                        &&
                        $correctedTimeOut->greaterThan(
                            $otherTimeIn
                        );

                    if ($overlaps) {
                        throw ValidationException::withMessages([
                            'time_in' =>
                                'The corrected session overlaps another attendance session on the same date.',
                        ]);
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | Calculate Corrected Rendered Minutes
                |--------------------------------------------------------------------------
                */

                $correctedRenderedMinutes = max(
                    0,
                    (int) floor(
                        $correctedTimeIn
                            ->diffInSeconds(
                                $correctedTimeOut
                            )
                        /
                        60
                    )
                );


                /*
                |--------------------------------------------------------------------------
                | Save Original Values
                |--------------------------------------------------------------------------
                */

                $originalTimeIn =
                    $lockedSession->time_in;

                $originalTimeOut =
                    $lockedSession->time_out;

                $originalRenderedMinutes =
                    (int) $lockedSession->rendered_minutes;

                $originalDailyRenderedMinutes =
                    (int) $attendance->rendered_minutes;


                /*
                |--------------------------------------------------------------------------
                | Detect No Changes
                |--------------------------------------------------------------------------
                */

                $originalTimeInMinute =
                    $originalTimeIn
                        ? CarbonImmutable::parse(
                            $originalTimeIn
                        )->format(
                            'Y-m-d H:i'
                        )
                        : null;

                $originalTimeOutMinute =
                    $originalTimeOut
                        ? CarbonImmutable::parse(
                            $originalTimeOut
                        )->format(
                            'Y-m-d H:i'
                        )
                        : null;


                if (
                    $originalTimeInMinute
                    ===
                    $correctedTimeIn->format(
                        'Y-m-d H:i'
                    )
                    &&
                    $originalTimeOutMinute
                    ===
                    $correctedTimeOut->format(
                        'Y-m-d H:i'
                    )
                ) {
                    throw ValidationException::withMessages([
                        'time_in' =>
                            'No attendance changes were detected.',
                    ]);
                }


                /*
                |--------------------------------------------------------------------------
                | Update Attendance Session
                |--------------------------------------------------------------------------
                */

                $lockedSession->update([
                    'time_in' =>
                        $correctedTimeIn,

                    'time_out' =>
                        $correctedTimeOut,

                    'rendered_minutes' =>
                        $correctedRenderedMinutes,
                ]);


                /*
                |--------------------------------------------------------------------------
                | Reload All Daily Sessions
                |--------------------------------------------------------------------------
                */

                $allSessions = AttendanceSession::query()
                    ->where(
                        'attendance_record_id',
                        $attendance->id
                    )
                    ->orderBy(
                        'session_number'
                    )
                    ->lockForUpdate()
                    ->get();


                /*
                |--------------------------------------------------------------------------
                | New Daily Rendered Total
                |--------------------------------------------------------------------------
                */

                $correctedDailyRenderedMinutes =
                    (int) $allSessions->sum(
                        'rendered_minutes'
                    );


                /*
                |--------------------------------------------------------------------------
                | First Session
                |--------------------------------------------------------------------------
                */

                $firstSession = $allSessions
                    ->sortBy(
                        'session_number'
                    )
                    ->first();


                /*
                |--------------------------------------------------------------------------
                | Last Session
                |--------------------------------------------------------------------------
                */

                $lastSession = $allSessions
                    ->sortByDesc(
                        'session_number'
                    )
                    ->first();


                /*
                |--------------------------------------------------------------------------
                | Synchronize Daily Attendance Parent
                |--------------------------------------------------------------------------
                */

                if ($firstSession) {
                    $attendance->time_in =
                        $firstSession->time_in;
                }

                if ($lastSession) {
                    $attendance->time_out =
                        $lastSession->time_out;
                }

                $attendance->rendered_minutes =
                    $correctedDailyRenderedMinutes;


                /*
                |--------------------------------------------------------------------------
                | Require Supervisor Revalidation
                |--------------------------------------------------------------------------
                |
                | If previously validated, the approval applied to the old
                | timestamps.
                |
                | A correction therefore sends the attendance back to Pending.
                |
                */

                $attendance->status =
                    AttendanceRecord::STATUS_PENDING;

                $attendance->supervisor_remarks =
                    null;

                $attendance->validated_by =
                    null;

                $attendance->validated_at =
                    null;

                $attendance->save();


                /*
                |--------------------------------------------------------------------------
                | Student User
                |--------------------------------------------------------------------------
                */

                $studentUserId =
                    $assignment
                        ->studentProfile
                        ?->user_id;


                /*
                |--------------------------------------------------------------------------
                | Authenticated Administrator
                |--------------------------------------------------------------------------
                */

                $admin = $request->user();

                if (! $admin) {
                    abort(403);
                }


                /*
                |--------------------------------------------------------------------------
                | Save Correction Audit Record
                |--------------------------------------------------------------------------
                */

                AttendanceCorrection::create([
                    'attendance_record_id' =>
                        $attendance->id,

                    'attendance_session_id' =>
                        $lockedSession->id,

                    'ojt_assignment_id' =>
                        $assignment->id,

                    'student_user_id' =>
                        $studentUserId,

                    'corrected_by' =>
                        $admin->id,

                    'attendance_date' =>
                        $attendanceDate,

                    'session_number' =>
                        $lockedSession->session_number,

                    'original_time_in' =>
                        $originalTimeIn,

                    'original_time_out' =>
                        $originalTimeOut,

                    'original_rendered_minutes' =>
                        $originalRenderedMinutes,

                    'corrected_time_in' =>
                        $correctedTimeIn,

                    'corrected_time_out' =>
                        $correctedTimeOut,

                    'corrected_rendered_minutes' =>
                        $correctedRenderedMinutes,

                    'original_daily_rendered_minutes' =>
                        $originalDailyRenderedMinutes,

                    'corrected_daily_rendered_minutes' =>
                        $correctedDailyRenderedMinutes,

                    'reason' =>
                        $validated['reason'],

                    'ip_address' =>
                        $request->ip(),

                    'user_agent' =>
                        mb_substr(
                            (string) $request->userAgent(),
                            0,
                            1000
                        ),
                ]);


                /*
                |--------------------------------------------------------------------------
                | Return Attendance ID
                |--------------------------------------------------------------------------
                */

                return $attendance->id;
            }
        );


        /*
        |--------------------------------------------------------------------------
        | Redirect Back to Attendance Detail
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.attendance.show',
                $attendanceId
            )
            ->with(
                'success',
                'Attendance corrected successfully. The rendered time was recalculated and the attendance was returned to Pending Review for Supervisor validation.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Attach Sessions to Pagination
    |--------------------------------------------------------------------------
    */

    private function attachSessionsToPaginator(
        LengthAwarePaginator $attendanceRecords
    ): void {
        $records = collect(
            $attendanceRecords->items()
        );

        $this->attachSessions(
            $records
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Attach Attendance Sessions
    |--------------------------------------------------------------------------
    */

    private function attachSessions(
        Collection $attendanceRecords
    ): void {
        /*
        |--------------------------------------------------------------------------
        | No Attendance Records
        |--------------------------------------------------------------------------
        */

        if ($attendanceRecords->isEmpty()) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Attendance IDs
        |--------------------------------------------------------------------------
        */

        $attendanceIds = $attendanceRecords
            ->pluck('id')
            ->filter()
            ->values();

        if ($attendanceIds->isEmpty()) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Load Sessions in One Query
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | Attach Session Collection
        |--------------------------------------------------------------------------
        */

        foreach ($attendanceRecords as $attendance) {
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
}