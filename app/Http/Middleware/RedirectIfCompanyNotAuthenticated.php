<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfCompanyNotAuthenticated
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'company')
    {
        if (! Auth::guard($guard)->check()) {

            /* /login redirects to jobseeker auth in web.php — employers must use employer login. */

            return redirect()->guest(route('employer.login'));

        }
        return $next($request);
    }

}
