<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditLogService
{
    /**
     * Store a permanent Audit Log entry.
     *
     * Important:
     *
     * Never pass passwords, password hashes,
     * GPS coordinates, selfie paths or other
     * unnecessary sensitive values in metadata.
     */
    public function record(
        string $action,
        ?Model $subject,
        string $description,
        array $metadata = [],
        ?User $actor = null
    ): AuditLog {
        /*
        |--------------------------------------------------------------------------
        | Resolve Actor
        |--------------------------------------------------------------------------
        */

        if (! $actor) {
            $authenticated =
                Auth::user();

            if ($authenticated instanceof User) {
                $actor =
                    $authenticated;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Request Context
        |--------------------------------------------------------------------------
        */

        $request =
            app()->bound('request')
                ? request()
                : null;

        $ipAddress =
            $request?->ip();

        $userAgent =
            $request?->userAgent();

        $routeName =
            $request
                ?->route()
                ?->getName();

        $method =
            $request?->method();

        /*
        |--------------------------------------------------------------------------
        | Safe Metadata
        |--------------------------------------------------------------------------
        */

        $safeMetadata =
            array_merge(
                [
                    'route' =>
                        $routeName,

                    'method' =>
                        $method,
                ],
                $metadata
            );

        /*
        |--------------------------------------------------------------------------
        | Create Immutable-Style Record
        |--------------------------------------------------------------------------
        */

        return AuditLog::create([
            'user_id' =>
                $actor?->id,

            'action' =>
                mb_substr(
                    $action,
                    0,
                    100
                ),

            'description' =>
                mb_substr(
                    $description,
                    0,
                    500
                ),

            'auditable_type' =>
                $subject
                    ? $subject->getMorphClass()
                    : null,

            'auditable_id' =>
                $subject
                    ? $subject->getKey()
                    : null,

            'metadata' =>
                $safeMetadata,

            'ip_address' =>
                $ipAddress
                    ? mb_substr(
                        $ipAddress,
                        0,
                        45
                    )
                    : null,

            'user_agent' =>
                $userAgent
                    ? mb_substr(
                        $userAgent,
                        0,
                        500
                    )
                    : null,
        ]);
    }
}