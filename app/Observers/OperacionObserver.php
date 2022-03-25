<?php

namespace App\Observers;

use App\Operacion;

class OperacionObserver
{
    /**
     * Handle the operacion "created" event.
     *
     * @param \App\Operacion $operacion
     * @return void
     */
    public function created(Operacion $operacion)
    {
        if ($operacion->oper_idtope == 1 && env('SMS_WEBSERVICE') != null && strlen(env('SMS_WEBSERVICE')) > 10) {
            $operacion->load('documento');
            if ($operacion->documento->docu_telef != null && strlen($operacion->documento->docu_telef) == 9 && $operacion->documento->docu_origen == 2) {
                $operacion->documento->load('tipoDocumento');
                $operacion->load('dependencia');
                $ruta   = env('SMS_WEBSERVICE');
                $ruta   .= '?sms=';
                $ruta   .= urlencode("El documento {$operacion->documento->numero_documento} fue registrado en la  {$operacion->dependencia->depe_nombre} \nReg: {$operacion->documento->getIdString()}\nExp: {$operacion->documento->getExpedienteString()}");
                $ruta   .= "&numero=51{$operacion->documento->docu_telef}";
                $result = file_get_contents($ruta);
            }
        }
    }

    /**
     * Handle the operacion "updated" event.
     *
     * @param \App\Operacion $operacion
     * @return void
     */
    public function updated(Operacion $operacion)
    {
        //
    }

    /**
     * Handle the operacion "deleted" event.
     *
     * @param \App\Operacion $operacion
     * @return void
     */
    public function deleted(Operacion $operacion)
    {
        //
    }

    /**
     * Handle the operacion "restored" event.
     *
     * @param \App\Operacion $operacion
     * @return void
     */
    public function restored(Operacion $operacion)
    {
        //
    }

    /**
     * Handle the operacion "force deleted" event.
     *
     * @param \App\Operacion $operacion
     * @return void
     */
    public function forceDeleted(Operacion $operacion)
    {
        //
    }
}
