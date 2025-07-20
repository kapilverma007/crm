<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Support\Facades\Storage;

class ContractMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
     public $record;

    /**
     * Create a new message instance.
     */
    public function __construct($record)
    {
        $this->record = $record;
    }


    /**
     * Get the message envelope.
     */
      public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Contract Document',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contract', // Update with your blade view name
            with: ['record' => $this->record],
        );
    }
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
 public function attachments(): array
{
    $path = $this->record->file_path;

    if (!$path || !Storage::disk('public')->exists($path)) {

        return [];
    }

    return [
        Attachment::fromPath(Storage::disk('public')->path($path))
            ->as('Contract.pdf')
            ->withMime('application/pdf'),
    ];
}
}
