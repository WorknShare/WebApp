<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\ReserveRoom;

class SendReserveRoomCanceledMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $reserve;
    protected $message;
    /**
     * Create a new job instance.
     *
     * @return void
     */
     public function __construct(User $user, ReserveRoom $reserve, $message)
     {
         $this->user = $user;
         $this->reserve = $reserve;
         $this->message = $message;
     }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $mail = new \App\Mail\ReserveRoomCancelMail($this->user, $this->reserve, $this->message);
      Mail::to($this->user->email)->send($mail);
    }
}
