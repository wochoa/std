@extends('layouts.proyectos.reporte')
@section('content')
<div id="myPrintArea" class="container-fluid" style="border: solid black 1px;">
    <div>
        <h3></h3>
    </div>
    <table class="table" style="padding: 15px;">
        <thead>
        <tr>
            <th style="border-left: hidden; border-top: hidden; border-bottom: hidden;" class="sin-borde"></th>
            <th style="text-align: center; padding: 2px; border: solid black 1px; font-size: 9px !important;">GRAFICO N&deg;05: Formato Est&aacute;ndar Solicitud CCP</th>
            <th style="border-right: hidden; border-top: hidden; border-bottom: hidden;" class="sin-borde"></th>
        </tr>
        </thead>
    </table>
    <!--<p>The .table class adds basic styling (light padding-top and only horizontal dividers) to a table:</p>-->
    <!--TITULO-->
    <table class="table table-bordered">
        <thead>
        <tr class="info">
            <th style="text-align: center; font-size: 9px !important;">SOLICITUD DE CERTIFICACI&Oacute;N DE CR&Eacute;DITO PRESUPUESTARIO - CERTIFICACI&Oacute;N N&deg; <u style="font-size: 1.4em;">{{sprintf("%06s",$solicitud->solc_certificado)}}</u></th>
        </tr>
        </thead>
    </table>
    <!--FIN TITULO-->
    <h5 style="width: 75%; float: left"><b>1.- INFORMACI&Oacute;N</b></h5>
    <div style="float: left;">
        <table class="table table-bordered">
            <thead>
            <tr class="info">
                <th style="text-align: center">D&Iacute;A</th>
                <th style="text-align: center">MES</th>
                <th style="text-align: center">A&Ntilde;O</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{\Carbon\Carbon::createFromFormat('Y-m-d',$documento->doc_fecha)->format('d')}}</td>
                <td>{{\Carbon\Carbon::createFromFormat('Y-m-d',$documento->doc_fecha)->format('m')}}</td>
                <td>{{\Carbon\Carbon::createFromFormat('Y-m-d',$documento->doc_fecha)->format('Y')}}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <br>
    <table>
        <tbody>
        <tr>
            <td width="20%" style="border: hidden;" class="sin-borde">UNIDAD ORG&Aacute;NICA</td>
            <td style="border-top: hidden; border-right: hidden;" class="con-borde-bottom">{{$documento->doc_oficina}}</td>
        </tr>
        </tbody>
    </table>

    <table>
        <tbody>
        <tr>
            <td width="20%" style="border: hidden;" class="sin-borde">N&deg; DE DOCUMENTO</td>
            <td style="border-top: hidden; border-right: hidden;" class="con-borde-bottom">{{$documento->doc_documento}}</td>
        </tr>
        </tbody>
    </table>

    <table>
        <tbody>
        <tr>
            <td width="20%" style="border: hidden;" class="sin-borde">TIPO DE GASTO</td>
            <td style="border: hidden;" class="sin-borde">GASTO CORRIENTE <input type="text" class="text-center" size="1" style="margin-left: 20px" value="{{($solicitud->solc_tipo_gasto==1)?'X':''}}"></td>
            <td style="border: hidden;" class="sin-borde">GASTO DE CAPITAL<input type="text" class="text-center" size="1" style="margin-left: 20px" value="{{($solicitud->solc_tipo_gasto==2)?'X':''}}" ></td>
        </tr>
        </tbody>
    </table>

    <table>
        <tbody>
        <tr>
            <td width="20%" style="border: hidden;" class="sin-borde">OBJETO</td>
            <td style="border: hidden;" class="sin-borde">{{$solicitud->solc_objeto}}</td>
        </tr>
        </tbody>
    </table>

    <table>
        <tbody>
        <tr>
            <td width="20%" style="border: hidden;" class="sin-borde">TIPO PROCESO SELECCI&Oacute;N</td>
            <td style="border-top: hidden; border-right: hidden;" class="con-borde-bottom">{{$solicitud->solc_tipo_proceso_seleccion}}</td>
        </tr>
        </tbody>
    </table>

    <table>
        <tbody>
        <tr>
            <td width="20%" style="border: hidden;" class="sin-borde">OTROS</td>
            <td style="border: hidden;" class="con-borde-bottom">{{$solicitud->solc_otros}}</td>
        </tr>
        </tbody>
    </table>

    <table>
        <tbody>
        <tr>
            <td width="20%" style="border: hidden;" class="sin-borde">OTROS</td>
            <td style="border: hidden;" class="sin-borde">{{$solicitud->solc_justificacion}}</td>
        </tr>
        </tbody>
    </table>
    <br>
    <table>
        <tbody>
        <tr>
            <td width="20%" style="border: hidden;" class="sin-borde"></td>
            <td style="border-top: hidden; border-right: hidden;" class="con-borde-bottom"></td>
        </tr>
        </tbody>
    </table>

    <table>
        <tbody>
        <tr>
            <td width="20%" style="border: hidden;" class="sin-borde">DOCUMENTO DE PRIORIZACI&Oacute;N</td>
            <td style="border-top: hidden; border-right: hidden;" class="con-borde-bottom">{{$solicitud->solc_doc_priorizacion}}</td>
        </tr>
        </tbody>
    </table>
    <br>


    <h5><b>2.- ESTRUCTURA FUNCIONAL Y COSTO</b></h5>
    <br>
    <!--1. INFORMACI&Oacute;N GENERA-->
    <table class="table table-bordered table-condensed" style="margin-bottom: 20px !important;">
        <thead>
        <tr class="info">
            <th class="text-center" width="5%">FUENTE FINANCIAMIENTO</th>
            <th class="text-center" width="5%">TIPO DE RECURSO</th>
            <th class="text-center" width="5%">CATEGOR&Iacute;A PRESUPUESTAL</th>
            <th class="text-center" width="6%">PRODUCTO/PROYECTO</th>
            <th class="text-center" width="6%">ACTIV/OBRA/ACC INVER</th>
            <th class="text-center" width="5%">FUNCI&Oacute;N</th>
            <th class="text-center" width="5%">DIVISI&Oacute;N FUNCIONAL</th>
            <th class="text-center" width="5%">GRUPO FUNCIONAL</th>
            <th class="text-center" width="5%">FINALIDAD</th>
            <th class="text-center" width="5%">META</th>
            <th class="text-center" width="8%">ESPEC&Iacute;FICA DE GASTO</th>
            <th class="text-center" width="8%">PIA (A)</th>
            <th class="text-center" width="8%">PIM (B)</th>
            <th class="text-center" width="8%">CERTIFICACI&Oacute;N ACTUAL (C)</th>
            <th class="text-center" width="8%">SALDO POR CERTIFICAR (D=B-C)</th>
            <th class="text-center" width="8%">MONTO SOLICITADO</th>
        </tr>
        </thead>
        <tbody><?php $total=0?>
        @foreach($detalles as $detalle)
        <tr>
            <td class="text-center">{{\App\Http\Controllers\Proy\tools\cert\SolicitudC::iniciales($detalle->fuente_financiamiento_nombre)}}</td>
            <td class="text-center">{{sprintf("%02s",$detalle->det_fuente_financiamiento)}}</td>
            <td class="text-center">{{sprintf("%04s",$detalle->programa)}}</td>
            <td class="text-center">{{sprintf("%07s",$detalle->prod_proy)}}</td>
            <td class="text-center">{{sprintf("%07s",$detalle->act_al_obra)}}</td>
            <td class="text-center">{{sprintf("%02s",$detalle->funcion)}}</td>
            <td class="text-center">{{sprintf("%03s",$detalle->division_funcional)}}</td>
            <td class="text-center">{{sprintf("%04s",$detalle->grupo_funcional)}}</td>
            <td class="text-center">{{sprintf("%04s",$detalle->finalidad)}}</td>
            <td class="text-center">{{sprintf("%04s",$detalle->sec_func)}}</td>
            <td class="text-center">{{$detalle->especifica}}</td>
            <td class="text-right">{{Money::toMoney($detalle->det_pia,'')}}</td>
            <td class="text-right">{{Money::toMoney($detalle->det_pim,'')}}</td>
            <td class="text-right">{{Money::toMoney($detalle->det_certificacion,'')}}</td>
            <td class="text-right">{{Money::toMoney($detalle->det_pim-$detalle->det_certificacion,'')}}</td>
            <td class="text-right">{{Money::toMoney($detalle->det_monto_solicitado,'')}}</td><?php $total+=$detalle->det_monto_solicitado?>
        </tr>
        @endforeach
        <tr>
            <td colspan="15" class="total sin-borde" style="border-bottom: hidden; border-left: hidden;"></td>
            <td class="text-right">{{Money::toMoney($total,'')}}</td>
        </tr>
        </tbody>
    </table>
    <table class="sellos">
        <tbody>
        <tr>
            <td width="9%" style="border: hidden;" class="sin-borde"></td>
            <td width="12%" style="border: hidden;" class="text-center"></td>
            <td width="22%" style="border: hidden;" class="sin-borde"></td>
            <td width="20%" style="border: hidden;" class="text-center"></td>
            <td width="7%" style="border: hidden;" class="sin-borde"></td>
        </tr>
        </tbody>
    </table>
    <table>
        <tbody>
        <tr>
            <td width="10%" style="border: hidden;" class="sin-borde"></td>
            <td width="10%" style="border-top: hidden; border-right: hidden; border-width: 2px;"></td>
            <td width="30%" style="border: hidden;" class="sin-borde"></td>
            <td width="10%" style="border-top: hidden; border-right: hidden; border-width: 2px;"></td>
            <td width="10%" style="border: hidden;" class="sin-borde"></td>
        </tr>
        </tbody>
    </table>
    <table>
        <tbody>
        <tr>
            <td width="10%" style="border: hidden;" class="sin-borde"></td>
            <td width="10%" style="border: hidden;" class="text-center">ELABORADO POR:</td>
            <td width="30%" style="border: hidden;" class="sin-borde"></td>
            <td width="10%" style="border: hidden;" class="text-center">REVISADO POR:</td>
            <td width="10%" style="border: hidden;" class="sin-borde"></td>
        </tr>
        </tbody>
    </table>
    <!--FIN 1. INFORMACI&Oacute;N GENERA-->

</div>
    @endsection
@push('style')
<style>
    @media print {
        .info th {
            background-color: #D9EDF7 !important;
        }

        .info td {
            background-color: #D9EDF7 !important;
        }

        thead tr th {
            font-size: 0.75em !important;
            padding: 5px 0px !important;
            vertical-align: middle !important;
            text-align: center !important;
        }
        table{
            margin-bottom: 200px;
            margin-top: 0px;
            text-align: center;
        }
        .text-left{text-align: left!important;}
        .subtitle{
            font-size: 10px !important;
            font-weight: 100;
        }
        table tbody tr td{
            vertical-align: middle!important;
            font-weight: 100;
        }

        .sellos tbody tr td {
            vertical-align: bottom !important;
        }
        .text-justify{text-align: justify!important;}

        margin-top: 0.2in;
        margin-bottom: 0.75in;
    }

    .footer{ position: fixed; bottom: 0px; }
    .header{ position: fixed; top: 0px; text-align: right; width: 98%; }
    .breack-page { page-break-after: always; }
    }
    .header{ position: fixed; top: 0px; text-align: right; width: 100%; }
</style>
@endpush
@push('scripts')
<script>
    $(document).ready(function () {
        var myCallBack = function() {window.close();};
        $('#myPrintArea').print({
            deferred: $.Deferred().done(myCallBack)
        });
    })
</script>
@endpush
