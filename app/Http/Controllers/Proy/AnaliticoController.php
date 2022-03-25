<?php

namespace App\Http\Controllers\Proy;

use App\_clases\proyectos\analitico\Analitico;
use App\_clases\proyectos\analitico\Version;
use App\_clases\proyectos\Proyecto;
use App\_clases\proyectos\TablaAnaliticoPDFF;
use App\_clases\siaf\ElementoGasto;
use App\_clases\siaf\Especifica;
use App\_clases\proyectos\plan\cadena_funcional\Componente;
use App\_clases\siaf\reportes\Presupuesto;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Object_;
use Illuminate\Support\Facades\Response;

class AnaliticoController extends Controller
{
    //
    public static $especificas;
    public static $elemento;


    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {

        return Proyecto::GetEjecucionAcumulada($request->act_proy, '1');
    }

    public function print(Request $request)
    {

        $proyecto           = Proyecto::where('proy_cod_siaf', '=', $request->id)->get()[0];
        list($ejec, $an)    = Proyecto::GetEjecucionAcumulada2($request->id, '1');
        $analitico          = $this->ordenarAnalitico($an);
        $mytime             =  Carbon::now();
        $anio               = $mytime->year;

        $headers            = ['Content-Type' => 'application/pdf'];
        $version            = $request->version;
        list($ejecucion, $analitico) = Proyecto::GetEjecucionAcumuladaAnio($proyecto->proy_cod_siaf, $anio, $version);
        $especifias         = Especifica::getEspecificasToSelectCached();
        $elementos          = ElementoGasto::getElementoToSelectCached();
        $componentes        = Componente::getComponentesForShowCached();
        $presupuesto        = Presupuesto::getPresupuestoForProy($anio, $proyecto->proy_cod_siaf);
        $vers               = \App\_clases\proyectos\analitico\Version::find($request->version);
        $where=[
            ['proy_plan_proyecto', '=', $proyecto->proy_cod_siaf],
            ['proy_plan_anio', '=', $anio],
            ['version_id', '=', $request->version]
        ];


        $pdf = new tablaAnaliticoPDFF('P','mm','A3');
        if ($vers->id==1)
            $pdf->SetTitle('Linea de tiempo BORRADOR');
        else
            $pdf->SetTitle('Linea de tiempo version '.$vers->vers_version.' '.$vers->vers_fecha);
        $pdf->setHeader( $proyecto, $vers, User::find($vers->vers_responzable));
        $pdf->SetMargins((2*$pdf->cm),50,(2.5*$pdf->cm));
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();
        // Títulos de las columnas
        $header = array("\nCOMPONENTE\n", "\nESPECIFICA\n", "\nMONTO SNIP\nINICIAL", "\nMODIFICAC.\n", "\nCOSTO\nACTUALIZ", "\nACUM\n", "\nPIM\n", "\nSALDO\n");


        $pdf->Analitico($header, $especifias, $elementos,
            $componentes,$ejecucion, $analitico,
            $presupuesto);

        /*
        $header = array("\nCOMPONENTE\n", "\nTIPO\n", "\nUNIDAD DE\nMEDIDA", "\nMETA\n", "\nENE\n", "\nFEB\n", "\nMAR\n", "\nABR\n", "\nMAY\n",
            "\nJUN\n", "\nJUL\n", "\nAGO\n", "\nSET\n", "\nOCT\n", "\nNOV\n", "\nDIC\n", "\nTOTAL\n2018");
        $pdf->AddPage();
        $metas=SiafMeta::obtener_metas_por_proyecto_y_anio($proyecto->proy_cod_siaf, $anio, 'config('proyectos.unidad_ejecutora')');
        $arreglo=[];
        foreach ($metas as $meta){
            $arreglo[$meta->COMPONENTE]=$meta;
        }
        $pdf->LineaDeTiempoResumida($header,$prg,$especifias,
            $componentes,$ejecucion, $analitico,
            $presupuesto,
            $arreglo,SiafUnidadDeMedida::obtener_todo_para_select());
        */
        return Response::make($pdf->Output(),200,$headers);
    }

    private  function ordenarAnalitico($an)
    {
        $analitico = [];
        foreach ($an as $id => $dato) {
            uasort($dato, function ($a, $b) {
                $espa = Especifica::getEspecificasToSelectCached();
                $espb = Especifica::getEspecificasToSelectCached();
                if (!isset($espa[$a->ana_especifca])) $espa = ElementoGasto::getElementoToSelectCached();
                if (!isset($espb[$b->ana_especifca])) $espb = ElementoGasto::getElementoToSelectCached();
                if ($espa[$a->ana_especifca] == $espb[$b->ana_especifca]) {
                    return 0;
                }
                return ($espa[$a->ana_especifca] < $espb[$b->ana_especifca]) ? -1 : 1;
            });
            $analitico[$id] = $dato;
        }
        return $analitico;
    }

    public function listarVersionesAnalitico(Request $request)
    {
        return Version::where('vers_proyecto', '=', $request->act_proy)->get();
    }

    public function store(Request $request){

        $analitico                          = ($request->analitico_id == null)?new Analitico(): Analitico::find($request->analitico_id);
        $analitico->ana_act_proy            = $request->ana_act_proy;
        $analitico->ana_componente          = $request->ana_componente;
        $analitico->ana_especifca           = $request->ana_especifca;
        $analitico->ana_monto               = $request->ana_monto;
        $analitico->ana_modificaciones      = $request->ana_modificaciones    ;
        $analitico->ana_descricion          = $request->ana_descricion;
        $analitico->analitico_version_id    = $request->analitico_version_id;
        $analitico->save();

        return json_encode([
            'analitico_id'          => $analitico->analitico_id,
            'ana_act_proy'          => $analitico->ana_act_proy,
            'ana_componente'        => $analitico->ana_componente,
            'ana_especifca'         => $analitico->ana_especifca,
            'ana_monto'             => $analitico->ana_monto,
            'ana_modificaciones'    => $analitico->ana_modificaciones,
            'ana_descricion'        => $analitico->ana_descricion,
            'analitico_version_id'  => $analitico->analitico_version_id,
            'ejecutado'             => $request->ejecutado,
            'program'               => true,
        ],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK );

    }

    public function storeVersion(Request $request)
    {
        $max_version = Version::select(DB::raw('max(vers_version) as version'))
                                ->where('vers_proyecto', '=', $request->vers_proyecto)
                                ->get()[0];

        $version                        = new Version();
        $version->vers_proyecto         = $request->vers_proyecto;
        $version->vers_version          = (($max_version->version>0)?$max_version->version:0)+1;
        $version->vers_responzable      = \Auth::id();
        $version->vers_cargo            = $request->vers_cargo;
        $version->vers_observacion      = $request->vers_observacion;
        $version->save();
        $this->newAnalitico($request->vers_proyecto, $version->id);
        return $version;
    }

    public function newAnalitico($proy, $idVersion)
    {

        $anali = Analitico::select(['ana_act_proy',
                                    'ana_componente',
                                    'ana_especifca',
                                    'ana_monto',
                                    'ana_modificaciones',
                                    'ana_descricion'])
                                ->where('ana_act_proy','=', $proy)
                                ->where('analitico_version_id','=',1)
                                ->get();
        foreach($anali as $an){
            $newAnalitico                           = new Analitico();
            $newAnalitico->ana_act_proy             = $an->ana_act_proy;
            $newAnalitico->ana_componente           = $an->ana_componente;
            $newAnalitico->ana_especifca            = $an->ana_especifca;
            $newAnalitico->ana_monto                = $an->ana_monto;
            $newAnalitico->ana_modificaciones       = $an->ana_modificaciones;
            $newAnalitico->ana_descricion           = $an->ana_descricion;
            $newAnalitico->analitico_version_id     = $idVersion;
            $newAnalitico->save();
        }

    }

    public function destroy($act_proy, $id)
    {
        Analitico::destroy($id);
        return ['ok'=>'true'];
    }
}
