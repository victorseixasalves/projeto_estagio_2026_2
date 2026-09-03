<?php

namespace App\Mail;

use App\Models\Socio;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SocioStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Socio $socio,
        public string $novoStatus,
    ) {}

    public function envelope(): Envelope
    {
        $assunto = $this->novoStatus === 'confirmado'
            ? 'Seu cadastro de sócio foi confirmado!'
            : 'Sobre o seu cadastro de sócio';

        return new Envelope(
            subject: $assunto,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.socio-status',
        );
    }
}