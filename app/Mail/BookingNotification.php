<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;
    public $recipientType;

    /**
     * Create a new message instance.
     *
     * @param array $emailData
     * @param string $recipientType
     */
    public function __construct($emailData, $recipientType)
    {
        $this->emailData = $emailData;
        $this->recipientType = $recipientType;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->recipientType === 'teacher'
            ? 'Your new Booking Notification'
            : 'Booking Confirmation';

        return $this->view('frontend.email.booking_notification')
                    ->with(['emailData' =>$this->emailData, 'recipientType' => $this->recipientType])
                    ->subject($subject);
    }
}
