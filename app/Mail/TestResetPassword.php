<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Test Reset Password Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $this->user->email,
        ], false));

        return new Content(
            view: 'emails.reset',
            with: [
                'url' => $url,
                'user' => $this->user,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
