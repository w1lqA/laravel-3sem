<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DailyStatsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $stats;

    public function __construct(array $stats)
    {
        $this->stats = $stats;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Статистика сайта - ' . $this->stats['date'],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.stats.daily',
        );
    }
}