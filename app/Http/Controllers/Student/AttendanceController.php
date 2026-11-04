<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\OjtAssignment;
use App\Models\StudentProfile;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class AttendanceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Business Timezone
    |--------------------------------------------------------------------------
    */

    private const BUSINESS_TIMEZONE = 'Asia/Manila';


    /*
    |--------------------------------------------------------------------------
    | Attendance Page
    |--------------------------------------------------------------------------
    */

    public function index(
        Request $request
    ): View {
        [
            $user,
            $profile,
            $activeAssignment,
        ] = $this->studentContext(
            $request
        );

        $today =
            CarbonImmutable::now(
                self::BUSINESS_TIMEZONE
            )->toDateString();


        /*
        |--------------------------------------------------------------------------
        | Default Page State
        |--------------------------------------------------------------------------
        */

        $todayAttendance = null;

        $todaySessions =
            collect();

        $openSession = null;

        $sessionCount = 0;

        $todayRenderedMinutes = 0;

        $canTimeIn = false;

        $canTimeOut = false;

        $dayComplete = false;

        $legacyToday = false;

        $nextSessionNumber =
            AttendanceSession::MORNING_SESSION;


        /*
        |--------------------------------------------------------------------------
        | Today's Daily Attendance Record
        |--------------------------------------------------------------------------
        */

        if ($activeAssignment) {
            $todayAttendance =
                AttendanceRecord::query()
                    ->where(
                        'ojt_assignment_id',
                        $activeAssignment->id
                    )
                    ->where(
                        'attendance_date',
                        $today
                    )
                    ->first();
        }


        /*
        |--------------------------------------------------------------------------
        | Today's Attendance Sessions
        |--------------------------------------------------------------------------
        */

        if ($todayAttendance) {
            $todaySessions =
                AttendanceSession::query()
                    ->where(
                        'attendance_record_id',
                        $todayAttendance->id
                    )
                    ->orderBy(
                        'session_number'
                    )
                    ->get();

            $sessionCount =
                $todaySessions->count();

            $todayRenderedMinutes =
                (int) $todaySessions
                    ->sum(
                        'rendered_minutes'
                    );

            $openSession =
                $todaySessions
                    ->first(
                        function (
                            AttendanceSession $session
                        ): bool {
                            return
                                $session->time_out
                                === null;
                        }
                    );


            /*
            |--------------------------------------------------------------------------
            | Legacy Attendance Detection
            |--------------------------------------------------------------------------
            |
            | Older records may contain attendance directly in attendance_records
            | without attendance_sessions.
            |
            | We preserve them instead of automatically modifying them.
            |
            */

            if (
                $sessionCount === 0
                && $todayAttendance->time_in !== null
            ) {
                $legacyToday = true;

                $todayRenderedMinutes =
                    (int) $todayAttendance
                        ->rendered_minutes;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Available Attendance Action
        |--------------------------------------------------------------------------
        */

        $assignmentIsActive =
            $activeAssignment
            &&
            $activeAssignment->status
                === OjtAssignment::STATUS_ACTIVE;

        if (
            $assignmentIsActive
            && ! $legacyToday
        ) {
            if ($openSession) {
                $canTimeOut = true;
            } elseif (
                $sessionCount
                <
                AttendanceSession::MAX_SESSIONS_PER_DAY
            ) {
                $canTimeIn = true;

                $nextSessionNumber =
                    $sessionCount + 1;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Determine Whether Day Is Complete
        |--------------------------------------------------------------------------
        */

        $dayComplete =
            $sessionCount
                >=
                AttendanceSession::MAX_SESSIONS_PER_DAY
            && $openSession === null;


        /*
        |--------------------------------------------------------------------------
        | Attendance History
        |--------------------------------------------------------------------------
        */

        if ($activeAssignment) {
            $records =
                $activeAssignment
                    ->attendanceRecords()
                    ->latest(
                        'attendance_date'
                    )
                    ->latest('id')
                    ->paginate(10);
        } else {
            $records =
                AttendanceRecord::query()
                    ->whereRaw(
                        '1 = 0'
                    )
                    ->paginate(10);
        }


        /*
        |--------------------------------------------------------------------------
        | Attendance History Sessions
        |--------------------------------------------------------------------------
        |
        | These sessions are used by the history table so the Student can
        | securely view Morning and Afternoon Time In / Time Out photos.
        |
        */

        $historyAttendanceIds =
            $records
                ->getCollection()
                ->pluck('id');

        $historySessions =
            collect();

        if (
            $historyAttendanceIds
                ->isNotEmpty()
        ) {
            $historySessions =
                AttendanceSession::query()
                    ->whereIn(
                        'attendance_record_id',
                        $historyAttendanceIds
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


        return view(
            'student.attendance.index',
            compact(
                'profile',
                'activeAssignment',

                'todayAttendance',
                'todaySessions',
                'openSession',

                'sessionCount',
                'todayRenderedMinutes',

                'canTimeIn',
                'canTimeOut',
                'dayComplete',

                'legacyToday',
                'nextSessionNumber',

                'records',
                'historySessions',

                'today'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Time In
    |--------------------------------------------------------------------------
    */

    public function timeIn(
        Request $request
    ): RedirectResponse {
        [
            $user,
            $profile,
            $activeAssignment,
        ] = $this->studentContext(
            $request
        );


        /*
        |--------------------------------------------------------------------------
        | Require Student Profile
        |--------------------------------------------------------------------------
        */

        if (! $profile) {
            return back()->with(
                'error',
                'Please complete your Student Profile before recording attendance.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Require OJT Assignment
        |--------------------------------------------------------------------------
        */

        if (! $activeAssignment) {
            return back()->with(
                'error',
                'You do not currently have an OJT Assignment.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Assignment Must Be Active
        |--------------------------------------------------------------------------
        */

        if (
            $activeAssignment->status
            !== OjtAssignment::STATUS_ACTIVE
        ) {
            return back()->with(
                'error',
                'Your OJT Assignment is not yet active. Attendance will be available once the assignment is activated.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Validate GPS and Selfie
        |--------------------------------------------------------------------------
        */

        $validated =
            $this->validateAttendanceInput(
                $request
            );

        $uploadedSelfie =
            $request->file(
                'selfie'
            );

        if (! $uploadedSelfie) {
            return back()->with(
                'error',
                'A selfie is required before recording Time In.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Server-Controlled Philippine Time
        |--------------------------------------------------------------------------
        */

        $now =
            CarbonImmutable::now(
                self::BUSINESS_TIMEZONE
            );

        $today =
            $now->toDateString();

        $selfiePath = null;


        try {
            $result =
                DB::transaction(
                    function () use (
                        $user,
                        $activeAssignment,
                        $validated,
                        $uploadedSelfie,
                        $today,
                        $now,
                        &$selfiePath
                    ): array {

                        /*
                        |--------------------------------------------------------------------------
                        | Lock Today's Attendance
                        |--------------------------------------------------------------------------
                        */

                        $attendance =
                            AttendanceRecord::query()
                                ->where(
                                    'ojt_assignment_id',
                                    $activeAssignment->id
                                )
                                ->where(
                                    'attendance_date',
                                    $today
                                )
                                ->lockForUpdate()
                                ->first();


                        /*
                        |--------------------------------------------------------------------------
                        | Lock Existing Sessions
                        |--------------------------------------------------------------------------
                        */

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


                            /*
                            |--------------------------------------------------------------------------
                            | Protect Finalized Attendance
                            |--------------------------------------------------------------------------
                            */

                            if (
                                in_array(
                                    $attendance->status,
                                    [
                                        'pending',
                                        'validated',
                                        'rejected',
                                    ],
                                    true
                                )
                            ) {
                                return [
                                    'type' =>
                                        'error',

                                    'message' =>
                                        'This attendance record has already been submitted or reviewed and can no longer be modified.',
                                ];
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Protect Legacy Records
                            |--------------------------------------------------------------------------
                            */

                            if (
                                $sessions->isEmpty()
                                && $attendance->time_in !== null
                            ) {
                                return [
                                    'type' =>
                                        'error',

                                    'message' =>
                                        'Today already has an attendance record created before the multi-session update. Please begin the new Morning and Afternoon workflow on your next attendance day.',
                                ];
                            }
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Prevent Overlapping Sessions
                        |--------------------------------------------------------------------------
                        */

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
                                'type' =>
                                    'error',

                                'message' =>
                                    'You already have an active attendance session. Please Time Out before starting another session.',
                            ];
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Maximum Two Sessions Per Day
                        |--------------------------------------------------------------------------
                        */

                        $sessionCount =
                            $sessions->count();

                        if (
                            $sessionCount
                            >=
                            AttendanceSession::MAX_SESSIONS_PER_DAY
                        ) {
                            return [
                                'type' =>
                                    'error',

                                'message' =>
                                    'You have already completed both attendance sessions for today.',
                            ];
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Determine Session Number
                        |--------------------------------------------------------------------------
                        */

                        $sessionNumber =
                            $sessionCount + 1;


                        /*
                        |--------------------------------------------------------------------------
                        | Store Time In Selfie Privately
                        |--------------------------------------------------------------------------
                        */

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
                                'type' =>
                                    'error',

                                'message' =>
                                    'Unable to save your Time In selfie.',
                            ];
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Create Daily Parent Attendance
                        |--------------------------------------------------------------------------
                        */

                        if (! $attendance) {
                            $attendance =
                                AttendanceRecord::create([
                                    'ojt_assignment_id' =>
                                        $activeAssignment->id,

                                    'attendance_date' =>
                                        $today,

                                    /*
                                    |--------------------------------------------------------------------------
                                    | Legacy Compatibility Fields
                                    |--------------------------------------------------------------------------
                                    */

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

                            /*
                            |--------------------------------------------------------------------------
                            | Beginning Afternoon Session
                            |--------------------------------------------------------------------------
                            |
                            | Clear the daily Time Out because the Student is now
                            | actively working again. Individual Morning evidence
                            | remains safely stored in attendance_sessions.
                            |
                            */

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


                        /*
                        |--------------------------------------------------------------------------
                        | Create Attendance Session
                        |--------------------------------------------------------------------------
                        */

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


                        /*
                        |--------------------------------------------------------------------------
                        | Success Message
                        |--------------------------------------------------------------------------
                        */

                        $sessionLabel =
                            $sessionNumber
                            ===
                            AttendanceSession::MORNING_SESSION
                                ? 'Morning Session'
                                : 'Afternoon Session';

                        return [
                            'type' =>
                                'success',

                            'message' =>
                                $sessionLabel
                                .' Time In recorded successfully.',
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

            throw $exception;
        }


        /*
        |--------------------------------------------------------------------------
        | Remove Stored File if Transaction Was Rejected
        |--------------------------------------------------------------------------
        */

        if (
            $result['type']
            === 'error'
        ) {
            if ($selfiePath) {
                Storage::disk(
                    'local'
                )->delete(
                    $selfiePath
                );
            }

            return back()->with(
                'error',
                $result['message']
            );
        }


        return redirect()
            ->route(
                'student.attendance.index'
            )
            ->with(
                'success',
                $result['message']
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Time Out
    |--------------------------------------------------------------------------
    */

    public function timeOut(
        Request $request
    ): RedirectResponse {
        [
            $user,
            $profile,
            $activeAssignment,
        ] = $this->studentContext(
            $request
        );


        /*
        |--------------------------------------------------------------------------
        | Require Student Profile
        |--------------------------------------------------------------------------
        */

        if (! $profile) {
            return back()->with(
                'error',
                'Please complete your Student Profile first.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Require OJT Assignment
        |--------------------------------------------------------------------------
        */

        if (! $activeAssignment) {
            return back()->with(
                'error',
                'You do not currently have an OJT Assignment.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Assignment Must Be Active
        |--------------------------------------------------------------------------
        */

        if (
            $activeAssignment->status
            !== OjtAssignment::STATUS_ACTIVE
        ) {
            return back()->with(
                'error',
                'Your OJT Assignment is not active. Attendance cannot be recorded.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Validate GPS and Selfie
        |--------------------------------------------------------------------------
        */

        $validated =
            $this->validateAttendanceInput(
                $request
            );

        $uploadedSelfie =
            $request->file(
                'selfie'
            );

        if (! $uploadedSelfie) {
            return back()->with(
                'error',
                'A selfie is required before recording Time Out.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Server-Controlled Philippine Time
        |--------------------------------------------------------------------------
        */

        $now =
            CarbonImmutable::now(
                self::BUSINESS_TIMEZONE
            );

        $today =
            $now->toDateString();

        $selfiePath = null;


        try {
            $result =
                DB::transaction(
                    function () use (
                        $user,
                        $activeAssignment,
                        $validated,
                        $uploadedSelfie,
                        $today,
                        $now,
                        &$selfiePath
                    ): array {

                        /*
                        |--------------------------------------------------------------------------
                        | Find Today's Attendance
                        |--------------------------------------------------------------------------
                        */

                        $attendance =
                            AttendanceRecord::query()
                                ->where(
                                    'ojt_assignment_id',
                                    $activeAssignment->id
                                )
                                ->where(
                                    'attendance_date',
                                    $today
                                )
                                ->lockForUpdate()
                                ->first();

                        if (! $attendance) {
                            return [
                                'type' =>
                                    'error',

                                'message' =>
                                    'You must Time In before you can Time Out.',
                            ];
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Protect Finalized Attendance
                        |--------------------------------------------------------------------------
                        */

                        if (
                            in_array(
                                $attendance->status,
                                [
                                    'pending',
                                    'validated',
                                    'rejected',
                                ],
                                true
                            )
                        ) {
                            return [
                                'type' =>
                                    'error',

                                'message' =>
                                    'This attendance record has already been submitted or reviewed and can no longer be modified.',
                            ];
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Lock Sessions
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
                                ->lockForUpdate()
                                ->get();


                        /*
                        |--------------------------------------------------------------------------
                        | Protect Legacy Record
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $sessions->isEmpty()
                            && $attendance->time_in !== null
                        ) {
                            return [
                                'type' =>
                                    'error',

                                'message' =>
                                    'This attendance record was created before the multi-session update and cannot be modified using the new session workflow.',
                            ];
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Find Open Session
                        |--------------------------------------------------------------------------
                        */

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
                                'type' =>
                                    'error',

                                'message' =>
                                    'There is no open attendance session to Time Out.',
                            ];
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Store Time Out Selfie Privately
                        |--------------------------------------------------------------------------
                        */

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
                                'type' =>
                                    'error',

                                'message' =>
                                    'Unable to save your Time Out selfie.',
                            ];
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Calculate Session Rendered Minutes
                        |--------------------------------------------------------------------------
                        */

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


                        /*
                        |--------------------------------------------------------------------------
                        | Close Attendance Session
                        |--------------------------------------------------------------------------
                        */

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


                        /*
                        |--------------------------------------------------------------------------
                        | Calculate Daily Rendered Total
                        |--------------------------------------------------------------------------
                        */

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


                        /*
                        |--------------------------------------------------------------------------
                        | Determine Daily Status
                        |--------------------------------------------------------------------------
                        |
                        | Session 1 Time Out:
                        | status = in_progress
                        |
                        | Session 2 Time Out:
                        | status = pending
                        |
                        */

                        $dayComplete =
                            $sessionCount
                            >=
                            AttendanceSession::MAX_SESSIONS_PER_DAY;

                        $dailyStatus =
                            $dayComplete
                                ? AttendanceRecord::STATUS_PENDING
                                : AttendanceRecord::STATUS_IN_PROGRESS;


                        /*
                        |--------------------------------------------------------------------------
                        | Synchronize Daily Attendance Parent
                        |--------------------------------------------------------------------------
                        */

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


                        /*
                        |--------------------------------------------------------------------------
                        | Success Message
                        |--------------------------------------------------------------------------
                        */

                        if ($dayComplete) {
                            return [
                                'type' =>
                                    'success',

                                'message' =>
                                    'Afternoon Session Time Out recorded successfully. Today\'s attendance is now waiting for Supervisor validation.',
                            ];
                        }

                        return [
                            'type' =>
                                'success',

                            'message' =>
                                'Morning Session Time Out recorded successfully. You may Time In again for your Afternoon Session.',
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

            throw $exception;
        }


        /*
        |--------------------------------------------------------------------------
        | Remove Stored File if Transaction Was Rejected
        |--------------------------------------------------------------------------
        */

        if (
            $result['type']
            === 'error'
        ) {
            if ($selfiePath) {
                Storage::disk(
                    'local'
                )->delete(
                    $selfiePath
                );
            }

            return back()->with(
                'error',
                $result['message']
            );
        }


        return redirect()
            ->route(
                'student.attendance.index'
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
    | Used for attendance records created before AttendanceSession
    | was introduced.
    |
    */

    public function selfie(
        Request $request,
        AttendanceRecord $attendance,
        string $type
    ): Response {
        $user =
            $request->user();

        if (
            ! $user instanceof User
            || ! $user->isStudent()
        ) {
            abort(403);
        }

        $profile =
            $user->studentProfile;

        if (! $profile) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Load Assignment
        |--------------------------------------------------------------------------
        */

        $attendance->loadMissing(
            'ojtAssignment'
        );

        if (
            ! $attendance->ojtAssignment
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
                ->student_profile_id
            !==
            (int) $profile->id
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Select Photo
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
    | Securely serves Morning / Afternoon Time In and Time Out selfies.
    |
    */

    public function sessionSelfie(
        Request $request,
        AttendanceSession $session,
        string $type
    ): Response {
        $user =
            $request->user();

        if (
            ! $user instanceof User
            || ! $user->isStudent()
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Student Profile
        |--------------------------------------------------------------------------
        */

        $profile =
            $user->studentProfile;

        if (! $profile) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Load Session Parent and Assignment
        |--------------------------------------------------------------------------
        */

        $session->loadMissing(
            'attendanceRecord.ojtAssignment'
        );

        $attendance =
            $session->attendanceRecord;

        if (
            ! $attendance
            || ! $attendance->ojtAssignment
        ) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | Ownership Check
        |--------------------------------------------------------------------------
        |
        | A Student must never be allowed to request another Student's
        | Attendance Session photo by changing the URL ID.
        |
        */

        if (
            (int)
            $attendance
                ->ojtAssignment
                ->student_profile_id
            !==
            (int) $profile->id
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Select Session Photo
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
    | Secure Private Image Response
    |--------------------------------------------------------------------------
    |
    | Selfies remain on the private local disk.
    |
    | Do NOT use Storage::mimeType() here.
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
        | Determine MIME Type Using Validated Extension
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
    | Resolve Student Context
    |--------------------------------------------------------------------------
    */

    private function studentContext(
        Request $request
    ): array {
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
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Student Profile
        |--------------------------------------------------------------------------
        */

        $profile =
            $user->studentProfile;

        $activeAssignment = null;


        if (
            $profile instanceof
            StudentProfile
        ) {

            /*
            |--------------------------------------------------------------------------
            | Priority 1: Active Assignment
            |--------------------------------------------------------------------------
            */

            $activeAssignment =
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


            /*
            |--------------------------------------------------------------------------
            | Priority 2: Pending / Open Assignment
            |--------------------------------------------------------------------------
            |
            | This allows a Student to see an assigned placement before it
            | becomes active without allowing attendance recording yet.
            |
            */

            if (! $activeAssignment) {
                $activeAssignment =
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
            $activeAssignment,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Validate Attendance Input
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