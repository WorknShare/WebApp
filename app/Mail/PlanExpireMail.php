<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;

class PlanExpireMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $username = $this->user->surname;
        $payment = $this->user->lastPayment();
        $plan = $payment->plan()->first();
        return $this
            ->subject('Votre forfait arrive bientôt à expiration')
            ->view('email.expire', compact('username', 'plan', 'payment'));
    }
}
