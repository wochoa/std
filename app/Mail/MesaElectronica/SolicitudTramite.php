<?php

namespace App\Mail\MesaElectronica;

use App\Models\MesaElectronica\DocumentoExterno;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SolicitudTramite extends Mailable
{
    use Queueable, SerializesModels;

    public $doc;

    /**
     * Create a new message instance.
     *
     * @param DocumentoExterno $doc
     */
    public function __construct(DocumentoExterno $doc)
    {
        $this->subject='Solicitud de trámite recibida';
        $this->doc = $doc;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.MesaElectronica.solicitudTramite');
    }
}
