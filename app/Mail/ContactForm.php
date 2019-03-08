<?php

namespace BlaudCMS\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactForm extends Mailable
{
    use Queueable, SerializesModels;

    public $contactFormFields;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contactFormFields)
    {
        $this->contactFormFields = $contactFormFields;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@observatorioanticorrupcion.com')
                    ->subject('Formulario de Contacto - Observatorio anti Corrupción')
                    ->view('frontend.emails.contact-form');
    }
}
