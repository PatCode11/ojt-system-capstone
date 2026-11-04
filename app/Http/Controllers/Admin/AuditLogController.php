<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuditLogController extends Controller
{
    /**
     * Display Audit Logs.
     */
    public function index(
        Request $request
    ): View {
        $request->merge([
            'search' =>
                trim(
                    (string) $request->input(
                        'search',
                        ''
                    )
                ),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        $filters =
            $request->validate([
                'search' => [
                    'nullable',
                    'string',
                    'max:150',
                ],

                'action' => [
                    'nullable',
                    'string',
                    'max:100',
                ],

                'user_id' => [
                    'nullable',
                    'integer',
                    'exists:users,id',
                ],

                'date_from' => [
                    'nullable',
                    'date',
                ],

                'date_to' => [
                    'nullable',
                    'date',
                    'after_or_equal:date_from',
                ],
            ]);

        /*
        |--------------------------------------------------------------------------
        | Audit Query
        |--------------------------------------------------------------------------
        */

        $query =
            AuditLog::query()
                ->with('actor');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (
            isset($filters['search'])
            && $filters['search'] !== ''
        ) {
            $search =
                $filters['search'];

            $query->where(
                function (Builder $query) use ($search): void {
                    $query
                        ->where(
                            'action',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'description',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'auditable_type',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhereHas(
                            'actor',
                            function (Builder $actorQuery) use ($search): void {
                                $actorQuery
                                    ->where(
                                        'name',
                                        'like',
                                        "%{$search}%"
                                    )
                                    ->orWhere(
                                        'email',
                                        'like',
                                        "%{$search}%"
                                    );
                            }
                        );
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Action Filter
        |--------------------------------------------------------------------------
        */

        if (
            isset($filters['action'])
            && $filters['action'] !== ''
        ) {
            $query->where(
                'action',
                $filters['action']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Actor Filter
        |--------------------------------------------------------------------------
        */

        if (
            isset($filters['user_id'])
            && $filters['user_id']
        ) {
            $query->where(
                'user_id',
                $filters['user_id']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Date Range
        |--------------------------------------------------------------------------
        */

        if (
            isset($filters['date_from'])
            && $filters['date_from'] !== ''
        ) {
            $query->whereDate(
                'created_at',
                '>=',
                $filters['date_from']
            );
        }

        if (
            isset($filters['date_to'])
            && $filters['date_to'] !== ''
        ) {
            $query->whereDate(
                'created_at',
                '<=',
                $filters['date_to']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Paginate
        |--------------------------------------------------------------------------
        */

        $auditLogs =
            $query
                ->latest('id')
                ->paginate(25)
                ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Filter Dropdown Data
        |--------------------------------------------------------------------------
        */

        $actions =
            AuditLog::query()
                ->select('action')
                ->distinct()
                ->orderBy('action')
                ->pluck('action');

        $actors =
            User::query()
                ->orderBy('name')
                ->get([
                    'id',
                    'name',
                    'email',
                    'role',
                ]);

        /*
        |--------------------------------------------------------------------------
        | Security Statistics
        |--------------------------------------------------------------------------
        */

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

        $auditEventsLast24Hours =
            AuditLog::query()
                ->where(
                    'created_at',
                    '>=',
                    now()->subDay()
                )
                ->count();

        return view(
            'admin.audit-logs.index',
            compact(
                'auditLogs',
                'actions',
                'actors',
                'filters',
                'failedLoginsLast24Hours',
                'auditEventsLast24Hours'
            )
        );
    }

    /**
     * Display one Audit Log.
     */
    public function show(
        AuditLog $auditLog
    ): View {
        $auditLog->load([
            'actor',
            'auditable',
        ]);

        return view(
            'admin.audit-logs.show',
            compact(
                'auditLog'
            )
        );
    }
}