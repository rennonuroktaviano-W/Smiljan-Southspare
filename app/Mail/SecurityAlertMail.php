<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SecurityAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $event,
        public ?string $ip = null,
        public ?string $userAgent = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Peringatan Keamanan — '.config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.security-alert',
        );
    }
}
