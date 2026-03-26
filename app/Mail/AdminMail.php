<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $data;

    public $tries = 5;
    public $backoff = 60;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Admin Mail',
        );
    }


    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'superadmin.sendData',
            with: ['data' => $this->data],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
