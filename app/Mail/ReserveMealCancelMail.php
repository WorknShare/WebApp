<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\ReserveMeal;

class ReserveMealCancelMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $meal;
    protected $message_send;

    /**
     * Create a new message instance.
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      $username = $this->user->surname;
      $command_number = $this->meal->command_number;
      $message_send = $this->message_send;
      return $this
          ->subject('Commande n°'.$command_number.' annulée!')
          ->view('email.order_meal_canceled', compact('username', 'command_number', 'message_send'));
    }
}
