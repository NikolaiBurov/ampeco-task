<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\PriceNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationsExceedingPrice extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public readonly PriceNotification $notification
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('mail.from.address'),
            subject: 'Bitcoin Exceeding given price',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.notifications-exceeding-price',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
