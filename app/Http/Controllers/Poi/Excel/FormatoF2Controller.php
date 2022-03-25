<?php

namespace App\Http\Controllers\Poi\Excel;

use Illuminate\Http\Request;

use Excel;
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

class FormatoF2Controller extends Controller
{
    public function exportarf2($id)
    {
        Excel::create('Formato F2', function($excel) use($id)
        {           
            $excel->sheet('Sheetname', function($sheet) use($id)
            {                
                $mision = DB::table('poi_plan_detalle')->select('plan_det_descripcion as mision')->where('plan_det_id', '=', 1)->first();
        
                $vision = DB::table('poi_plan_detalle')->select('plan_det_descripcion as vision')->where('plan_det_id', '=', 2)->first();

                $actividades=DB::table('poi_actividad_proyecto AS act')
                    ->join('poi AS p', 'act.poi_codigo', '=', 'p.poi_codigo')
                    ->join('oficina AS o', 'p.oficina', '=', 'o.ofi_codigo')
                    ->join('unidad_ejecutora AS ue', 'o.unidad_ejecutora_ue_codigo', '=', 'ue.ue_codigo')
                    ->select('ue.ue_codigo AS unieje', 'ue.ue_descripcion AS nomunieje', 'o.ofi_nombre AS nomofi', 'p.poi_anio as anio', 'act.act_proy_prog_pres AS categoria', 'act.act_proy_funcion AS funcion', 'act.act_proy_div_funcional AS division', 'act.act_proy_grupo_funcional AS grupo', 'act.act_proy_prod_proy AS producto', 'act.act_proy_actividad AS actividad', 'act.idactividad_proyecto AS actid', 'act.act_proy_finalidad AS finalidad', 'act.act_proy_pdrc_oet_meta1 AS meta_oet_1', 'act.act_proy_pdrc_oet_meta2 AS meta_oet_2', 'act.act_proy_pdrc_aet_meta1 AS meta_aet_1', 'act.act_proy_pdrc_aet_meta2 AS meta_aet_2', 'act.act_proy_unidad_organica AS uniresponsable', 'act.act_proy_id_siaf_meta AS siaf')
                    ->where('act.idactividad_proyecto', '=', $id)
                    ->first();

                $inversiones = DB::table('poi_actividad_actividad AS aa')
                    ->leftJoin('poi_actividad_especifica AS ae', 'aa.actividad_id', '=', 'ae.especifica_id_actividad_actividad')
                    ->select('aa.actividad_id AS id', 'aa.actividad_numero AS numero', 'aa.actividad_denominacion AS denominacion', 'aa.actividad_indicador AS indicador', 'aa.actividad_unidad_medida AS um', 'aa.actividad_descripcion AS descripcion', 'aa.actividad_tareas_operativas AS tareas', 'aa.actividad_beneficiarios AS beneficiarios', 'aa.actividad_localizacion AS localizacion', 'aa.actividad_prioridad_oei AS prioridad', 'aa.actividad_fisica_enero AS enero', 'aa.actividad_fisica_febrero AS febrero', 'aa.actividad_fisica_marzo AS marzo', 'aa.actividad_fisica_abril AS abril', 'aa.actividad_fisica_mayo AS mayo', 'aa.actividad_fisica_junio AS junio', 'aa.actividad_fisica_julio AS julio', 'aa.actividad_fisica_agosto AS agosto', 'aa.actividad_fisica_setiembre AS setiembre', 'aa.actividad_fisica_octubre AS octubre', 'aa.actividad_fisica_noviembre AS noviembre', 'aa.actividad_fisica_diciembre AS diciembre', 'aa.actividad_fisica_total AS total', 
                        DB::raw('sum(ae.especifica_enero) AS esp_enero'),
                        DB::raw('sum(ae.especifica_febrero) AS esp_febrero'),
                        DB::raw('sum(ae.especifica_marzo) AS esp_marzo'),
                        DB::raw('sum(ae.especifica_abril) AS esp_abril'),
                        DB::raw('sum(ae.especifica_mayo) AS esp_mayo'),
                        DB::raw('sum(ae.especifica_junio) AS esp_junio'),
                        DB::raw('sum(ae.especifica_julio) AS esp_julio'),
                        DB::raw('sum(ae.especifica_agosto) AS esp_agosto'),
                        DB::raw('sum(ae.especifica_setiembre) AS esp_setiembre'),
                        DB::raw('sum(ae.especifica_octubre) AS esp_octubre'),
                        DB::raw('sum(ae.especifica_noviembre) AS esp_noviembre'),
                        DB::raw('sum(ae.especifica_diciembre) AS esp_diciembre'),
                        DB::raw('sum(ae.especifica_monto_total) AS esp_monto_total'),
                        DB::raw(
                                '(SELECT
                                    Sum(poi_actividad_especifica.especifica_monto_total)
                                FROM
                                    poi_actividad_especifica
                                WHERE
                                    poi_actividad_especifica.especifica_id_actividad_proyecto = '."'".$id."'".' AND
                                    poi_actividad_especifica.especifica_fuente_financiamiento = 1 AND
                                    poi_actividad_especifica.especifica_id_actividad_actividad = aa.actividad_id
                                GROUP BY
                                    poi_actividad_especifica.especifica_fuente_financiamiento,
                                    poi_actividad_especifica.especifica_id_actividad_actividad
                                ORDER BY
                                    poi_actividad_especifica.especifica_id_actividad_actividad ASC) AS ff1'
                                ),
                        DB::raw(
                                '(SELECT
                                    Sum(poi_actividad_especifica.especifica_monto_total)
                                FROM
                                    poi_actividad_especifica
                                WHERE
                                    poi_actividad_especifica.especifica_id_actividad_proyecto = '."'".$id."'".' AND
                                    poi_actividad_especifica.especifica_fuente_financiamiento = 2 AND
                                    poi_actividad_especifica.especifica_id_actividad_actividad = aa.actividad_id
                                GROUP BY
                                    poi_actividad_especifica.especifica_fuente_financiamiento,
                                    poi_actividad_especifica.especifica_id_actividad_actividad
                                ORDER BY
                                    poi_actividad_especifica.especifica_id_actividad_actividad ASC) AS ff2'
                                ),
                        DB::raw(
                                '(SELECT
                                    Sum(poi_actividad_especifica.especifica_monto_total)
                                FROM
                                    poi_actividad_especifica
                                WHERE
                                    poi_actividad_especifica.especifica_id_actividad_proyecto = '."'".$id."'".' AND
                                    poi_actividad_especifica.especifica_fuente_financiamiento = 3 AND
                                    poi_actividad_especifica.especifica_id_actividad_actividad = aa.actividad_id
                                GROUP BY
                                    poi_actividad_especifica.especifica_fuente_financiamiento,
                                    poi_actividad_especifica.especifica_id_actividad_actividad
                                ORDER BY
                                    poi_actividad_especifica.especifica_id_actividad_actividad ASC) AS ff3'
                                ),
                        DB::raw(
                                '(SELECT
                                    Sum(poi_actividad_especifica.especifica_monto_total)
                                FROM
                                    poi_actividad_especifica
                                WHERE
                                    poi_actividad_especifica.especifica_id_actividad_proyecto = '."'".$id."'".' AND
                                    poi_actividad_especifica.especifica_fuente_financiamiento = 4 AND
                                    poi_actividad_especifica.especifica_id_actividad_actividad = aa.actividad_id
                                GROUP BY
                                    poi_actividad_especifica.especifica_fuente_financiamiento,
                                    poi_actividad_especifica.especifica_id_actividad_actividad
                                ORDER BY
                                    poi_actividad_especifica.especifica_id_actividad_actividad ASC) AS ff4'
                                ),
                        DB::raw(
                                '(SELECT
                                    Sum(poi_actividad_especifica.especifica_monto_total)
                                FROM
                                    poi_actividad_especifica
                                WHERE
                                    poi_actividad_especifica.especifica_id_actividad_proyecto = '."'".$id."'".' AND
                                    poi_actividad_especifica.especifica_fuente_financiamiento = 5 AND
                                    poi_actividad_especifica.especifica_id_actividad_actividad = aa.actividad_id
                                GROUP BY
                                    poi_actividad_especifica.especifica_fuente_financiamiento,
                                    poi_actividad_especifica.especifica_id_actividad_actividad
                                ORDER BY
                                    poi_actividad_especifica.especifica_id_actividad_actividad ASC) AS ff5'
                                )
                            )
                    ->where('aa.idactividad_proyecto', '=', $id)
                    ->orderBy('aa.actividad_numero', 'asc')
                    ->groupBy('aa.actividad_id')
                    ->get();
                //dd($inversiones);
                $inversionrows=count($inversiones);   

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

                
            //-------------------------------------CONBINAR CELDAS------------------------------------------
                $sheet->mergeCells('A1:V1'); //conbinar celdas
                $sheet->mergeCells('A2:V2'); //conbinar celdas
                $sheet->mergeCells('A3:V3'); 
                $sheet->mergeCells('A4:C4'); $sheet->mergeCells('E4:H4'); $sheet->mergeCells('I4:K4'); $sheet->mergeCells('L4:Q4'); $sheet->mergeCells('R4:S4'); $sheet->mergeCells('T4:V4'); 
                $sheet->mergeCells('A5:V5');
                $sheet->mergeCells('A6:V6');
                $sheet->mergeCells('A7:C7'); $sheet->mergeCells('D7:K7'); $sheet->mergeCells('L7:O7'); $sheet->mergeCells('P7:V7');
                $sheet->mergeCells('A8:C8'); $sheet->mergeCells('E8:K8'); $sheet->mergeCells('L8:O9'); $sheet->mergeCells('P8:T9'); $sheet->mergeCells('U8:V9');
                $sheet->mergeCells('A9:B11'); $sheet->mergeCells('E9:K9');
                $sheet->mergeCells('E10:K10'); $sheet->mergeCells('L10:O10'); $sheet->mergeCells('P10:T10'); 
                $sheet->mergeCells('E11:K11'); $sheet->mergeCells('L11:O11'); $sheet->mergeCells('P11:T11');
                $sheet->mergeCells('A12:B13'); $sheet->mergeCells('E12:K12'); $sheet->mergeCells('L12:O12'); $sheet->mergeCells('P12:T12');
                $sheet->mergeCells('E13:K13'); $sheet->mergeCells('L13:O13'); $sheet->mergeCells('P13:T13');
                $sheet->mergeCells('A14:V14');
                $sheet->mergeCells('A15:V15');
                $sheet->mergeCells('A16:B17');$sheet->mergeCells('C16:D16');$sheet->mergeCells('E16:G16');$sheet->mergeCells('H16:J16');$sheet->mergeCells('K16:L16');$sheet->mergeCells('M16:O16');$sheet->mergeCells('P16:R16');$sheet->mergeCells('S16:T16');$sheet->mergeCells('U16:V16');
                $sheet->mergeCells('C17:D17');$sheet->mergeCells('E17:G17');$sheet->mergeCells('H17:J17');$sheet->mergeCells('K17:L17');$sheet->mergeCells('M17:O17');$sheet->mergeCells('P17:R17');$sheet->mergeCells('S17:T17');$sheet->mergeCells('U17:V17');
                $sheet->mergeCells('A18:V18');
                $sheet->mergeCells('A19:V19');
                $sheet->mergeCells('A20:A21');$sheet->mergeCells('B20:G21');$sheet->mergeCells('H20:J21');$sheet->mergeCells('K20:M21');$sheet->mergeCells('N20:Q20');$sheet->mergeCells('R20:V20');$sheet->mergeCells('N21:O21');$sheet->mergeCells('P21:Q21');
            //-------------------------------------BORDES DE CELDAS----------------------------------------
                $sheet->setWidth(array('A'=>'12')); //tamaño horizontal
                $sheet->setWidth(array('B'=>'12')); //tamaño horizontal
                $sheet->setBorder('A1:V1', 'thin'); //pintar border
                $sheet->setBorder('A3:V4', 'thin'); //pintar border
                $sheet->setBorder('A6:V13', 'thin'); //pintar border
                $sheet->setBorder('A15:V17', 'thin'); //pintar border              
                $sheet->setBorder('A19:V21', 'thin'); //pintar border              
                
            //-------------------------------------PINTAR CELDAS------------------------------------------
                $sheet->cells('A1:V1', function($cells)
                {
                    $cells->setBackground('#244062');   //color de fondo
                    $cells->setFontColor('#ffffff');   //color de letra
                    $cells->setAlignment('center');   //centrar Horizontal
                    $cells->setValignment('center');   //centrar Vertical
                    $cells->setFont(array('bold'=>true)); //negrita
                });                 
                
                $sheet->cells('A3:V3', function($cells)
                    {$cells->setBackground('#4F81BD');$cells->setFontColor('#ffffff');$cells->setFont(array('bold'=>true));});  
                $sheet->cells('A4:C4', function($cells)
                    {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));});  
                $sheet->cells('I4:K4', function($cells)
                    {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));});  
                $sheet->cells('R4:S4', function($cells)
                    {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));}); 
                $sheet->cells('A6:V6', function($cells)
                    {$cells->setBackground('#4F81BD');$cells->setFontColor('#ffffff');$cells->setFont(array('bold'=>true));}); 
                $sheet->cells('A7:C7', function($cells)
                    {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));}); 
                $sheet->cells('K7:O7', function($cells)
                    {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));});  
                $sheet->cells('A8:V8', function($cells)
                    {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));});
                $sheet->cells('A9:C13', function($cells)
                    {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));});
                $sheet->cells('A15:V15', function($cells)
                    {$cells->setBackground('#4F81BD');$cells->setFontColor('#ffffff');$cells->setFont(array('bold'=>true));});
                $sheet->cells('A16:B17', function($cells)
                    {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));});
                $sheet->cells('C16:V16', function($cells)
                    {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));});
                $sheet->cells('A19:V19', function($cells)
                    {$cells->setBackground('#4F81BD');$cells->setFontColor('#ffffff');$cells->setFont(array('bold'=>true));});
                $sheet->cells('A20:V21', function($cells)
                    {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));});
                $sheet->cells('R21:V21', function($cells)
                    {$cells->setFont(array('bold'=>true));$cells->setAlignment('center');});
                //------------------------------------- TAREAS --------------------------------------------               
                
                //$sheet->setHeigth(array('letra(D)'=>'tamaño')); //tamaño horizontal
                //$sheet->setHeigth(array('numero(1)'=>'tamaño'));//tamaño vertical     
            //-------------------------------------IMPRIMIR CELDAS------------------------------------------
                $data=[];
                array_push($data, array('FORMATO F2: PROGRAMACIÓN DE LA ACTIVIDAD OPERATIVA / ACCIÓN INVERSIÓN','','','','','','','','','','','','','','','','','','','','',''));
                //1.........................................................................................
                array_push($data, array('','','','','','','','','','','','','','','','','','','','','',''));
                array_push($data, array('1. INFORMACIÓN GENERAL','','','','','','','','','','','','','','','','','','','','',''));
                array_push($data, array('1.1. Unidad Ejecutora','','',$actividades->unieje,$actividades->nomunieje,'','','','1.2. Centro de Costo','','',$actividades->nomofi,'','','','','','1.3. Periodo','',$actividades->anio,'',''));
                //2.........................................................................................
                array_push($data, array('','','','','','','','','','','','','','','','','','','','','',''));
                array_push($data, array('2. ALINEAMIENTO ESTRATÉGICO','','','','','','','','','','','','','','','','','','','','',''));
                array_push($data, array('2.1. Visión Regional','','',$vision->vision,'','','','','','','','2.2. Misión Institucional','','','',$mision->mision,'','','','','',''));
                array_push($data, array('2.3. Plan Estratégico','','','2.4. Código','2.5. Descripción','','','','','','','2.6. Indicador','','','','2.7. Unidad de Medida','','','','','2.8. Meta',''));
                array_push($data, array('2.3.1. PDRC Huánuco al 2021','','C.E.',$ce->id,$ce->descripcion,'','','','','','','','','','','','','','','','',''));
                array_push($data, array('','','O.E.T.',$oet->id,$oet->descripcion,'','','','','','',$oet->indicador,'','','',$oet->medida,'','','','',$oet->meta1,$oet->meta2));
                array_push($data, array('','','A.E.T.',$aet->id,$aet->descripcion,'','','','','','',$aet->indicador,'','','',$aet->medida,'','','','',$aet->meta1,$aet->meta2));
                array_push($data, array('2.3.2. PEI 2017-2019','','O.E.I.',$oei->id,$oei->descripcion,'','','','','','',$oei->indicador,'','','',$oei->medida,'','','','',$oei->meta1,$oei->meta2));
                array_push($data, array('','','A.E.I.',$aei->id,$aei->descripcion,'','','','','','',$aei->indicador,'','','',$aei->medida,'','','','',$aei->meta1,$aei->meta2));
                //3.........................................................................................
                array_push($data, array('','','','','','','','','','','','','','','','','','','','','',''));
                array_push($data, array('3.ARTICULACIÓN PRESUPUESTARIA','','','','','','','','','','','','','','','','','','','','',''));                
                array_push($data, array('3.1. Estructura Funcional Programática','','3.1.1. Función','','3.1.2. División Funcional','','','3.1.3. Grupo Funcional','','','3.1.4. Categoría Presupuestal','','3.1.5. Producto/Proyecto','','','3.1.6. Actividad/Acción/Obra','','','3.1.7. Finalidad','','3.1.8. Meta Presupuestaria',''));
                array_push($data, array('','',$actividades->funcion,'',$actividades->division,'','',$actividades->grupo,'','',$actividades->categoria,'',$actividades->producto,'','',$actividades->actividad,'','',$actividades->finalidad,'',$actividades->siaf,''));
                //4.........................................................................................
                array_push($data, array('','','','','','','','','','','','','','','','','','','','','',''));
                array_push($data, array('4. PROGRAMACIÓN OPERATIVA','','','','','','','','','','','','','','','','','','','','',''));
                array_push($data, array('4.1. Número','4.2. Denominación de la Actividad Operativa o Inversión','','','','','','4.3. Indicador','','','4.4. Unidad de Medida','','','4.5. Meta Anual','','','','4.6. Fuente de Financiamiento (S/.)','','','',''));
                array_push($data, array('','','','','','','','','','','','','','FÍSICA','','FINANCIERA','','RO','RDR','ROOC','DyT','RD'));
            //----------------------------------------- ACTIVIDADES --------------------------------------------
                $a=22;$b=21;$v=21;
                foreach($inversiones AS $inversion){
                    $b++;
                    $v++;
                    $sheet->mergeCells('B'.$b.':G'.$v);$sheet->mergeCells('H'.$b.':J'.$v);$sheet->mergeCells('K'.$b.':M'.$v);$sheet->mergeCells('N'.$b.':O'.$v);$sheet->mergeCells('P'.$b.':Q'.$v);
                    
                    array_push($data, array($inversion->numero,$inversion->denominacion,'','','','','',$inversion->indicador,'','',$inversion->um,'','',$inversion->total,'',$inversion->esp_monto_total,'',$inversion->ff1,$inversion->ff2,$inversion->ff3,$inversion->ff4,$inversion->ff5));
                }
            //----------------------------------------- ACTIVIDADES --------------------------------------------
                
                $b++;$v++;
                $sheet->mergeCells('A'.$b.':D'.$v);$sheet->mergeCells('E'.$b.':I'.$v);$sheet->mergeCells('J'.$b.':M'.$v);$sheet->mergeCells('N'.$b.':P'.$v);$sheet->mergeCells('Q'.$b.':T'.$v);$sheet->mergeCells('U'.$b.':V'.$v);
                $sheet->cells('A'.$b.':V'.$v, function($cells)
                    {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));});                
                array_push($data, array('4.7. Actividad-Acción Inversión','','','','4.7.1. Descripción','','','','','4.7.2. Tareas Operativa(s)','','','','4.7.3. Beneficiarios','','','4.7.4. Localización','','','','4.8. Prioridad OEI',''));
                
            //----------------------------------------- ACTIVIDADES 2 --------------------------------------------
                $num=1;
                foreach($inversiones AS $inversion){
                    $b++;
                    $v++;
                    $num++;
                    $sheet->mergeCells('A'.$b.':D'.$v);$sheet->mergeCells('E'.$b.':I'.$v);$sheet->mergeCells('J'.$b.':M'.$v);$sheet->mergeCells('N'.$b.':P'.$v);$sheet->mergeCells('Q'.$b.':T'.$v);$sheet->mergeCells('U'.$b.':V'.$v);
                    
                    array_push($data, array($num.'.-'. $inversion->denominacion,'','','',$inversion->descripcion,'','','','',$inversion->tareas,'','','',$inversion->beneficiarios,'','',$inversion->localizacion,'','','',$inversion->prioridad,''));                        
                }                
            //----------------------------------------- ACTIVIDADES 2 --------------------------------------------
                        
                $b++;$v++;      
                $c=$b+1;        
                $sheet->mergeCells('A'.$b.':C'.$c); $sheet->mergeCells('D'.$b.':E'.$c); $sheet->mergeCells('F'.$b.':H'.$v); $sheet->mergeCells('I'.$b.':I'.$c); $sheet->mergeCells('J'.$b.':L'.$v); $sheet->mergeCells('M'.$b.':M'.$c); $sheet->mergeCells('N'.$b.':P'.$v); $sheet->mergeCells('Q'.$b.':Q'.$c); $sheet->mergeCells('R'.$b.':T'.$v); $sheet->mergeCells('U'.$b.':U'.$c); $sheet->mergeCells('V'.$b.':V'.$c);
                
                $sheet->cells('A'.$b.':V'.$c, function($cells)
                    {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));}); 
                $sheet->cells('F'.$c.':H'.$c, function($cells)
                    {$cells->setAlignment('center');});
                $sheet->cells('J'.$c.':L'.$c, function($cells)
                    {$cells->setAlignment('center');});
                $sheet->cells('N'.$c.':P'.$c, function($cells)
                    {$cells->setAlignment('center');}); 
                $sheet->cells('R'.$c.':T'.$c, function($cells)
                    {$cells->setAlignment('center');}); 
                                       
                
                
                array_push($data, array('4.9. Actividad-Acción de Inversión','','','Unidad de Medida','','I Trimestre','','','Total al I Trim','II Trimestre','','','Total al II Trim','III Trimestre','','','Total al III Trim','IV Trimestre','','','Total al IV Trim','Total I Anual'));
                array_push($data, array('','','','','','Ene','Feb','Mar','','Abr','May','Jun','','Jul','Ago','Set','','Oct','Nov','Dic','',''));
                
            //------------------------------------- INVERSIONES --------------------------------------------
                $tar=1;
                $q=$b+2;
                if($inversionrows != 0){
                    foreach($inversiones AS $inversion){
                        $b=$b+2;
                        $v=$v+2;
                        $c=$c+2;
                        $sheet->mergeCells('A'.$b.':C'.$c);
                        $sheet->cells('A'.$b.':D'.$c, function($cells)
                            {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));});  
                        $sheet->cells('U'.$b.':V'.$c, function($cells)
                            {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));});   
                        
                        array_push($data, array('Actividad '.$tar.':'. $inversion->denominacion,'','','Física','-',$inversion->enero,$inversion->febrero,$inversion->marzo,$inversion->enero+$inversion->febrero+$inversion->marzo,$inversion->abril,$inversion->mayo,$inversion->junio,$inversion->abril+$inversion->mayo+$inversion->junio,$inversion->julio,$inversion->agosto,$inversion->setiembre,$inversion->julio+$inversion->agosto+$inversion->setiembre,$inversion->octubre,$inversion->noviembre,$inversion->diciembre,$inversion->octubre+$inversion->noviembre+$inversion->diciembre,$inversion->total));
                        
                        array_push($data, array('','','','Financiera','S/.',$inversion->esp_enero,$inversion->esp_febrero,$inversion->esp_marzo,$inversion->esp_enero+$inversion->esp_febrero+$inversion->esp_marzo,$inversion->esp_abril,$inversion->esp_mayo,$inversion->esp_junio,$inversion->esp_abril+$inversion->esp_mayo+$inversion->esp_junio,$inversion->esp_julio,$inversion->esp_agosto,$inversion->esp_setiembre,$inversion->esp_julio+$inversion->esp_agosto+$inversion->esp_setiembre,$inversion->esp_octubre,$inversion->esp_noviembre,$inversion->esp_diciembre,$inversion->esp_octubre+$inversion->esp_noviembre+$inversion->esp_diciembre,$inversion->esp_monto_total));
                        $tar++;
                    }   
                    
                    $sheet->setBorder('A'.$a.':V'.$c, 'thin'); //pintar border

                    $sheet->cells('I'.$q.':I'.$c, function($cells)
                        {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));}); 
                    $sheet->cells('M'.$q.':M'.$c, function($cells)
                        {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));}); 
                    $sheet->cells('Q'.$q.':Q'.$c, function($cells)
                        {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));}); 
                    $sheet->cells('E'.$q.':E'.$c, function($cells)
                        {$cells->setAlignment('center');});
                    $sheet->cells('F'.$q.':V'.$c, function($cells)
                        {$cells->setAlignment('right');}); 
                }
            //------------------------------------- INVERSIONES --------------------------------------------
                
                $sheet->fromArray($data, null, 'A1', false, false);                
            });
        })->download('xls');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
        //
    }
}
