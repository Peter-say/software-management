<?php

namespace App\Mail\Api;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetCode;

    /**
     * Create a new message instance.
     */
    public function __construct($resetCode)
    {
        $this->resetCode = $resetCode;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Reset Your Password')
                    ->markdown('emails.reset-password');
    }
}