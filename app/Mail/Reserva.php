<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Reserva extends Mailable
{
    use Queueable, SerializesModels;

    public $nombreUsuario;
    public $fecha;
    public $nombreRestaurante;

    /**
     * Create a new message instance.
     */
    public function __construct($nombreUsuario, $fecha, $nombreRestaurante)
    {
        $this->nombreUsuario = $nombreUsuario;
        $this->fecha = $fecha;
        $this->nombreRestaurante = $nombreRestaurante;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmación de Reserva',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reserva', // Asume que la vista se llama 'emails.reserva.blade.php'
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}