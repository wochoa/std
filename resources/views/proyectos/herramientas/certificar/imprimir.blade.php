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
            <th style="text-align: center; padding: 2px; border: solid black 1px">GRAFICO N&deg;05: Formato Est&aacute;ndar Solicitud CCP</th>
            <th style="border-right: hidden; border-top: hidden; border-bottom: hidden;" class="sin-borde"></th>
        </tr>
        </thead>
    </table>
    <!--<p>The .table class adds basic styling (light padding-top and only horizontal dividers) to a table:</p>-->
    <!--TITULO-->
    <table class="table table-bordered">
        <thead>
        <tr class="info">
            <th style="text-align: center">SOLICITUD DE CERTIFICACI&Oacute;N DE CR&Eacute;DITO PRESUPUESTARIO - CRETIFICACI&Oacute;N N&deg; <u>{{sprintf("%06s",$solicitud->solc_certificado)}}</u></th>
        </tr>
        </thead>
    </table>
    <!--FIN TITULO-->
    <h5><b>1.- INFORMACI&Oacute;N</b></h5>
    <br>
    <table>
        <tbody>
        <tr>
            <td width="20%" style="border: hidden;" class="sin-borde">UNIDAD ORG&Aacute;NICA</td>
            <td style="border-top: hidden; border-right: hidden;" class="con-borde-bottom">{{$solicitud->solc_oficina}}</td>
        </tr>
        </tbody>
    </table>

    <table>
        <tbody>
        <tr>
            <td width="20%" style="border: hidden;" class="sin-borde">N&deg; DE DOCUMENTO</td>
            <td style="border-top: hidden; border-right: hidden;" class="con-borde-bottom">{{$solicitud->solc_documento}}</td>
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
    <table class="table table-bordered table-condensed" style="margin-bottom: 100px !important;">
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
        <tbody>
        <tr>
            <td class="text-center">RO</td>
            <td class="text-center">{{sprintf("%02s",$solicitud->solc_fuente_financiamiento)}}</td>
            <td class="text-center">{{sprintf("%04s",$solicitud->programa)}}</td>
            <td class="text-center">{{sprintf("%07s",$solicitud->prod_proy)}}</td>
            <td class="text-center">{{sprintf("%07s",$solicitud->act_al_obra)}}</td>
            <td class="text-center">{{sprintf("%02s",$solicitud->FUNCION)}}</td>
            <td class="text-center">{{sprintf("%03s",$solicitud->division_funcional)}}</td>
            <td class="text-center">{{sprintf("%04s",$solicitud->grupo_funcional)}}</td>
            <td class="text-center">{{sprintf("%04s",$solicitud->FINALIDAD)}}</td>
            <td class="text-center">{{sprintf("%04s",$solicitud->META)}}</td>
            <td class="text-center">2.6.2.2.3.4</td>
            <td class="text-right">{{Money::toMoney($solicitud->solc_pia,'')}}</td>
            <td class="text-right">{{Money::toMoney($solicitud->solc_pim,'')}}</td>
            <td class="text-right">{{Money::toMoney($solicitud->solc_certificacion,'')}}</td>
            <td class="text-right">{{Money::toMoney($solicitud->solc_pim-$solicitud->solc_certificacion,'')}}</td>
            <td class="text-right">{{Money::toMoney($solicitud->solc_monto_solicitado,'')}}</td>
        </tr>
        <tr>
            <td colspan="15" class="total sin-borde" style="border-bottom: hidden; border-left: hidden;"></td>
            <td class="text-right">{{Money::toMoney($solicitud->solc_monto_solicitado,'')}}</td>
        </tr>
        </tbody>
    </table>
    <br>
    <br>
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