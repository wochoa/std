<?php

namespace App\Http\Controllers\Tramite;

use App\Dependencia;
use App\DocGenerado;
use App\Documento;
use App\Plantilla;
use App\_clases\utilitarios\Cadena;
use App\TipoDocumento;
use App\TipoDocumentoCorrel;
use App\User;
use App\File;
use Auth;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Response;

class DocGeneradoController extends Controller
{

    public function __construct()
    {
        //Aqui se verifica si esta logueado
        $this->middleware('auth', ['except' => []]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Request $request)
    {

        $where = [
            ['dgen_iddependencia', '=', Auth::user()->depe_id],
        ];
        if ($request->idadmin != null)
            $where[] = ['dgen_idadmin', '=', $request->idadmin];

        return DocGenerado::select(['*'])
            ->where($where)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function printPdf($id)
    {

        $docGenerado = DocGenerado::find($id);
        $documento   = $docGenerado->getDocumento();
        //dd([$documento,$docGenerado]);
        return DocGeneradoController::printPdf2($docGenerado, $documento);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $docGenerado
     * @param $documento
     * @return TCPDF
     * @throws \Exception
     */
    public static function printPdf2($docGenerado, $documento)
    {

        setlocale(LC_TIME, 'ES_PE');
        setlocale(LC_TIME, 'es_PE.UTF-8');
        //$documento = (Object)$documento;

        $operaciones = collect($docGenerado->dgen_derivaciones);
        $destinos    = $operaciones
            ->where('oper_es_destino', 1);
        $docGenerado->dgen_derivaciones = $destinos;
        //dd(($documento->docu_numero_doc != null));
        $fecha            = ($documento->docu_fecha_doc != null) ? new Carbon($documento->docu_fecha_doc) : Carbon::now();
        $nro              = ($documento->docu_numero_doc != null) ? str_pad($documento->docu_numero_doc, 6, "0", STR_PAD_LEFT) : '______';
        $tipo_documento   = TipoDocumento::find($documento->docu_idtipodocumento)->tdoc_descripcion;
        $nro_documento    = ' Nº ' . $nro . ' ' . $fecha->formatLocalized("%Y") . '-' . $documento->docu_siglas_doc;
        $nombre_documento = $tipo_documento . $nro_documento;
        //$ccs = json_decode($doc->td_cc);
        $cont      = [
            "\t"      => '',
            "<table>" => '<table border="1">',
            //"<metas />" => 'ESTA ES UNA META DE PRUEBA',
        ];
        $plantilla = html_entity_decode(Cadena::ReplaceCadena($cont, $docGenerado->dgen_html));


        $oficina     = Dependencia::find($documento->docu_iddependencia);
        $dependencia = Dependencia::find($oficina->depe_depende);
        $superior    = $oficina->getSuperiorName();
        $ofi1        = ($superior != null) ? $superior : $oficina->depe_superior["nombre"];
        $ofi2        = ($superior != null) ? $oficina->depe_superior["nombre"] : '';
        //dd(dirname(__FILE__));
        //define('FPDF_FONTPATH', '/resources/fontTcpdf');
        $pdf = new TCPDF();
        $cm  = 10;
        $top = 3;
        //IDs de tipos de documento que tomaran el formato de documento
        $oficio = [1, 5];
        //IDs de tipos de documento que tomaran el formato de documento multiple INCLUYE MEMORANDUM
        $multile = [2, 4, 19];
        //IDs de tipos de documento que tomaran el formato de RESOLUCION
        $resolucion = [9];
        //IDs de tipos de documento que tomaran el formato de ACUERDO
        $acuerdo = [16];
        $pdf::SetMargins((3 * $cm), ($top * $cm), (2.5 * $cm));
        $pdf::SetAutoPageBreak(true, (3.5 * $cm));
        $margins = $pdf::getMargins();
        $anio    = env('ANIO_NAME');
        if (in_array($documento->docu_idtipodocumento, $resolucion)) {
            $pdf::setHeaderCallback(function ($pdf) use ($ofi1, $ofi2, $margins, $anio, $dependencia) {
                $pdf->SetTextColor(100, 100, 100);
                $w = $pdf->GetPageWidth() - $margins['right'] - $margins['left'] - 15;
                $pdf->image(
                    'img/membrete_header2.jpg',
                    15,
                    15,
                    40
                );
                if ($anio != '')
                    $pdf->SetFont('Helvetica', '', 9);
                $pdf->SetY(22);
                $pdf->Cell($pdf->getPageWidth() - $margins['right'] - $margins['left'], 6, "\"$anio\"", 0, 0, 'C');
            });
        } else if (in_array($documento->docu_idtipodocumento, $acuerdo)) {
            $pdf::setHeaderCallback(function ($pdf) use ($ofi1, $ofi2, $margins, $anio, $dependencia) {
                $pdf->SetTextColor(100, 100, 100);
                $w = $pdf->GetPageWidth() - $margins['right'] - $margins['left'] - 15;
                $pdf->image(
                    'img/membrete_header2.jpg',
                    85,
                    10,
                    40
                );
                if ($anio != '')
                    $pdf->SetFont('Helvetica', '', 9);
                $pdf->SetY(25);
                $pdf->Cell($pdf->getPageWidth() - $margins['right'] - $margins['left'], 6, "\"$anio\"", 0, 0, 'C');
            });
        } else {
            $pdf::setHeaderCallback(function ($pdf) use ($ofi1, $ofi2, $margins, $anio, $dependencia) {
                $pdf->SetTextColor(100, 100, 100);
                $w = $pdf->GetPageWidth() - $margins['right'] - $margins['left'] - 15;
                $pdf->image(
                    'img/membrete_header.jpg',
                    $margins['left'],
                    4,
                    $w
                );
                if (Storage::disk('imagenes')->exists($dependencia->depe_imagen_header)) {
                    $pdf->Image(
                        '@' . Storage::disk('imagenes')->get($dependencia->depe_imagen_header),
                        173,
                        6,
                        32
                    );
                }
                $pdf->SetFont('Times', 'B');
                $pdf->SetFontSize(11 - (strlen($ofi1) / 20));
                $pdf->SetY(5);
                $pdf->SetX(75);
                $pdf->MultiCell(47, 25, $ofi1, 0, 'C', 0, 1, '', '', true, 0, false, true, 15, 'M');

                $pdf->SetFontSize(11 - (strlen($ofi2) / 20));
                $pdf->SetY(5);
                $pdf->SetX(122);
                $pdf->MultiCell(47, 15, $ofi2, 0, 'C', 0, 1, '', '', true, 0, false, true, 15, 'M');

                if ($anio != '')
                    $pdf->SetFont('Times', 'B', 10);
                $pdf->SetY(22);
                $pdf->Cell($pdf->getPageWidth() - $margins['right'] - $margins['left'], 6, "\"$anio\"", 0, 0, 'C');
            });
            $pdf::setFooterCallback(function ($pdf) use ($documento, $margins, $dependencia) {
                if ($documento->iddocumento != '') {
                    if (in_array($documento->docu_idtipodocumento, [1, 2, 5, 19])) {
                        $pdf->SetY($pdf->getPageHeight() - $margins['bottom']);
                    } else {
                        $pdf->SetY($pdf->getPageHeight() - $margins['bottom'] + 10);
                    }
                    $pdf->SetTextColor(100, 100, 100);
                    $pdf->SetFont('Helvetica', '', 9);
                    $pdf->Cell(15, 4, 'Doc. Reg.', 0, 0, 'C');
                    $pdf->SetFont('Helvetica', 'B', 9);
                    $pdf->Cell(15, 4, str_pad($documento->iddocumento, 8, "0", STR_PAD_LEFT), 0, 0, 'C');
                    $pdf->Cell(5, 4, '', 0, 0, 'C');
                    $pdf->SetFont('Helvetica', '', 9);
                    $pdf->Cell(15, 4, 'Expe. Reg.', 0, 0, 'C');
                    $pdf->SetFont('Helvetica', 'B', 9);
                    $pdf->Cell(15, 4, str_pad($documento->docu_idexma, 8, "0", STR_PAD_LEFT), 0, 0, 'C');
                    $pdf->Cell(5, 4, '', 0, 0, 'C');
                    $pdf->SetFont('Helvetica', '', 9);
                    $pdf->Cell(18, 4, 'Contraseña:', 0, 0, 'C');
                    $pdf->SetFont('Helvetica', 'B', 9);
                    $pdf->Cell(18, 4, $documento->docu_contrasenia, 0, 0, 'C');
                    $pdf->SetFont('Helvetica', '', 9);
                    $pdf->Ln();
                    $pdf->SetFont('Helvetica', '', 7);
                    $pdf->Cell(
                        $pdf->getPageWidth() - $margins['right'] - $margins['left'],
                        3,
                        'esta es una copia autentica imprimible de un documento electronico archivado en el SGD, puede verificar en: ',
                        0,
                        0,
                        'L'
                    );
                    $pdf->Ln();
                    $pdf->SetFont('Helvetica', 'B', 7);
                    $pdf->Cell(
                        $pdf->getPageWidth() - $margins['right'] - $margins['left'],
                        3,
                        'http://digital.regionhuanuco.gob.pe/tramite/buscar/buscarDigital',
                        0,
                        0,
                        'L',
                        0,
                        'http://digital.regionhuanuco.gob.pe/tramite/buscar/buscarDigital'
                    );
                    $pdf->Ln();
                }
                $pdf->SetTextColor(100, 100, 100);

                if (in_array($documento->docu_idtipodocumento, [1, 2, 5, 19])) {
                    if (Storage::disk('imagenes')->exists($dependencia->depe_imagen_footer)) {
                        $pdf->Image(
                            '@' . Storage::disk('imagenes')->get($dependencia->depe_imagen_footer),
                            $margins['left'],
                            $pdf->getPageHeight() - $margins['bottom'] + 11,
                            $pdf->getPageWidth() - $margins['right'] - $margins['left']
                        );
                    } else {
                        $pdf->Image(
                            'img/membrete_footer.jpg',
                            $margins['left'],
                            $pdf->getPageHeight() - $margins['bottom'] + 11,
                            $pdf->getPageWidth() - $margins['right'] - $margins['left']
                        );
                    }
                }
                $pdf->Ln();
            });
        }
        if (in_array($documento->docu_idtipodocumento, $resolucion))
            DocGeneradoController::printResolucion($pdf, $nro_documento, $tipo_documento, $plantilla, $margins, $dependencia);
        elseif (in_array($documento->docu_idtipodocumento, $acuerdo))
            DocGeneradoController::printAcuerdo($pdf, $nro_documento, $tipo_documento, $plantilla, $margins, $dependencia);
        elseif (in_array($documento->docu_idtipodocumento, $multile))
            DocGeneradoController::printMultiple($docGenerado, $docGenerado->dgen_derivaciones, $pdf, $nombre_documento, $documento, $fecha, $plantilla, $dependencia);
        else {
            foreach ($docGenerado->dgen_derivaciones as $derivacion) {
                if (in_array($documento->docu_idtipodocumento, $oficio))
                    DocGeneradoController::printOficio($docGenerado, $derivacion, $pdf, $nombre_documento, $documento, $fecha, $plantilla, $dependencia);
                else
                    DocGeneradoController::printInforme($docGenerado, $derivacion, $pdf, $nombre_documento, $documento, $fecha, $plantilla, $dependencia);
            }
            if (count($docGenerado->dgen_derivaciones) == 0) {
                if (in_array($documento->docu_idtipodocumento, $oficio))
                    DocGeneradoController::printOficio($docGenerado, null, $pdf, $nombre_documento, $documento, $fecha, $plantilla, $dependencia);
                else
                    DocGeneradoController::printInforme($docGenerado, null, $pdf, $nombre_documento, $documento, $fecha, $plantilla, $dependencia);
            }
        }

        return $pdf;
    }

    public static function printResolucion($pdf, $nro_documento, $tipo_documento, $plantilla, $margins, $dependencia)
    {
        $pdf::AddPage();
        $fontSize = 11;
        $pdf::AddFont('Mono', '', base_path() . '/resources/fontTcpdf/monotypecorsivai.php');
        //$pdf::AddFont('Monotype',   '',base_path().'/resources/fontTcpdf/monotype-corsiva.php');
        $pdf::SetFont('Mono', '', 24);
        $pdf::Cell($pdf::getPageWidth() - $margins['right'] - $margins['left'], 6, '    ' . ucwords(strtolower($tipo_documento)) . '    ', 0, 0, 'C', false, '', 0);
        $pdf::Ln(15);
        $pdf::SetFont('Helvetica', 'B', 16);
        $pdf::Cell($pdf::getPageWidth() - $margins['right'] - $margins['left'], 6, "$nro_documento", 0, 0, 'C');
        $pdf::Ln(6);
        $pdf::SetFont('Helvetica', 'B', $fontSize);
        if ($dependencia->depe_ciudad == null)
            $pdf::Cell(0, 6, 'HUANUCO,');
        else
            $pdf::Cell(0, 6, $dependencia->depe_ciudad.',');


        $texto = $plantilla;
        $pdf::Ln(10);
        $pdf::SetFont('Helvetica', '', $fontSize);
        $pdf::writeHTML($texto, true, false, true, false, 'J');
    }

    public static function printAcuerdo($pdf, $nro_documento, $tipo_documento, $plantilla, $margins, $dependencia)
    {
        $pdf::AddPage();
        $fontSize = 11;
        $pdf::SetFont('Helvetica', 'B', 13);
        $pdf::Ln(6);
        $pdf::Cell($pdf::getPageWidth() - $margins['right'] - $margins['left'], 6, ($tipo_documento), 0, 0, 'C', false, '', 0);
        $pdf::Ln(6);
        $pdf::SetFont('Helvetica', 'B', 13);
        $pdf::Cell($pdf::getPageWidth() - $margins['right'] - $margins['left'], 6, "$nro_documento", 0, 0, 'C');
        $pdf::Ln(10);
        $pdf::SetFont('Helvetica', 'B', $fontSize);
        if ($dependencia->depe_ciudad == null)
            $pdf::Cell(0, 6, 'HUANUCO,');
        else
            $pdf::Cell(0, 6, $dependencia->depe_ciudad.',');


        $texto = $plantilla;
        $pdf::Ln(10);
        $pdf::SetFont('Helvetica', '', $fontSize);
        $pdf::writeHTML($texto, true, false, true, false, 'J');
    }

    public static function printMultiple($docGenerado, $derivaciones, $pdf, $nro_documento, $documento, $fecha, $plantilla, $dependencia)
    {

        //agregamos una pagina
        $pdf::AddPage();
        $fontSize = 11;
        //fuente inicial
        //$pdf::SetY( $pdf::getTMargin());
        $pdf::SetFont('Helvetica', 'B', $fontSize);
        $pdf::Write(6, $nro_documento);
        $pdf::Ln(6);
        if ($documento->docu_idtipodocumento == 4)
            $pdf::Cell(40, 6, 'A:');
        else
            $pdf::Cell(40, 6, 'SEÑOR:');
        $ccs = [];

        foreach ($derivaciones as $derivacion) {
            if (count($derivaciones) > 0) {
                $derivacion = (object)$derivacion;
                if (isset($derivacion->oper_manual) && $derivacion->oper_manual) {
                    $nombre = $derivacion->oper_persona;
                    $cargo  = $derivacion->oper_cargo;
                } else {
                    $nombre = ($derivacion->oper_usuid_d == null) ? Dependencia::find($derivacion->oper_depeid_d)->depe_representante : User::find($derivacion->oper_usuid_d)->getNombre();
                    $cargo  = ($derivacion->oper_usuid_d == null) ? Dependencia::find($derivacion->oper_depeid_d)->depe_cargo : User::find($derivacion->oper_usuid_d)->adm_cargo;
                }
            } else {
                $nombre = 'DEPENDENCIA';
                $cargo  = 'CARGO';
                //$oficina = 'OFICINA';
            }
            $ccs[] = $cargo;
            $x     = $pdf::getMargins()['right'];
            $pdf::SetX($x + 45);
            $pdf::SetFont('Helvetica', 'B', $fontSize);
            $pdf::Cell(0, 6, $nombre);
            $pdf::Ln(5);
            $pdf::SetFont('Helvetica', '', $fontSize);
            $pdf::SetX($x + 45);
            $pdf::MultiCell(0, 4, $cargo, 0, 'L');
            /*$pdf::Cell(40);
            $pdf::MultiCell(0, 6, $oficina, 0, 'L');*/
            $pdf::Ln(1);
        }
        $pdf::SetFont('Helvetica', 'B', $fontSize);
        $pdf::Cell(40, 6, 'ASUNTO:');
        $pdf::MultiCell(0, 6, $documento->docu_asunto, 0, 'L');
        $pdf::Ln(1);
        $pdf::SetFont('Helvetica', 'B', $fontSize);
        foreach ($docGenerado->dgen_referencias as $key => $value) {
            $text = (count($docGenerado->dgen_referencias) == 1) ? $docGenerado->dgen_referencias[$key] : '(' . ($key + 1) . ') ' . $docGenerado->dgen_referencias[$key];
            if ($key == 0) {
                $pdf::Cell(40, 6, 'REFERENCIA:');
                $pdf::MultiCell(0, 6, $text, 0, 'L');
            } else {
                $pdf::Cell(40);
                $pdf::MultiCell(0, 6, $text, 0, 'L');
            }
        }
        $pdf::Ln(2);
        $pdf::SetFont('Helvetica', 'B', $fontSize);
        $pdf::Cell(40, 6, 'FECHA:');

        if ($dependencia->depe_ciudad == null)
            $pdf::Cell(0, 6, 'HUANUCO, ' . $fecha->formatLocalized("%d de " . explode("|", env("MESES"))[$fecha->month] . " del %Y"));
        else
            $pdf::Cell(0, 6, $dependencia->depe_ciudad.', '. $fecha->formatLocalized("%d de " . explode("|", env("MESES"))[$fecha->month] . " del %Y"));


        $texto = $plantilla;
        $pdf::Ln(10);
        //dd($texto);
        $pdf::SetFont('Helvetica', '', $fontSize);
        $pdf::writeHTML($texto, true, false, true, false, 'J');
        //$pdf::WriteTagIdent(0, 5, $texto, 0, "J", 0, 0);
        /*$pdf::Ln(20);
        $pdf::SetFont('Helvetica', '', 6);
        $pdf::Write(5, 'CC:');
        $pdf::Ln();
        foreach ($ccs as $key => $cc) {
            $pdf::Write(5, utf8_decode(strtoupper($cc)));
            $pdf::Ln();
        }
        $pdf::Write(5, 'ARCHIVO');
        $pdf::Ln();*/
    }

    public static function printInforme($docGenerado, $derivacion, $pdf, $nro_documento, $documento, $fecha, $plantilla, $dependencia)
    {
        if ($derivacion != null) {
            $derivacion = (object)$derivacion;
            if (isset($derivacion->oper_manual) && $derivacion->oper_manual) {
                $nombre = $derivacion->oper_persona;
                $cargo  = $derivacion->oper_cargo;
            } else {
                $nombre = ($derivacion->oper_usuid_d == null) ? Dependencia::find($derivacion->oper_depeid_d)->depe_representante : User::find($derivacion->oper_usuid_d)->getNombre();
                $cargo  = ($derivacion->oper_usuid_d == null) ? Dependencia::find($derivacion->oper_depeid_d)->depe_cargo : User::find($derivacion->oper_usuid_d)->adm_cargo;
            }
            $oficina    = Dependencia::find($derivacion->oper_depeid_d)->depe_nombre;
        } else {
            $nombre  = 'DEPENDENCIA';
            $cargo   = 'CARGO';
            $oficina = 'OFICINA';
        }
        //agregamos una pagina
        $pdf::AddPage();
        $fontSize = 11;
        //fuente inicial
        //$pdf::SetY( $pdf::getTMargin());
        $pdf::SetFont('Helvetica', 'B', $fontSize);
        $pdf::Write(6, $nro_documento);
        $pdf::Ln(6);
        $pdf::Cell(40, 6, 'A:');
        $pdf::Cell(0, 6, $nombre);
        $pdf::Ln(5);
        $pdf::SetFont('Helvetica', '', $fontSize);
        $pdf::Cell(40);
        $pdf::MultiCell(0, 4, $cargo, 0, 'L');
        $pdf::Cell(40);
        $pdf::MultiCell(0, 6, $oficina, 0, 'L');
        $pdf::Ln(1);
        $pdf::SetFont('Helvetica', 'B', $fontSize);
        $pdf::Cell(40, 6, 'ASUNTO:');
        $pdf::MultiCell(0, 6, $documento->docu_asunto, 0, 'L');
        $pdf::Ln(1);
        $pdf::SetFont('Helvetica', 'B', $fontSize);
        foreach ($docGenerado->dgen_referencias as $key => $value) {
            $text = (count($docGenerado->dgen_referencias) == 1) ? $docGenerado->dgen_referencias[$key] : '(' . ($key + 1) . ') ' . $docGenerado->dgen_referencias[$key];
            if ($key == 0) {
                $pdf::Cell(40, 6, 'REFERENCIA:');
                $pdf::MultiCell(0, 6, $text, 0, 'L');
            } else {
                $pdf::Cell(40);
                $pdf::MultiCell(0, 6, $text, 0, 'L');
            }
        }
        $pdf::Ln(2);
        $pdf::SetFont('Helvetica', 'B', $fontSize);
        $pdf::Cell(40, 6, 'FECHA:');

        if ($dependencia->depe_ciudad == null)
            $pdf::Cell(0, 6, 'HUANUCO, ' . $fecha->formatLocalized("%d de " . explode("|", env("MESES"))[$fecha->month] . " del %Y"));
        else
            $pdf::Cell(0, 6, $dependencia->depe_ciudad.', '. $fecha->formatLocalized("%d de " . explode("|", env("MESES"))[$fecha->month] . " del %Y"));


        $texto = $plantilla;
        $pdf::Ln(10);
        //dd($texto);
        $pdf::SetFont('Helvetica', '', $fontSize);
        $pdf::writeHTML($texto, true, false, true, false, 'J');
        //$pdf::WriteTagIdent(0, 5, $texto, 0, "J", 0, 0);
        /*$pdf::Ln(10);
        $pdf::SetY(-45);
        $pdf::SetFont('Helvetica', '', 6);
        $pdf::Write(5, 'CC:');
        //$pdf::Ln();
//        foreach ($ccs as $key => $cc) {
//            $pdf::Write(5,utf8_decode(strtoupper($cc)));
//            $pdf::Ln();
//        }
        $pdf::Write(5, 'ARCHIVO');
        $pdf::Ln();*/
    }

    public static function printOficio($docGenerado, $derivacion, $pdf, $nro_documento, $documento, $fecha, $plantilla, $dependencia)
    {
        //dd($documento->docu_asunto);
        if ($derivacion != null) {
            $derivacion = (object)$derivacion;

            if (isset($derivacion->oper_manual) && $derivacion->oper_manual) {
                $nombre = $derivacion->oper_persona;
                $cargo  = $derivacion->oper_cargo;
            } else {
                $nombre = ($derivacion->oper_usuid_d == null) ? Dependencia::find($derivacion->oper_depeid_d)->depe_representante : User::find($derivacion->oper_usuid_d)->getNombre();
                $cargo  = ($derivacion->oper_usuid_d == null) ? Dependencia::find($derivacion->oper_depeid_d)->depe_cargo : User::find($derivacion->oper_usuid_d)->adm_cargo;
            }
        } else {
            $nombre = 'DEPENDENCIA';
            $cargo  = 'CARGO';
        }
        //agregamos una pagina
        $pdf::AddPage();
        $fontSize = 11;
        //fuente inicial
        $pdf::Ln(8);
        $pdf::SetFont('Helvetica', 'B', $fontSize);
        if ($dependencia->depe_ciudad == null)
            $pdf::Cell(0, 6, 'HUANUCO, ' . $fecha->formatLocalized("%d de " . explode("|", env("MESES"))[$fecha->month] . " del %Y"));
        else
            $pdf::Cell(0, 6, $dependencia->depe_ciudad.', '. $fecha->formatLocalized("%d de " . explode("|", env("MESES"))[$fecha->month] . " del %Y"));
        //$pdf::Cell(0, 6, 'HUANUCO, ' . $fecha->formatLocalized("%d de " . explode("|", env("MESES"))[$fecha->month] . " del %Y"));
        $pdf::Ln(8);
        $pdf::Write(6, $nro_documento);
        $pdf::Ln(8);
        $pdf::Cell(40, 6, 'SEÑOR:');
        $pdf::Ln();
        $pdf::SetFont('Helvetica', '', $fontSize);
        $pdf::MultiCell(0, 6, $nombre . ' - ' . $cargo, 0, 'L');
        $pdf::SetFont('Helvetica', '', $fontSize);

        if ($dependencia->depe_ciudad == null)
            $pdf::Cell(0, 6, 'HUANUCO');
        else
            $pdf::Cell(0, 6, $dependencia->depe_ciudad.',');
        //$pdf::MultiCell(0, 6, "HUANUCO");
        $pdf::Ln();
        $pdf::SetFont('Helvetica', 'B', $fontSize);
        $pdf::Cell(38, 6, 'ASUNTO');
        $pdf::SetFont('Helvetica', '', $fontSize);
        $pdf::MultiCell(0, 6, ': ' . $documento->docu_asunto, 0, 'L');

        $pdf::SetFont('Helvetica', 'B', $fontSize);
        foreach ($docGenerado->dgen_referencias as $key => $value) {
            $text = (count($docGenerado->dgen_referencias) == 1) ? $docGenerado->dgen_referencias[$key] : '(' . ($key + 1) . ') ' . $docGenerado->dgen_referencias[$key];
            if ($key == 0) {
                $pdf::Cell(38, 6, 'REFERENCIA');
                $pdf::MultiCell(0, 6, ': ' . $text, 0, 'L');
            } else {
                $pdf::Cell(40);
                $pdf::MultiCell(0, 6, $text, 0, 'L');
            }
        }
        $texto = $plantilla;
        $pdf::Ln(5);
        $pdf::SetFont('Helvetica', '', $fontSize);
        $pdf::SetFillColor(255, 255, 255);
        //$pdf::writeHTMLCell(160, '', '', $pdf::getY(), $texto, 0, 0, false, false, 'J', false);
        $pdf::writeHTML($texto, false, true, true, false, 'J');
        /*$pdf::Ln(10);
        $pdf::SetY(-42);
        $pdf::SetFont('Helvetica', '', $fontSize);
        $pdf::Write(5, 'CC:');
        $pdf::Write(5, 'ARCHIVO');
        $pdf::Ln();*/
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $documentoGenerado = ($request->id == null) ? new DocGenerado() : DocGenerado::find($request->id);
        //$documento = (new Documento())->fill((Array)$request->plt_datos['documento']);
        //$documento->iddocumento = $request->plt_datos['documento']['iddocumento'];
        //$documento->docu_archivo = $request->plt_datos['documento']['docu_archivo'];
        //$documento->iddocumento = $request->plt_datos['documento']->iddco
        $request->plt_datos = ['documento' => $request->plt_datos['documento'], 'derivaciones' => []];
        if (!$request->validar) {
            $documentoGenerado->dgen_html          = $request->plt_plantilla;
            $documentoGenerado->dgen_datos         = json_encode($request->plt_datos);
            $documentoGenerado->dgen_derivaciones  = $request->plt_derivaciones;
            $documentoGenerado->dgen_referencias   = $request->plt_referencias;
            $documento                             = (object)$request->plt_datos['documento'];
            $documentoGenerado->dgen_idadmin       = ($documento->docu_tipo) ? $documento->docu_idusuario : null;
            $documentoGenerado->dgen_iddependencia = $documento->docu_iddependencia;
            if (isset($documento->iddocumento) && $documento->iddocumento != null) {
                //dd($documento->iddocumento);
                $doc              = Documento::find($documento->iddocumento);
                $doc->docu_folios = $documento->docu_folios;
                $doc->docu_asunto = $documento->docu_asunto;
                //$doc->docu_contrasenia=($doc->docu_contrasenia==null)?Str::random(8):$doc->docu_contrasenia;
                $doc->save();
                //$doc->addVisible('iddocumento');
                $documentoGenerado->dgen_datos = json_encode(['documento' => $doc, 'derivaciones' => ['hola']]);
                //$documentoGenerado->save();
                $anio = substr($documento->docu_fecha_doc, 0, 4);

                $file = '\\' . $anio . '\\' . $documento->docu_iddependencia . '\\' . $documento->docu_idtipodocumento;
                $file .= ($documento->docu_tipo) ? '\\' . $documento->docu_idusuario : '';
                $file .= '\\' . $doc->getIdString() . '.pdf';
                if (count($documento->docu_archivo) > 0) {
                    $path = '\\' . $anio . '\\' . $documento->docu_iddependencia . '\\' . $documento->docu_idtipodocumento;
                    $path .= ($documento->docu_tipo) ? '\\' . $documento->docu_idusuario : '';
                    DocumentoController::guardarFile($documento->docu_archivo, $doc, $path);
                }
                $doc->load(['operaciones']);
                $generado = collect($documento->docu_archivo)->where('file_generado', 1);
                $operaciones = collect($doc->operaciones);
                $first       = $operaciones->first();

                if (count($documentoGenerado->dgen_derivaciones) > 0) {
                    $doc->derivar($first, $documentoGenerado->dgen_derivaciones);
                }
                $operaciones = collect($doc->operaciones);
                $destinos    = $operaciones
                    ->where('oper_idprocesado', $first->idoperacion);
                $documentoGenerado->dgen_derivaciones = $destinos->toArray();
                if (count($generado) == 1 && $generado->first()['edit']) {
                    Storage::disk('tramite')->put($file, DocGeneradoController::printPdf2($documentoGenerado, $doc)::Output($doc->getIdString() . '.pdf', 'S'));
                    $g = File::find($generado->first()['id']);
                    $size = Storage::disk('tramite')->size($file);
                    $g->file_size = $size;
                    $g->save();
                }
            }
        } else { //****************************FUNCION EJECUTADA AL VALIDAR
            $datos                            = json_decode($documentoGenerado->dgen_datos);
            $datos->documento                 = (object)$datos->documento;
            $datos->documento->docu_idusuario = Auth::user()->id;
            $datos->documento->docu_fecha_doc = Carbon::now()->toDateString();
            $anio                             = substr($datos->documento->docu_fecha_doc, 0, 4);
            $where                            = [
                ['tdco_idtipodocumento', '=', $datos->documento->docu_idtipodocumento],
                ['tdco_iddependencia', '=', $datos->documento->docu_iddependencia],
                ['tdco_idusuario', '=', ($datos->documento->docu_tipo) ? $datos->documento->docu_idusuario : null],
                ['tdco_periodo', '=', $anio],
            ];
            $correlativo                      = TipoDocumentoCorrel::select('id', 'tdco_numero')->where($where)->first();

            if ($correlativo != null) {
                $datos->documento->correlativo     = $correlativo->id;
                $datos->documento->docu_numero_doc = str_pad($correlativo->tdco_numero, 6, "0", STR_PAD_LEFT);
            } else {
                $datos->documento->correlativo     = null;
                $datos->documento->docu_numero_doc = '000001';
            }
            //$datos->documento->docu_referencias = [];
            if (!isset($datos->documento->docu_digital))
                $datos->documento->docu_digital = false;
            if (!isset($datos->documento->docu_emailorigen))
                $datos->documento->docu_emailorigen = null;
            $doc = DocumentoController::guardarDocumeto($datos->documento, $documentoGenerado->dgen_derivaciones, true, false, []);
            $doc->load('operaciones');
            $operaciones = collect($doc->operaciones);
            $first       = $operaciones->first();
            $destinos    = $operaciones
                ->where('oper_idprocesado', $first->idoperacion);
            $file        = '\\' . $anio . '\\' . $datos->documento->docu_iddependencia . '\\' . $datos->documento->docu_idtipodocumento;
            $file        .= ($datos->documento->docu_tipo) ? '\\' . $datos->documento->docu_idusuario . '\\' : ('' . '\\');
            $file_save   = $file . $doc->getIdString() . '.pdf';

            $file_doc                 = new File();
            $file_doc->file_url       = $file_save;
            $file_doc->file_name      = 'Doc. generado ' . $doc->getIdString() . '.pdf';
            $file_doc->file_tipo      = 'application/pdf';
            $file_doc->file_mostrar   = true;
            $file_doc->id_documento   = $doc->getIdString();
            $file_doc->file_principal = 1;
            $file_doc->file_generado  = 1;
            $file_doc->save();

            $doc->docu_doc_generado = $documentoGenerado->id;
            $doc->docu_contrasenia  = Str::random(8);
            $doc->save();
            $documentoGenerado->dgen_datos = json_encode((object)['documento' => $doc]);
            $documentoGenerado->dgen_derivaciones = $destinos->toArray();

            Storage::disk('tramite')->put($file_save, DocGeneradoController::printPdf2($documentoGenerado, $doc)::Output($doc->getIdString() . '.pdf', 'S'));
            $size = Storage::disk('tramite')->size($file_save);

            $file_doc->file_size      = $size; //revisar bien
            $file_doc->save();
        }
        return json_encode((object)['status' => $documentoGenerado->save()]);
    }

    public function imprimir($id)
    {
        return Response::make($this->printPdf($id)::Output(), 200, ['Content-Type' => 'application/pdf']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        //return Response::make($this->printPdf($id)->Output(),200,['Content-Type' => 'application/pdf']);
        return DocGenerado::find($id)->getForDocGenerado();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
