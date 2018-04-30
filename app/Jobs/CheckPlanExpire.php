<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\User;

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
        $users = User::all()->with('lastPayment');
        foreach ($user as $user) {
            $payment = $user->last_payment;
            if($payment != null)
            {
                $limitDate = new DateTime($payment->limit_date);
                $now = new DateTime('now');
                if($limitDate < $now && $user->id_plan != null) //Plan expired
                {
                    $user->id_plan = null;
                    $user->save();

                    //Send plan expired mail
                }
                else
                {
                    //Almost expired
                    $now->add(new DateInterval('P7D'));

                    if($limitDate < $now)
                    {
                        //Send mail

                    }
                }
            }
        }
    }
}
