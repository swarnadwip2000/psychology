<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\UserSubscription;

class SubscriptionConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $userSubscription;

    /**
     * Create a new message instance.
     */
    public function __construct(UserSubscription $userSubscription)
    {
        $this->userSubscription = $userSubscription;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Subscription Confirmation')
            ->view('frontend.email.subscription_confirmation');
    }
}
