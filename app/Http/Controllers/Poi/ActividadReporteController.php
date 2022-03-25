<?php

namespace App\Http\Controllers\Poi;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use DB;
use App\_clases\poi\Oficina;
use App\_clases\poi\UnidadEjecutora;
use App\_clases\poi\PoiActividadProyecto;

class ActividadReporteController extends Controller
{
    public function index(Request $request)
    {
        /*if($request){ 
            
            $eje= trim($request->get('unidad_ejecutora')); //Oficina  
            $org= trim($request->get('unidad_org')); //Clasificador  
            

            $actividad = DB::table('poi_actividad_proyecto AS act')
                ->join('oficina AS o', 'act.idactividad_proyecto')

        }*/
            $ejecutoras = UnidadEjecutora::select('ue_codigo AS id', 'ue_codigo_nro AS numero', 'ue_descripcion AS nombre')->orderBy('ue_codigo', 'ASC')->get();
            return view('poi.reporte.inicio', ['ejecutoras'=>$ejecutoras]);
    }
    
    public function uniorganica(Request $request, $id)
    {
        if($request->ajax()){
            $organicas = Oficina::select('ofi_codigo AS id', 'ofi_nombre AS nombre')->where('unidad_ejecutora_ue_codigo', '=', $id)->get();
            return response()->json($organicas);
		}
    }
    
    public function modificar()
    {
        
    }
    
    public function create($usuario, $unidad )
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }
    
    public function destroy($id)
    {
        
    }
}
