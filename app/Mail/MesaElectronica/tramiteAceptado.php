<?php

namespace App\Mail\MesaElectronica;

use App\Dependencia;
use App\Documento;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class tramiteAceptado extends Mailable
{
    use Queueable, SerializesModels;

    public $doc;
    public $user;
    public $dependencia;
    /**
     * Create a new message instance.
     *
     * @param Documento $doc
     */
    public function __construct(Documento $doc)
    {
        $this->subject='Solicitud de trámite registrado';
        $this->doc       = $doc;
        $this->user = \App\User::find($this->doc->docu_idusuario);
        $this->user->load('dependencia');
        $this->dependencia = Dependencia::find($this->user->dependencia->depe_depende);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.MesaElectronica.tramiteAceptado');
    }
}
