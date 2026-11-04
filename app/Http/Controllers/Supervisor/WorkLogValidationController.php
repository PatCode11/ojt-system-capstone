<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\DailyWorkLog;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkLogValidationController extends Controller
{
    /**
     * Display pending Work Logs assigned to this Supervisor.
     */
    public function index(
        Request $request
    ): View {
        $supervisor =
            $this->supervisor($request);

        $pendingWorkLogs = DailyWorkLog::query()
            ->with([
                'attendanceRecord.ojtAssignment.studentProfile.user',
                'attendanceRecord.ojtAssignment.company',
            ])
            ->whereHas(
                'attendanceRecord.ojtAssignment',
                function ($query) use ($supervisor): void {
                    $query->where(
                        'supervisor_id',
                        $supervisor->id
                    );
                }
            )
            ->where(
                'status',
                DailyWorkLog::STATUS_PENDING
            )
            ->latest('submitted_at')
            ->paginate(10);

        return view(
            'supervisor.work-logs.index',
            compact(
                'pendingWorkLogs'
            )
        );
    }

    /**
     * Review one Work Log.
     */
    public function show(
        Request $request,
        DailyWorkLog $workLog
    ): View {
        $supervisor =
            $this->supervisor($request);

        $this->authorizeWorkLog(
            $workLog,
            $supervisor
        );

        $workLog->load([
            'attendanceRecord.ojtAssignment.studentProfile.user',
            'attendanceRecord.ojtAssignment.company',
            'validator',
        ]);

        return view(
            'supervisor.work-logs.show',
            compact(
                'workLog'
            )
        );
    }

    /**
     * Approve Daily Work Log.
     */
    public function approve(
        Request $request,
        DailyWorkLog $workLog
    ): RedirectResponse {
        $supervisor =
            $this->supervisor($request);

        $this->authorizeWorkLog(
            $workLog,
            $supervisor
        );

        /*
        |--------------------------------------------------------------------------
        | Attendance Must Be Validated First
        |--------------------------------------------------------------------------
        */

        $workLog->loadMissing(
            'attendanceRecord'
        );

        if (
            $workLog->attendanceRecord->status
            !== AttendanceRecord::STATUS_VALIDATED
        ) {
            return back()->with(
                'error',
                'The Student attendance must be validated before the Daily Work Log can be approved.'
            );
        }

        if (
            $workLog->status
            !== DailyWorkLog::STATUS_PENDING
        ) {
            return back()->with(
                'error',
                'This Daily Work Log has already been processed.'
            );
        }

        $validated = $request->validate([
            'remarks' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        DB::transaction(
            function () use (
                $workLog,
                $supervisor,
                $validated
            ): void {
                $record = DailyWorkLog::query()
                    ->whereKey(
                        $workLog->id
                    )
                    ->lockForUpdate()
                    ->firstOrFail();

                if (
                    $record->status
                    !== DailyWorkLog::STATUS_PENDING
                ) {
                    abort(
                        409,
                        'This Daily Work Log has already been processed.'
                    );
                }

                $record->update([
                    'status' =>
                        DailyWorkLog::STATUS_VALIDATED,

                    'supervisor_remarks' =>
                        $validated['remarks'] ?? null,

                    'validated_by' =>
                        $supervisor->id,

                    'validated_at' =>
                        now(),
                ]);
            }
        );

        return redirect()
            ->route(
                'supervisor.work-logs.index'
            )
            ->with(
                'success',
                'Daily Work Log validated successfully.'
            );
    }

    /**
     * Reject Daily Work Log.
     */
    public function reject(
        Request $request,
        DailyWorkLog $workLog
    ): RedirectResponse {
        $supervisor =
            $this->supervisor($request);

        $this->authorizeWorkLog(
            $workLog,
            $supervisor
        );

        if (
            $workLog->status
            !== DailyWorkLog::STATUS_PENDING
        ) {
            return back()->with(
                'error',
                'This Daily Work Log has already been processed.'
            );
        }

        $validated = $request->validate([
            'remarks' => [
                'required',
                'string',
                'min:3',
                'max:2000',
            ],
        ]);

        DB::transaction(
            function () use (
                $workLog,
                $supervisor,
                $validated
            ): void {
                $record = DailyWorkLog::query()
                    ->whereKey(
                        $workLog->id
                    )
                    ->lockForUpdate()
                    ->firstOrFail();

                if (
                    $record->status
                    !== DailyWorkLog::STATUS_PENDING
                ) {
                    abort(
                        409,
                        'This Daily Work Log has already been processed.'
                    );
                }

                $record->update([
                    'status' =>
                        DailyWorkLog::STATUS_REJECTED,

                    'supervisor_remarks' =>
                        $validated['remarks'],

                    'validated_by' =>
                        $supervisor->id,

                    'validated_at' =>
                        now(),
                ]);
            }
        );

        return redirect()
            ->route(
                'supervisor.work-logs.index'
            )
            ->with(
                'success',
                'Daily Work Log rejected. The Student may correct and resubmit it.'
            );
    }

    /**
     * Resolve authenticated Supervisor.
     */
    private function supervisor(
        Request $request
    ): User {
        $user = $request->user();

        if (
            ! $user instanceof User
            || ! $user->isSupervisor()
        ) {
            abort(403);
        }

        return $user;
    }

    /**
     * Ensure Work Log belongs to this Supervisor.
     */
    private function authorizeWorkLog(
        DailyWorkLog $workLog,
        User $supervisor
    ): void {
        $workLog->loadMissing(
            'attendanceRecord.ojtAssignment'
        );

        if (
            (int) $workLog
                ->attendanceRecord
                ->ojtAssignment
                ->supervisor_id
            !==
            (int) $supervisor->id
        ) {
            abort(403);
        }
    }
}