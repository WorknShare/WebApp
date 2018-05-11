<?php

namespace App\Jobs;

use App\User;
use App\Equipment;
use App\ReserveRoom;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;


class DeletedItemMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $equipment;
    protected $reserve_room;

    /**
     * Create a new job instance.
     *
     * @return void
     */
     public function __construct(User $user, Equipment $equipment, ReserveRoom $reserve_room)
     {
         $this->user = $user;
         $this->equipment = $equipment;
         $this->reserve_room = $reserve_room;
     }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $mail = new \App\Mail\DeletedItemMail($this->user, $this->equipment, $this->reserve_room);
      Mail::to($this->user->email)->send($mail);
    }
}
