<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveApprovedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $employeeName,
        public string $fromDate,
        public string $toDate
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Don nghi phep da duoc duyet',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.leave-approved',
            with: [
                'employeeName' => $this->employeeName,
                'fromDate' => $this->fromDate,
                'toDate' => $this->toDate,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
