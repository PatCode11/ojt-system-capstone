<?php

namespace App\Observers;

use App\Models\User;
use App\Services\AuditLogService;

class UserObserver
{
    /**
     * Account created.
     */
    public function created(
        User $user
    ): void {
        app(AuditLogService::class)
            ->record(
                'account.created',
                $user,
                sprintf(
                    '%s account created for %s.',
                    ucfirst($user->role),
                    $user->name
                ),
                [
                    'account_id' =>
                        $user->id,

                    'role' =>
                        $user->role,

                    'status' =>
                        $user->status,
                ]
            );
    }

    /**
     * Account updated.
     */
    public function updated(
        User $user
    ): void {
        $monitoredFields = [
            'name',
            'email',
            'password',
            'role',
            'status',
        ];

        $changedFields =
            array_values(
                array_intersect(
                    array_keys(
                        $user->getChanges()
                    ),
                    $monitoredFields
                )
            );

        /*
        |--------------------------------------------------------------------------
        | Ignore Non-Security Changes
        |--------------------------------------------------------------------------
        */

        if ($changedFields === []) {
            return;
        }

        $passwordChanged =
            in_array(
                'password',
                $changedFields,
                true
            );

        $statusChanged =
            in_array(
                'status',
                $changedFields,
                true
            );

        /*
        |--------------------------------------------------------------------------
        | Determine Semantic Action
        |--------------------------------------------------------------------------
        */

        if ($statusChanged) {
            $action =
                'account.status_changed';

            $description =
                sprintf(
                    '%s account status changed to %s.',
                    $user->name,
                    $user->status
                );
        } elseif ($passwordChanged) {
            $action =
                'account.password_changed';

            $description =
                sprintf(
                    'Password changed for %s.',
                    $user->name
                );
        } else {
            $action =
                'account.updated';

            $description =
                sprintf(
                    'Account information updated for %s.',
                    $user->name
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Never Store Password Values
        |--------------------------------------------------------------------------
        */

        app(AuditLogService::class)
            ->record(
                $action,
                $user,
                $description,
                [
                    'account_id' =>
                        $user->id,

                    'role' =>
                        $user->role,

                    'status' =>
                        $user->status,

                    'changed_fields' =>
                        $changedFields,

                    'password_changed' =>
                        $passwordChanged,
                ]
            );
    }

    /**
     * Account deleted.
     *
     * There is currently no normal deletion route,
     * but we audit it if deletion ever happens.
     */
    public function deleted(
        User $user
    ): void {
        app(AuditLogService::class)
            ->record(
                'account.deleted',
                $user,
                sprintf(
                    '%s account deleted.',
                    $user->name
                ),
                [
                    'account_id' =>
                        $user->id,

                    'role' =>
                        $user->role,
                ]
            );
    }
}