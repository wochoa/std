<?php

namespace App\Http\Controllers;


use App\_clases\proyectos\plan\Programar;
use App\_clases\siaf\reportes\Asignacion;
use App\_clases\siaf\reportes\Certificado;
use App\_clases\siaf\reportes\Compromiso;
use App\_clases\siaf\reportes\Gasto;
use App\_clases\siaf\reportes\Presupuesto;
use App\Http\Controllers\Siaf\PresupuestoController;
use App\_clases\proyectos\PresupuestoMeta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GastosController extends Controller
{


    public function reporte(Request $request)
    {
        return call_user_func_array([$this, $request->rep], [$request, false]);
    }

    public function reporteador($reporte, Request $request)
    {
        return call_user_func_array([$this, $reporte], [$request, 'reporteador']);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function reporteGeneral(Request $request)
    {
        $anio            = $request->anio;
        $fechas          = $this->getFechasReporte();
        $oficina         = $request->oficina;
        $act_proy        = $request->act_proy;
        $show            = 100;
        $notas           = null;
        $cuentaCorriente = false;
        $anulaciones     = false;
        $girado         = false;
        //echo 'hola';
        $gastos        = Gasto::getGastos($anio, $oficina, $act_proy, $girado);
        $girados       = Gasto::getGastos($anio, $oficina, $act_proy, $girado = true);
        $reporteDiario = Gasto::informacionDiaria($gastos);
        $presupuesto   = Presupuesto::getPresupuestoResumen($anio, $oficina, $act_proy);
        $certificado   = Certificado::getCertificadoResumen($anio, $oficina, $act_proy, config('proyectos.unidad_ejecutora'));
        $compromiso    = Compromiso::getCompromisoResumen($anio, $oficina, $act_proy, config('proyectos.unidad_ejecutora'));

        $fechas['cert'] = $certificado;
        $fechas['cop']  = $compromiso;
        /*foreach ($fechas['resumen'] as $idFecha => $fecha) {
            $fechas['resumen'][$idFecha]['presupuesto'] = $presupuesto->pim;
            $fechas['resumen'][$idFecha]['certificado'] = round($certificado->where('fecha_doc', '<=', $fecha['date'])->sum('monto'), 2);
            $fechas['resumen'][$idFecha]['comprometido'] = round($compromiso->where('fecha_doc', '<=', $fecha['date'])->sum('monto'), 2);
            $fechas['resumen'][$idFecha]['devengado'] = round($gastos->where('fecha_autorizacion', '<=', $fecha['date'])->sum('monto'), 2);
        }*/
        foreach ($fechas['resumen'] as $idFecha => $fecha) {
            $fechas['resumen'][$idFecha]['presupuesto'] = $presupuesto->pim;
            $fechas['resumen'][$idFecha]['presupuesto'] = round($fechas['resumen'][$idFecha]['presupuesto'], 2);
            foreach ($certificado as $pres) {
                if ($pres->fecha_doc <= $fecha['date'])
                    $fechas['resumen'][$idFecha]['certificado'] += $pres->monto;
            }
            $fechas['resumen'][$idFecha]['certificado'] = round($fechas['resumen'][$idFecha]['certificado'], 2);
            foreach ($compromiso as $pres) {
                if ($pres->fecha_doc <= $fecha['date'])
                    $fechas['resumen'][$idFecha]['comprometido'] += $pres->monto;
            }
            $fechas['resumen'][$idFecha]['comprometido'] = round($fechas['resumen'][$idFecha]['comprometido'], 2);
            foreach ($gastos as $pres) {
                if ($pres->fecha_autorizacion <= $fecha['date'])
                    $fechas['resumen'][$idFecha]['devengado'] += $pres->monto;
            }
            $fechas['resumen'][$idFecha]['devengado'] = round($fechas['resumen'][$idFecha]['devengado'], 2);
            foreach ($girados as $pres) {
                if ($pres->fecha_autorizacion <= $fecha['date'])
                    $fechas['resumen'][$idFecha]['girado'] += $pres->monto;
            }
            $fechas['resumen'][$idFecha]['girado'] = round($fechas['resumen'][$idFecha]['girado'], 2);
        }
        //return 'a';
        $fechas['reportediario']    = $reporteDiario;
        $fechas['asignacion']       = Asignacion::getAsignacionResumen($anio, $oficina, $act_proy, config('proyectos.unidad_ejecutora'));
        $fechas['programado']       = Programar::getProgramacionResumen($anio, $oficina, $act_proy);
        $fechas['prioritario']      = Presupuesto::PresupuestoPrioritario($anio,$oficina);
        $fechas['cert']             = $certificado;
        $fechas['cop']              = $compromiso;
        $fechas['certificados']     = Certificado::getCertificados($anio, $oficina, $act_proy, $show, $notas, $cuentaCorriente, $anulaciones);
        $fechas['compromisosAnual'] = Compromiso::getCompromisosAnual($anio, $oficina, $act_proy, $show, $notas, $cuentaCorriente, $anulaciones);
        $fechas['compromisosMes']   = Gasto::getCompromisosMes($anio, $oficina, $act_proy, $show, $notas, $cuentaCorriente, $anulaciones);
        $fechas['devengados']       = Gasto::getDevengados($anio, $oficina, $act_proy, $show, $notas, $cuentaCorriente, $anulaciones, $girado);
        $fechas['girados']          = Gasto::getDevengados($anio, $oficina, $act_proy, $show, $notas, $cuentaCorriente, $anulaciones, $girado=true);
        return $fechas;

    }

    private function getFechasReporte()
    {
        $hoy = Carbon::today();
        /*        $mes           = $hoy->month;
                $mesAnterior   = Carbon::today()->firstOfMonth();
                $diaDeSemana   = $hoy->dayOfWeek;
                $ultimoViernes = Carbon::today()->subDays(($diaDeSemana + 2) % 7);
                if ($diaDeSemana == 5 || $diaDeSemana == 6 || $diaDeSemana == 0)
                    $ultimoViernes->subWeek();
                $ayer    = Carbon::yesterday();
                $acarreo = ['resumen' => []];
                if ($mes > 1)
                    $acarreo['resumen'][] = [
                        'name'         => 'Mes Anterior',
                        'date'         => $mesAnterior->subDay(),
                        'presupuesto'  => 0,
                        'certificado'  => 0,
                        'comprometido' => 0,
                        'devengado'    => 0,
                    ];
                if ($mes == $ultimoViernes->month)
                    $acarreo['resumen'][] = [
                        'name'         => 'Semana Anterior',
                        'date'         => $ultimoViernes,
                        'presupuesto'  => 0,
                        'certificado'  => 0,
                        'comprometido' => 0,
                        'devengado'    => 0,
                    ];
                if ($mes == $ayer->month)
                    $acarreo['resumen'][] = [
                        'name'         => 'Ayer',
                        'date'         => $ayer,
                        'presupuesto'  => 0,
                        'certificado'  => 0,
                        'comprometido' => 0,
                        'devengado'    => 0,
                    ];*/
        $acarreo['resumen'][] = [
            'name'         => 'Hoy',
            'date'         => $hoy,
            'presupuesto'  => 0,
            'certificado'  => 0,
            'comprometido' => 0,
            'devengado'    => 0,
            'girado'       => 0,
        ];
        return $acarreo;
    }

    public function cicloGasto(Request $request)
    {
        $girado         = false;
        switch ($request->tipo) {
            case '0':
            {
                return Certificado::getCertificados($request->anio, $request->oficina, $request->act_proy, $request->show, $request->notas, $request->cuentaCorriente, $request->anulaciones);
                break;
            }
            case '1':
            {
                return Compromiso::getCompromisosAnual($request->anio, $request->oficina, $request->act_proy, $request->show, $request->notas, $request->cuentaCorriente, $request->anulaciones);
                break;
            }
            case '2':
            {
                return Gasto::getCompromisosMes($request->anio, $request->oficina, $request->act_proy, $request->show, $request->notas, $request->cuentaCorriente, $request->anulaciones);
                break;
            }
            case '3':
            {
                return Gasto::getDevengados($request->anio, $request->oficina, $request->act_proy, $request->show, $request->notas, $request->cuentaCorriente, $request->anulaciones, $girado);
                break;
            }
            case '4':
            {
                return Gasto::getDevengados($request->anio, $request->oficina, $request->act_proy, $request->show, $request->notas, $request->cuentaCorriente, $request->anulaciones, $girado=true);
                break;
            }
        }
    }

    public function secfuncOficina(Request $request)
    {
        return PresupuestoMeta::getSecfuncOficina($request->anio);
    }

    public function presupuestoGastoProyecto()
    {
        return Gasto::getPresupuestoGastoProyectos();
    }

}
