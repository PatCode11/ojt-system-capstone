<?php

namespace App\Providers;

use App\Models\AttendanceRecord;
use App\Models\Company;
use App\Models\DailyWorkLog;
use App\Models\OjtAssignment;
use App\Models\SupervisorEvaluation;
use App\Models\User;

use App\Observers\AttendanceRecordObserver;
use App\Observers\CompanyObserver;
use App\Observers\DailyWorkLogObserver;
use App\Observers\OjtAssignmentObserver;
use App\Observers\SupervisorEvaluationObserver;
use App\Observers\UserObserver;

use App\Services\AuditLogService;

use Illuminate\Auth\Events\Failed as FailedLogin;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap application services.
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Database String Length Compatibility
        |--------------------------------------------------------------------------
        */

        Schema::defaultStringLength(
            191
        );

        /*
        |--------------------------------------------------------------------------
        | Model Observers
        |--------------------------------------------------------------------------
        */

        User::observe(
            UserObserver::class
        );

        Company::observe(
            CompanyObserver::class
        );

        OjtAssignment::observe(
            OjtAssignmentObserver::class
        );

        AttendanceRecord::observe(
            AttendanceRecordObserver::class
        );

        DailyWorkLog::observe(
            DailyWorkLogObserver::class
        );

        SupervisorEvaluation::observe(
            SupervisorEvaluationObserver::class
        );

        /*
        |--------------------------------------------------------------------------
        | Successful Login
        |--------------------------------------------------------------------------
        */

        Event::listen(
            Login::class,
            function (Login $event): void {
                if (
                    ! $event->user instanceof User
                ) {
                    return;
                }

                app(AuditLogService::class)
                    ->record(
                        'auth.login_success',
                        $event->user,
                        sprintf(
                            'Successful login for %s.',
                            $event->user->name
                        ),
                        [
                            'account_id' =>
                                $event->user->id,

                            'role' =>
                                $event->user->role,
                        ],
                        $event->user
                    );
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Failed Login
        |--------------------------------------------------------------------------
        */

        Event::listen(
            FailedLogin::class,
            function (FailedLogin $event): void {
                $email =
                    isset(
                        $event->credentials['email']
                    )
                        ? mb_substr(
                            (string) $event
                                ->credentials['email'],
                            0,
                            255
                        )
                        : null;

                $subject =
                    $event->user instanceof User
                        ? $event->user
                        : null;

                app(AuditLogService::class)
                    ->record(
                        'auth.login_failed',
                        $subject,
                        $email
                            ? sprintf(
                                'Failed login attempt for %s.',
                                $email
                            )
                            : 'Failed login attempt.',
                        [
                            /*
                            |--------------------------------------------------------------------------
                            | Email Only
                            |--------------------------------------------------------------------------
                            |
                            | Never save the password from credentials.
                            |
                            */

                            'email' =>
                                $email,
                        ]
                    );
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Logout
        |--------------------------------------------------------------------------
        */

        Event::listen(
            Logout::class,
            function (Logout $event): void {
                if (
                    ! $event->user instanceof User
                ) {
                    return;
                }

                app(AuditLogService::class)
                    ->record(
                        'auth.logout',
                        $event->user,
                        sprintf(
                            '%s logged out.',
                            $event->user->name
                        ),
                        [
                            'account_id' =>
                                $event->user->id,

                            'role' =>
                                $event->user->role,
                        ],
                        $event->user
                    );
            }
        );
    }
}