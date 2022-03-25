<?php

namespace App\Mail\MesaElectronica;

use App\Dependencia;
use App\Models\MesaElectronica\DocumentoExterno;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ObservarTramite extends Mailable
{
    use Queueable, SerializesModels;

    public $doc;
    public $user;
    public $dependencia;

    /**
     * Create a new message instance.
     *
     * @param DocumentoExterno $doc
     */
    public function __construct(DocumentoExterno $doc)
    {
        $this->subject='Solicitud de trámite observado';
        $this->doc       = $doc;
        $this->user = \App\User::find($this->doc->updated_by);
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
        return $this->view('mail.MesaElectronica.observarTramite');
    }
}
