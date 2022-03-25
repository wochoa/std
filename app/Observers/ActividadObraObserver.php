<?php

namespace App\Observers;

use App\_clases\proyectos\ActividadObra;
use App\_clases\proyectos\Actividad;

class ActividadObraObserver
{

    public function created(ActividadObra $actividadObra)
    {
        $actividad = Actividad::select('act_plazo_probable', 'act_accion')
            ->where('idactividad', '=', $actividadObra->actividad_idactividad)
            ->first();
        if ($actividadObra->aco_programado == null && $actividadObra->actividad_idactividad != 7) {
            $actividadObra->aco_programado = $actividadObra->aco_inicio->copy()->addDays($actividad->act_plazo_probable);
            if ($actividad->act_accion != 0) {
                $actividadObra->aco_ocurrencia = $actividadObra->aco_inicio->copy()->addDays($actividadObra->aco_accion_numero);
            }
        }
        if (!($actividad->act_accion  == 0 || $actividad->act_accion  == 4 || $actividad->act_accion  == 5 || $actividad->act_accion  == 6)) {
            $actividadObra->aco_ocurrencia = $actividadObra->aco_inicio->copy()->addDays($actividadObra->aco_accion_numero);
            $actividadObra->aco_programado = $actividadObra->aco_inicio->copy()->addDays($actividadObra->aco_accion_numero);
        }
        $actividadObra->save();
    }

    public function updated(ActividadObra $actividadObra)
    {
        //
    }

    public function deleted(ActividadObra $actividadObra)
    {
        //
    }

    public function restored(ActividadObra $actividadObra)
    {
        //
    }

    public function forceDeleted(ActividadObra $actividadObra)
    {
        //
    }
}
