<?php

namespace App\Mail;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewArticleNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Новая статья опубликована: ' . $this->article->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.articles.new', // Указывает на созданный шаблон
        );
    }
}