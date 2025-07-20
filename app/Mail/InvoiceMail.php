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
class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $filePath;
    public $quote;

    public function __construct($filePath, $quote)
    {
        $this->filePath = $filePath;
        $this->quote = $quote;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
  public function attachments(): array
{
    $path = $this->filePath;


    if (!$path || !Storage::disk('public')->exists($path)) {

        return [];
    }

    return [
        Attachment::fromPath(Storage::disk('public')->path($path))
            ->as('Invoice.pdf')
            ->withMime('application/pdf'),
    ];
}
}
