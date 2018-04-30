<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Payment;

class PaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $payment;

    /**
     * Create a new message instance.
     *
     * @param Payment $payment
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $payment = $this->payment;
        return $this
            ->subject('Votre paiement a été enregistré')
            ->view('email.payment', compact('payment'));
    }
}
