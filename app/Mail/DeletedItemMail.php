<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Equipment;
use App\ReserveRoom;


class DeletedItemMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $equipment;
    protected $reserve_room;

    /**
     * Create a new message instance.
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      $username = $this->user->surname;
      $command_number = $this->reserve_room->command_number;
      $serial_number = $this->equipment->serial_number;
      return $this
          ->subject('Matériel retiré de votre réservation n°'.$command_number.'!')
          ->view('email.deleteItem', compact('username', 'command_number', 'serial_number'));
    }
}
