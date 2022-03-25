<?php

namespace App\Mail\MesaElectronica;

use App\Models\Tramite\PersonaCorreo;
use App\Persona;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class validarCorreo extends Mailable
{
    use Queueable, SerializesModels;

    public $persona;
    public $correo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $persona, PersonaCorreo $correo)
    {
        $this->persona = $persona;
        $this->correo = $correo;
        $this->subject = 'Validación del Correo Electrónico';
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.MesaElectronica.verificacionCorreo');
    }
}
