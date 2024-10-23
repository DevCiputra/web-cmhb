<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($token)
    {
        $this->resetUrl = route('password.reset.token', ['token' => $token]);
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Permintaan Reset Password')
            ->markdown('emails.password-reset')
            ->with(['resetUrl' => $this->resetUrl]);
    }
}
