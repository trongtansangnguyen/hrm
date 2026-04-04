<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CandidateApplicationReceivedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $fullName,
        public string $positionTitle
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Da nhan ho so ung tuyen cua ban',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.candidate-application-received',
            with: [
                'fullName' => $this->fullName,
                'positionTitle' => $this->positionTitle,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
