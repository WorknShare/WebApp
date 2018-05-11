<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\ReserveMeal;

class SendReserveMealCanceledMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $meal;
    protected $message_send;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, ReserveMeal $meal, $message_send)
    {
      $this->user = $user;
      $this->meal = $meal;
      $this->message_send = $message_send;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $mail = new \App\Mail\ReserveMealCancelMail($this->user, $this->meal, $this->message_send);
      Mail::to($this->user->email)->send($mail);
    }
}
