<?php

use App\Http\Controllers\Api\MobileAuthController;
use App\Http\Controllers\Api\StudentAttendanceController;
use App\Http\Controllers\Api\StudentAttendanceEvidenceController;
use App\Http\Controllers\Api\StudentDashboardController;
use App\Http\Controllers\Api\StudentScheduleController;
use App\Http\Controllers\Api\StudentTimesheetController;
use App\Http\Controllers\Api\StudentWorkLogController;
use App\Http\Controllers\Api\SupervisorAttendanceController;
use App\Http\Controllers\Api\SupervisorDashboardController;
use App\Http\Controllers\Api\SupervisorEvaluationController;
use App\Http\Controllers\Api\SupervisorStudentController;
use App\Http\Controllers\Api\SupervisorWorkLogController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| OJT Sync Mobile API
|--------------------------------------------------------------------------
*/


Route::prefix('mobile')
    ->name('api.mobile.')
    ->group(function (): void {

        /*
        |--------------------------------------------------------------------------
        | Login
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/login',
            [
                MobileAuthController::class,
                'login',
            ]
        )
            ->middleware(
                'throttle:10,1'
            )
            ->name(
                'login'
            );


        /*
        |--------------------------------------------------------------------------
        | Authenticated Mobile Routes
        |--------------------------------------------------------------------------
        */

        Route::middleware(
            'auth:sanctum'
        )->group(function (): void {

            /*
            |--------------------------------------------------------------------------
            | Current User
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/me',
                [
                    MobileAuthController::class,
                    'me',
                ]
            )
                ->name(
                    'me'
                );


            /*
            |--------------------------------------------------------------------------
            | Student Dashboard
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/student/dashboard',
                [
                    StudentDashboardController::class,
                    'show',
                ]
            )
                ->middleware(
                    'throttle:60,1'
                )
                ->name(
                    'student.dashboard'
                );


            /*
            |--------------------------------------------------------------------------
            | Student Attendance
            |--------------------------------------------------------------------------
            */

            Route::prefix(
                'student/attendance'
            )
                ->name(
                    'student.attendance.'
                )
                ->group(
                    function (): void {

                        Route::get(
                            '/today',
                            [
                                StudentAttendanceController::class,
                                'today',
                            ]
                        )
                            ->middleware(
                                'throttle:60,1'
                            )
                            ->name(
                                'today'
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | Protected Morning / Afternoon Session Selfies
                        |--------------------------------------------------------------------------
                        */

                        Route::get(
                            '/sessions/{session}/selfie/{type}',
                            [
                                StudentAttendanceEvidenceController::class,
                                'sessionSelfie',
                            ]
                        )
                            ->whereNumber(
                                'session'
                            )
                            ->whereIn(
                                'type',
                                [
                                    'time-in',
                                    'time-out',
                                ]
                            )
                            ->middleware(
                                'throttle:120,1'
                            )
                            ->name(
                                'session-selfie'
                            );


                        Route::post(
                            '/time-in',
                            [
                                StudentAttendanceController::class,
                                'timeIn',
                            ]
                        )
                            ->middleware(
                                'throttle:10,1'
                            )
                            ->name(
                                'time-in'
                            );


                        Route::post(
                            '/time-out',
                            [
                                StudentAttendanceController::class,
                                'timeOut',
                            ]
                        )
                            ->middleware(
                                'throttle:10,1'
                            )
                            ->name(
                                'time-out'
                            );
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Student Timesheet
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/student/timesheet',
                [
                    StudentTimesheetController::class,
                    'show',
                ]
            )
                ->middleware(
                    'throttle:60,1'
                )
                ->name(
                    'student.timesheet'
                );


            /*
            |--------------------------------------------------------------------------
            | Student Daily Work Logs
            |--------------------------------------------------------------------------
            */

            Route::prefix(
                'student/work-logs'
            )
                ->name(
                    'student.work-logs.'
                )
                ->group(
                    function (): void {

                        Route::get(
                            '/',
                            [
                                StudentWorkLogController::class,
                                'index',
                            ]
                        )
                            ->middleware(
                                'throttle:60,1'
                            )
                            ->name(
                                'index'
                            );


                        Route::post(
                            '/',
                            [
                                StudentWorkLogController::class,
                                'store',
                            ]
                        )
                            ->middleware(
                                'throttle:10,1'
                            )
                            ->name(
                                'store'
                            );


                        Route::put(
                            '/{workLog}',
                            [
                                StudentWorkLogController::class,
                                'update',
                            ]
                        )
                            ->whereNumber(
                                'workLog'
                            )
                            ->middleware(
                                'throttle:10,1'
                            )
                            ->name(
                                'update'
                            );
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Student Schedule
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/student/schedule',
                [
                    StudentScheduleController::class,
                    'show',
                ]
            )
                ->middleware(
                    'throttle:60,1'
                )
                ->name(
                    'student.schedule'
                );


            /*
            |--------------------------------------------------------------------------
            | Supervisor Dashboard
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/supervisor/dashboard',
                [
                    SupervisorDashboardController::class,
                    'show',
                ]
            )
                ->middleware(
                    'throttle:60,1'
                )
                ->name(
                    'supervisor.dashboard'
                );


            /*
            |--------------------------------------------------------------------------
            | Supervisor Attendance Validation
            |--------------------------------------------------------------------------
            */

            Route::prefix(
                'supervisor/attendance'
            )
                ->name(
                    'supervisor.attendance.'
                )
                ->group(
                    function (): void {

                        Route::get(
                            '/',
                            [
                                SupervisorAttendanceController::class,
                                'index',
                            ]
                        )
                            ->middleware(
                                'throttle:60,1'
                            )
                            ->name(
                                'index'
                            );


                        Route::get(
                            '/{attendance}/selfie/{type}',
                            [
                                SupervisorAttendanceController::class,
                                'selfie',
                            ]
                        )
                            ->whereNumber(
                                'attendance'
                            )
                            ->whereIn(
                                'type',
                                [
                                    'time-in',
                                    'time-out',
                                ]
                            )
                            ->middleware(
                                'throttle:120,1'
                            )
                            ->name(
                                'selfie'
                            );


                        Route::patch(
                            '/{attendance}/validate',
                            [
                                SupervisorAttendanceController::class,
                                'validateAttendance',
                            ]
                        )
                            ->whereNumber(
                                'attendance'
                            )
                            ->middleware(
                                'throttle:20,1'
                            )
                            ->name(
                                'validate'
                            );


                        Route::patch(
                            '/{attendance}/reject',
                            [
                                SupervisorAttendanceController::class,
                                'reject',
                            ]
                        )
                            ->whereNumber(
                                'attendance'
                            )
                            ->middleware(
                                'throttle:20,1'
                            )
                            ->name(
                                'reject'
                            );


                        Route::get(
                            '/{attendance}',
                            [
                                SupervisorAttendanceController::class,
                                'show',
                            ]
                        )
                            ->whereNumber(
                                'attendance'
                            )
                            ->middleware(
                                'throttle:60,1'
                            )
                            ->name(
                                'show'
                            );
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Supervisor Daily Work Log Validation
            |--------------------------------------------------------------------------
            */

            Route::prefix(
                'supervisor/work-logs'
            )
                ->name(
                    'supervisor.work-logs.'
                )
                ->group(
                    function (): void {

                        Route::get(
                            '/',
                            [
                                SupervisorWorkLogController::class,
                                'index',
                            ]
                        )
                            ->middleware(
                                'throttle:60,1'
                            )
                            ->name(
                                'index'
                            );


                        Route::patch(
                            '/{workLog}/validate',
                            [
                                SupervisorWorkLogController::class,
                                'validateWorkLog',
                            ]
                        )
                            ->whereNumber(
                                'workLog'
                            )
                            ->middleware(
                                'throttle:20,1'
                            )
                            ->name(
                                'validate'
                            );


                        Route::patch(
                            '/{workLog}/reject',
                            [
                                SupervisorWorkLogController::class,
                                'reject',
                            ]
                        )
                            ->whereNumber(
                                'workLog'
                            )
                            ->middleware(
                                'throttle:20,1'
                            )
                            ->name(
                                'reject'
                            );


                        Route::get(
                            '/{workLog}',
                            [
                                SupervisorWorkLogController::class,
                                'show',
                            ]
                        )
                            ->whereNumber(
                                'workLog'
                            )
                            ->middleware(
                                'throttle:60,1'
                            )
                            ->name(
                                'show'
                            );
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Supervisor Student Monitoring
            |--------------------------------------------------------------------------
            */

            Route::prefix(
                'supervisor/students'
            )
                ->name(
                    'supervisor.students.'
                )
                ->group(
                    function (): void {

                        Route::get(
                            '/',
                            [
                                SupervisorStudentController::class,
                                'index',
                            ]
                        )
                            ->middleware(
                                'throttle:60,1'
                            )
                            ->name(
                                'index'
                            );


                        Route::get(
                            '/{assignment}',
                            [
                                SupervisorStudentController::class,
                                'show',
                            ]
                        )
                            ->whereNumber(
                                'assignment'
                            )
                            ->middleware(
                                'throttle:60,1'
                            )
                            ->name(
                                'show'
                            );
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Supervisor Final Evaluation
            |--------------------------------------------------------------------------
            */

            Route::prefix(
                'supervisor/evaluations'
            )
                ->name(
                    'supervisor.evaluations.'
                )
                ->group(
                    function (): void {

                        Route::get(
                            '/{assignment}',
                            [
                                SupervisorEvaluationController::class,
                                'show',
                            ]
                        )
                            ->whereNumber(
                                'assignment'
                            )
                            ->middleware(
                                'throttle:60,1'
                            )
                            ->name(
                                'show'
                            );


                        Route::post(
                            '/{assignment}',
                            [
                                SupervisorEvaluationController::class,
                                'store',
                            ]
                        )
                            ->whereNumber(
                                'assignment'
                            )
                            ->middleware(
                                'throttle:10,1'
                            )
                            ->name(
                                'store'
                            );


                        Route::put(
                            '/{assignment}',
                            [
                                SupervisorEvaluationController::class,
                                'update',
                            ]
                        )
                            ->whereNumber(
                                'assignment'
                            )
                            ->middleware(
                                'throttle:10,1'
                            )
                            ->name(
                                'update'
                            );
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Logout
            |--------------------------------------------------------------------------
            */

            Route::post(
                '/logout',
                [
                    MobileAuthController::class,
                    'logout',
                ]
            )
                ->middleware(
                    'throttle:20,1'
                )
                ->name(
                    'logout'
                );
        });
    });
