<?php

namespace App\Http\Controllers\Poi;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\_clases\poi\Poi;
use App\_clases\poi\PoiActividadProyecto;
use App\_clases\poi\PlanDetalle;
use App\_clases\siaf\SiafMeta;
use App\_clases\poi\PoiTarea;
use App\_clases\poi\PoiActividadEspecifica;
use App\_clases\poi\UnidadEjecutora;
use App\_clases\poi\Oficina;
use App\_clases\poi\ClasificadorGasto;
use DB;

class HuamaliesController extends Controller
{
    public function index()
    {
        /*$oficinas=DB::table('poi_huamalies_excel AS hua')
            ->join('oficina AS o', function ($join) {
                    $join->on('hua.poi_huam_ue', '=', 'o.unidad_ejecutora_ue_cod_nac')
                         ->on('hua.poi_huam_centro_costo_id', '=', 'o.id_ceplan' ); })
            ->select('hua.id_poi_huam AS huam','o.ofi_codigo AS id', 'hua.poi_huam_ue AS unieje', 'hua.poi_huam_centro_costo_id AS oficina')
            ->groupBy('o.ofi_codigo')
            ->orderBy('hua.id_poi_huam', 'ASC')
            ->get();
        //dd($oficinas);
        
        $oficinasExistentes=Poi::where('poi_anio', '=', 2018)->get();
        $of=[];
        foreach ($oficinasExistentes as $oficina){
            $of[$oficina->oficina]=true;
        }
        
        foreach ($oficinas as $oficina){
            if (!isset($of[$oficina->id])) {
                $poi = new Poi();
                $poi->oficina = $oficina->id;
                $poi->poi_anio = 2018;
                $poi->save();
            }
        }        
        return('Guardado con Exito Todos los codigos POI');*/
        
        /*$huamalies=DB::table('poi_huamalies_excel AS huam')
            ->join('oficina AS of', function ($join) {
                    $join->on('huam.poi_huam_ue', '=', 'of.unidad_ejecutora_ue_cod_nac')
                         ->on('huam.poi_huam_centro_costo_id', '=', 'of.id_ceplan' ); })
            ->join('poi AS p', 'of.ofi_codigo', '=', 'p.oficina')
            ->select('huam.poi_huam_centro_costores_nombre', 'p.poi_codigo', 'huam.poi_huam_actividad_operativa_nombre', 'huam.poi_huam_unidad_medida_nombre', 'huam.poi_huam_financiamiento_id', 'huam.poi_huam_funcional_id', 'huam.poi_huam_div_funcional_id', 'huam.poi_huam_grup_funcional_id', 'huam.poi_huam_categoria_presupuestal_id', 'huam.poi_huam_producto_id', 'huam.poi_huam_actividad_id', 'huam.poi_huam_objetivo_id', 'huam.poi_huam_accion_est_id')
            ->where('p.poi_anio', 2018)
            ->groupBy('huam.poi_huam_regio')
            ->orderBy('huam.id_poi_huam', 'ASC')
            ->toSql();
        dd($huamalies);

        foreach ($huamalies as $huamal){
            $actividad = new PoiActividadProyecto();
                $actividad->act_proy_denominacion = $huamal->poi_huam_actividad_operativa_nombre;
                $actividad->act_proy_indicador = $huamal->poi_huam_unidad_medida_nombre;
                $actividad->act_proy_um = $huamal->poi_huam_unidad_medida_nombre;
                $actividad->act_proy_fuente_finan = $huamal->poi_huam_financiamiento_id;
                $actividad->act_proy_funcion = $huamal->poi_huam_funcional_id;
                $actividad->act_proy_div_funcional = $huamal->poi_huam_div_funcional_id;
                $actividad->act_proy_grupo_funcional = $huamal->poi_huam_grup_funcional_id;
                $actividad->act_proy_prog_pres = $huamal->poi_huam_categoria_presupuestal_id;
                $actividad->act_proy_prod_proy = $huamal->poi_huam_producto_id;
                $actividad->act_proy_actividad = $huamal->poi_huam_actividad_id;
                $actividad->poi_codigo = $huamal->poi_codigo;
                $actividad->act_proy_unidad_organica = $huamal->poi_huam_centro_costores_nombre;
                $actividad->act_proy_fuente_finan1 = $huamal->poi_huam_financiamiento_id;
                $actividad->act_proy_objetivo_id = $huamal->poi_huam_objetivo_id;
                $actividad->act_proy_accion_est_id = $huamal->poi_huam_accion_est_id;
                $actividad->save();
        }
        return('Guardado con Exito Todas las Actividades');*/
		return redirect('poi/huamalies/show');
    }

    public function create()
    {
        //
    }
	
    public function store(Request $request)
    {
        //
    }

    public function show(Request $request)
    {
        if($request){ 
            
            $eje= $request->get('unidad_ejecutora'); 
            $org= $request->get('unidad_org');  
            $where =[];
        
            if($eje >0){ $where[]=['o.unidad_ejecutora_ue_codigo', '=', $eje]; }                           
            if($org >0){ $where[]=['p.oficina', '=', $org]; }
            
            //dd($where);
            
            //$actividades=PoiActividadProyecto::select('idactividad_proyecto as id')->get();
            $actividades=DB::table('poi_actividad_proyecto AS act')
                ->join('poi AS p', 'act.poi_codigo', '=', 'p.poi_codigo')
                ->join('oficina AS o', 'p.oficina', '=', 'o.ofi_codigo')
                ->select('act.idactividad_proyecto AS id', 'act.act_proy_denominacion AS nombre', 'act.act_proy_indicador AS indicador', 'act.act_proy_um AS um', 'act.act_proy_fuente_finan AS fuente', 'act.act_proy_funcion AS funcion', 'act.act_proy_div_funcional AS division', 'act.act_proy_grupo_funcional AS grupo', 'act.act_proy_prog_pres AS categoria', 'act.act_proy_prod_proy AS producto', 'act.act_proy_actividad AS actividad', 'act.act_proy_estado AS estado')
                ->where('p.poi_anio', 2018)
                ->where('act.act_proy_huam_regio', '>', 0)
                ->where($where)
                ->orderBy('act.idactividad_proyecto', 'ASC')
                ->get();
            
            $organicas = DB::table('oficina AS o')
                ->join('poi AS p', 'o.ofi_codigo', '=', 'p.oficina')
                ->select('o.ofi_codigo AS id', 'o.ofi_nombre AS nombre')
                ->where('p.poi_anio', '=', 2018)
                ->where('o.unidad_ejecutora_ue_codigo', '=', $request->unidad_ejecutora)
                ->get();
            
            $ejecutoras = UnidadEjecutora::select('ue_codigo AS id', 'ue_codigo_nro AS numero', 'ue_descripcion AS nombre')->orderBy('ue_codigo', 'ASC')->get();
            
            return view('poi.huamalies.inicio', ['actividades'=>$actividades, 'ejecutoras'=>$ejecutoras, 'request'=>$request, '$ejecutoras'=>$ejecutoras, 'organicas'=>$organicas]);
        }
    }

    public function edit($id)
    {
        $mision = DB::table('poi_plan_detalle')->select('plan_det_descripcion as mision')->where('plan_det_id', '=', 1)->first();
        
        $vision = DB::table('poi_plan_detalle')->select('plan_det_descripcion as vision')->where('plan_det_id', '=', 2)->first();
        
        $actividades=DB::table('poi_actividad_proyecto AS act')
            ->join('poi AS p', 'act.poi_codigo', '=', 'p.poi_codigo')
            ->join('oficina AS o', 'p.oficina', '=', 'o.ofi_codigo')
            ->join('unidad_ejecutora AS ue', 'o.unidad_ejecutora_ue_codigo', '=', 'ue.ue_codigo')
            ->select('ue.ue_codigo AS unieje', 'ue.ue_descripcion AS nomunieje', 'o.ofi_nombre AS nomofi', 'p.poi_anio as anio', 'act.act_proy_prog_pres AS categoria', 'act.act_proy_funcion AS funcion', 'act.act_proy_div_funcional AS division', 'act.act_proy_grupo_funcional AS grupo', 'act.act_proy_prod_proy AS producto', 'act.act_proy_actividad AS actividad', 'act.idactividad_proyecto AS actid', 'act.act_proy_denominacion AS nomact', 'act.act_proy_indicador AS indicador', 'act.act_proy_um AS medida', 'act.act_proy_fuente_finan1 AS fuente1', 'act.act_proy_fuente_finan2 AS fuente2', 'act.act_proy_fuente_finan3 AS fuente3', 'act.act_proy_fuente_finan4 AS fuente4', 'act.act_proy_fuente_finan5 AS fuente5', 'act.act_proy_objetivo_id AS oei', 'act.act_proy_accion_est_id AS aei', 'act.act_proy_descripcion AS descripcion', 'act.act_proy_local_benef AS local', 'act.act_proy_beneficiarios AS beneficio', 'act.act_proy_est_operativa AS estrategia', 'act.act_proy_prioridad AS prioridad', 'act.act_proy_finalidad AS finalidad', 'act.act_proy_cantidad AS fisica', 'act.act_proy_pdrc_oet_meta1 AS meta_oet_1', 'act.act_proy_pdrc_oet_meta2 AS meta_oet_2', 'act.act_proy_pdrc_aet_meta1 AS meta_aet_1', 'act.act_proy_pdrc_aet_meta2 AS meta_aet_2', 'act.act_proy_unidad_organica AS uniresponsable', 'act.act_proy_pdrc_ee AS ce', 'act.act_proy_id_siaf_meta AS siaf')
            ->where('act.idactividad_proyecto', '=', $id)
            ->first();
        
        $cadena = PoiActividadProyecto::select('act_proy_pdrc_ee AS ce', 'act_proy_pdrc_oer AS oet', 'act_proy_pdrc_oe AS aet', 'act_proy_objetivo_id AS oei', 'act_proy_accion_est_id AS aei')
        ->where('idactividad_proyecto', '=', $id)
        ->first();
                            
        $ces = PlanDetalle::select('plan_det_id AS id', 'plan_det_codigo AS codigo', 'plan_det_descripcion AS nombre')
            ->where( 'plan_id','=','1' )//PDRC
            ->where( 'plan_det_categoria','=','EE' )//C.E.
            ->orderBy('plan_det_id','ASC')
            ->get();
                
        $oets = PlanDetalle::select('plan_det_id AS id', 'plan_det_codigo AS codigo', 'plan_det_descripcion AS nombre', 'plan_det_cod_indicador AS codindicador', 'plan_det_indicador AS indicador', 'plan_det_cod_unidad_medida AS codmedida', 'plan_det_unidad_medida AS medida', 'plan_det_meta AS meta')
            ->where( 'plan_id','=','1' )//PDRC
            ->where( 'plan_det_categoria','=','OER' )//O.E.R
            ->orderBy('plan_det_id','ASC')
            ->get();
        
        $aets = PlanDetalle::select('plan_det_id AS id', 'plan_det_codigo AS codigo', 'plan_det_descripcion AS nombre', 'plan_det_cod_indicador AS codindicador', 'plan_det_indicador AS indicador', 'plan_det_cod_unidad_medida AS codmedida', 'plan_det_unidad_medida AS medida', 'plan_det_meta AS meta')
            ->where( 'plan_id','=','1' )//PDRC
            ->where( 'plan_det_categoria','=','AER' )//A.E.R
            ->orderBy('plan_det_id','ASC')
            ->get();
        
        $oeis = PlanDetalle::select('plan_det_id AS id', 'plan_det_codigo AS codigo', 'plan_det_descripcion AS nombre', 'plan_det_cod_indicador AS codindicador', 'plan_det_indicador AS indicador', 'plan_det_cod_unidad_medida AS codmedida', 'plan_det_unidad_medida AS medida', 'plan_det_meta AS meta')
            ->where( 'plan_id','=','2' )//PDRC
            ->where( 'plan_det_categoria','=','OEI' )//O.E.I
            ->orderBy('plan_det_id','ASC')
            ->get();
        
        $aeis = PlanDetalle::select('plan_det_id AS id', 'plan_det_codigo AS codigo', 'plan_det_descripcion AS nombre', 'plan_det_cod_indicador AS codindicador', 'plan_det_indicador AS indicador', 'plan_det_cod_unidad_medida AS codmedida', 'plan_det_unidad_medida AS medida', 'plan_det_meta AS meta')
            ->where( 'plan_id','=','2' )//PDRC
            ->where( 'plan_det_categoria','=','AEI' )//A.E.I
            ->orderBy('plan_det_id','ASC')
            ->get();

        $metas=DB::table('siaf_meta')
            ->select('ID AS id', 'SEC_FUNC AS meta')
            ->where('ANO_EJE', '=', 2017)
            ->where('FUNCION', 'LIKE','%'.$actividades->funcion.'%')
            ->where('PROGRAMA', 'LIKE','%'.$actividades->division.'%')
            ->where('SUB_PROGRA', 'LIKE','%'.$actividades->grupo.'%')
            ->where('PROGRAMA_P', 'LIKE','%'.$actividades->categoria.'%')
            ->where('ACT_PROY', 'LIKE','%'.$actividades->producto.'%')
            ->where('COMPONENTE', 'LIKE','%'.$actividades->actividad.'%')
            ->groupBy('FINALIDAD')
            ->get();

        $prog_p = DB::table('siaf_programa_ppto_nombre')
            ->where( 'ANO_EJE','=','2017' )//Año de ejecución
            ->where( 'PROGRAMA_P','LIKE','%'.$actividades->categoria.'%')//Año de ejecución
            ->select( 'PROGRAMA_P AS id', 'NOMBRE AS nombre')
            ->first();
        
        $fuente=DB::table('poi_actividad_proyecto AS ap')
            ->join('poi_huamalies_excel AS hua', 'ap.act_proy_huam_regio', '=', 'hua.poi_huam_regio')
            ->select('ap.act_proy_huam_regio AS regio', 'hua.poi_huam_financiamiento_id', DB::raw('Sum(hua.poi_huam_total_financiera) AS total'), DB::raw('Sum(hua.poi_huam_total_fisica) AS fisica'))
            ->where('ap.idactividad_proyecto', '=', $id)
            ->groupBy('poi_huam_regio')
            ->orderBy('id_poi_huam', 'ASC')
            ->first();
        //dd($fuente);
        
        return view('poi.huamalies.editar', ['actividades'=>$actividades, 'mision'=>$mision, 'vision'=>$vision, 'ces'=>$ces, 'metas'=>$metas, 'id'=>$id, 'prog_p'=>$prog_p, 'cadena'=>$cadena, 'ces'=>$ces, 'oets'=>$oets, 'aets'=>$aets, 'oeis'=>$oeis, 'aeis'=>$aeis, 'fuente'=>$fuente]);
    }

    public function obtener_oets(Request $request, $tipo, $ce){
		
		if($request->ajax()){
			switch($tipo){
			case 1://obtiene todos los oets
				$oets = PlanDetalle::obtener_oets($ce);
				return response()->json($oets);
				break;
			case 2://obtiene los oets de acuerdo al indicador seleccionado
				$oets = PlanDetalle::obtener_oet_por_indicador($ce);
				return response()->json($oets);
				break;
			case 3://obtiene todos los aets
				$aets = PlanDetalle::obtener_aets($ce);
				return response()->json($aets);
				break;
			}
		}
	}
    
    public function obtener_aets(Request $request, $tipo, $padre, $aet, $indicador=0){
		
		if($request->ajax()){
			switch($tipo){
			case 1://obtiene los indicadores de la aet seleccionada
				$aets = PlanDetalle::obtener_aet_por_indicador($padre, $aet);
				return response()->json($aets);
				break;      
            case 2://obtiene los aets de acuerdo al indicador seleccionado
				$oets = PlanDetalle::obtener_aet_indicador($padre);
				return response()->json($oets);
				break;
            case 3://obtiene las unidades de medida de las aets de acuerdo al indicador seleccionado
				$aets = PlanDetalle::obtener_um_aet_por_indicador($padre, $aet, $indicador);
				return response()->json($aets);
				break;
			}
		}
	}
    
    public function obtener_oeis(Request $request, $tipo, $ce){
		
		if($request->ajax()){
			switch($tipo){
			case 1://obtiene todos los oeis
				$oeis = PlanDetalle::obtener_oeis($ce);
				return response()->json($oeis);
				break;
			case 2://obtiene los oeis de acuerdo al indicador seleccionado
				$oeis = PlanDetalle::obtener_oei_por_indicador($ce);
				return response()->json($oeis);
				break;
			case 5://obtiene los oeis de acuerdo al indicador seleccionados
				$oeis = PlanDetalle::obtener_oei_indicador($ce);
				return response()->json($oeis);
				break;
			case 3://obtiene todos los aeis
				$aeis = PlanDetalle::obtener_aeis($ce);
				return response()->json($aeis);
				break;
            case 4://
				$aeis = PlanDetalle::obtener_aei_por_indicador($ce);
				return response()->json($aeis);
				break;
            case 7:
				$aeis = PlanDetalle::obtener_aei_por_meta($ce);
				return response()->json($aeis);
				break;
            case 8:
				$aeis = PlanDetalle::obtener_faltante_aei($ce);
				return response()->json($aeis);
				break;
            case 6://obtiene los oeis por um oet
				$oeis = PlanDetalle::obtener_oeis_por_oet($ce);
				return response()->json($oeis);
				break;
			}
		}
	}
    
    public function obtener_datos_siaf_meta_por_id(Request $request, $id){
		
		if($request->ajax()){
				$meta = SiafMeta::obtener_metas_por_id($id);
				return response()->json($meta);
		}
	}
    
    public function update(Request $request, $id)
    {
        $actividad = PoiActividadProyecto::find($id);
        $actividad->act_proy_denominacion = mb_strtoupper($request->nombre_actividad);
        $actividad->act_proy_indicador = mb_strtoupper($request->nombre_indicador);
        $actividad->act_proy_um = mb_strtoupper($request->um_indicador);
        $actividad->act_proy_funcion = $request->funcion;
        $actividad->act_proy_div_funcional = $request->div_funcional;
        $actividad->act_proy_grupo_funcional = $request->grupo_funcional;
        $actividad->act_proy_prog_pres = $request->cat_pres;
        $actividad->act_proy_prod_proy = $request->prod_proy;
        $actividad->act_proy_actividad = $request->act_obra;
        $actividad->act_proy_finalidad = $request->sel_finalidad;
        $actividad->act_proy_pdrc_ee = $request->sel_cei;                       //CEI
        $actividad->act_proy_pdrc_oer = $request->sel_oet;                      //OET
        $actividad->act_proy_pdrc_oet_indicador = $request->sel_oet_indicador;  //OET1
        $actividad->act_proy_pdrc_oet_medida = $request->sel_oet_unidad_medida; //OET2
        $actividad->act_proy_pdrc_oet_meta1 = $request->plan_det_id_oet;        //OET3
        $actividad->act_proy_pdrc_oet_meta2 = $request->meta_oet;               //OET4
        $actividad->act_proy_pdrc_oe = $request->sel_aet;                       //AET
        $actividad->act_proy_pdrc_aet_indicador = $request->sel_aet_indicador;  //AET1
        $actividad->act_proy_pdrc_aet_medida = $request->sel_aet_unidad_medida; //AET2
        $actividad->act_proy_pdrc_aet_meta1 = $request->plan_det_id_aet;        //AET3
        $actividad->act_proy_pdrc_aet_meta2 = $request->meta_aet;               //AET4
        $actividad->act_proy_id_siaf_meta = $request->sel_meta_presupuestaria;  //Siaf Meta 
        $actividad->act_proy_objetivo_id = $request->sel_oei;                   //Objetico
        $actividad->act_proy_accion_est_id = $request->sel_aei;                 //Accion   
        $actividad->act_proy_objetivo_id_meta = $request->plan_det_id_oei;      //OEI-META
        $actividad->act_proy_accion_id_meta = $request->plan_det_id_aei;        //AEI-META
        $actividad->act_proy_descripcion = mb_strtoupper($request->descripcion);
        $actividad->act_proy_local_benef = mb_strtoupper($request->localizacion);
        $actividad->act_proy_beneficiarios = mb_strtoupper($request->beneficiarios);
        $actividad->act_proy_est_operativa = mb_strtoupper($request->estrategias);
        $actividad->act_proy_estado = 2;
        $actividad->act_proy_prioridad = $request->prioridad;
        $actividad->act_proy_fuente_finan1 = $request->fuente_finan1;
        $actividad->act_proy_fuente_finan2 = $request->fuente_finan2;
        $actividad->act_proy_fuente_finan3 = $request->fuente_finan3;
        $actividad->act_proy_fuente_finan4 = $request->fuente_finan4;
        $actividad->act_proy_fuente_finan5 = $request->fuente_finan5;
        $actividad->act_proy_cantidad = $request->valor_meta;
        $actividad->act_proy_total_financiera= $request->monto_financiamiento;
        $actividad->save();
        
        return redirect('poi/anteproyecto/f2/'.$id)->with('msg', 'El Tipo de Documento fue Editado Satisfactoriamente.');
    }

    public function ver($id)
    {
        $mision = DB::table('poi_plan_detalle')->select('plan_det_descripcion as mision')->where('plan_det_id', '=', 1)->first();
        
        $vision = DB::table('poi_plan_detalle')->select('plan_det_descripcion as vision')->where('plan_det_id', '=', 2)->first();
        
        $actividades=DB::table('poi_actividad_proyecto AS act')
            ->join('poi AS p', 'act.poi_codigo', '=', 'p.poi_codigo')
            ->join('oficina AS o', 'p.oficina', '=', 'o.ofi_codigo')
            ->join('unidad_ejecutora AS ue', 'o.unidad_ejecutora_ue_codigo', '=', 'ue.ue_codigo')
            ->select('ue.ue_codigo AS unieje', 'ue.ue_descripcion AS nomunieje', 'o.ofi_nombre AS nomofi', 'p.poi_anio as anio', 'act.act_proy_prog_pres AS categoria', 'act.act_proy_funcion AS funcion', 'act.act_proy_div_funcional AS division', 'act.act_proy_grupo_funcional AS grupo', 'act.act_proy_prod_proy AS producto', 'act.act_proy_actividad AS actividad', 'act.idactividad_proyecto AS actid', 'act.act_proy_denominacion AS nomact', 'act.act_proy_indicador AS indicador', 'act.act_proy_um AS medida', 'act.act_proy_fuente_finan1 AS fuente1', 'act.act_proy_fuente_finan2 AS fuente2', 'act.act_proy_fuente_finan3 AS fuente3', 'act.act_proy_fuente_finan4 AS fuente4', 'act.act_proy_fuente_finan5 AS fuente5', 'act.act_proy_objetivo_id AS oei', 'act.act_proy_accion_est_id AS aei', 'act.act_proy_descripcion AS descripcion', 'act.act_proy_local_benef AS local', 'act.act_proy_beneficiarios AS beneficio', 'act.act_proy_est_operativa AS estrategia', 'act.act_proy_prioridad AS prioridad', 'act.act_proy_finalidad AS finalidad', 'act.act_proy_cantidad AS fisica', 'act.act_proy_pdrc_oet_meta1 AS meta_oet_1', 'act.act_proy_pdrc_oet_meta2 AS meta_oet_2', 'act.act_proy_pdrc_aet_meta1 AS meta_aet_1', 'act.act_proy_pdrc_aet_meta2 AS meta_aet_2', 'act.act_proy_unidad_organica AS uniresponsable', 'act.act_proy_id_siaf_meta AS siaf')
            ->where('act.idactividad_proyecto', '=', $id)
            ->first();
                
        $ce=DB::table('poi_actividad_proyecto AS aproy')
            ->join('poi_plan_detalle AS pdet', 'aproy.act_proy_pdrc_ee', '=', 'pdet.plan_det_id')
            ->select('pdet.plan_det_codigo AS id', 'pdet.plan_det_descripcion AS descripcion')
            ->where('aproy.idactividad_proyecto', '=', $id)
            ->first();
        
        if (is_null($ce))
            $ce=(object)array(
                        "id" => "",
                        "descripcion" => "",
                        );
        
        $oet=DB::table('poi_actividad_proyecto AS proy')
            ->join('poi_plan_detalle AS det', 'proy.act_proy_pdrc_oet_meta1', '=', 'det.plan_det_id')
            ->select('det.plan_det_codigo AS id', 'det.plan_det_descripcion AS descripcion','det.plan_det_indicador AS indicador', 'det.plan_det_unidad_medida AS medida', 'det.plan_det_id AS meta1', 'det.plan_det_meta AS meta2')
            ->where('proy.idactividad_proyecto', '=', $id)
            ->first();
        
        if (is_null($oet))
            $oet=(object)array(
                        "id" => "",
                        "descripcion" => "",
                        "indicador" => "",
                        "medida" => "",
                        "meta1" => "",
                        "meta2" => "",
                        );
        
        $aet=DB::table('poi_actividad_proyecto AS pro')
            ->join('poi_plan_detalle AS de', 'pro.act_proy_pdrc_aet_meta1', '=', 'de.plan_det_id')
            ->select('de.plan_det_codigo AS id', 'de.plan_det_descripcion AS descripcion', 'de.plan_det_indicador AS indicador', 'de.plan_det_unidad_medida AS medida', 'de.plan_det_id AS meta1', 'de.plan_det_meta AS meta2')
            ->where('pro.idactividad_proyecto', '=', $id)
            ->first();
        
        if (is_null($aet))
            $aet=(object)array(
                        "id" => "",
                        "descripcion" => "",
                        "indicador" => "",
                        "medida" => "",
                        "meta1" => "",
                        "meta2" => "",
                        );
        
        $oei=DB::table('poi_actividad_proyecto AS proy')
            ->join('poi_plan_detalle AS det', 'proy.act_proy_objetivo_id_meta', '=', 'det.plan_det_id')
            ->select('det.plan_det_codigo AS id', 'det.plan_det_descripcion AS descripcion','det.plan_det_indicador AS indicador', 'det.plan_det_unidad_medida AS medida', 'det.plan_det_id AS meta1', 'det.plan_det_meta AS meta2')
            ->where('proy.idactividad_proyecto', '=', $id)
            ->first();
        
        if (is_null($oei))
            $oei=(object)array(
                        "id" => "",
                        "descripcion" => "",
                        "indicador" => "",
                        "medida" => "",
                        "meta1" => "",
                        "meta2" => "",
                        );
        
        $aei=DB::table('poi_actividad_proyecto AS pro')
            ->join('poi_plan_detalle AS de', 'pro.act_proy_accion_id_meta', '=', 'de.plan_det_id')
            ->select('de.plan_det_codigo AS id', 'de.plan_det_descripcion AS descripcion', 'de.plan_det_indicador AS indicador', 'de.plan_det_unidad_medida AS medida', 'de.plan_det_id AS meta1', 'de.plan_det_meta AS meta2')
            ->where('pro.idactividad_proyecto', '=', $id)
            ->first();
        
        if (is_null($aei))
            $aei=(object)array(
                        "id" => "",
                        "descripcion" => "",
                        "indicador" => "",
                        "medida" => "",
                        "meta1" => "",
                        "meta2" => "",
                        );
        
        $prog_p = DB::table('siaf_programa_ppto_nombre')
            ->where( 'ANO_EJE','=','2017' )//Año de ejecución
			->where( 'PROGRAMA_P','LIKE','%'.$actividades->categoria.'%')//Año de ejecución
			->select( 'PROGRAMA_P AS id', 'NOMBRE AS nombre')
			->first();
                
        $tareas = DB::table('poi_tarea AS t')
            ->leftJoin('poi_actividad_especifica AS ae', 't.id_tarea', '=', 'ae.especifica_id_tarea')
            ->select('t.id_tarea AS id', 't.tar_descripcion AS tarea', 't.tar_um AS um', 't.tar_cantidad AS total', 't.tar_enero', 't.tar_febrero', 't.tar_marzo', 't.tar_abril', 't.tar_mayo', 't.tar_junio', 't.tar_julio', 't.tar_agosto', 't.tar_setiembre', 't.tar_octubre', 't.tar_noviembre', 't.tar_diciembre', DB::raw('sum(ae.especifica_monto_total) AS tartotal'), DB::raw('sum(ae.especifica_enero) AS tarenero'), DB::raw('sum(ae.especifica_febrero) AS tarfebrero'), DB::raw('sum(ae.especifica_marzo) AS tarmarzo'), DB::raw('sum(ae.especifica_abril) AS tarabril'), DB::raw('sum(ae.especifica_mayo) AS tarmayo'), DB::raw('sum(ae.especifica_junio) AS tarjunio'), DB::raw('sum(ae.especifica_julio) AS tarjulio'), DB::raw('sum(ae.especifica_agosto) AS taragosto'), DB::raw('sum(ae.especifica_setiembre) AS tarsetiembre'), DB::raw('sum(ae.especifica_octubre) AS taroctubre'), DB::raw('sum(ae.especifica_noviembre) AS tarnoviembre'), DB::raw('sum(ae.especifica_diciembre) AS tardiciembre'), DB::raw('sum(ae.especifica_enero+ae.especifica_febrero+ae.especifica_marzo) AS tartri1'), DB::raw('sum(ae.especifica_abril+ae.especifica_mayo+ae.especifica_junio) AS tartri2'), DB::raw('sum(ae.especifica_julio+ae.especifica_agosto+ae.especifica_setiembre) AS tartri3'), DB::raw('sum(ae.especifica_octubre+ae.especifica_noviembre+ae.especifica_diciembre) AS tartri4'))->where('t.poi_actividad_proyecto_idactividad_proyecto', '=', $id)->orderBy('t.id_tarea', 'ASC')->groupBy('t.id_tarea')->get();
        $tareasrow = count($tareas);
        //dd($tareas);
        
        $acttareas = PoiTarea::select(DB::raw('Sum(tar_enero) AS act_enero'), DB::raw('Sum(tar_febrero) AS act_febrero'), DB::raw('Sum(tar_marzo) AS act_marzo'), DB::raw('Sum(tar_abril) AS act_abril'), DB::raw('Sum(tar_mayo) AS act_mayo'), DB::raw('Sum(tar_junio) AS act_junio'), DB::raw('Sum(tar_julio) AS act_julio'), DB::raw('Sum(tar_agosto) AS act_agosto'), DB::raw('Sum(tar_setiembre) AS act_setiembre'), DB::raw('Sum(tar_octubre) AS act_octubre'), DB::raw('Sum(tar_noviembre) AS act_noviembre'), DB::raw('Sum(tar_diciembre) AS act_diciembre'), DB::raw('Sum(tar_enero+tar_febrero+tar_marzo) AS act_tri1'), DB::raw('Sum(tar_abril+tar_mayo+tar_junio) AS act_tri2'), DB::raw('Sum(tar_julio+tar_agosto+tar_setiembre) AS act_tri3'), DB::raw('Sum(tar_octubre+tar_noviembre+tar_diciembre) AS act_tri4'), DB::raw('Sum(tar_cantidad) AS act_total'))->where('poi_actividad_proyecto_idactividad_proyecto', '=', $id)->orderBy('id_tarea', 'ASC')->groupBy('poi_actividad_proyecto_idactividad_proyecto')->first();
        
        $actinsumos = PoiActividadEspecifica::select(DB::raw('sum(especifica_monto_total) AS instotal'), DB::raw('sum(especifica_enero) AS insenero'), DB::raw('sum(especifica_febrero) AS insfebrero'), DB::raw('sum(especifica_marzo) AS insmarzo'), DB::raw('sum(especifica_abril) AS insabril'), DB::raw('sum(especifica_mayo) AS insmayo'), DB::raw('sum(especifica_junio) AS insjunio'), DB::raw('sum(especifica_julio) AS insjulio'), DB::raw('sum(especifica_agosto) AS insagosto'), DB::raw('sum(especifica_setiembre) AS inssetiembre'), DB::raw('sum(especifica_octubre) AS insoctubre'), DB::raw('sum(especifica_noviembre) AS insnoviembre'), DB::raw('sum(especifica_diciembre) AS insdiciembre'), DB::raw('sum(especifica_enero+especifica_febrero+especifica_marzo) AS instri1'), DB::raw('sum(especifica_abril+especifica_mayo+especifica_junio) AS instri2'), DB::raw('sum(especifica_julio+especifica_agosto+especifica_setiembre) AS instri3'), DB::raw('sum(especifica_octubre+especifica_noviembre+especifica_diciembre) AS instri4'))->where('especifica_id_actividad_proyecto', '=', $id)->groupBy('especifica_id_actividad_proyecto')->first();
        $actinsumosrow = count($actinsumos);
        //dd($actinsumos);
        
        $fuente=DB::table('poi_actividad_proyecto AS ap')
            ->join('poi_huamalies_excel AS hua', 'ap.act_proy_huam_regio', '=', 'hua.poi_huam_regio')
            ->select('ap.act_proy_huam_regio AS regio', 'hua.poi_huam_financiamiento_id', DB::raw('Sum(hua.poi_huam_total_financiera) AS total'), DB::raw('Sum(hua.poi_huam_total_fisica) AS fisica'))
            ->where('ap.idactividad_proyecto', '=', $id)
            ->groupBy('poi_huam_regio')
            ->orderBy('id_poi_huam', 'ASC')
            ->first();
                        
        return view('poi.huamalies.ver', ['actividades'=>$actividades, 'mision'=>$mision, 'vision'=>$vision, 'ce'=>$ce, 'oet'=>$oet, 'aet'=>$aet, 'oei'=>$oei, 'aei'=>$aei, 'id'=>$id, 'prog_p'=>$prog_p, 'fuente'=>$fuente, 'tareas'=>$tareas, 'acttareas'=>$acttareas, 'actinsumos'=>$actinsumos, 'tareasrow'=>$tareasrow, 'actinsumosrow'=>$actinsumosrow]);
    }
    
     public function imprimir($id)
    {
        $mision = DB::table('poi_plan_detalle')->select('plan_det_descripcion as mision')->where('plan_det_id', '=', 1)->first();
        
        $vision = DB::table('poi_plan_detalle')->select('plan_det_descripcion as vision')->where('plan_det_id', '=', 2)->first();
        
        $actividades=DB::table('poi_actividad_proyecto AS act')
            ->join('poi AS p', 'act.poi_codigo', '=', 'p.poi_codigo')
            ->join('oficina AS o', 'p.oficina', '=', 'o.ofi_codigo')
            ->join('unidad_ejecutora AS ue', 'o.unidad_ejecutora_ue_codigo', '=', 'ue.ue_codigo')
            ->select('ue.ue_codigo AS unieje', 'ue.ue_descripcion AS nomunieje', 'o.ofi_nombre AS nomofi', 'p.poi_anio as anio', 'act.act_proy_prog_pres AS categoria', 'act.act_proy_funcion AS funcion', 'act.act_proy_div_funcional AS division', 'act.act_proy_grupo_funcional AS grupo', 'act.act_proy_prod_proy AS producto', 'act.act_proy_actividad AS actividad', 'act.idactividad_proyecto AS actid', 'act.act_proy_denominacion AS nomact', 'act.act_proy_indicador AS indicador', 'act.act_proy_um AS medida', 'act.act_proy_fuente_finan1 AS fuente1', 'act.act_proy_fuente_finan2 AS fuente2', 'act.act_proy_fuente_finan3 AS fuente3', 'act.act_proy_fuente_finan4 AS fuente4', 'act.act_proy_fuente_finan5 AS fuente5', 'act.act_proy_objetivo_id AS oei', 'act.act_proy_accion_est_id AS aei', 'act.act_proy_descripcion AS descripcion', 'act.act_proy_local_benef AS local', 'act.act_proy_beneficiarios AS beneficio', 'act.act_proy_est_operativa AS estrategia', 'act.act_proy_prioridad AS prioridad', 'act.act_proy_finalidad AS finalidad', 'act.act_proy_cantidad AS fisica', 'act.act_proy_pdrc_oet_meta1 AS meta_oet_1', 'act.act_proy_pdrc_oet_meta2 AS meta_oet_2', 'act.act_proy_pdrc_aet_meta1 AS meta_aet_1', 'act.act_proy_pdrc_aet_meta2 AS meta_aet_2', 'act.act_proy_unidad_organica AS uniresponsable', 'act.act_proy_id_siaf_meta AS siaf')
            ->where('act.idactividad_proyecto', '=', $id)
            ->first();
                
        $ce=DB::table('poi_actividad_proyecto AS aproy')
            ->join('poi_plan_detalle AS pdet', 'aproy.act_proy_pdrc_ee', '=', 'pdet.plan_det_id')
            ->select('pdet.plan_det_codigo AS id', 'pdet.plan_det_descripcion AS descripcion')
            ->where('aproy.idactividad_proyecto', '=', $id)
            ->first();
        
        if (is_null($ce))
            $ce=(object)array(
                        "id" => "",
                        "descripcion" => "",
                        );
        
        $oet=DB::table('poi_actividad_proyecto AS proy')
            ->join('poi_plan_detalle AS det', 'proy.act_proy_pdrc_oet_meta1', '=', 'det.plan_det_id')
            ->select('det.plan_det_codigo AS id', 'det.plan_det_descripcion AS descripcion','det.plan_det_indicador AS indicador', 'det.plan_det_unidad_medida AS medida', 'det.plan_det_id AS meta1', 'det.plan_det_meta AS meta2')
            ->where('proy.idactividad_proyecto', '=', $id)
            ->first();
        
        if (is_null($oet))
            $oet=(object)array(
                        "id" => "",
                        "descripcion" => "",
                        "indicador" => "",
                        "medida" => "",
                        "meta1" => "",
                        "meta2" => "",
                        );
        
        $aet=DB::table('poi_actividad_proyecto AS pro')
            ->join('poi_plan_detalle AS de', 'pro.act_proy_pdrc_aet_meta1', '=', 'de.plan_det_id')
            ->select('de.plan_det_codigo AS id', 'de.plan_det_descripcion AS descripcion', 'de.plan_det_indicador AS indicador', 'de.plan_det_unidad_medida AS medida', 'de.plan_det_id AS meta1', 'de.plan_det_meta AS meta2')
            ->where('pro.idactividad_proyecto', '=', $id)
            ->first();
        
        if (is_null($aet))
            $aet=(object)array(
                        "id" => "",
                        "descripcion" => "",
                        "indicador" => "",
                        "medida" => "",
                        "meta1" => "",
                        "meta2" => "",
                        );
        
        $oei=DB::table('poi_actividad_proyecto AS proy')
            ->join('poi_plan_detalle AS det', 'proy.act_proy_objetivo_id_meta', '=', 'det.plan_det_id')
            ->select('det.plan_det_codigo AS id', 'det.plan_det_descripcion AS descripcion','det.plan_det_indicador AS indicador', 'det.plan_det_unidad_medida AS medida', 'det.plan_det_id AS meta1', 'det.plan_det_meta AS meta2')
            ->where('proy.idactividad_proyecto', '=', $id)
            ->first();
        
        if (is_null($oei))
            $oei=(object)array(
                        "id" => "",
                        "descripcion" => "",
                        "indicador" => "",
                        "medida" => "",
                        "meta1" => "",
                        "meta2" => "",
                        );
        
        $aei=DB::table('poi_actividad_proyecto AS pro')
            ->join('poi_plan_detalle AS de', 'pro.act_proy_accion_id_meta', '=', 'de.plan_det_id')
            ->select('de.plan_det_codigo AS id', 'de.plan_det_descripcion AS descripcion', 'de.plan_det_indicador AS indicador', 'de.plan_det_unidad_medida AS medida', 'de.plan_det_id AS meta1', 'de.plan_det_meta AS meta2')
            ->where('pro.idactividad_proyecto', '=', $id)
            ->first();
        
        if (is_null($aei))
            $aei=(object)array(
                        "id" => "",
                        "descripcion" => "",
                        "indicador" => "",
                        "medida" => "",
                        "meta1" => "",
                        "meta2" => "",
                        );
        
        $prog_p = DB::table('siaf_programa_ppto_nombre')
            ->where( 'ANO_EJE','=','2017' )//Año de ejecución
			->where( 'PROGRAMA_P','LIKE','%'.$actividades->categoria.'%')//Año de ejecución
			->select( 'PROGRAMA_P AS id', 'NOMBRE AS nombre')
			->first();
                
        $especificas = DB::table('poi_actividad_especifica AS e')
            ->join('poi_actividad_proyecto AS a', 'e.especifica_id_actividad_proyecto', '=', 'a.idactividad_proyecto')
            ->select('e.id_actividad_especifica AS id', 'a.act_proy_denominacion AS actividad', 'e.especifica_fuente_financiamiento AS fuente', 'e.especifica_clasificador_gastos AS especifica', 'e.especifica_monto_total AS monto')
            ->where('a.idactividad_proyecto', '=', $id)->orderBy('id_actividad_especifica', 'ASC')->get(); 
        $verespecificas = count($especificas);
                
        $tareas = DB::table('poi_tarea AS t')
            ->leftJoin('poi_actividad_especifica AS ae', 't.id_tarea', '=', 'ae.especifica_id_tarea')
            ->select('t.id_tarea AS id', 't.tar_descripcion AS tarea', 't.tar_cantidad AS total', 't.tar_enero', 't.tar_febrero', 't.tar_marzo', 't.tar_abril', 't.tar_mayo', 't.tar_junio', 't.tar_julio', 't.tar_agosto', 't.tar_setiembre', 't.tar_octubre', 't.tar_noviembre', 't.tar_diciembre', DB::raw('sum(ae.especifica_monto_total) AS tartotal'), DB::raw('sum(ae.especifica_enero) AS tarenero'), DB::raw('sum(ae.especifica_febrero) AS tarfebrero'), DB::raw('sum(ae.especifica_marzo) AS tarmarzo'), DB::raw('sum(ae.especifica_abril) AS tarabril'), DB::raw('sum(ae.especifica_mayo) AS tarmayo'), DB::raw('sum(ae.especifica_junio) AS tarjunio'), DB::raw('sum(ae.especifica_julio) AS tarjulio'), DB::raw('sum(ae.especifica_agosto) AS taragosto'), DB::raw('sum(ae.especifica_setiembre) AS tarsetiembre'), DB::raw('sum(ae.especifica_octubre) AS taroctubre'), DB::raw('sum(ae.especifica_noviembre) AS tarnoviembre'), DB::raw('sum(ae.especifica_diciembre) AS tardiciembre'), DB::raw('sum(ae.especifica_enero+ae.especifica_febrero+ae.especifica_marzo) AS tartri1'), DB::raw('sum(ae.especifica_abril+ae.especifica_mayo+ae.especifica_junio) AS tartri2'), DB::raw('sum(ae.especifica_julio+ae.especifica_agosto+ae.especifica_setiembre) AS tartri3'), DB::raw('sum(ae.especifica_octubre+ae.especifica_noviembre+ae.especifica_diciembre) AS tartri4'))->where('t.poi_actividad_proyecto_idactividad_proyecto', '=', $id)->orderBy('t.id_tarea', 'ASC')->groupBy('t.id_tarea')->get();
        $tareasrow = count($tareas);
        
        $acttareas = PoiTarea::select(DB::raw('Sum(tar_enero) AS act_enero'), DB::raw('Sum(tar_febrero) AS act_febrero'), DB::raw('Sum(tar_marzo) AS act_marzo'), DB::raw('Sum(tar_abril) AS act_abril'), DB::raw('Sum(tar_mayo) AS act_mayo'), DB::raw('Sum(tar_junio) AS act_junio'), DB::raw('Sum(tar_julio) AS act_julio'), DB::raw('Sum(tar_agosto) AS act_agosto'), DB::raw('Sum(tar_setiembre) AS act_setiembre'), DB::raw('Sum(tar_octubre) AS act_octubre'), DB::raw('Sum(tar_noviembre) AS act_noviembre'), DB::raw('Sum(tar_diciembre) AS act_diciembre'), DB::raw('Sum(tar_enero+tar_febrero+tar_marzo) AS act_tri1'), DB::raw('Sum(tar_abril+tar_mayo+tar_junio) AS act_tri2'), DB::raw('Sum(tar_julio+tar_agosto+tar_setiembre) AS act_tri3'), DB::raw('Sum(tar_octubre+tar_noviembre+tar_diciembre) AS act_tri4'), DB::raw('Sum(tar_cantidad) AS act_total'))->where('poi_actividad_proyecto_idactividad_proyecto', '=', $id)->orderBy('id_tarea', 'ASC')->groupBy('poi_actividad_proyecto_idactividad_proyecto')->first();
        //dd($tareas);
        
        $actinsumos = PoiActividadEspecifica::select(DB::raw('sum(especifica_monto_total) AS instotal'), DB::raw('sum(especifica_enero) AS insenero'), DB::raw('sum(especifica_febrero) AS insfebrero'), DB::raw('sum(especifica_marzo) AS insmarzo'), DB::raw('sum(especifica_abril) AS insabril'), DB::raw('sum(especifica_mayo) AS insmayo'), DB::raw('sum(especifica_junio) AS insjunio'), DB::raw('sum(especifica_julio) AS insjulio'), DB::raw('sum(especifica_agosto) AS insagosto'), DB::raw('sum(especifica_setiembre) AS inssetiembre'), DB::raw('sum(especifica_octubre) AS insoctubre'), DB::raw('sum(especifica_noviembre) AS insnoviembre'), DB::raw('sum(especifica_diciembre) AS insdiciembre'), DB::raw('sum(especifica_enero+especifica_febrero+especifica_marzo) AS instri1'), DB::raw('sum(especifica_abril+especifica_mayo+especifica_junio) AS instri2'), DB::raw('sum(especifica_julio+especifica_agosto+especifica_setiembre) AS instri3'), DB::raw('sum(especifica_octubre+especifica_noviembre+especifica_diciembre) AS instri4'))->where('especifica_id_actividad_proyecto', '=', $id)->groupBy('especifica_id_actividad_proyecto')->first();
        $actinsumosrow = count($actinsumos);
            
        $gastos=DB::table('clasificador_gasto')
            ->select('idclasificador_gasto AS id', 'cg_clasificador AS clasificador', 'cg_descripcion AS nombre')
            ->get();
        
        $fuente=DB::table('poi_actividad_proyecto AS ap')
            ->join('poi_huamalies_excel AS hua', 'ap.act_proy_huam_regio', '=', 'hua.poi_huam_regio')
            ->select('ap.act_proy_huam_regio AS regio', 'hua.poi_huam_financiamiento_id', DB::raw('Sum(hua.poi_huam_total_financiera) AS total'), DB::raw('Sum(hua.poi_huam_total_fisica) AS fisica'))
            ->where('ap.idactividad_proyecto', '=', $id)
            ->groupBy('poi_huam_regio')
            ->orderBy('id_poi_huam', 'ASC')
            ->first();
        
        return view('poi.huamalies.imprimir', ['actividades'=>$actividades, 'mision'=>$mision, 'vision'=>$vision, 'ce'=>$ce, 'oet'=>$oet, 'aet'=>$aet, 'oei'=>$oei, 'aei'=>$aei, 'id'=>$id, 'especificas'=>$especificas, 'verespecificas'=>$verespecificas, 'gastos'=>$gastos, 'prog_p'=>$prog_p, 'fuente'=>$fuente, 'tareas'=>$tareas, 'acttareas'=>$acttareas, 'actinsumos'=>$actinsumos, 'tareasrow'=>$tareasrow, 'actinsumosrow'=>$actinsumosrow]);
    }
    
    public function tareas(Request $request)
    {
        $actividad = $request->poi_actividad_proyecto_idactividad_proyecto;
        $tarea = new PoiTarea();
        $tarea->tar_descripcion = mb_strtoupper($request->tar_descripcion);
        $tarea->tar_um = mb_strtoupper($request->tar_um);
        $tarea->tar_cantidad = $request->tar_cantidad;
        $tarea->poi_actividad_proyecto_idactividad_proyecto = $request->poi_actividad_proyecto_idactividad_proyecto;
        $tarea->tar_estado = 1;
        $tarea->tar_enero = $request->tar_enero;
        $tarea->tar_febrero = $request->tar_febrero;
        $tarea->tar_marzo = $request->tar_marzo;
        $tarea->tar_abril = $request->tar_abril;
        $tarea->tar_mayo = $request->tar_mayo;
        $tarea->tar_junio = $request->tar_junio;
        $tarea->tar_julio = $request->tar_julio;
        $tarea->tar_agosto = $request->tar_agosto;
        $tarea->tar_setiembre = $request->tar_setiembre;
        $tarea->tar_octubre = $request->tar_octubre;
        $tarea->tar_noviembre = $request->tar_noviembre;
        $tarea->tar_diciembre = $request->tar_diciembre;
        $tarea->save();
        
        return redirect('poi/huamalies/ver/'.$actividad);
    }
    
    public function edittareas(Request $request, $id)
    {
        $actividad = $request->poi_actividad_proyecto_idactividad_proyecto;
        $tarea = PoiTarea::find($id);
        $tarea->tar_descripcion = mb_strtoupper($request->tar_descripcion);
        $tarea->tar_um = mb_strtoupper($request->tar_um);
        $tarea->tar_cantidad = $request->taredit_cantidad;
        $tarea->poi_actividad_proyecto_idactividad_proyecto = $request->poi_actividad_proyecto_idactividad_proyecto;
        $tarea->tar_estado = 1;
        $tarea->tar_enero = $request->taredit_enero;
        $tarea->tar_febrero = $request->taredit_febrero;
        $tarea->tar_marzo = $request->taredit_marzo;
        $tarea->tar_abril = $request->taredit_abril;
        $tarea->tar_mayo = $request->taredit_mayo;
        $tarea->tar_junio = $request->taredit_junio;
        $tarea->tar_julio = $request->taredit_julio;
        $tarea->tar_agosto = $request->taredit_agosto;
        $tarea->tar_setiembre = $request->taredit_setiembre;
        $tarea->tar_octubre = $request->taredit_octubre;
        $tarea->tar_noviembre = $request->taredit_noviembre;
        $tarea->tar_diciembre = $request->taredit_diciembre;
        $tarea->save();
        
        return redirect('poi/huamalies/ver/'.$actividad)->with('msg', 'La Tarea fue Editado Satisfactoriamente.');
    }
        
    public function especificas(Request $request)
    {
        $actividad = $request->poi_actividad_proyecto_idactividad_proyecto;
        $tarea = $request->especifica_id_tarea;
        $especifica = new PoiActividadEspecifica();
        $especifica->especifica_id_actividad_proyecto = $request->poi_actividad_proyecto_idactividad_proyecto;
        $especifica->especifica_id_tarea = $request->especifica_id_tarea;
        $especifica->especifica_fuente_financiamiento = $request->especifica_fuente_financiamiento;
        $especifica->especifica_clasificador_gastos = $request->especifica_clasificador_gastos;
        $especifica->especifica_unidad_medida = mb_strtoupper($request->especifica_unidad_medida);
        $especifica->especifica_cantidad = $request->especifica_cantidad;
        $especifica->especifica_costo_referencial = $request->especifica_costo_referencial;
        $especifica->especifica_monto_total = $request->especifica_monto_total;
        $especifica->especifica_enero = $request->esp_enero;
        $especifica->especifica_febrero = $request->esp_febrero;
        $especifica->especifica_marzo = $request->esp_marzo;
        $especifica->especifica_abril = $request->esp_abril;
        $especifica->especifica_mayo = $request->esp_mayo;
        $especifica->especifica_junio = $request->esp_junio;
        $especifica->especifica_julio = $request->esp_julio;
        $especifica->especifica_agosto = $request->esp_agosto;
        $especifica->especifica_setiembre = $request->esp_setiembre;
        $especifica->especifica_octubre = $request->esp_octubre;
        $especifica->especifica_noviembre = $request->esp_noviembre;
        $especifica->especifica_diciembre = $request->esp_diciembre;
        $especifica->save();
        
        return redirect('poi/huamalies/insumos/'.$actividad.'/'.$tarea);
    }
    
    public function editespecificas(Request $request, $id)
    {
        $actividad = $request->poi_actividad_proyecto_idactividad_proyecto;
        $tarea = $request->especifica_id_tarea;
        
        $especifica = PoiActividadEspecifica::find($id);
        $especifica->especifica_id_actividad_proyecto = $request->poi_actividad_proyecto_idactividad_proyecto;
        $especifica->especifica_id_tarea = $request->especifica_id_tarea;
        $especifica->especifica_fuente_financiamiento = $request->especifica_fuente_financiamiento;
        $especifica->especifica_clasificador_gastos = $request->especifica_clasificador_gastos;
        $especifica->especifica_unidad_medida = mb_strtoupper($request->especifica_unidad_medida);
        $especifica->especifica_cantidad = $request->especifica_cantidad;
        $especifica->especifica_costo_referencial = $request->especifica_costo_referencial;
        $especifica->especifica_monto_total = $request->edit_especifica_monto_total;
        $especifica->especifica_enero = $request->edit_enero;
        $especifica->especifica_febrero = $request->edit_febrero;
        $especifica->especifica_marzo = $request->edit_marzo;
        $especifica->especifica_abril = $request->edit_abril;
        $especifica->especifica_mayo = $request->edit_mayo;
        $especifica->especifica_junio = $request->edit_junio;
        $especifica->especifica_julio = $request->edit_julio;
        $especifica->especifica_agosto = $request->edit_agosto;
        $especifica->especifica_setiembre = $request->edit_setiembre;
        $especifica->especifica_octubre = $request->edit_octubre;
        $especifica->especifica_noviembre = $request->edit_noviembre;
        $especifica->especifica_diciembre = $request->edit_diciembre;
        $especifica->save();
        
        return redirect('poi/huamalies/insumos/'.$actividad.'/'.$tarea)->with('msg', 'El Insumo fue Editado Satisfactoriamente.');
    }
    
    public function deleteespecificas($act, $tar, $id)
    {     
        $especifica = PoiActividadEspecifica::find($id);
        $especifica->delete();
        
        return redirect('poi/huamalies/insumos/'.$act.'/'.$tar)->with('msg', 'El Insumo fue Eliminado de la Tabla.');
    }
    
    public function uniorganica(Request $request, $id)
    {
        if($request->ajax()){
            /*$organicas = Oficina::select('ofi_codigo AS id', 'ofi_nombre AS nombre')->where('unidad_ejecutora_ue_codigo', '=', $id)->get();*/
            $organicas = DB::table('oficina AS o')
                ->join('poi AS p', 'o.ofi_codigo', '=', 'p.oficina')
                ->select('o.ofi_codigo AS id', 'o.ofi_nombre AS nombre')
                ->where('p.poi_anio', '=', 2018)
                ->where('o.unidad_ejecutora_ue_codigo', '=', $id)
                ->get();
            return response()->json($organicas);
		}
    }
    
    public function insumos($act, $tar)
    {
        $actividad = PoiActividadProyecto::select('act_proy_denominacion AS actividad')
            ->where('idactividad_proyecto', '=', $act)->first();
        
        $tarea = PoiTarea::select('tar_descripcion AS tarea')->where('id_tarea', '=', $tar)->first();
        
        $insumos = PoiActividadEspecifica::select('id_actividad_especifica AS id', 'especifica_fuente_financiamiento AS fuente', 'especifica_clasificador_gastos', 'especifica_unidad_medida AS um', 'especifica_cantidad AS cantidad', 'especifica_costo_referencial AS costo', 'especifica_monto_total AS monto', 'especifica_enero AS enero', 'especifica_febrero AS febrero', 'especifica_marzo AS marzo', DB::raw('sum(especifica_enero+especifica_febrero+especifica_marzo) AS tri1'), 'especifica_abril AS abril', 'especifica_mayo AS mayo', 'especifica_junio AS junio', DB::raw('sum(especifica_abril+especifica_mayo+especifica_junio) AS tri2'), 'especifica_julio AS julio', 'especifica_agosto AS agosto', 'especifica_setiembre AS setiembre', DB::raw('sum(especifica_julio+especifica_agosto+especifica_setiembre) AS tri3'), 'especifica_octubre AS octubre', 'especifica_noviembre AS noviembre', 'especifica_diciembre AS diciembre', DB::raw('sum(especifica_octubre+especifica_noviembre+especifica_diciembre) AS tri4'))->where('especifica_id_tarea', '=', $tar)->groupBy('id_actividad_especifica')->get();
        $insumosrow = count($insumos);
        //dd($insumosrow);
            
        $insact = PoiActividadEspecifica::select(DB::raw('sum(especifica_monto_total) AS tartotal'), DB::raw('sum(especifica_enero) AS tarenero'), DB::raw('sum(especifica_febrero) AS tarfebrero'), DB::raw('sum(especifica_marzo) AS tarmarzo'), DB::raw('sum(especifica_abril) AS tarabril'), DB::raw('sum(especifica_mayo) AS tarmayo'), DB::raw('sum(especifica_junio) AS tarjunio'), DB::raw('sum(especifica_julio) AS tarjulio'), DB::raw('sum(especifica_agosto) AS taragosto'), DB::raw('sum(especifica_setiembre) AS tarsetiembre'), DB::raw('sum(especifica_octubre) AS taroctubre'), DB::raw('sum(especifica_noviembre) AS tarnoviembre'), DB::raw('sum(especifica_diciembre) AS tardiciembre'), DB::raw('sum(especifica_enero+especifica_febrero+especifica_marzo) AS tartri1'), DB::raw('sum(especifica_abril+especifica_mayo+especifica_junio) AS tartri2'), DB::raw('sum(especifica_julio+especifica_agosto+especifica_setiembre) AS tartri3'), DB::raw('sum(especifica_octubre+especifica_noviembre+especifica_diciembre) AS tartri4'))->where('especifica_id_tarea', '=', $tar)->groupBy('especifica_id_tarea')->first();
        
        $gastos=DB::table('clasificador_gasto')
            ->select('idclasificador_gasto AS id', 'cg_descripcion AS nombre', DB::raw('Replace(cg_clasificador, " ", ".") AS clasificador'))
            ->having( DB::raw('LENGTH(clasificador)'), '>=','11')
            ->get();
        
        return view('poi.huamalies.insumos', ['actividad'=>$actividad, 'tarea'=>$tarea, 'insumos'=>$insumos, 'insact'=>$insact, 'insumosrow'=>$insumosrow, 'tar'=>$tar, 'act'=>$act, 'gastos'=>$gastos]);
    }
/*------------------------------------- IMPRIMIR FORMATO F3  ------------------------------------------------------*/     
    public function imprimirf3($act)
    {
        $actividad = DB::table('poi_actividad_proyecto AS ap')
            ->leftJoin('poi_actividad_especifica as aesp', 'ap.idactividad_proyecto', '=', 'aesp.especifica_id_actividad_proyecto')
            ->select('ap.act_proy_denominacion AS actividad', DB::raw('sum(aesp.especifica_monto_total) AS acttotal'), DB::raw('sum(aesp.especifica_enero) AS actenero'), DB::raw('sum(aesp.especifica_febrero) AS actfebrero'), DB::raw('sum(aesp.especifica_marzo) AS actmarzo'), DB::raw('sum(aesp.especifica_abril) AS actabril'), DB::raw('sum(aesp.especifica_mayo) AS actmayo'), DB::raw('sum(aesp.especifica_junio) AS actjunio'), DB::raw('sum(aesp.especifica_julio) AS actjulio'), DB::raw('sum(aesp.especifica_agosto) AS actagosto'), DB::raw('sum(aesp.especifica_setiembre) AS actsetiembre'), DB::raw('sum(aesp.especifica_octubre) AS actoctubre'), DB::raw('sum(aesp.especifica_noviembre) AS actnoviembre'), DB::raw('sum(aesp.especifica_diciembre) AS actdiciembre'), DB::raw('sum(aesp.especifica_enero+aesp.especifica_febrero+aesp.especifica_marzo) AS acttri1'), DB::raw('sum(aesp.especifica_abril+aesp.especifica_mayo+aesp.especifica_junio) AS acttri2'), DB::raw('sum(aesp.especifica_julio+aesp.especifica_agosto+aesp.especifica_setiembre) AS acttri3'), DB::raw('sum(aesp.especifica_octubre+aesp.especifica_noviembre+aesp.especifica_diciembre) AS acttri4'))
            ->groupBy('ap.idactividad_proyecto')
            ->where('ap.idactividad_proyecto', '=', $act)->first();
        
        $tareas = DB::table('poi_tarea AS t')
            ->leftJoin('poi_actividad_especifica AS ae', 't.id_tarea', '=', 'ae.especifica_id_tarea')
            ->select('id_tarea', 'tar_descripcion AS tarea', DB::raw('sum(ae.especifica_monto_total) AS tartotal'), DB::raw('sum(ae.especifica_enero) AS tarenero'), DB::raw('sum(ae.especifica_febrero) AS tarfebrero'), DB::raw('sum(ae.especifica_marzo) AS tarmarzo'), DB::raw('sum(ae.especifica_abril) AS tarabril'), DB::raw('sum(ae.especifica_mayo) AS tarmayo'), DB::raw('sum(ae.especifica_junio) AS tarjunio'), DB::raw('sum(ae.especifica_julio) AS tarjulio'), DB::raw('sum(ae.especifica_agosto) AS taragosto'), DB::raw('sum(ae.especifica_setiembre) AS tarsetiembre'), DB::raw('sum(ae.especifica_octubre) AS taroctubre'), DB::raw('sum(ae.especifica_noviembre) AS tarnoviembre'), DB::raw('sum(ae.especifica_diciembre) AS tardiciembre'), DB::raw('sum(ae.especifica_enero+ae.especifica_febrero+ae.especifica_marzo) AS tartri1'), DB::raw('sum(ae.especifica_abril+ae.especifica_mayo+ae.especifica_junio) AS tartri2'), DB::raw('sum(ae.especifica_julio+ae.especifica_agosto+ae.especifica_setiembre) AS tartri3'), DB::raw('sum(ae.especifica_octubre+ae.especifica_noviembre+ae.especifica_diciembre) AS tartri4'))
            ->where('poi_actividad_proyecto_idactividad_proyecto', '=', $act)
            ->orderBy('t.id_tarea', 'asc')
            ->groupBy('t.id_tarea')
            ->get();
        $tareasrow = count($tareas);
        
        $insumos = DB::table('poi_actividad_proyecto AS apr')
            ->leftJoin('poi_actividad_especifica as aes', 'apr.idactividad_proyecto', '=', 'aes.especifica_id_actividad_proyecto')
            ->join('clasificador_gasto AS cg', 'aes.especifica_clasificador_gastos', '=', 'cg.idclasificador_gasto')
            ->select('cg.cg_descripcion AS insumo', 'cg.cg_clasificador AS clasificador', 'aes.especifica_id_tarea AS id_tarea', 'aes.especifica_fuente_financiamiento AS fuente', 'aes.especifica_clasificador_gastos', 'aes.especifica_unidad_medida AS um', 'aes.especifica_cantidad AS cantidad', 'aes.especifica_costo_referencial AS costo', 'aes.especifica_monto_total AS monto', 'aes.especifica_enero AS enero', 'aes.especifica_febrero AS febrero', 'aes.especifica_marzo AS marzo', DB::raw('sum(aes.especifica_enero+aes.especifica_febrero+aes.especifica_marzo) AS tri1'), 'aes.especifica_abril AS abril', 'aes.especifica_mayo AS mayo', 'aes.especifica_junio AS junio', DB::raw('sum(aes.especifica_abril+aes.especifica_mayo+aes.especifica_junio) AS tri2'), 'aes.especifica_julio AS julio', 'aes.especifica_agosto AS agosto', 'aes.especifica_setiembre AS setiembre', DB::raw('sum(aes.especifica_julio+aes.especifica_agosto+aes.especifica_setiembre) AS tri3'), 'aes.especifica_octubre AS octubre', 'aes.especifica_noviembre AS noviembre', 'aes.especifica_diciembre AS diciembre', DB::raw('sum(aes.especifica_octubre+aes.especifica_noviembre+aes.especifica_diciembre) AS tri4'),
                    
                    DB::raw('(SELECT
                    count(*)
                    FROM
                    poi_actividad_proyecto
                    INNER JOIN poi_actividad_especifica ON poi_actividad_proyecto.idactividad_proyecto = poi_actividad_especifica.especifica_id_actividad_proyecto
                    WHERE
                    poi_actividad_especifica.especifica_id_tarea = aes.especifica_id_tarea ) AS con_ins')
                     
                    )
            ->where('apr.idactividad_proyecto', '=', $act)
            ->groupBy('aes.id_actividad_especifica')
            ->get();
        $insumosrow= count($insumos);
        
        $clasificadores = DB::table('poi_actividad_especifica AS pae')
            ->join('clasificador_gasto AS cg', 'pae.especifica_clasificador_gastos', '=', 'cg.idclasificador_gasto')
            ->select('pae.especifica_clasificador_gastos', 'cg.cg_clasificador AS clasificador', 'cg.cg_descripcion AS nombreclasf', DB::raw('sum(pae.especifica_cantidad) AS clacantidad'), DB::raw('sum(pae.especifica_monto_total) AS clamonto'), DB::raw('sum(pae.especifica_enero) AS claenero'), DB::raw('sum(pae.especifica_febrero) AS clafebrero'), DB::raw('sum(pae.especifica_marzo) AS clamarzo'), DB::raw('sum(pae.especifica_abril) AS claabril'), DB::raw('sum(pae.especifica_mayo) AS clamayo'), DB::raw('sum(pae.especifica_junio) AS clajunio'), DB::raw('sum(pae.especifica_julio) AS clajulio'), DB::raw('sum(pae.especifica_agosto) AS claagosto'), DB::raw('sum(pae.especifica_setiembre) AS clasetiembre'), DB::raw('sum(pae.especifica_octubre) AS claoctubre'), DB::raw('sum(pae.especifica_noviembre) AS clanoviembre'), DB::raw('sum(pae.especifica_diciembre) AS cladiciembre'), DB::raw('sum(pae.especifica_enero+pae.especifica_febrero+pae.especifica_marzo) AS clatri1'), DB::raw('sum(pae.especifica_abril+pae.especifica_mayo+pae.especifica_junio) AS clatri2'), DB::raw('sum(pae.especifica_julio+pae.especifica_agosto+pae.especifica_setiembre) AS clatri3'), DB::raw('sum(pae.especifica_octubre+pae.especifica_noviembre+pae.especifica_diciembre) AS clatri4'))
            ->where('pae.especifica_id_actividad_proyecto', '=', $act)
            ->orderBy('pae.especifica_clasificador_gastos', 'asc')
            ->groupBy('pae.especifica_clasificador_gastos')
            ->get();
        $clasifrow = count($clasificadores);
        
        $clasiftotal = PoiActividadEspecifica::select(DB::raw('sum(especifica_monto_total) AS totalmonto'), DB::raw('sum(especifica_monto_total) AS totalmonto'), DB::raw('sum(especifica_enero) AS totalenero'), DB::raw('sum(especifica_febrero) AS totalfebrero'), DB::raw('sum(especifica_marzo) AS totalmarzo'), DB::raw('sum(especifica_abril) AS totalabril'), DB::raw('sum(especifica_mayo) AS totalmayo'), DB::raw('sum(especifica_junio) AS totaljunio'), DB::raw('sum(especifica_julio) AS totaljulio'), DB::raw('sum(especifica_agosto) AS totalagosto'), DB::raw('sum(especifica_setiembre) AS totalsetiembre'), DB::raw('sum(especifica_octubre) AS totaloctubre'), DB::raw('sum(especifica_noviembre) AS totalnoviembre'), DB::raw('sum(especifica_diciembre) AS totaldiciembre'), DB::raw('sum(especifica_enero+especifica_febrero+especifica_marzo) AS totaltri1'), DB::raw('sum(especifica_abril+especifica_mayo+especifica_junio) AS totaltri2'), DB::raw('sum(especifica_julio+especifica_agosto+especifica_setiembre) AS totaltri3'), DB::raw('sum(especifica_octubre+especifica_noviembre+especifica_diciembre) AS totaltri4'))
            ->where('especifica_id_actividad_proyecto', '=', $act)
            ->groupBy('especifica_id_actividad_proyecto')
            ->first();
        //dd($clasifrow);
                
        return view('poi.huamalies.imprimirf3', ['actividad'=>$actividad, 'tareas'=>$tareas, 'tareasrow'=>$tareasrow, 'insumos'=>$insumos, 'clasificadores'=>$clasificadores, 'clasifrow'=>$clasifrow, 'clasiftotal'=>$clasiftotal, 'insumosrow'=>$insumosrow]);
    }
/*------------------------------------- VER FORMATO F3 -----------------------------------------------------------*/    
    public function verf3($act)
    {
        $actividad = DB::table('poi_actividad_proyecto AS ap')
            ->leftJoin('poi_actividad_especifica as aesp', 'ap.idactividad_proyecto', '=', 'aesp.especifica_id_actividad_proyecto')
            ->select('ap.act_proy_denominacion AS actividad', DB::raw('sum(aesp.especifica_monto_total) AS acttotal'), DB::raw('sum(aesp.especifica_enero) AS actenero'), DB::raw('sum(aesp.especifica_febrero) AS actfebrero'), DB::raw('sum(aesp.especifica_marzo) AS actmarzo'), DB::raw('sum(aesp.especifica_abril) AS actabril'), DB::raw('sum(aesp.especifica_mayo) AS actmayo'), DB::raw('sum(aesp.especifica_junio) AS actjunio'), DB::raw('sum(aesp.especifica_julio) AS actjulio'), DB::raw('sum(aesp.especifica_agosto) AS actagosto'), DB::raw('sum(aesp.especifica_setiembre) AS actsetiembre'), DB::raw('sum(aesp.especifica_octubre) AS actoctubre'), DB::raw('sum(aesp.especifica_noviembre) AS actnoviembre'), DB::raw('sum(aesp.especifica_diciembre) AS actdiciembre'), DB::raw('sum(aesp.especifica_enero+aesp.especifica_febrero+aesp.especifica_marzo) AS acttri1'), DB::raw('sum(aesp.especifica_abril+aesp.especifica_mayo+aesp.especifica_junio) AS acttri2'), DB::raw('sum(aesp.especifica_julio+aesp.especifica_agosto+aesp.especifica_setiembre) AS acttri3'), DB::raw('sum(aesp.especifica_octubre+aesp.especifica_noviembre+aesp.especifica_diciembre) AS acttri4'))
            ->groupBy('ap.idactividad_proyecto')
            ->where('ap.idactividad_proyecto', '=', $act)->first();
        
        $tareas = DB::table('poi_tarea AS t')
            ->leftJoin('poi_actividad_especifica AS ae', 't.id_tarea', '=', 'ae.especifica_id_tarea')
            ->select('id_tarea', 'tar_descripcion AS tarea', DB::raw('sum(ae.especifica_monto_total) AS tartotal'), DB::raw('sum(ae.especifica_enero) AS tarenero'), DB::raw('sum(ae.especifica_febrero) AS tarfebrero'), DB::raw('sum(ae.especifica_marzo) AS tarmarzo'), DB::raw('sum(ae.especifica_abril) AS tarabril'), DB::raw('sum(ae.especifica_mayo) AS tarmayo'), DB::raw('sum(ae.especifica_junio) AS tarjunio'), DB::raw('sum(ae.especifica_julio) AS tarjulio'), DB::raw('sum(ae.especifica_agosto) AS taragosto'), DB::raw('sum(ae.especifica_setiembre) AS tarsetiembre'), DB::raw('sum(ae.especifica_octubre) AS taroctubre'), DB::raw('sum(ae.especifica_noviembre) AS tarnoviembre'), DB::raw('sum(ae.especifica_diciembre) AS tardiciembre'), DB::raw('sum(ae.especifica_enero+ae.especifica_febrero+ae.especifica_marzo) AS tartri1'), DB::raw('sum(ae.especifica_abril+ae.especifica_mayo+ae.especifica_junio) AS tartri2'), DB::raw('sum(ae.especifica_julio+ae.especifica_agosto+ae.especifica_setiembre) AS tartri3'), DB::raw('sum(ae.especifica_octubre+ae.especifica_noviembre+ae.especifica_diciembre) AS tartri4'))
            ->where('poi_actividad_proyecto_idactividad_proyecto', '=', $act)
            ->orderBy('t.id_tarea', 'asc')
            ->groupBy('t.id_tarea')
            ->get();
        $tareasrow = count($tareas);
        
        $insumos = DB::table('poi_actividad_proyecto AS apr')
            ->leftJoin('poi_actividad_especifica as aes', 'apr.idactividad_proyecto', '=', 'aes.especifica_id_actividad_proyecto')
            ->join('clasificador_gasto AS cg', 'aes.especifica_clasificador_gastos', '=', 'cg.idclasificador_gasto')
            ->select('cg.cg_descripcion AS insumo', 'cg.cg_clasificador AS clasificador', 'aes.especifica_id_tarea AS id_tarea', 'aes.especifica_fuente_financiamiento AS fuente', 'aes.especifica_clasificador_gastos', 'aes.especifica_unidad_medida AS um', 'aes.especifica_cantidad AS cantidad', 'aes.especifica_costo_referencial AS costo', 'aes.especifica_monto_total AS monto', 'aes.especifica_enero AS enero', 'aes.especifica_febrero AS febrero', 'aes.especifica_marzo AS marzo', DB::raw('sum(aes.especifica_enero+aes.especifica_febrero+aes.especifica_marzo) AS tri1'), 'aes.especifica_abril AS abril', 'aes.especifica_mayo AS mayo', 'aes.especifica_junio AS junio', DB::raw('sum(aes.especifica_abril+aes.especifica_mayo+aes.especifica_junio) AS tri2'), 'aes.especifica_julio AS julio', 'aes.especifica_agosto AS agosto', 'aes.especifica_setiembre AS setiembre', DB::raw('sum(aes.especifica_julio+aes.especifica_agosto+aes.especifica_setiembre) AS tri3'), 'aes.especifica_octubre AS octubre', 'aes.especifica_noviembre AS noviembre', 'aes.especifica_diciembre AS diciembre', DB::raw('sum(aes.especifica_octubre+aes.especifica_noviembre+aes.especifica_diciembre) AS tri4'),
                    
                    DB::raw('(SELECT
                    count(*)
                    FROM
                    poi_actividad_proyecto
                    INNER JOIN poi_actividad_especifica ON poi_actividad_proyecto.idactividad_proyecto = poi_actividad_especifica.especifica_id_actividad_proyecto
                    WHERE
                    poi_actividad_especifica.especifica_id_tarea = aes.especifica_id_tarea ) AS con_ins')
                     
                    )
            ->where('apr.idactividad_proyecto', '=', $act)
            ->groupBy('aes.id_actividad_especifica')
            ->get();
        $insumosrow= count($insumos);
        
        $clasificadores = DB::table('poi_actividad_especifica AS pae')
            ->join('clasificador_gasto AS cg', 'pae.especifica_clasificador_gastos', '=', 'cg.idclasificador_gasto')
            ->select('pae.especifica_clasificador_gastos', 'cg.cg_clasificador AS clasificador', 'cg.cg_descripcion AS nombreclasf', DB::raw('sum(pae.especifica_cantidad) AS clacantidad'), DB::raw('sum(pae.especifica_monto_total) AS clamonto'), DB::raw('sum(pae.especifica_enero) AS claenero'), DB::raw('sum(pae.especifica_febrero) AS clafebrero'), DB::raw('sum(pae.especifica_marzo) AS clamarzo'), DB::raw('sum(pae.especifica_abril) AS claabril'), DB::raw('sum(pae.especifica_mayo) AS clamayo'), DB::raw('sum(pae.especifica_junio) AS clajunio'), DB::raw('sum(pae.especifica_julio) AS clajulio'), DB::raw('sum(pae.especifica_agosto) AS claagosto'), DB::raw('sum(pae.especifica_setiembre) AS clasetiembre'), DB::raw('sum(pae.especifica_octubre) AS claoctubre'), DB::raw('sum(pae.especifica_noviembre) AS clanoviembre'), DB::raw('sum(pae.especifica_diciembre) AS cladiciembre'), DB::raw('sum(pae.especifica_enero+pae.especifica_febrero+pae.especifica_marzo) AS clatri1'), DB::raw('sum(pae.especifica_abril+pae.especifica_mayo+pae.especifica_junio) AS clatri2'), DB::raw('sum(pae.especifica_julio+pae.especifica_agosto+pae.especifica_setiembre) AS clatri3'), DB::raw('sum(pae.especifica_octubre+pae.especifica_noviembre+pae.especifica_diciembre) AS clatri4'))
            ->where('pae.especifica_id_actividad_proyecto', '=', $act)
            ->orderBy('pae.especifica_clasificador_gastos', 'asc')
            ->groupBy('pae.especifica_clasificador_gastos')
            ->get();
        $clasifrow = count($clasificadores);
        
        $clasiftotal = PoiActividadEspecifica::select(DB::raw('sum(especifica_monto_total) AS totalmonto'), DB::raw('sum(especifica_monto_total) AS totalmonto'), DB::raw('sum(especifica_enero) AS totalenero'), DB::raw('sum(especifica_febrero) AS totalfebrero'), DB::raw('sum(especifica_marzo) AS totalmarzo'), DB::raw('sum(especifica_abril) AS totalabril'), DB::raw('sum(especifica_mayo) AS totalmayo'), DB::raw('sum(especifica_junio) AS totaljunio'), DB::raw('sum(especifica_julio) AS totaljulio'), DB::raw('sum(especifica_agosto) AS totalagosto'), DB::raw('sum(especifica_setiembre) AS totalsetiembre'), DB::raw('sum(especifica_octubre) AS totaloctubre'), DB::raw('sum(especifica_noviembre) AS totalnoviembre'), DB::raw('sum(especifica_diciembre) AS totaldiciembre'), DB::raw('sum(especifica_enero+especifica_febrero+especifica_marzo) AS totaltri1'), DB::raw('sum(especifica_abril+especifica_mayo+especifica_junio) AS totaltri2'), DB::raw('sum(especifica_julio+especifica_agosto+especifica_setiembre) AS totaltri3'), DB::raw('sum(especifica_octubre+especifica_noviembre+especifica_diciembre) AS totaltri4'))
            ->where('especifica_id_actividad_proyecto', '=', $act)
            ->groupBy('especifica_id_actividad_proyecto')
            ->first();
        //dd($clasifrow);
                
        return view('poi.huamalies.verf3', ['act'=>$act, 'actividad'=>$actividad, 'tareas'=>$tareas, 'tareasrow'=>$tareasrow, 'insumos'=>$insumos, 'clasificadores'=>$clasificadores, 'clasifrow'=>$clasifrow, 'clasiftotal'=>$clasiftotal, 'insumosrow'=>$insumosrow]);
    }
    
    
    public function destroy($id)
    {
    }
}
