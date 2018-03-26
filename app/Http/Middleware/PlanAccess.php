<?php

namespace App\Http\Middleware;

use Closure;

//Should only be used after 'auth:web' middleware
class PlanAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if(Auth::guard('web')->check())
        {
            $user = Auth::user();
            $plan = $user->plan()->first();
            if(empty($plan) ||
                ($permission == 'reserve' && !$plan->reserve) ||
                ($permission == 'order_meal' && !$plan->order_meal))
                    abort(403);
        }
        return $next($request);
    }
}
