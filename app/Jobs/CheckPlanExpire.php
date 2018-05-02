<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\User;
use DateTime;
use DateInterval;
use Carbon\Carbon;

use App\Jobs\SendPlanExpiredMail;
use App\Jobs\SendPlanExpireMail;

class CheckPlanExpire implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $count = 1;
        $users = User::all();
        foreach ($users as $user) {
            $payment = $user->lastPayment();
            if($payment != null)
            {
                $limitDate = new DateTime($payment->limit_date);
                $now = new DateTime('now');
                if($limitDate < $now && $user->id_plan != null) //Plan expired
                {
                    $user->id_plan = null;
                    $user->sent_expired_email = false;
                    $user->save();

                    //Send plan expired mail
                    $emailJob = (new SendPlanExpiredMail($user))->delay(Carbon::now()->addSeconds(10*$count));
                    dispatch($emailJob);

                    $count++;
                }
                else if(!$user->sent_expired_email)
                {
                    //Almost expired
                    $now->add(new DateInterval('P7D'));

                    if($limitDate < $now)
                    {
                        //Send mail

                        $user->sent_expired_email = true;
                        $user->save();

                        $emailJob = (new SendPlanExpireMail($user))->delay(Carbon::now()->addSeconds(10*$count));
                        dispatch($emailJob);

                        $count++;
                    }
                }
            }
        }
    }
}
