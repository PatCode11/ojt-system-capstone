<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\AuditLog;
use App\Models\Company;
use App\Models\DailyWorkLog;
use App\Models\OjtAssignment;
use App\Models\User;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Display Administrator dashboard.
     */
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Account Statistics
        |--------------------------------------------------------------------------
        */

        $studentCount =
            User::query()
                ->where(
                    'role',
                    User::ROLE_STUDENT
                )
                ->count();

        $activeStudentCount =
            User::query()
                ->where(
                    'role',
                    User::ROLE_STUDENT
                )
                ->where(
                    'status',
                    User::STATUS_ACTIVE
                )
                ->count();

        $supervisorCount =
            User::query()
                ->where(
                    'role',
                    User::ROLE_SUPERVISOR
                )
                ->count();

        $activeSupervisorCount =
            User::query()
                ->where(
                    'role',
                    User::ROLE_SUPERVISOR
                )
                ->where(
                    'status',
                    User::STATUS_ACTIVE
                )
                ->count();

        /*
        |--------------------------------------------------------------------------
        | OJT Statistics
        |--------------------------------------------------------------------------
        */

        $companyCount =
            Company::query()
                ->count();

        $activeAssignments =
            OjtAssignment::query()
                ->where(
                    'status',
                    OjtAssignment::STATUS_ACTIVE
                )
                ->count();

        $pendingAttendance =
            AttendanceRecord::query()
                ->where(
                    'status',
                    AttendanceRecord::STATUS_PENDING
                )
                ->count();

        $pendingWorkLogs =
            DailyWorkLog::query()
                ->where(
                    'status',
                    DailyWorkLog::STATUS_PENDING
                )
                ->count();

        /*
        |--------------------------------------------------------------------------
        | Security Monitoring
        |--------------------------------------------------------------------------
        */

        $auditEventsLast24Hours =
            AuditLog::query()
                ->where(
                    'created_at',
                    '>=',
                    now()->subDay()
                )
                ->count();

        $failedLoginsLast24Hours =
            AuditLog::query()
                ->where(
                    'action',
                    'auth.login_failed'
                )
                ->where(
                    'created_at',
                    '>=',
                    now()->subDay()
                )
                ->count();

        $recentSecurityEvents =
            AuditLog::query()
                ->with('actor')
                ->whereIn(
                    'action',
                    [
                        'auth.login_failed',
                        'account.status_changed',
                        'account.password_changed',
                        'assignment.completed',
                        'assignment.cancelled',
                    ]
                )
                ->latest('id')
                ->limit(5)
                ->get();

        return view(
            'admin.dashboard',
            compact(
                'studentCount',
                'activeStudentCount',
                'supervisorCount',
                'activeSupervisorCount',
                'companyCount',
                'activeAssignments',
                'pendingAttendance',
                'pendingWorkLogs',
                'auditEventsLast24Hours',
                'failedLoginsLast24Hours',
                'recentSecurityEvents'
            )
        );
    }
}