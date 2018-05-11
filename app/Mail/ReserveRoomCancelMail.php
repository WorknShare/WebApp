<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\ReserveRoom;

class ReserveRoomCancelMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $reserve;
    protected $message;
    /**
     * Create a new message instance.
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      $username = $this->user->surname;
      $command_number = $this->reserve->command_number;
      $message_send = $this->message;
      return $this
          ->subject('Réservation n°'.$command_number.' annulée!')
          ->view('email.reserve_room_canceled', compact('username', 'command_number', 'message_send'));
    }
}
