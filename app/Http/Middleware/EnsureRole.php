<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {
        $user = $request->user();

        if (! $user) {
            abort(401);
        }

        /*
        |--------------------------------------------------------------------------
        | Block inactive accounts
        |--------------------------------------------------------------------------
        */

        if ($user->status !== User::STATUS_ACTIVE) {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()
                ->route('home')
                ->with(
                    'error',
                    'Your account is currently inactive. Please contact the administrator.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Check allowed roles
        |--------------------------------------------------------------------------
        */

        if (! in_array($user->role, $roles, true)) {
            abort(403, 'You are not authorized to access this page.');
        }

        return $next($request);
    }
}