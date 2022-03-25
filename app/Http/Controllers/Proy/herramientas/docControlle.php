<?php

namespace App\Http\Controllers\Proy\herramientas;

use App\_clases\proyectos\tools\documento\AsuntoDoc;
use App\_clases\proyectos\tools\documento\Documento;
use App\_clases\proyectos\plan\Componente;
use App\_clases\siaf\reportes\Presupuesto;
use App\_clases\siaf\reportes\Certificado;
use App\_clases\siaf\reportes\Compromiso;
use App\_clases\siaf\FuenteFinanciamiento;
use App\_clases\siaf\SiafMeta;
use App\_clases\proyectos\ProyectosPDFF;
use Illuminate\Http\Request;
use Fpdf;
use Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use Carbon\Carbon;

class docControlle extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('proyectos.herramientas.documentos.listardoc', ['anio'=>$request->an]);
    }

	public function nuevoDoc($anio, Request $request)
    {
		if($request->id){
			$doc = Documento::find($request->id);
			$as = AsuntoDoc::find($doc->td_asunto);

			return view('proyectos.herramientas.documentos.index', ['anio'=>$anio,'documento'=>$doc,'asunto'=>AsuntoDoc::orderBy('tda_nombre', 'ASC')->get(), 'asu' => $as]);
		}else{
			return view('proyectos.herramientas.documentos.index', ['anio'=>$anio,'asunto'=>AsuntoDoc::orderBy('tda_nombre', 'ASC')->get()]);
		}
    }

    public function nuevoContrato($anio, Request $request)
    {
        return view('proyectos.herramientas.documentos.nuevoContratoForm',['anio'=>$anio]);
    }
    public function ReporteSisgedo(Request $request)
    {
        return view('proyectos.herramientas.documentos.reporte_sisgedo');
    }
    public function Reporte(Request $request)
    {
        if($request->listar){
        $cadenas1=\DB::table('tools_document')
        ->select([
            'tools_document.id',
            'tools_document.td_expeSISGEDO',
            'tools_document.td_contenido',
            'tools_document.td_fecha'])
        ->where('tools_document.td_asunto','=',$request->tipo)
        ->where('tools_document.td_asunto','!=','9');

        $ret = Datatables::of($cadenas1)
                ->editColumn('td_expeSISGEDO', function ($cadena) {
                    return sprintf('<strong>%s</strong>',
                        $cadena->td_expeSISGEDO);
                })
                ->addColumn('proyecto', function ($cadena) {
                    return sprintf('%s - %s',
                        isset(json_decode($cadena->td_contenido)->doc_idobra)?json_decode($cadena->td_contenido)->doc_idobra:'',
                        isset(json_decode($cadena->td_contenido)->doc_obra)?json_decode($cadena->td_contenido)->doc_obra:'');
                })
                ->addColumn('meta', function ($cadena) {
                    return sprintf('%s',isset(json_decode($cadena->td_contenido)->doc_meta)?json_decode($cadena->td_contenido)->doc_meta:'');
                })
                ->addColumn('especifica', function ($cadena) {
                    return sprintf('%s',isset(json_decode($cadena->td_contenido)->doc_especifica)?json_decode($cadena->td_contenido)->doc_especifica:'');
                })
                ->editColumn('td_fecha', function ($cadena) {
                    return sprintf('%s',$cadena->td_fecha);
                })
                ->addColumn('monto', function ($cadena) {
                    return sprintf('%s',isset(json_decode($cadena->td_contenido)->doc_monto)?\Money::toMoney(json_decode($cadena->td_contenido)->doc_monto):'');
                })
                ->removeColumn('id')
                ->removeColumn('td_contenido')
                ->make(true);
                //dd($ret);
                return $ret;
        }
        else
        {
            return view('proyectos.herramientas.documentos.reporte', ['asunto'=>AsuntoDoc::all()]);
        }
    }
    public function PrintReporte(Request $request){
        setlocale(LC_TIME, 'ES_PE');
        setlocale(LC_TIME, 'es_PE.UTF-8');
        $headers = ['Content-Type' => 'application/pdf'];

        $doc = Documento::where('td_asunto','=','14')
                        //->whereBetween('td_fecha', [$request->rep_fechainicio, $request->rep_fechafin])
                        ->get();

        $pdf = new ProyectosPDFF();
        //margenes

        $pdf->SetMargins((2*$pdf->cm),(2*$pdf->cm),(2.5*$pdf->cm));
        $pdf->SetAutoPageBreak(true,(2.5*$pdf->cm));
        //agregamos una pagina
        $pdf->AddPage('L');
        //fuente inicial
        //dd($pdf->GetY().'-'.$pdf->GetX());
        $l = $pdf->GetPageWidth()-5*$pdf->cm;
        $pdf->SetY(2*$pdf->cm);
        $pdf->SetFont('Arial','B',10);
        $pdf->Write(6,utf8_decode('REPORTE DE DOCUMENTOS'));
        $pdf->Ln();
        $pdf->SetWidths(array(0.08*$l,0.5*$l,0.1*$l,0.1*$l,0.1*$l,0.12*$l));
        $pdf->Row(array('EXPE','PROYECTO', 'META', 'ESPECIFICA', 'FECHA', 'MONTO'));
        $total = 0;
        $pdf->SetFont('Arial','',10);
        foreach ($doc as $key => $value) {
                            $pdf->Row(array(
                                $value->td_expeSISGEDO,
                                isset(json_decode($value->td_contenido)->doc_idobra)?json_decode($value->td_contenido)->doc_idobra:''.'-'.isset(json_decode($value->td_contenido)->doc_obra)?html_entity_decode(json_decode($value->td_contenido)->doc_obra):'',
                                isset(json_decode($value->td_contenido)->doc_meta)?explode('-', json_decode($value->td_contenido)->doc_meta)[0]:'',
                                isset(json_decode($value->td_contenido)->doc_especifica)?json_decode($value->td_contenido)->doc_especifica:'',
                                $value->td_fecha,
                                isset(json_decode($value->td_contenido)->doc_monto)?\Money::toMoney(json_decode($value->td_contenido)->doc_monto):''
                                ));
             isset(json_decode($value->td_contenido)->doc_monto)?$total += json_decode($value->td_contenido)->doc_monto:$total+=0;
        }
        //$pdf->Ln();
        $pdf->SetFont('Arial','B',10);
        $pdf->SetWidths(array(0.88*$l,0.12*$l));
        $pdf->Row(array('TOTAL', \Money::toMoney($total)));
        return Response::make($pdf->Output(),200,$headers);

    }
	public function listaDoc(Request $request)
    {
		if($request->listar){
		$cadenas1=\DB::table('tools_document')
		->select([
			'tools_document.id',
			'tools_document.td_expeSISGEDO',
			'tools_document.td_contenido',
            'tools_document.td_asunto_txt',
            'tools_document.td_fecha'])
		->leftJoin('tools_doc_asunto', 'tools_doc_asunto.id', '=', 'tools_document.td_asunto')
        ->where('tools_document.td_asunto','!=','9')
        ->whereBetween('tools_document.td_fecha',[$request->anio.'-01-01', $request->anio.'-12-31']);
		//dd($request->anio);
		return Datatables::of($cadenas1)
                ->editColumn('td_expeSISGEDO', function ($cadena) {
                    return sprintf('<strong>%s</strong>',
                        $cadena->td_expeSISGEDO);
                })
                ->editColumn('td_asunto_txt', function ($cadena) {
					if(isset(json_decode($cadena->td_contenido)->doc_meta)){
						return sprintf('<b>%s - %s</b><br><b>Meta: </b>%s<br><b>FF: </b>%s<br><b>Esp: </b>%s',json_decode($cadena->td_contenido)->doc_idobra, $cadena->td_asunto_txt, json_decode($cadena->td_contenido)->doc_meta, json_decode($cadena->td_contenido)->doc_ff, json_decode($cadena->td_contenido)->doc_especifica);
					}else{
						return sprintf('<b>%s - %s</b>',isset(json_decode($cadena->td_contenido)->doc_idobra)?json_decode($cadena->td_contenido)->doc_idobra:"", $cadena->td_asunto_txt);
					}

                })
                ->addColumn('action', function ($cadena) {
                    return sprintf('
					<a href="#" class="print" data-data="%s"><i class="glyphicon glyphicon-print"></i> Imprimir</a><br>
					<a href="#" class="edit" data-data="%s"><i class="glyphicon glyphicon-edit"></i> Editar</a><br>
					<a href="#" class="delete" data-data="%s"><i class="glyphicon glyphicon-trash"></i> Eliminar</a><br>',
					$cadena->id,$cadena->id,$cadena->id);
                })
				->removeColumn('id')
				->removeColumn('td_contenido')
                ->make(true);
		}
		else
        {
			return view('proyectos.herramientas.documentos.listardoc', ['anio'=>$request->anio]);
        }
    }
    public function listaCnt(Request $request)
    {
		if($request->listar){
		$cadenas1=\DB::table('tools_document')
		->select([
			'tools_document.id',
			'tools_document.td_expeSISGEDO',
			'tools_document.td_contenido',
            'tools_document.td_asunto_txt',
            'tools_document.updated_at'])
		->leftJoin('tools_doc_asunto', 'tools_doc_asunto.id', '=', 'tools_document.td_asunto')
		->where('tools_document.td_asunto','=','9');
		$ret = Datatables::of($cadenas1)
                ->editColumn('td_expeSISGEDO', function ($cadena) {
                    return sprintf('<strong>%s</strong>',
                        $cadena->td_expeSISGEDO);
                })
                ->editColumn('td_asunto_txt', function ($cadena) {
					if(isset(json_decode($cadena->td_contenido)->cnt_meta)){
						return sprintf('<b>%s - %s</b><br><b>%s</b>',
							json_decode($cadena->td_contenido)->cnt_idobra, $cadena->td_asunto_txt,
							json_decode($cadena->td_contenido)->cnt_nombre);

					}else{
						return sprintf('<b>%s - %s</b>',json_decode($cadena->td_contenido)->cnt_idobra, $cadena->td_asunto_txt);
					}

                })
                ->addColumn('action', function ($cadena) {
                    return sprintf('
					<a href="#" class="print" data-data="%s"><i class="glyphicon glyphicon-print"></i> Imprimir</a><br><a href="#" class="edit" data-data="%s"><i class="glyphicon glyphicon-edit"></i> Editar</a><br><a href="#" class="delete" data-data="%s"><i class="glyphicon glyphicon-trash"></i> Eliminar</a><br>',
					$cadena->id,$cadena->id,$cadena->id);
                })
				->removeColumn('id')
				->removeColumn('td_contenido')
                ->make(true);
                //dd($ret);
                return $ret;
		}
		else
        {
			return view('proyectos.herramientas.documentos.listarcnt');
        }
    }

	public function listar(Request $request)
    {
		$ruta = AsuntoDoc::find($request->asunto);
		return view($ruta->tda_ruta_form,  ['dest'=>$ruta->tda_destino]);
    }
	/*public function printer(Request $request)
    {
		$doc = Documento::find($request->id);
		$asunto = AsuntoDoc::find($doc->td_asunto);
		if(isset(json_decode($doc->td_contenido)->doc_ff)){
			return view('proyectos.herramientas.documentos.print',
		['ff'=>FuenteFinanciamiento::getFuenteFinanciamiento('2017',json_decode($doc->td_contenido)->doc_ff), 'documento' => $doc, 'asunto' => $asunto]);
		}else{
			return view('proyectos.herramientas.documentos.print',
		['documento' => $doc, 'asunto' => $asunto]);
		}

    }*/
    public function printer(Request $request)
    {

        setlocale(LC_TIME, 'ES_PE');
        setlocale(LC_TIME, 'es_PE.UTF-8');
        $headers = ['Content-Type' => 'application/pdf'];


        $doc = Documento::find($request->id);
        $asunto = AsuntoDoc::find($doc->td_asunto);
        $contenido = json_decode($doc->td_contenido);
        $destino = json_decode($asunto->tda_destino);
        $tmpf = explode("-",$doc->td_fecha);
        $fecha = Carbon::create((int)$tmpf[0],(int)$tmpf[1],(int)$tmpf[2]);
        $ccs = json_decode($doc->td_cc);

        if(isset(json_decode($doc->td_contenido)->doc_ff)){
            $ff=FuenteFinanciamiento::getFuenteFinanciamiento('2017',json_decode($doc->td_contenido)->doc_ff);
        }
        $cont = [
                "("                     =>'',
                ")"                     =>'.-',
                "\t"                    =>'',
                "<div>"                 =>'',
                "</div>"                =>'',
                "<proced></proced>"     =>isset($contenido->doc_proced)?\Cadena::firstuppchar(strtolower(utf8_decode($contenido->doc_proced))):'',
                "<obra></obra>"         =>isset($contenido->doc_obra)?$contenido->doc_obra:'',
                "<afd></afd>"           =>isset($contenido->doc_afd)?$contenido->doc_afd:'',
                "<cp></cp>"             =>isset($contenido->doc_cp)?$contenido->doc_cp:'',
                "<metas></metas>"       =>isset($contenido->doc_meta)?$contenido->doc_meta:'',
                "<ff></ff>"             =>isset($ff)?$ff:'',
                "<cfp></cfp>"           =>isset($contenido->doc_cfp)?$contenido->doc_cfp:'',
                "<esp></esp>"           =>isset($contenido->doc_especifica)?$contenido->doc_especifica:'',
                "<pedido></pedido>"     =>isset($contenido->doc_nro_pedido)?$contenido->doc_nro_pedido:'',
                "<monto></monto>"       =>isset($contenido->doc_monto)?\Money::toMoney($contenido->doc_monto):'',
                "<val></val>"           =>isset($contenido->doc_val)?$contenido->doc_val:'',
                "<txt></txt>"           =>isset($contenido->doc_txt)?$contenido->doc_txt:'',
                "<contrato></contrato>"       =>isset($contenido->doc_contrato)?$contenido->doc_contrato:'',
                "<nrocontrato></nrocontrato>" =>isset($contenido->doc_nro_contrato)?$contenido->doc_nro_contrato:'',
                ];
        $referencia = explode("\n", \Cadena::ReplaceCadena($cont,$doc->td_referencia));
        foreach ($referencia as $key => $value) {
            if ($value == "") {
                unset($referencia[$key]);
            }
        }
        $plantilla = html_entity_decode(\Cadena::ReplaceCadena($cont,$asunto->td_contenido));



        $pdf = new ProyectosPDFF();
        //margenes

        $pdf->SetMargins((4*$pdf->cm),(4*$pdf->cm),(2.5*$pdf->cm));
        $pdf->SetAutoPageBreak(true,(2.5*$pdf->cm));
        $pdf->setHeader('img/head_doc.jpg',$doc->td_expeSISGEDO);
        $pdf->setFooter('img/footer_doc.JPG');
        //agregamos una pagina
        $pdf->AddPage();
        //fuente inicial
        //dd($pdf->GetY().'-'.$pdf->GetX());
        $pdf->SetY(4*$pdf->cm);
        $pdf->SetFont('Arial','B',10);
        $pdf->Write(6,utf8_decode('MEMORANDUM Nº ________'.$fecha->formatLocalized("%Y").'-GRH-GRI'));

        $pdf->SetFont('Arial','B',10);
        $pdf->Ln(10);
        $pdf->Cell(40,6,utf8_decode('A:'));
        $pdf->Cell(0,6,utf8_decode($destino->dest_nombre));
        $pdf->Ln();
        $pdf->Cell(40);
        $pdf->Cell(0,6,utf8_decode($destino->dest_oficina));
        $pdf->Ln(10);
        $pdf->Cell(40,6,utf8_decode('ASUNTO:'));
        $pdf->MultiCell(0,6,utf8_decode($doc->td_asunto_txt));
        if (count($referencia) == 1) {
            $pdf->Ln(10);
            $pdf->Cell(40,6,utf8_decode('REFERENCIA:'));

            $pdf->Cell(0,6,utf8_decode($referencia[0]));
        }elseif (count($referencia) > 1) {
            $pdf->SetFont('Arial','B',9);
            foreach ($referencia as $key => $value) {
                if ($key == 0) {
                    $pdf->Ln();
                    $pdf->Cell(40,6,utf8_decode('REFERENCIA:'));
                    $pdf->MultiCell(0,6,utf8_decode($referencia[$key]));
                }else{
                    $pdf->Cell(40);
                    $pdf->MultiCell(0,6,utf8_decode($referencia[$key]));
                }
            }
        }
        $pdf->SetFont('Arial','B',10);
        $pdf->Ln();
        $pdf->Cell(40,6,utf8_decode('FECHA:'));
        $pdf->Cell(0,6,utf8_decode('HUANUCO, '.$fecha->formatLocalized("%d %B del %Y")));

        $pdf->SetStyle("p","arial","N",10,"0,0,0",10,11);
        $pdf->SetStyle("li","arial","N",10,"0,0,0",10,11);
        $pdf->SetStyle("b","arial","B",10,"0,0,0");
        $texto = utf8_decode($plantilla);
        $pdf->Ln(10);
        $pdf->WriteTagIdent(0,5,$texto,0,"J",0,0);
        $pdf->Ln(10);
        $pdf->Image('img/selloGerente.PNG',5*$pdf->cm,null,-200);
        $pdf->SetY(-40);
        $pdf->SetFont('Arial','',6);
        $pdf->Write(5,utf8_decode('CC:'));
        //$pdf->Ln();
        foreach ($ccs as $key => $cc) {
            $pdf->Write(5,utf8_decode(strtoupper($cc)));
            $pdf->Ln();
        }
        $pdf->Write(5,utf8_decode('ARCHIVO'));
        $pdf->Ln();


        return Response::make($pdf->Output(),200,$headers);
    }
    public function printerContrato(Request $request)
    {
    	setlocale(LC_TIME, 'Spanish');
		$doc = Documento::find($request->id);
		$asunto = AsuntoDoc::find($doc->td_asunto);
		$contenido = json_decode($doc->td_contenido);
                $plantilla = $asunto->td_contenido;
		$ff = FuenteFinanciamiento::getFuenteFinanciamiento('2017',json_decode($doc->td_contenido)->cnt_ff);
		$referencia = explode(",", $doc->td_referencia);
		$tmpini = explode("-",$contenido->cnt_finicio);
		$tmpfin = explode("-",$contenido->cnt_ffin);
		$fini = Carbon::create((int)$tmpini[0],(int)$tmpini[1],(int)$tmpini[2]);
		$ffin = Carbon::create((int)$tmpfin[0],(int)$tmpfin[1],(int)$tmpfin[2]);
        $h1 = array();
        $h2txt = "";
        $ptxt = "";
        $ntxt = "";
        $h2 = array();
        $p = array();
        $b = array();
        $cont = [
                "__cntnombre__"     =>$contenido->cnt_nombre,
                "__cntdni__"        =>$contenido->cnt_dni,
                "__cntdireccion__"    =>$contenido->cnt_direccion,
                "__cntcargo__"      =>$doc->td_asunto_txt,
                "__cntoficina__"    =>$contenido->cnt_proced,
                "__cntinforme1__"   =>$referencia[0],
                "__cntinforme2__"   =>$referencia[1],
                "__cntinforme3__"   =>$referencia[2],
                "__cntinforme4__"   =>$referencia[3],
                "__cntcfp__"        =>$contenido->cnt_cfp,
                "__cntespecifica__" =>$contenido->cnt_especifica,
                "__cntobranombre__"   =>$contenido->cnt_obra,
                "__cntff__"         =>$ff,
                "__cntmonto__"      =>\Money::NumeroALetras($contenido->cnt_monto).' ('.\Money::toMoney($contenido->cnt_monto).')',
                "__cntvigenciainicio__"=>$fini->formatLocalized("%A %d %B del %Y"),
                " __cntvigenciafin__"=>$ffin->formatLocalized("%A %d %B del %Y"),
                "<li>"=>"<li>» "];

        $plantilla = \Cadena::ReplaceCadena($cont,$asunto->td_contenido);

        foreach (explode("</h1>",$plantilla) as $key => $value) {
            $temp = explode("<h2>", $value);
            if (count($temp) == 1) {
                $h1[$key] = $value.'</h1>';
            }else{
                $h2txt .= $value;
            }
        }
        foreach (explode("<h2>",$h2txt) as $key => $value) {
            $temp = explode("<p>", $value);
            if (count($temp) == 1) {
                $h2[$key] = $value;
            }else{
                $ptxt .= $value;
            }
        }
        foreach (explode("<p>",$ptxt) as $key => $value) {
            if ($value != "") {
                $p["p".$key] = $value;
            }

        }
        foreach ($p as $key => $value) {
            $tmp = explode("<b>", $value);
            foreach ($tmp as $k => $v) {
                if ($k%2==0) {
                    $b[$key.'n'.$k] = $v;
                }else{
                    $b[$key.'b'.$k] = $v;
                }
            }

        }

		$headers = ['Content-Type' => 'application/pdf'];
		$pdf = new ProyectosPDFF();
        $pdf->setHeader('img/head_cnt.JPG');
		$ancho = $pdf->GetPageWidth()-20;
		$cm = 9.05;
		$pdf->AliasNbPages();
        $pdf->SetMargins((4*$cm),(4*$cm),(2.5*$cm));
        $pdf->SetAutoPageBreak(true,(2.5*$cm));
        $pdf->AddPage();

        $pdf->SetFont('Arial','',12);

        $pdf->SetStyle("p","arial","N",11,"0,0,0",0);
        $pdf->SetStyle("h1","arial","BI",14,"0,0,0",0);
        $pdf->SetStyle("h2","arial","BI",12,"0,0,0",0);
        $pdf->SetStyle("b","arial","B",11,"0,0,0");
        $pdf->SetStyle("li","arial","N",11,"0,0,0",10);
        $pdf->SetStyle("ul","arial","B",11,"0,0,0");


        $pdf->WriteTag(0,5,utf8_decode($h1[0]),0,"C",0,0);
        $pdf->Ln(5);
        $pdf->WriteTag(0,5,utf8_decode($h1[1]),0,"C",0,0);
        $pdf->Ln(5);
        $pdf->WriteTag(0,5,utf8_decode($h2txt),0,"J",0,0);

        $pdf->Ln(5);

        return Response::make($pdf->Output(),200,$headers);
    }

	public function getDoc(Request $request)
    {
		$doc = Documento::find($request->id);
		return json_encode($doc);
    }

	public function getAsunto(Request $request)
    {
		$doc = Documento::find($request->id);
		$asunto = AsuntoDoc::find($doc->td_asunto);
		return json_encode($asunto);
    }

	public function guardarDoc(Request $request)
    {
        $meta=explode('-', $request->doc_meta)[0];
        $cfp = SiafMeta::getCF($meta, '2017', config('proyectos.unidad_ejecutora'));
		if($request->id_doc){
			$doc = Documento::find($request->id_doc);
		}else{
			$doc = new Documento();
		}
		$array = $request->doc_especifica;
		if (count($array) > 1) {
			unset($array[count($array)-1]);
			$array = implode(', ', $array);
			$request->doc_especifica = implode(' y ', [$array, $request->doc_especifica[count($request->doc_especifica)-1] ]);
		} else{
			$request->doc_especifica = isset($request->doc_especifica)?implode('',$request->doc_especifica):'';
		}



		if($request->doc_asunto == 1 || $request->doc_asunto == 6 || $request->doc_asunto == 16 || $request->doc_asunto == 15){
			$doc->td_asunto 		= $request->doc_asunto;
			$doc->td_asunto_txt		= $request->doc_asunto_txt;
			$doc->td_destinoN 		= $request->doc_desNombre;
			$doc->td_destinoO 		= $request->doc_desOficina;
			$doc->td_expeSISGEDO 	= $request->doc_expe_sisgedo;
			$doc->td_referencia 	= $request->doc_referencia;
			$doc->td_fecha 			= $request->doc_fecha;
			//guardamos los datos del doc en Json
			$doc_contenido = array(
				'doc_obra' => $request->doc_obra,
				'doc_idobra' => $request->doc_idobra,
				'doc_meta' => $request->doc_meta,
				'doc_especifica' => $request->doc_especifica,
				'doc_ff' => $request->doc_ff,
				'doc_cp' => $request->doc_cp,
				'doc_monto' => $request->doc_monto,
				'doc_nro_pedido' => $request->doc_nro_pedido,
				'doc_proced' => $request->doc_proced_nombre,
				'doc_ofi' => $request->doc_proced
			);
			$doc->td_contenido 		= json_encode($doc_contenido);
			$doc_cc = explode(',', $request->doc_cc);
			$doc->td_cc 		= json_encode($doc_cc);
		}else
		if($request->doc_asunto == 2){
			$doc->td_asunto 		= $request->doc_asunto;
			$doc->td_asunto_txt		= $request->doc_asunto_txt;
			$doc->td_destinoN 		= $request->doc_desNombre;
			$doc->td_destinoO 		= $request->doc_desOficina;
			$doc->td_expeSISGEDO 	= $request->doc_expe_sisgedo;
			$doc->td_referencia 	= $request->doc_referencia;
			$doc->td_fecha 			= $request->doc_fecha;
			//guardamos los datos del doc en Json
			$doc_contenido = array(
				'doc_obra' => $request->doc_obra,
				'doc_idobra' => $request->doc_idobra,
				'doc_meta' => $request->doc_meta,
				'doc_especifica' => $request->doc_especifica,
				'doc_ff' => $request->doc_ff,
				'doc_proced' => $request->doc_proced_nombre,
				'doc_ofi' => $request->doc_proced
			);
			$doc->td_contenido 		= json_encode($doc_contenido);
			$doc_cc = explode(',', $request->doc_cc);
			$doc->td_cc 		= json_encode($doc_cc);
		}else
		if($request->doc_asunto == 4){
			$doc->td_asunto 		= $request->doc_asunto;
			$doc->td_asunto_txt		= $request->doc_asunto_txt;
			$doc->td_destinoN 		= $request->doc_desNombre;
			$doc->td_destinoO 		= $request->doc_desOficina;
			$doc->td_expeSISGEDO 	= $request->doc_expe_sisgedo;
			$doc->td_referencia 	= $request->doc_referencia;
			$doc->td_fecha 			= $request->doc_fecha;
			//guardamos los datos del doc en Json
			//dd($request->doc_especifica);
			$doc_contenido = array(
				'doc_obra' => $request->doc_obra,
				'doc_idobra' => $request->doc_idobra,
				'doc_meta' => $request->doc_meta,
				'doc_especifica' => $request->doc_especifica,
				'doc_ff' => $request->doc_ff,
				'doc_cp' => $request->doc_cp,
				'doc_monto' => $request->doc_monto,
				'doc_proced' => $request->doc_proced_nombre,
				'doc_ofi' => $request->doc_proced
			);
			$doc->td_contenido 		= json_encode($doc_contenido);
			$doc_cc = explode(',', $request->doc_cc);
			$doc->td_cc 		= json_encode($doc_cc);
		}else
		if($request->doc_asunto == 5){
			$doc->td_asunto 		= $request->doc_asunto;
			$doc->td_asunto_txt		= $request->doc_asunto_txt;
			$doc->td_destinoN 		= $request->doc_desNombre;
			$doc->td_destinoO 		= $request->doc_desOficina;
			$doc->td_expeSISGEDO 	= $request->doc_expe_sisgedo;
			$doc->td_referencia 	= $request->doc_referencia;
			$doc->td_fecha 			= $request->doc_fecha;

			//guardamos los datos del doc en Json
			$doc_contenido = array(
				'doc_obra' => $request->doc_obra,
				'doc_idobra' => $request->doc_idobra,
				'doc_meta' => $request->doc_meta,
				'doc_especifica' => $request->doc_especifica,
				'doc_ff' => $request->doc_ff,
				'doc_cp' => $request->doc_cp,
				'doc_monto' => $request->doc_monto,
				'doc_afd' => $request->doc_afd,
				'doc_nro_pedido' => $request->doc_nro_pedido,
				'doc_proced' => $request->doc_proced_nombre,
				'doc_ofi' => $request->doc_proced

			);
			$doc->td_contenido 		= json_encode($doc_contenido);
			$doc_cc = explode(',', $request->doc_cc);
			$doc->td_cc 		= json_encode($doc_cc);
		}else
		if($request->doc_asunto == 7){
			$doc->td_asunto 		= $request->doc_asunto;
			$doc->td_asunto_txt		= $request->doc_asunto_txt;
			$doc->td_destinoN 		= $request->doc_desNombre;
			$doc->td_destinoO 		= $request->doc_desOficina;
			$doc->td_expeSISGEDO 	= $request->doc_expe_sisgedo;
			$doc->td_referencia 	= $request->doc_referencia;
			$doc->td_fecha 			= $request->doc_fecha;

			//guardamos los datos del doc en Json
			$doc_contenido = array(
				'doc_obra' => $request->doc_obra,
				'doc_idobra' => $request->doc_idobra,
				'doc_meta' => $request->doc_meta,
				'doc_especifica' => $request->doc_especifica,
				'doc_ff' => $request->doc_ff,
				'doc_cp' => $request->doc_cp,
				'doc_monto' => $request->doc_monto,
				'doc_nro_contrato' => $request->doc_nro_contrato,
				'doc_contrato' => $request->doc_contrato,
				'doc_val' => $request->doc_val,
				'doc_proced' => $request->doc_proced_nombre,
				'doc_ofi' => $request->doc_proced

			);
			$doc->td_contenido 		= json_encode($doc_contenido);
			$doc_cc = explode(',', $request->doc_cc);
			$doc->td_cc 		= json_encode($doc_cc);
		}else
		if($request->doc_asunto == 8){
			$doc->td_asunto 		= $request->doc_asunto;
			$doc->td_asunto_txt		= $request->doc_asunto_txt;
			$doc->td_destinoN 		= $request->doc_desNombre;
			$doc->td_destinoO 		= $request->doc_desOficina;
			$doc->td_expeSISGEDO 	= $request->doc_expe_sisgedo;
			$doc->td_referencia 	= $request->doc_referencia;
			$doc->td_fecha 			= $request->doc_fecha;

			//guardamos los datos del doc en Json
			$doc_contenido = array(
				'doc_obra' => $request->doc_obra,
				'doc_idobra' => $request->doc_idobra,
				'doc_snip' => $request->doc_snip,
				'doc_proced' => $request->doc_proced_nombre,
				'doc_ofi' => $request->doc_proced

			);
			$doc->td_contenido 		= json_encode($doc_contenido);
			$doc_cc = explode(',', $request->doc_cc);
			$doc->td_cc 		= json_encode($doc_cc);
		}else
        if($request->doc_asunto == 13){
            $doc->td_asunto         = $request->doc_asunto;
            $doc->td_asunto_txt     = $request->doc_asunto_txt;
            $doc->td_destinoN       = $request->doc_desNombre;
            $doc->td_destinoO       = $request->doc_desOficina;
            $doc->td_expeSISGEDO    = $request->doc_expe_sisgedo;
            $doc->td_referencia     = $request->doc_referencia;
            $doc->td_fecha          = $request->doc_fecha;

            //guardamos los datos del doc en Json
            $doc_contenido = array(
                'doc_proced' => $request->doc_proced_nombre,
                'doc_ofi' => $request->doc_proced

            );
            $doc->td_contenido      = json_encode($doc_contenido);
            $doc_cc = explode(',', $request->doc_cc);
            $doc->td_cc         = json_encode($doc_cc);
        }else
        if($request->doc_asunto == 14){
            $doc->td_asunto         = $request->doc_asunto;
            $doc->td_asunto_txt     = $request->doc_asunto_txt;
            $doc->td_destinoN       = $request->doc_desNombre;
            $doc->td_destinoO       = $request->doc_desOficina;
            $doc->td_expeSISGEDO    = $request->doc_expe_sisgedo;
            $doc->td_referencia     = $request->doc_referencia;
            $doc->td_fecha          = $request->doc_fecha;

            //guardamos los datos del doc en Json
            $doc_contenido = array(
                'doc_obra' => $request->doc_obra,
                'doc_idobra' => $request->doc_idobra,
                'doc_meta' => $meta,
                'doc_especifica' => $request->doc_especifica,
                'doc_ff' => $request->doc_ff,
                'doc_cfp' => $cfp,
                'doc_afd' => $request->doc_afd,
                'doc_cp' => $request->doc_cp,
                'doc_val' => $request->doc_val,
                'doc_monto' => $request->doc_monto,
                'doc_proced' => $request->doc_proced_nombre,
                'doc_ofi' => $request->doc_proced,
                'doc_txt' => $request->doc_txt

            );
            $doc->td_contenido      = json_encode($doc_contenido);
            $doc_cc = explode(',', $request->doc_cc);
            $doc->td_cc         = json_encode($doc_cc);
        }
		$doc->save();
        $date = Carbon::createFromFormat('Y-m-d', $doc->td_fecha);
		$ret = array('ok'=>'true','id'=>$doc->id, 'anio'=>$date->year);
        return json_encode($ret);
    }

	public function getMeta($anio,Request $request)
    {
		$meta = Presupuesto::where('ANO_EJE','=',$anio)
		->where('ACT_PROY','=',$request->proy_cod_siaf)->groupBy('SEC_FUNC');
		//dd($meta->toSql());
		return json_encode($meta->get());
    }
    public function getCf($anio, Request $request)
    {
		$meta = SiafMeta::getCF($request->sec_func,$anio,config('proyectos.unidad_ejecutora'));
		return $meta;
    }
	public function getEsp($anio, Request $request)
    {
		$especifica = Presupuesto::select(['ESPECIFICA','DESCRIPCIO', 'pim'])
            ->where('ANO_EJE','=',$anio)
            ->where('SEC_FUNC','=',$request->sec_func)
            ->where('FUENTE_FIN','=',$request->fuente_fto)
            ->where('pim','>',0);
		//dd($especifica->toSql());
		return json_encode($especifica->get());
    }
	public function getFf($anio, Request $request)
    {
		$ff = Presupuesto::select(['FUENTE_FIN'])
            ->where('ANO_EJE','=',$anio)
            ->where('SEC_FUNC','=',$request->sec_func)
            ->groupBy('FUENTE_FIN');
		//dd($ff->toSql());
		return json_encode($ff->get());
    }
	public function getCp($anio, Request $request)
    {
		$ff = Certificado::where('ANO_EJE','=',$anio)
            ->where('ACT_PROY','=',$request->proy_cod_siaf)
            ->where('SEC_FUNC','=',$request->sec_func)
            ->where('ESPECIFICA','=',$request->especifica)
		->groupBy('CERTIFICAD');
		//dd($ff->toSql());
		return json_encode($ff->get());
    }
	public function getContrato($anio, Request $request)
    {
		$ff = Compromiso::where('ANO_EJE','=',$anio)
		->where('CERTIFICAD','=',$request->cert)
		->groupBy('NUM_DOC');
		//dd($especifica->toSql());
		return json_encode($ff->get());
    }

	public function searchObra(Request $request)
    {
		if($request->listar){
		$cadenas1=\DB::table('proy_proyecto')
		->select([
					'proy_proyecto.idproy_proyecto',
                    'proy_proyecto.proy_nombre',
                    'proy_proyecto.proy_cod_snip',
                    'proy_proyecto.proy_cod_siaf'
                   ]);

		return Datatables::of($cadenas1)
                ->editColumn('proy_nombre', function ($cadena) {
                    return sprintf('<strong>%s</strong>',htmlentities($cadena->proy_nombre));
                })
                ->editColumn('proy_cod_snip', function ($cadena) {
                    return sprintf('%s', $cadena->proy_cod_snip);
                })
                ->editColumn('proy_cod_siaf', function ($cadena) {
                    return sprintf('%s', $cadena->proy_cod_siaf);
                })
                ->addColumn('action', function ($cadena) {
                    return sprintf('<a href="#" class="btn btn-xs btn-primary return" data-data="%s"><i class="glyphicon glyphicon-list"></i> Seleccionar</a>',
					e(json_encode($cadena)));
                })
                ->removeColumn('idproy_proyecto')
                ->make(true);
		}
		else
        {
			return view('proyectos.herramientas.documentos.buscar.index');
        }
        //return view('proyectos.herramientas.documentos.buscar.index');
    }

    public function savecnt(Request $request){
    	if($request->id_doc){
			$doc = Documento::find($request->id_doc);
		}else{
			$doc = new Documento();
		}

		$doc->td_asunto 		= $request->cnt_cargo;
		$doc->td_asunto_txt		= $request->cnt_cargo_txt;
		$doc->td_destinoN 		= '';
		$doc->td_destinoO 		= '';
		$doc->td_expeSISGEDO 	= $request->cnt_expe_sisgedo;
		$doc->td_referencia 	= $request->cnt_ref1.','.$request->cnt_ref2.','.$request->cnt_ref3.','.$request->cnt_ref4;
		$doc->td_fecha 			= '';
		//guardamos los datos del doc en Json
		$doc_contenido = array(
			'cnt_nombre' => $request->cnt_nombre,
			'cnt_dni' => $request->cnt_dni,
			'cnt_direccion' => $request->cnt_direccion,
			'cnt_finicio' => $request->cnt_finicio,
			'cnt_ffin' => $request->cnt_ffin,
			'cnt_proced' => $request->cnt_proced,
			'cnt_obra' => $request->cnt_obra,
			'cnt_idobra' => $request->cnt_idobra,
			'cnt_meta' => $request->cnt_meta,
			'cnt_especifica' => $request->cnt_especifica,
			'cnt_ff' => $request->cnt_ff,
			'cnt_cfp' => $request->cnt_cfp,
			'cnt_monto' => $request->cnt_monto,
		);
		$doc->td_contenido 		= json_encode($doc_contenido);
		$doc->save();
		$ret = array('ok'=>'true','id'=>$doc->id);
        return json_encode($ret);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function SelloGerente()
    {
        return view('proyectos.herramientas.sello_gerente');
    }

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
