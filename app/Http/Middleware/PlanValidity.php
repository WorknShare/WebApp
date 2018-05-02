<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use DateTime;
use DateInterval;

use Carbon\Carbon;
use App\Jobs\SendPlanExpiredMail;

//Should only be used after 'auth:web' middleware and before the plan access middleware
class PlanValidity
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
        if(Auth::guard('web')->check())
        {
            $user = Auth::user();
            $plan = $user->plan()->first();
            if(!empty($plan))
            {
                $limitDate = new DateTime(Auth::user()->lastPayment()->limit_date);
                $now = new DateTime('now');
                if($limitDate < $now) //Plan expired
                {
                    $user->id_plan = null;
                    $user->sent_expired_email = false;
                    $user->save();

                    //Send email
                    $emailJob = (new SendPlanExpiredMail($user))->delay(Carbon::now()->addSeconds(3));
                    dispatch($emailJob);
                }
                else
                {
                    //Almost expired
                    $now->add(new DateInterval('P7D'));

                    if($limitDate < $now)
                    {
                        $interval = $limitDate->diff($now, true)->format('%d');
                        if($interval == '0') $interval = 'aujourd\'hui';
                        else $interval = 'dans '.$interval.($interval == '1' ? ' jour' : ' jours');
                        View::share('planWarning' , $interval);
                        View::share('userPlan' , $plan);
                    }
                }

            }
        }
        
        return $next($request);
    }
}
