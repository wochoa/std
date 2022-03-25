<?php

namespace App\Http\Controllers\Proy;

use App\_clases\proyectos\tools\certificar\SolicitudCertificacion;
use App\_clases\siaf\Especifica;
use App\_clases\siaf\reportes\Certificado;
use App\_clases\siaf\reportes\Presupuesto;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CertificarController extends Controller
{
    /**
     * Muestra la lista de certificaciones para su certificacion o ampliacion.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($act_proy,$anio, Request $request)
    {
        if($request->listar){
            $arreglo=[];
            $arreglo=$this->presupuestoToArray($act_proy,$anio,$arreglo);
            $arreglo=$this->certificadoToArray($act_proy,$anio,$arreglo);

            return view('proyectos.herramientas.certificar.listar', ['arr'=>$arreglo]);
        }
        else{
            return view('proyectos.herramientas.certificar.index',['proy'=>$act_proy,'anio'=>$anio, 'especificas'=>Especifica::getEspecificasToSelectforObra()]);
        }
    }
    /**
     * Muestra la lista de solicitudes de certificacion presupuestal.
     *
     * @return \Illuminate\Http\Response
     */
    public function imprimir($act_proy,$anio, Request $request)
    {
            return view('proyectos.herramientas.certificar.imprimir', ['proy'=>$act_proy,'anio'=>$anio]);
    }
    public function listar($act_proy,$anio, Request $request)
    {
        if($request->listar){

            $solicitudes = SolicitudCertificacion::where('solc_anio', '=', $anio)->where('solc_act_proy', '=', $act_proy);

            return view('proyectos.herramientas.certificar.solicitudes_lista', ['proy' => $act_proy, 'anio' => $anio, 'solicitudes' => $solicitudes->get()]);
        }
        else {

            return view('proyectos.herramientas.certificar.solicitudes', ['proy' => $act_proy, 'anio' => $anio]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $act_proy
     * @param  int  $anio
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($act_proy, $anio, Request $request)
    {
        if ($request->id==-1)
            $cert=new SolicitudCertificacion();
        else
            $cert = SolicitudCertificacion::find($request->id);

        $cert->solc_certificado=$request->solc_certificado;
        $cert->solc_oficina=$request->solc_oficina;
        $cert->solc_fecha=$request->solc_fecha;
        $cert->solc_documento=$request->solc_documento;
        $cert->solc_doc_sisgedo=$request->solc_doc_sisgedo;
        $cert->solc_tipo_gasto=$request->solc_tipo_gasto;
        $cert->solc_objeto=$request->solc_objeto;
        $cert->solc_tipo_proceso_seleccion=$request->solc_tipo_proceso_seleccion;
        $cert->solc_otros=$request->solc_otros;
        $cert->solc_justificacion=$request->solc_justificacion;
        $cert->solc_doc_priorizacion=$request->solc_doc_priorizacion;
        $cert->solc_pia=$request->solc_pia;
        $cert->solc_pim=$request->solc_pim;
        $cert->solc_certificacion=$request->solc_certificacion;
        $cert->solc_monto_solicitado=$request->solc_monto_solicitado;
        $cert->solc_anio=$request->solc_anio;
        $cert->solc_act_proy=$request->solc_act_proy;
        $cert->solc_sec_func=$request->solc_sec_func;
        $cert->solc_fuente_financiamiento=$request->solc_fuente_financiamiento;
        $cert->usuario_id=$request->usuario_id;
        $cert->save();
        return response(['ok'=>1]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($act_proy,$anio,$id)
    {
        $presupuestos = DB::table('proy_tools_certificacion')
        ->select('proy_tools_certificacion.solc_certificado',
            'proy_tools_certificacion.solc_fecha',
            'proy_tools_certificacion.solc_oficina',
            'proy_tools_certificacion.solc_documento',
            'proy_tools_certificacion.solc_tipo_gasto',
            'proy_tools_certificacion.solc_objeto',
            'proy_tools_certificacion.solc_tipo_proceso_seleccion',
            'proy_tools_certificacion.solc_otros',
            'proy_tools_certificacion.solc_justificacion',
            'proy_tools_certificacion.solc_doc_priorizacion',
            'proy_tools_certificacion.solc_fuente_financiamiento',
            'siaf_meta.PROGRAMA_P AS programa',
            'siaf_meta.ACT_PROY AS prod_proy',
            'siaf_meta.COMPONENTE AS act_al_obra',
            'siaf_meta.FUNCION',
            'siaf_meta.PROGRAMA AS division_funcional',
            'siaf_meta.SUB_PROGRA AS grupo_funcional',
            'siaf_meta.FINALIDAD',
            'siaf_meta.META',
            'proy_tools_certificacion.solc_pia',
            'proy_tools_certificacion.solc_pim',
            'proy_tools_certificacion.solc_certificacion',
            'proy_tools_certificacion.solc_monto_solicitado')
        ->join('siaf_meta', function (JoinClause $join){
            return $join->on('siaf_meta.ANO_EJE','=','proy_tools_certificacion.solc_anio')
                ->on('siaf_meta.SEC_FUNC','=','proy_tools_certificacion.solc_sec_func');
        })
        ->where('proy_tools_certificacion.id', '=', $id)
        ->where('siaf_meta.SEC_EJEC', '=', config('proyectos.unidad_ejecutora'));
        //dd($presupuestos->get());
        return view('proyectos.herramientas.certificar.imprimir', ['proy'=>$act_proy,'anio'=>$anio,'solicitud'=>$presupuestos->get()[0]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($act_proy,$anio, $id)
    {
        SolicitudCertificacion::find($id)->destroy();
    }
    /**
     * Crea un arreglo multidimencional a partir de el presupuesto.
     *
     * @param  int  $act_proy
     * @param  int  $anio
     * @param  array  $arreglo
     * @return array
     */
    private function presupuestoToArray($act_proy, $anio, $arreglo){
        $presupuestos = Presupuesto::select('ANO_EJE','SEC_FUNC', 'FUENTE_FIN', 'DESCRIPCIO', 'COMPONENTE_NOMBRE',
            'ID_CLASIFI', 'monto_cert', 'ESPECIFICA', 'pia', 'pim')
            ->where('ACT_PROY', '=', $act_proy)
            ->where('ANO_EJE', '=', $anio)
            ->where('SEC_EJEC', '=', config('proyectos.unidad_ejecutora'));
        foreach ($presupuestos->get() as $press){
            $sec_func=$press->SEC_FUNC;
            $especifica=$press->ID_CLASIFI;
            $fuente_ft=$press->FUENTE_FIN;
            $dataCert=['id'=>-1,
                'solc_certificado'=>'',
                'solc_oficina'=> 'GERENCIA REGIONAL DE INFRAESTRUCTURA',
                'solc_fecha'=> '',
                'solc_documento'=> '',
                'solc_doc_sisgedo'=> '',
                'solc_tipo_gasto'=> '',
                'solc_objeto'=> '',
                'solc_tipo_proceso_seleccion'=> '',
                'solc_otros'=> '',
                'solc_justificacion'=> '',
                'solc_doc_priorizacion'=> '',
                'solc_pia'=> 0,
                'solc_pim'=> 0,
                'solc_certificacion'=> 0,
                'solc_monto_solicitado'=> 0,
                'solc_anio'=> $anio,
                'solc_act_proy'=> $act_proy,
                'solc_sec_func'=> $sec_func,
                'solc_fuente_financiamiento'=> $fuente_ft,
                'solc_id_clasif'=>'',
                'usuario_id'=> ''];
            /******SECUENCIA FUNCIONAL***/
            if(!isset($arreglo[$sec_func])) {
                $arreglo[$sec_func] = [];
                $arreglo[$sec_func]['d']['pia']=$press->pia;
                $arreglo[$sec_func]['d']['pim']=$press->pim;
                $arreglo[$sec_func]['d']['monto_cert']=$press->monto_cert;
            }else{
                $arreglo[$sec_func]['d']['pia']+=$press->pia;
                $arreglo[$sec_func]['d']['pim']+=$press->pim;
                $arreglo[$sec_func]['d']['monto_cert']+=$press->monto_cert;
            }
            /*******ESPECIFICA****************/
            if(!isset($arreglo[$sec_func][$especifica])){
                $arreglo[$sec_func][$especifica] = [];
                $arreglo[$sec_func][$especifica]['d']['ESPECIFICA']=$press->ESPECIFICA;
                $arreglo[$sec_func][$especifica]['d']['pia']=$press->pia;
                $arreglo[$sec_func][$especifica]['d']['pim']=$press->pim;
                $arreglo[$sec_func][$especifica]['d']['monto_cert']=$press->monto_cert;
            }else{
                $arreglo[$sec_func][$especifica]['d']['pia']+=$press->pia;
                $arreglo[$sec_func][$especifica]['d']['pim']+=$press->pim;
                $arreglo[$sec_func][$especifica]['d']['monto_cert']+=$press->monto_cert;
            }
            /************FUENTE DE FINANCIAMIENTO*********/
            if(!isset($arreglo[$sec_func][$especifica][$fuente_ft])){
                $arreglo[$sec_func][$especifica][$fuente_ft] = [];
                $arreglo[$sec_func][$especifica][$fuente_ft]['d']['pia']=$press->pia;
                $arreglo[$sec_func][$especifica][$fuente_ft]['d']['pim']=$press->pim;
                $arreglo[$sec_func][$especifica][$fuente_ft]['d']['monto_cert']=$press->monto_cert;
                $arreglo[$sec_func][$especifica][$fuente_ft]['d']['d']=$dataCert;
                $arreglo[$sec_func][$especifica][$fuente_ft]['d']['d']['solc_pia']=$press->pia;
                $arreglo[$sec_func][$especifica][$fuente_ft]['d']['d']['solc_pim']=$press->pim;
                $arreglo[$sec_func][$especifica][$fuente_ft]['d']['d']['solc_certificacion']=$press->monto_cert;
            }else{
                $arreglo[$sec_func][$especifica][$fuente_ft]['d']['pia']+=$press->pia;
                $arreglo[$sec_func][$especifica][$fuente_ft]['d']['pim']+=$press->pim;
                $arreglo[$sec_func][$especifica][$fuente_ft]['d']['monto_cert']+=$press->monto_cert;
            }
        }
        return $arreglo;
    }
    private function certificadoToArray($act_proy, $anio, $arreglo){

        $certificados = Certificado::where('ACT_PROY', '=', $act_proy)
            ->where('ANO_EJE', '=', $anio)
            ->where('SEC_EJEC', '=', config('proyectos.unidad_ejecutora'));
        foreach ($certificados->get() as $cert){
            $sec_func=$cert->SEC_FUNC;
            $especifica=$cert->ID_CLASIFI;
            $fuente_ft=$cert->FUENTE_FIN;
            $certificado=$cert->CERTIFICAD.'-'.$cert->SECUENCIA1.' : '.$cert->GLOSA;
            /******SECUENCIA FUNCIONAL***/
            if(!isset($arreglo[$sec_func])) {
                $arreglo[$sec_func] = [];
                $arreglo[$sec_func]['d']['pia']='no definido';
                $arreglo[$sec_func]['d']['pim']='no definido';
                $arreglo[$sec_func]['d']['monto_cert']='no definido';
            }else{
            }
            /*******ESPECIFICA****************/
            if(!isset($arreglo[$sec_func][$especifica])){
                $arreglo[$sec_func][$especifica] = [];
                $arreglo[$sec_func][$especifica]['d']['ESPECIFICA']=$cert->ESPECIFICA;
                $arreglo[$sec_func][$especifica]['d']['pia']='no definido';
                $arreglo[$sec_func][$especifica]['d']['pim']='no definido';
                $arreglo[$sec_func][$especifica]['d']['monto_cert']='no definido';
            }else{
            }
            /************FUENTE DE FINANCIAMIENTO*********/
            if(!isset($arreglo[$sec_func][$especifica][$fuente_ft])){
                $arreglo[$sec_func][$especifica][$fuente_ft] = [];
                $arreglo[$sec_func][$especifica][$fuente_ft]['d']['pia']='no definido';
                $arreglo[$sec_func][$especifica][$fuente_ft]['d']['pim']='no definido';
                $arreglo[$sec_func][$especifica][$fuente_ft]['d']['monto_cert']='no definido';
            }else{
            }
            /*************CERTIFICACION PRESUPUESTAL***********/
            if(!isset($arreglo[$sec_func][$especifica][$fuente_ft][$certificado])){
                $arreglo[$sec_func][$especifica][$fuente_ft][$certificado] = [];
                $arreglo[$sec_func][$especifica][$fuente_ft][$certificado]['d']['monto_cert']=$cert->MONTO;
                $arreglo[$sec_func][$especifica][$fuente_ft][$certificado]['d']['glosa']=$cert->GLOSA;
            }else{
                $arreglo[$sec_func][$especifica][$fuente_ft][$certificado]['d']['monto_cert']+=$cert->MONTO;
                $arreglo[$sec_func][$especifica][$fuente_ft][$certificado]['d']['glosa']=$cert->GLOSA;
            }
        }
        return $arreglo;
    }
    private function getSolicitudCertificacion($act_proy, $anio, $arreglo){

    }
}
