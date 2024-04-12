<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $code;
    /**
     * Create a new message instance.
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Get the message envelope.
     */

    public function build()
    {
        $content = "<html> Hola <br>";
        $content .= "Recibes este correo electrónico porque hemos recibido una solicitud de una creación de una cuenta en Cinexperto.<br>";
        $content .= "Debes digitar el siguiente codigo de 6 digitos para verificar tu cuenta. <br>";
        $content .= "Codigo: <b>".$this->code."</b> <br>";
        $content .= "Si no realizaste esta solicitud, puedes ignorar este correo.</html>";
        return $this
            ->subject('Verificacion del email')
            ->html($content);
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
