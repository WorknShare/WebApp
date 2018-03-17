<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ChangedPasswordMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $employee = Auth::user();
        if(!$employee->changed_password)
        {
            return new RedirectResponse(url('admin/employee/'. $employee->id_employee . '/editpasswordprompt'));
        }
        return $next($request);
    }
}
