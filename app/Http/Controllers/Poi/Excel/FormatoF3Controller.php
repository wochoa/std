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

class FormatoF3Controller extends Controller
{
    public function exportarf3($act)
    {
        Excel::create('Formato F3', function($excel) use($act)
        {           
            $excel->sheet('Sheetname', function($sheet) use($act)
            {  
                
                $actividades=DB::table('poi_actividad_proyecto AS act')
                ->join('poi AS p', 'act.poi_codigo', '=', 'p.poi_codigo')
                ->join('oficina AS o', 'p.oficina', '=', 'o.ofi_codigo')
                ->join('unidad_ejecutora AS ue', 'o.unidad_ejecutora_ue_codigo', '=', 'ue.ue_codigo')
                ->select('ue.ue_codigo AS unieje', 'ue.ue_descripcion AS nomunieje', 'o.ofi_nombre AS nomofi', 'p.poi_anio as anio', 'act.act_proy_prog_pres AS categoria', 'act.act_proy_funcion AS funcion', 'act.act_proy_div_funcional AS division', 'act.act_proy_grupo_funcional AS grupo', 'act.act_proy_prod_proy AS producto', 'act.act_proy_actividad AS actividad', 'act.act_proy_finalidad AS finalidad', 'act.act_proy_unidad_organica AS uniresponsable', 'act.act_proy_id_siaf_meta AS siaf')
                ->where('act.idactividad_proyecto', '=', $act)
                ->first();


                $inversiones = DB::table('poi_actividad_actividad AS aa')
                    ->leftJoin('poi_actividad_especifica AS ae', 'aa.actividad_id', '=', 'ae.especifica_id_actividad_actividad')
                    ->select('aa.actividad_id AS id', 'aa.actividad_denominacion AS denominacion', 'aa.actividad_indicador AS indicador', 'aa.actividad_unidad_medida AS um', 'aa.actividad_fisica_total AS total', 
                        DB::raw('sum(ae.especifica_cantidad) AS esp_cantidad'),
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
                        DB::raw('count(ae.especifica_monto_total) AS con_ins_tar')
                            )
                    ->where('aa.idactividad_proyecto', '=', $act)
                    ->orderBy('aa.actividad_numero', 'asc')
                    ->groupBy('aa.actividad_id')
                    ->get();        
                $inversionrows=count($inversiones);

                $insumos=PoiActividadEspecifica::select('especifica_id_actividad_actividad AS idact', 'id_actividad_especifica AS id', 'especifica_fuente_financiamiento AS fuente', 'especifica_clasificador_gastos', 'especifica_unidad_medida AS um', 'especifica_cantidad AS cantidad', 'especifica_costo_referencial AS costo', 'especifica_monto_total AS monto', 'especifica_enero AS enero', 'especifica_febrero AS febrero', 'especifica_marzo AS marzo', 'especifica_abril AS abril', 'especifica_mayo AS mayo', 'especifica_junio AS junio', 'especifica_julio AS julio', 'especifica_agosto AS agosto', 'especifica_setiembre AS setiembre', 'especifica_octubre AS octubre', 'especifica_noviembre AS noviembre', 'especifica_diciembre AS diciembre')->where('especifica_id_actividad_proyecto', '=', $act)->orderBy('id_actividad_especifica')->get();
                //dd($insumos);
                $insumorows = count($insumos);

                $totalins=PoiActividadEspecifica::select(DB::raw('sum(especifica_cantidad) AS total_cantidad'), DB::raw('sum(especifica_enero) AS total_enero'),
                DB::raw('sum(especifica_febrero) AS total_febrero'), 
                DB::raw('sum(especifica_marzo) AS total_marzo'),
                DB::raw('sum(especifica_abril) AS total_abril'),
                DB::raw('sum(especifica_mayo) AS total_mayo'),
                DB::raw('sum(especifica_junio) AS total_junio'),
                DB::raw('sum(especifica_julio) AS total_julio'),
                DB::raw('sum(especifica_agosto) AS total_agosto'),
                DB::raw('sum(especifica_setiembre) AS total_setiembre'),
                DB::raw('sum(especifica_octubre) AS total_octubre'),
                DB::raw('sum(especifica_noviembre) AS total_noviembre'),
                DB::raw('sum(especifica_diciembre) AS total_diciembre'),
                DB::raw('sum(especifica_monto_total) AS total_monto'))
                    ->where('especifica_id_actividad_proyecto', '=', $act)
                    ->groupBy('especifica_id_actividad_proyecto')
                    ->first();

                $actinsumos=PoiActividadEspecifica::select('especifica_id_actividad_actividad AS idact', 'id_actividad_especifica AS id', 'especifica_fuente_financiamiento AS act_fuente', 'especifica_clasificador_gastos', 'especifica_unidad_medida AS act_um', 'especifica_cantidad AS act_cantidad', 'especifica_monto_total AS act_monto', 'especifica_enero AS act_enero', 'especifica_febrero AS act_febrero', 'especifica_marzo AS act_marzo', 'especifica_abril AS act_abril', 'especifica_mayo AS act_mayo', 'especifica_junio AS act_junio', 'especifica_julio AS act_julio', 'especifica_agosto AS act_agosto', 'especifica_setiembre AS act_setiembre', 'especifica_octubre AS act_octubre', 'especifica_noviembre AS act_noviembre', 'especifica_diciembre AS act_diciembre')->where('especifica_id_actividad_proyecto', '=', $act)->orderBy('especifica_fuente_financiamiento')->get();
                $actinsrows=count($actinsumos);
                
            //----------------------------------------------------------------------------------------------
                $sheet->setStyle(array(
                    'font' => array(
                        'name'      =>  'Calibri',
                        'size'      =>  8
                        //'bold'      =>  true
                    )
                ));
                //------------------------------------CONBINAR CELDAS-------------------------------------
                $sheet->mergeCells('A1:AA1');
                $sheet->mergeCells('A2:AA2');
                $sheet->mergeCells('A3:AA3');
                
                $sheet->mergeCells('A4:B4'); $sheet->mergeCells('C4:D4'); $sheet->mergeCells('E4:K4'); $sheet->mergeCells('L4:N4'); $sheet->mergeCells('O4:V4'); $sheet->mergeCells('W4:X4'); $sheet->mergeCells('Y4:AA4');
                
                $sheet->mergeCells('A5:AA5');
                $sheet->mergeCells('A6:AA6');
                
                $sheet->mergeCells('A7:B8'); $sheet->mergeCells('C7:D7'); $sheet->mergeCells('E7:H7'); $sheet->mergeCells('I7:L7'); $sheet->mergeCells('M7:O7'); $sheet->mergeCells('P7:R7'); $sheet->mergeCells('S7:U7'); $sheet->mergeCells('V7:X7'); $sheet->mergeCells('Y7:AA7');
                
                $sheet->mergeCells('C8:D8'); $sheet->mergeCells('E8:H8'); $sheet->mergeCells('I8:L8'); $sheet->mergeCells('M8:O8'); $sheet->mergeCells('P8:R8'); $sheet->mergeCells('S8:U8'); $sheet->mergeCells('V8:X8'); $sheet->mergeCells('Y8:AA8');
                $sheet->mergeCells('A9:AA9');
                
                $sheet->mergeCells('A10:AA10');
                $sheet->mergeCells('A11:A12');$sheet->mergeCells('B11:B12');$sheet->mergeCells('C11:C12');$sheet->mergeCells('D11:D12');$sheet->mergeCells('E11:E12');$sheet->mergeCells('F11:F12');$sheet->mergeCells('G11:K11');$sheet->mergeCells('L11:L12');$sheet->mergeCells('M11:M12');$sheet->mergeCells('N11:N12');$sheet->mergeCells('O11:Z11');$sheet->mergeCells('AA11:AA12');
                //-------------------------------------BORDES DE CELDAS-------------------------------------
                $sheet->setBorder('A1:AA1', 'thin');
                $sheet->setBorder('A3:AA4', 'thin');
                $sheet->setBorder('A6:AA8', 'thin');
                $sheet->setBorder('A10:AA12', 'thin');
                $sheet->setWidth(array('A'=>'15'));
                $sheet->setWidth(array('B'=>'40'));
                $sheet->setWidth(array('L'=>'40'));
                $sheet->setWidth(array('F'=>'6'));
                $sheet->setWidth(array('G'=>'6'));
                $sheet->setWidth(array('H'=>'6'));
                $sheet->setWidth(array('I'=>'6'));
                $sheet->setWidth(array('J'=>'6'));
                $sheet->setWidth(array('K'=>'6'));
                
                //-------------------------------------PINTAR CELDAS----------------------------------------
                $sheet->cells('A1:V1', function($cells)
                {
                    $cells->setBackground('#244062');   //color de fondo
                    $cells->setFontColor('#ffffff');   //color de letra
                    $cells->setAlignment('center');   //centrar Horizontal
                    $cells->setValignment('center');   //centrar Vertical
                    $cells->setFont(array('bold'=>true)); //negrita
                }); 
                $sheet->cells('A3:AA3', function($cells)
                    {$cells->setBackground('#4F81BD');$cells->setFontColor('#ffffff');$cells->setFont(array('bold'=>true));});
                $sheet->cells('A4:B4', function($cells)
                    {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));}); 
                $sheet->cells('L4:N4', function($cells)
                    {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));}); 
                $sheet->cells('W4:X4', function($cells)
                    {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));});
                
                $sheet->cells('A6:AA6', function($cells)                              
                    {$cells->setBackground('#4F81BD');$cells->setFont(array('bold'=>true));$cells->setFontColor('#ffffff');});
                $sheet->cells('A7:B8', function($cells)
                    {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));$cells->setValignment('center');});
                $sheet->cells('C7:AA7', function($cells)
                    {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));});
                $sheet->cells('C8:AA8', function($cells)
                    {$cells->setAlignment('center'); });
                
                $sheet->cells('A10:AA10', function($cells)
                    {$cells->setBackground('#4F81BD');$cells->setFontColor('#ffffff');$cells->setFont(array('bold'=>true)); });
                $sheet->cells('A11:AA12', function($cells)
                    {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));$cells->setValignment('center');});
                $sheet->cells('G11:K12', function($cells){$cells->setAlignment('center');});
                $sheet->cells('O11:AA12', function($cells){$cells->setAlignment('center');});
                
                //-------------------------------------IMPRIMIR CELDAS--------------------------------------
                $data=[];
                array_push($data, array('MATRIZ DE CONSISTENCIA TÉCNICA DEL PLAN OPERATIVO INSTITUCIONAL','','','','','','','','','','','','','','','','','','','','','','','','','',''));
                array_push($data, array('','','','','','','','','','','','','','','','','','','','','','','','','','',''));
                
                array_push($data, array('1. INFORMACIÓN GENERAL','','','','','','','','','','','','','','','','','','','','','','','','','',''));
                array_push($data, array('1.1. Unidad Ejecutora','',$actividades->unieje,'',strtoupper($actividades->nomunieje),'','','','','','','1.2. Centro de Costo','','',strtoupper($actividades->nomofi),'','','','','','','','1.3. Año','',$actividades->anio,'',''));
                array_push($data, array('','','','','','','','','','','','','','','','','','','','','','','','','','',''));
                
                array_push($data, array('2. ARTICULACIÓN PRESUPUESTARIA','','','','','','','','','','','','','','','','','','','','','','','','','',''));
                array_push($data, array('2.1. Estructura Funcional Programática','','2.1.1. Función','','2.1.2. División Funcional','','','','2.1.3. Grupo Funcional','','','','2.1.4. Categoría Presupuestal','','','2.1.5. Producto/Proyecto','','','2.1.6. Actividad/Acción/Obra','','','2.1.7. Finalidad','','','2.1.8. Meta Presupuetaria','',''));                
                array_push($data, array('','',$actividades->funcion,'',$actividades->division,'','','',$actividades->grupo,'','','',$actividades->categoria,'','',$actividades->producto,'','',$actividades->actividad,'','',$actividades->finalidad,'','',$actividades->siaf,'',''));
                array_push($data, array('','','','','','','','','','','','','','','','','','','','','','','','','','',''));
                
                array_push($data, array('3. PROGRAMACIÓN DE ESPECÍFICAS DE GASTOS','','','','','','','','','','','','','','','','','','','','','','','','','',''));
                array_push($data, array('CENTRO DE COSTO','ACTIVIDAD / ACCIÓN DE INVERSIÓN','INDICADOR','UNIDAD DE MEDIDA','META ANUAL','F.F.','CLASIFICADOR','','','','','DESCRIPCIÓN','UNIDAD DE MEDIDA','CANTIDAD','PROGRAMACIÓN MENSUAL','','','','','','','','','','','','TOTAL'));
                array_push($data, array('','','','','','','GG','Sub G1','Sub G2','Esp 1','Esp 2','','','','ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SET','OCT','NOV','DIC',''));
                
                $i=0;
                $a=13;
                $c=13;
                                
                if($inversionrows!=0){                    
                    foreach($inversiones AS $inversion){                            
                        $b = $a + $inversion->con_ins_tar - 1;
                        if($insumorows!=0){
                            //-------------------------CONBINAR CELDAS-------------------------------------
                            $sheet->mergeCells('A'.$a.':A'.$b);
                            $sheet->cells('A'.$a.':A'.$b, function($cells){$cells->setValignment('center');});
                            $sheet->mergeCells('B'.$a.':B'.$b);
                            $sheet->cells('B'.$a.':B'.$b, function($cells){$cells->setValignment('center');});
                            $sheet->mergeCells('C'.$a.':C'.$b);
                            $sheet->cells('C'.$a.':C'.$b, function($cells){$cells->setValignment('center');});
                            $sheet->mergeCells('D'.$a.':D'.$b);
                            $sheet->cells('D'.$a.':D'.$b, function($cells){$cells->setValignment('center');});
                            $sheet->mergeCells('E'.$a.':E'.$b);
                            $sheet->cells('E'.$a.':E'.$b, function($cells){$cells->setValignment('center');});
                            
                            $p = $a + $inversion->con_ins_tar; //16
                            $sheet->mergeCells('A'.$p.':L'.$p);
                            $sheet->cells('A'.$p.':L'.$p, function($cells){$cells->setAlignment('center');});
                            
                            //--------------------------PINTAR CELDAS----------------------------------------
                            $sheet->cells('A'.$p.':AA'.$p, function($cells){$cells->setBackground('#C4D79B'); $cells->setFont(array('bold'=>true));
                            });
                            
                            $sheet->cells('F'.$c.':K'.$b, function($cells){$cells->setAlignment('center');});
                            
                            foreach($insumos AS $insumo){                                 
                                
                                $str = $insumo->clasificador->cg_clasificador;
                                $separar = str_replace(" ", ".",$str);
                                $clasificador = explode(".",$separar);
                                
                                if($inversion->id == $insumo->idact){
                                    
                                    if($i==0){
                                        array_push($data, array($actividades->nomofi,$inversion->denominacion,$inversion->indicador,$inversion->um,$inversion->total,$insumo->fuente,$clasificador[0].'.'.$clasificador[1],$clasificador[2],$clasificador[3],$clasificador[4],$clasificador[5],$insumo->clasificador->cg_descripcion,$insumo->um,$insumo->cantidad,$insumo->enero,$insumo->febrero,$insumo->marzo,$insumo->abril,$insumo->mayo,$insumo->junio,$insumo->julio,$insumo->agosto,$insumo->setiembre,$insumo->octubre,$insumo->noviembre,$insumo->diciembre,$insumo->monto));
                                        $i++;
                                    }
                                    else{
                                        array_push($data, array('','','','','',$insumo->fuente,$clasificador[0].'.'.$clasificador[1],$clasificador[2],$clasificador[3],$clasificador[4],$clasificador[5],$insumo->clasificador->cg_descripcion,$insumo->um,$insumo->cantidad,$insumo->enero,$insumo->febrero,$insumo->marzo,$insumo->abril,$insumo->mayo,$insumo->junio,$insumo->julio,$insumo->agosto,$insumo->setiembre,$insumo->octubre,$insumo->noviembre,$insumo->diciembre,$insumo->monto));
                                    }                                    
                                }
                            }
                            
                            $l = $a + $inversion->con_ins_tar; //16
                            
                            array_push($data, array('SUB TOTAL','','','','','','','','','','','','-',$inversion->esp_cantidad,$inversion->esp_enero,$inversion->esp_febrero,$inversion->esp_marzo,$inversion->esp_abril,$inversion->esp_mayo,$inversion->esp_junio,$inversion->esp_julio,$inversion->esp_agosto,$inversion->esp_setiembre,$inversion->esp_octubre,$inversion->esp_noviembre,$inversion->esp_diciembre,$inversion->esp_monto_total));
                            
                            $a = $a + $inversion->con_ins_tar + 1; //17
                        }
                        $i=0;
                    }
                    
                    //--------------------------BORDES DE CELDAS-------------------------------------
                    $sheet->setBorder('A'.$c.':AA'.($a-1), 'thin');                    
                }
                
                if($insumorows!=0){
                    
                    $a = $p + 1;
                    $b = $p + 1;
                    $sheet->mergeCells('A'.$a.':AA'.$b);
                    array_push($data,   array('','','','','','','','','','','','','','','','','','','','','','','','','','',''));            
                    
                    //------------------------------------------TOTAL-------------------------------------
                    $a = $a + 1;
                    $b = $b + 1;
                    $sheet->mergeCells('A'.$a.':N'.$b);
                    $sheet->setBorder('A'.$a.':AA'.$b, 'thin'); 
                    $sheet->cells('A'.$a.':AA'.$b, function($cells)
                        {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));});
                    
                    $sheet->cells('A'.$a.':N'.$b, function($cells)
                        {$cells->setAlignment('center');});
                    $sheet->cells('O'.$c.':AA'.$b, function($cells)
                        {$cells->setAlignment('right');});
                    
                    array_push($data,   array('TOTAL ACTIVIDAD OPERATIVA  / ACCIÓN DE INVERSIÓN','','','','','','','','','','','','','',$totalins->total_enero,$totalins->total_febrero,$totalins->total_marzo,$totalins->total_abril,$totalins->total_mayo,$totalins->total_junio,$totalins->total_julio,$totalins->total_agosto,$totalins->total_setiembre,$totalins->total_octubre,$totalins->total_noviembre,$totalins->total_diciembre,$totalins->total_monto)); 
                    //------------------------------------------TOTAL-------------------------------------
                    
                    $a = $a + 1;
                    $b = $b + 1;
                    $sheet->mergeCells('A'.$a.':AA'.$b);
                    array_push($data,   array('','','','','','','','','','','','','','','','','','','','','','','','','','','')); 
                    
                    //------------------------------------------TOTAL2-------------------------------------
                    $a = $a + 1;
                    $b = $b + 1;
                    $sheet->mergeCells('A'.$a.':AA'.$b);
                    $sheet->cells('A'.$a.':AA'.$b, function($cells)
                    {$cells->setBackground('#4F81BD');$cells->setFontColor('#ffffff');$cells->setFont(array('bold'=>true));});
                    $sheet->setBorder('A'.$a.':AA'.$b, 'thin'); 
                    
                    array_push($data,   array('4. RESUMEN POR FUENTE DE FINANCIAMIENTO','','','','','','','','','','','','','','','','','','','','','','','','','','')); 
                    
                    $a = $a + 1;
                    $b = $b + 1;
                    
                    $sheet->mergeCells('A'.$a.':E'.($b+1));$sheet->mergeCells('F'.$a.':F'.($b+1));$sheet->mergeCells('G'.$a.':K'.$b);$sheet->mergeCells('L'.$a.':L'.($b+1));$sheet->mergeCells('M'.$a.':M'.($b+1));$sheet->mergeCells('N'.$a.':N'.($b+1));$sheet->mergeCells('O'.$a.':Z'.$b);$sheet->mergeCells('AA'.$a.':AA'.($b+1));
                    
                    $sheet->cells('A'.$a.':AA'.($b+1), function($cells)
                    {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));$cells->setValignment('center');});
                    $sheet->cells('G'.$a.':K'.($b+1), function($cells){$cells->setAlignment('center');});
                    $sheet->cells('O'.$a.':AA'.($b+1), function($cells){$cells->setAlignment('center');});
                    
                    $sheet->setBorder('A'.$a.':AA'.($b+1), 'thin'); 
                    
                    array_push($data, array('CENTRO DE COSTO','','','','','F.F.','CLASIFICADOR','','','','','DESCRIPCIÓN','UNIDAD DE MEDIDA','CANTIDAD','PROGRAMACIÓN MENSUAL','','','','','','','','','','','','TOTAL'));
                    array_push($data, array('','','','','','','GG','Sub G1','Sub G2','Esp 1','Esp 2','','','','ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SET','OCT','NOV','DIC',''));
                    
                    $a = $a + 2;
                    $b = $b + 2;
                    $n = $a;
                    $r=$actinsrows;
                    $t=0;
                    $sheet->mergeCells('A'.$a.':E'.($b+$r-1));  
                    $sheet->cells('A'.$a.':E'.($b+$r-1), function($cells)
                        {$cells->setValignment('center');});
                    
                    foreach($actinsumos AS $actinsumo){
                        $str = $actinsumo->clasificador->cg_clasificador;
                        $separar = str_replace(" ", ".",$str);
                        $clasificador = explode(".",$separar);
                        
                        $sheet->setBorder('A'.$a.':AA'.$b, 'thin'); 
                        
                        if($t == 0){
                            array_push($data, array($actividades->nomofi,'','','','',$actinsumo->act_fuente,$clasificador[0].'.'.$clasificador[1],$clasificador[2],$clasificador[3],$clasificador[4],$clasificador[5],$actinsumo->clasificador->cg_descripcion,$actinsumo->act_um,$actinsumo->act_cantidad,$actinsumo->act_enero,$actinsumo->act_febrero,$actinsumo->act_marzo,$actinsumo->act_abril,$actinsumo->act_mayo,$actinsumo->act_junio,$actinsumo->act_julio,$actinsumo->act_agosto,$actinsumo->act_setiembre,$actinsumo->act_octubre,$actinsumo->act_noviembre,$actinsumo->act_diciembre,$actinsumo->act_monto));
                            $t++;
                        }
                        else{
                            array_push($data, array('','','','','',$actinsumo->act_fuente,$clasificador[0].'.'.$clasificador[1],$clasificador[2],$clasificador[3],$clasificador[4],$clasificador[5],$actinsumo->clasificador->cg_descripcion,$actinsumo->act_um,$actinsumo->act_cantidad,$actinsumo->act_enero,$actinsumo->act_febrero,$actinsumo->act_marzo,$actinsumo->act_abril,$actinsumo->act_mayo,$actinsumo->act_junio,$actinsumo->act_julio,$actinsumo->act_agosto,$actinsumo->act_setiembre,$actinsumo->act_octubre,$actinsumo->act_noviembre,$actinsumo->act_diciembre,$actinsumo->act_monto));
                        }
                        $a++;
                        $b++;
                    }
                    
                    $sheet->cells('F'.$n.':K'.($b-1), function($cells)
                        {$cells->setAlignment('center');});
                    $sheet->cells('N'.$n.':AA'.($b-1), function($cells)
                        {$cells->setAlignment('right');});
                           
                    //..........................................................................
                    $sheet->mergeCells('A'.$a.':N'.$b);
                    $sheet->setBorder('A'.$a.':AA'.$b, 'thin'); 
                    $sheet->cells('A'.$a.':AA'.$b, function($cells)
                        {$cells->setBackground('#D2E3F8');$cells->setFont(array('bold'=>true));});
                    
                    $sheet->cells('A'.$a.':N'.$b, function($cells)
                        {$cells->setAlignment('center');});
                    $sheet->cells('O'.$a.':AA'.$b, function($cells)
                        {$cells->setAlignment('right');});
                    
                    array_push($data,   array('TOTAL ACTIVIDAD OPERATIVA  / ACCIÓN DE INVERSIÓN','','','','','','','','','','','','','',$totalins->total_enero,$totalins->total_febrero,$totalins->total_marzo,$totalins->total_abril,$totalins->total_mayo,$totalins->total_junio,$totalins->total_julio,$totalins->total_agosto,$totalins->total_setiembre,$totalins->total_octubre,$totalins->total_noviembre,$totalins->total_diciembre,$totalins->total_monto)); 
                    //------------------------------------------TOTAL2-------------------------------------
                }
            //--------------------------------------------------------------------------------------------
                $sheet->fromArray($data, null, 'A1', false, false);                
            });
        })->download('xls');    
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
