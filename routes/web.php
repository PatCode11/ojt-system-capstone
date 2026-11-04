<?php

use App\Http\Controllers\Admin\AttendanceManagementController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OjtAssignmentController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\SupervisorController as AdminSupervisorController;

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\PortalLoginController;
use App\Http\Controllers\Auth\StudentRegistrationController;

use App\Http\Controllers\Student\AssignmentHistoryController;
use App\Http\Controllers\Student\AttendanceController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\ReportController as StudentReportController;
use App\Http\Controllers\Student\TimesheetController;
use App\Http\Controllers\Student\WorkLogController;

use App\Http\Controllers\Supervisor\AttendanceValidationController;
use App\Http\Controllers\Supervisor\DashboardController as SupervisorDashboardController;
use App\Http\Controllers\Supervisor\EvaluationController;
use App\Http\Controllers\Supervisor\ReportController as SupervisorReportController;
use App\Http\Controllers\Supervisor\WorkLogValidationController;

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Login Selection
|--------------------------------------------------------------------------
*/

Route::view(
    '/',
    'auth.choose-login'
)->name('home');


/*
|--------------------------------------------------------------------------
| Administrator Authentication
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/login',
    [AdminLoginController::class, 'create']
)->name('admin.login');

Route::post(
    '/admin/login',
    [AdminLoginController::class, 'store']
)
    ->middleware('throttle:5,1')
    ->name('admin.login.store');


/*
|--------------------------------------------------------------------------
| OJT Portal Authentication
|--------------------------------------------------------------------------
*/

Route::get(
    '/login',
    [PortalLoginController::class, 'create']
)->name('login');

Route::post(
    '/login',
    [PortalLoginController::class, 'store']
)
    ->middleware('throttle:5,1')
    ->name('login.store');


/*
|--------------------------------------------------------------------------
| Student Registration
|--------------------------------------------------------------------------
*/

Route::get(
    '/register',
    [StudentRegistrationController::class, 'create']
)->name('student.register');

Route::post(
    '/register',
    [StudentRegistrationController::class, 'store']
)
    ->middleware('throttle:5,1')
    ->name('student.register.store');


/*
|--------------------------------------------------------------------------
| Administrator
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware([
        'auth',
        'role:admin',
    ])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [AdminDashboardController::class, 'index']
        )->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Attendance Management
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/attendance',
            [
                AttendanceManagementController::class,
                'index',
            ]
        )->name(
            'attendance.index'
        );


        /*
        |--------------------------------------------------------------------------
        | Attendance Session - Edit
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | Keep the session routes before /attendance/{attendance}.
        |
        */

        Route::get(
            '/attendance/sessions/{session}/edit',
            [
                AttendanceManagementController::class,
                'editSession',
            ]
        )
            ->whereNumber('session')
            ->name(
                'attendance.sessions.edit'
            );


        /*
        |--------------------------------------------------------------------------
        | Attendance Session - Update
        |--------------------------------------------------------------------------
        */

        Route::put(
            '/attendance/sessions/{session}',
            [
                AttendanceManagementController::class,
                'updateSession',
            ]
        )
            ->whereNumber('session')
            ->middleware('throttle:10,1')
            ->name(
                'attendance.sessions.update'
            );


        /*
        |--------------------------------------------------------------------------
        | Attendance Detail
        |--------------------------------------------------------------------------
        |
        | Because this route is inside ->name('admin.'),
        | attendance.show becomes:
        |
        | admin.attendance.show
        |
        */

        Route::get(
            '/attendance/{attendance}',
            [
                AttendanceManagementController::class,
                'show',
            ]
        )
            ->whereNumber('attendance')
            ->name(
                'attendance.show'
            );


        /*
        |--------------------------------------------------------------------------
        | Students - Archive & Restore
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/students/archived',
            [AdminStudentController::class, 'archived']
        )->name('students.archived');

        Route::patch(
            '/students/{student}/archive',
            [AdminStudentController::class, 'archive']
        )
            ->middleware('throttle:10,1')
            ->name('students.archive');

        Route::patch(
            '/students/{student}/restore',
            [AdminStudentController::class, 'restore']
        )
            ->middleware('throttle:10,1')
            ->name('students.restore');


        /*
        |--------------------------------------------------------------------------
        | Students
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'students',
            AdminStudentController::class
        )->except([
            'destroy',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Supervisors - Archive & Restore
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/supervisors/archived',
            [AdminSupervisorController::class, 'archived']
        )->name('supervisors.archived');

        Route::patch(
            '/supervisors/{supervisor}/archive',
            [AdminSupervisorController::class, 'archive']
        )
            ->middleware('throttle:10,1')
            ->name('supervisors.archive');

        Route::patch(
            '/supervisors/{supervisor}/restore',
            [AdminSupervisorController::class, 'restore']
        )
            ->middleware('throttle:10,1')
            ->name('supervisors.restore');


        /*
        |--------------------------------------------------------------------------
        | Supervisors
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'supervisors',
            AdminSupervisorController::class
        )->except([
            'destroy',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Companies
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'companies',
            CompanyController::class
        );


        /*
        |--------------------------------------------------------------------------
        | System Reports
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/reports',
            [AdminReportController::class, 'index']
        )->name('reports.index');

        Route::get(
            '/reports/print',
            [AdminReportController::class, 'print']
        )->name('reports.print');

        Route::get(
            '/reports/export-csv',
            [AdminReportController::class, 'exportCsv']
        )
            ->middleware('throttle:10,1')
            ->name('reports.export-csv');


        /*
        |--------------------------------------------------------------------------
        | Audit Logs
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/audit-logs',
            [AuditLogController::class, 'index']
        )->name('audit-logs.index');

        Route::get(
            '/audit-logs/{auditLog}',
            [AuditLogController::class, 'show']
        )->name('audit-logs.show');


        /*
        |--------------------------------------------------------------------------
        | Formal OJT Completion
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/assignments/{assignment}/complete',
            [
                OjtAssignmentController::class,
                'complete',
            ]
        )
            ->middleware('throttle:10,1')
            ->name('assignments.complete');

        Route::get(
            '/assignments/{assignment}/completion-summary',
            [
                OjtAssignmentController::class,
                'completionSummary',
            ]
        )->name(
            'assignments.completion-summary'
        );


        /*
        |--------------------------------------------------------------------------
        | Assignments
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'assignments',
            OjtAssignmentController::class
        )->except([
            'destroy',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Logout
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/logout',
            [AdminLoginController::class, 'destroy']
        )->name('logout');
    });


/*
|--------------------------------------------------------------------------
| Student
|--------------------------------------------------------------------------
*/

Route::prefix('student')
    ->name('student.')
    ->middleware([
        'auth',
        'role:student',
    ])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [StudentDashboardController::class, 'index']
        )->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Profile
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/profile',
            [ProfileController::class, 'show']
        )->name('profile.show');

        Route::get(
            '/profile/edit',
            [ProfileController::class, 'edit']
        )->name('profile.edit');

        Route::put(
            '/profile',
            [ProfileController::class, 'update']
        )->name('profile.update');


        /*
        |--------------------------------------------------------------------------
        | Assignment History
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/assignment-history',
            [
                AssignmentHistoryController::class,
                'index',
            ]
        )->name(
            'assignment-history.index'
        );

        Route::get(
            '/assignment-history/{assignment}/completion',
            [
                AssignmentHistoryController::class,
                'completion',
            ]
        )->name(
            'assignment-history.completion'
        );


        /*
        |--------------------------------------------------------------------------
        | GPS Selfie Attendance
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/attendance',
            [AttendanceController::class, 'index']
        )->name('attendance.index');


        /*
        |--------------------------------------------------------------------------
        | Attendance - Time In
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/attendance/time-in',
            [AttendanceController::class, 'timeIn']
        )
            ->middleware('throttle:5,1')
            ->name('attendance.time-in');


        /*
        |--------------------------------------------------------------------------
        | Attendance - Time Out
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/attendance/time-out',
            [AttendanceController::class, 'timeOut']
        )
            ->middleware('throttle:5,1')
            ->name('attendance.time-out');


        /*
        |--------------------------------------------------------------------------
        | Attendance Session Selfies
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/attendance/sessions/{session}/selfie/{type}',
            [
                AttendanceController::class,
                'sessionSelfie',
            ]
        )
            ->whereNumber('session')
            ->whereIn(
                'type',
                [
                    'time-in',
                    'time-out',
                ]
            )
            ->name(
                'attendance.session-selfie'
            );


        /*
        |--------------------------------------------------------------------------
        | Legacy Daily Attendance Selfies
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/attendance/{attendance}/selfie/{type}',
            [AttendanceController::class, 'selfie']
        )
            ->whereNumber('attendance')
            ->whereIn(
                'type',
                [
                    'time-in',
                    'time-out',
                ]
            )
            ->name(
                'attendance.selfie'
            );


        /*
        |--------------------------------------------------------------------------
        | Timesheet
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/timesheets',
            [TimesheetController::class, 'index']
        )->name('timesheets.index');


        /*
        |--------------------------------------------------------------------------
        | Daily Work Logs
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/work-logs',
            [WorkLogController::class, 'index']
        )->name('work-logs.index');

        Route::get(
            '/work-logs/create',
            [WorkLogController::class, 'create']
        )->name('work-logs.create');

        Route::post(
            '/work-logs',
            [WorkLogController::class, 'store']
        )
            ->middleware('throttle:10,1')
            ->name('work-logs.store');

        Route::get(
            '/work-logs/{workLog}/edit',
            [WorkLogController::class, 'edit']
        )->name('work-logs.edit');

        Route::put(
            '/work-logs/{workLog}',
            [WorkLogController::class, 'update']
        )
            ->middleware('throttle:10,1')
            ->name('work-logs.update');


        /*
        |--------------------------------------------------------------------------
        | Reports
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/reports',
            [StudentReportController::class, 'index']
        )->name('reports.index');


        /*
        |--------------------------------------------------------------------------
        | Logout
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/logout',
            [PortalLoginController::class, 'destroy']
        )->name('logout');
    });


/*
|--------------------------------------------------------------------------
| Supervisor
|--------------------------------------------------------------------------
*/

Route::prefix('supervisor')
    ->name('supervisor.')
    ->middleware([
        'auth',
        'role:supervisor',
    ])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [SupervisorDashboardController::class, 'index']
        )->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Attendance Validation
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/validations',
            [AttendanceValidationController::class, 'index']
        )->name('validations.index');


        /*
        |--------------------------------------------------------------------------
        | Attendance Session Selfies
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/validations/sessions/{session}/selfie/{type}',
            [
                AttendanceValidationController::class,
                'sessionSelfie',
            ]
        )
            ->whereNumber('session')
            ->whereIn(
                'type',
                [
                    'time-in',
                    'time-out',
                ]
            )
            ->name(
                'validations.session-selfie'
            );


        /*
        |--------------------------------------------------------------------------
        | Attendance Detail
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/validations/{attendance}',
            [
                AttendanceValidationController::class,
                'show',
            ]
        )
            ->whereNumber('attendance')
            ->name(
                'validations.show'
            );


        /*
        |--------------------------------------------------------------------------
        | Approve Attendance
        |--------------------------------------------------------------------------
        */

        Route::put(
            '/validations/{attendance}/approve',
            [
                AttendanceValidationController::class,
                'approve',
            ]
        )
            ->whereNumber('attendance')
            ->middleware('throttle:10,1')
            ->name(
                'validations.approve'
            );


        /*
        |--------------------------------------------------------------------------
        | Reject Attendance
        |--------------------------------------------------------------------------
        */

        Route::put(
            '/validations/{attendance}/reject',
            [
                AttendanceValidationController::class,
                'reject',
            ]
        )
            ->whereNumber('attendance')
            ->middleware('throttle:10,1')
            ->name(
                'validations.reject'
            );


        /*
        |--------------------------------------------------------------------------
        | Legacy Daily Attendance Selfies
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/validations/{attendance}/selfie/{type}',
            [
                AttendanceValidationController::class,
                'selfie',
            ]
        )
            ->whereNumber('attendance')
            ->whereIn(
                'type',
                [
                    'time-in',
                    'time-out',
                ]
            )
            ->name(
                'validations.selfie'
            );


        /*
        |--------------------------------------------------------------------------
        | Work Log Validation
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/work-logs',
            [
                WorkLogValidationController::class,
                'index',
            ]
        )->name(
            'work-logs.index'
        );

        Route::get(
            '/work-logs/{workLog}',
            [
                WorkLogValidationController::class,
                'show',
            ]
        )->name(
            'work-logs.show'
        );

        Route::put(
            '/work-logs/{workLog}/approve',
            [
                WorkLogValidationController::class,
                'approve',
            ]
        )
            ->middleware('throttle:10,1')
            ->name(
                'work-logs.approve'
            );

        Route::put(
            '/work-logs/{workLog}/reject',
            [
                WorkLogValidationController::class,
                'reject',
            ]
        )
            ->middleware('throttle:10,1')
            ->name(
                'work-logs.reject'
            );


        /*
        |--------------------------------------------------------------------------
        | Final Evaluations
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/evaluations',
            [
                EvaluationController::class,
                'index',
            ]
        )->name(
            'evaluations.index'
        );

        Route::get(
            '/evaluations/{assignment}',
            [
                EvaluationController::class,
                'show',
            ]
        )->name(
            'evaluations.show'
        );

        Route::post(
            '/evaluations/{assignment}',
            [
                EvaluationController::class,
                'store',
            ]
        )
            ->middleware('throttle:10,1')
            ->name(
                'evaluations.store'
            );

        Route::put(
            '/evaluations/{assignment}',
            [
                EvaluationController::class,
                'update',
            ]
        )
            ->middleware('throttle:10,1')
            ->name(
                'evaluations.update'
            );


        /*
        |--------------------------------------------------------------------------
        | Reports
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/reports',
            [
                SupervisorReportController::class,
                'index',
            ]
        )->name(
            'reports.index'
        );


        /*
        |--------------------------------------------------------------------------
        | Logout
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/logout',
            [PortalLoginController::class, 'destroy']
        )->name('logout');
    });