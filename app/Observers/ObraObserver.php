<?php

namespace App\Observers;

use Carbon\Carbon;
use App\_clases\proyectos\Obra;
use App\_clases\proyectos\ActividadObra;

class ObraObserver
{

    public function created(Obra $obra)
    {
        $counter = 0;
        $counter2 = 0;
        $orden = 0;
        $plazo = 0;
        $contador = 0;
        if (!($obra->obr_fecha_contrato == '0000-00-00' || $obra->obr_fecha_contrato == null) || $obra->obr_tipo_contrato == 2 || $obra->obr_plazo > 0) {
            $tempF = $obra->obr_fecha_contrato;
            $fecha = $tempF->copy()->addDays(15);
            $plazo = $obra->obr_plazo;

            $actividad = new ActividadObra();
            $actividad->aco_inicio = $tempF;
            $actividad->aco_programado = $fecha;
            $actividad->aco_ideal = $fecha;
            $actividad->aco_orden = 1;
            $actividad->actividad_idactividad = 2;
            $actividad->obra_idobra = $obra->idobra;
            $actividad->save();

            $actividad1 = new ActividadObra();
            $actividad1->aco_inicio = $tempF;
            $actividad1->aco_programado = $fecha;
            $actividad1->aco_ideal = $fecha;
            $actividad1->aco_orden = 1;
            $actividad1->actividad_idactividad = 3;
            $actividad1->obra_idobra = $obra->idobra;
            $actividad1->save();

            $actividad2 = new ActividadObra();
            $actividad2->aco_inicio = $tempF;
            $actividad2->aco_programado = $fecha;
            $actividad2->aco_ideal = $fecha;
            $actividad2->aco_orden = 1;
            $actividad2->actividad_idactividad = 4;
            $actividad2->obra_idobra = $obra->idobra;
            $actividad2->save();

            $actividad3 = new ActividadObra();
            $actividad3->aco_inicio = $tempF;
            $actividad3->aco_programado = $fecha;
            $actividad3->aco_ideal = $fecha;
            $actividad3->aco_orden = 1;
            $actividad3->actividad_idactividad = 5;
            $actividad3->obra_idobra = $obra->idobra;
            $actividad3->save();

            $actividad4 = new ActividadObra();
            $actividad4->aco_inicio = $tempF;
            $actividad4->aco_programado = $fecha;
            $actividad4->aco_ideal = $fecha;
            $actividad4->aco_orden = 1;
            $actividad4->actividad_idactividad = 6;
            $actividad4->obra_idobra = $obra->idobra;
            $actividad4->save();

            $tempF = $fecha;
            $cond = true;
            while ($cond) {
                if ($orden >= 100) {
                    $cond = false;
                    break;
                }
                $tempF = $tempF->copy()->addDays(1);
                $tempF2 = $tempF;
                $tempF = $tempF->copy()->lastOfMonth();
                $counter = $counter + $tempF->diffInDays($fecha);
                $orden++;
                $fecha = $tempF;
                if ($counter >= $plazo) {
                    if ($counter2 < $plazo) {
                        $fecha = $fecha->year . '-' . $fecha->month . '-' . ($plazo - $counter2);
                        $counter2 = $counter2 + 100;
                    } else {
                        $cond = false;
                        break;
                    }
                } else {
                    $counter2 = $counter;
                }
                $actividad5 = new ActividadObra();
                $actividad5->aco_inicio = $tempF2;
                $actividad5->aco_programado = $fecha;
                $actividad5->aco_ideal = $fecha;
                $actividad5->aco_orden = $orden;
                $actividad5->actividad_idactividad = 7;
                $actividad5->obra_idobra = $obra->idobra;
                $actividad5->save();
            }
        }
    }

    public
    function updated(Obra $obra)
    {
        //
    }

    public
    function deleted(Obra $obra)
    {
        //
    }

    public
    function restored(Obra $obra)
    {
        //
    }

    public
    function forceDeleted(Obra $obra)
    {
        //
    }
}
