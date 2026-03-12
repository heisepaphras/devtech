<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
{
    /**
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $user = $request->user();

        if (! $user || ! $user->is_admin) {
            if ($user && ! $user->is_admin) {
                Auth::logout();
            }

            return redirect()
                ->route('admin.login')
                ->with('status', 'Please sign in with an admin account.');
        }

        return $next($request);
    }
}
