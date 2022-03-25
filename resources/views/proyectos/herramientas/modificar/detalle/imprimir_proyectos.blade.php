@extends('layouts.proyectos.reporte')
@section('content')
<div class="container-fluid">
    <div style="height: 0.5px;">.</div>
    <table class="table modif" style="padding: 15px; border: black 1px solid !important;">
        <thead style="display: table-header-group">
            <tr class="sin-borde">
                <th colspan="11" class="text-center"><h1></h1></th>
            </tr>
            <tr class="sin-borde">
                <th colspan="11" class="text-center"><h4>{{$modificatoria->modif_titulo}}</h4></th>
            </tr>
            <tr class="sin-borde">
                <th colspan="2" class="text-left subtitle">PLIEGO</th>
                <th colspan="9" class="text-left subtitle">: 448 GOBIERNO REGIONAL HUANUCO</th>
            </tr>
            <tr class="sin-borde">
                <th colspan="2" class="text-left subtitle">UNIDAD</th>
                <th colspan="9" class="text-left subtitle">: GERENCIA REGIONAL DE INFRAESTRUCTURA</th>
            </tr>
            <tr class="sin-borde">
                <th colspan="2" class="text-left subtitle">FTE. DE FTO.</th>
                <th colspan="9" class="text-left subtitle">: {{$fuenteFinanciamiento}} - {{$tipo}}</th>
            </tr>
            <tr class="info">
                <th rowspan="2" class="x">Nro</th>
                <th rowspan="2" class="x">PRODUC TO/ PROYEC TO</th>
                <th rowspan="2" class="y">DESCRIPCION</th>
                <th rowspan="2" class="w">COSTO TOTAL</th>
                <th rowspan="2" class="w">ACUM</th>
                <th rowspan="2" class="w">SALDO</th>
                <th rowspan="2" class="w">PIM</th>
                <th colspan="2">MODIFICACIONES</th>
                <th rowspan="2" class="w">NUEVO PIM</th>
                <th rowspan="2" class="z">JUSTIFICACION</th>
            </tr>
            <tr class="info">
                <th class="w">DE</th>
                <th class="w">A</th>
            </tr>
        </thead>
        
        <tbody><?php $count=1?>
        @foreach($modificaciones as $id =>$proyecto)
            <tr>
                <td class="text-center">{{$count++}}</td>
                <td class="text-center">{{$proyecto['modif']->comp_prod_proy}}</td>
                <td class="text-justify">{{$proyecto['modif']->proy_nombre}}</td>
                <td class="text-right">{{Money::toMoney($proyecto['modif']->proy_pip_actualizado,'')}}</td>
                <td class="text-right">{{Money::toMoney($proyecto['modif']->acumulado+$proyecto['modif']->proy_ejecucion_otras_ejecutoras,'')}}</td>
                <td class="text-right">{{Money::toMoney($proyecto['modif']->proy_pip_actualizado-$proyecto['modif']->acumulado,'')}}</td>
                <td class="text-right">{{Money::toMoney($proyecto['modif']->pim_proy,'')}}</td>
                <td class="text-right" {{($proyecto['d']['de']>0)?'style=color:red!important;':''}}>{{Money::toMoney(($proyecto['d']['de']>0)?($proyecto['d']['de']*-1):0,'')}}</td>
                <td class="text-right">{{Money::toMoney($proyecto['d']['a'],'')}}</td>
                <td class="text-right">{{Money::toMoney(($proyecto['modif']->pim_proy+($proyecto['d']['a']-$proyecto['d']['de'])),'')}}</td>
                <td class="text-justify">{{ $proyecto['modif']->det_justificacion}}</td>
            </tr>
        @endforeach


        <tr class="info">
            <td class="text-right" colspan="7">Total</td>
            <td class="text-right" {{($total['de']>0)?'style=color:red!important;':''}}>{{Money::toMoney(($total['de']>0)?($total['de']*-1):0,'')}}</td>
            <td class="text-right">{{Money::toMoney($total['a'],'')}}</td>
            <td class="text-justify" colspan="2"></td>
        </tr>
        </tbody>
    </table>
    <table>
            <tbody>
            <tr style="border-left: hidden;border-right: hidden; border-top: hidden;">
                <td colspan="8"><br><br></td>
            </tr>

        <tr class="sin-borde">
            <td colspan="4" style="border-bottom: hidden;">
                <table class="table" style="width: 150px !important;" ">
                    <tr>
                        <td style="border-bottom: hidden;">ECO. John Raul Otayza y Natividad <br>CEHCO N 00486</td>
                    </tr>
                </table></td>
            <td colspan="4" style="border-bottom: hidden;"></td>
        </tr>
        </tbody>

    </table>
    <!--<div class="footer">Page: <span class="pagenum"></span></div>-->
    <div class="header">Impresi&oacute;n generada a las {{$fecha->toTimeString()}} del {{$fecha->format('d/m/Y')}}</div>
</div>
    @endsection
@push('style')
<style>
    table thead tr th{padding: 2px !important;}
    table thead tr.info .x{width: 4%;}
    table thead tr.info .y{width: 20%;}
    table thead tr.info .z{width: 17%;}
    table thead tr.info .w{width: 7%;}

    .table>tbody>tr.info>td{
        border: solid black 1px !important;
    }
    .priorizacion .hid{
        border-top: hidden;
        border-left: hidden;
        border-right: hidden;
    }
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
            font-size: 0.5em;
        }
        .table>thead>tr>th{
            border-color: black !important;
        }
        .table>tbody>tr.info>td{
            border: solid black 1px !important;
        }
        .table>tbody>tr>td{
            border-left-color: black !important;
            border-right-color: black !important;

        }

        .sellos tbody tr td {
            vertical-align: bottom !important;
        }
        .text-justify{text-align: justify!important;}


        .footer{ position: fixed; bottom: 0px; }
        .header{ position: fixed; top: 0px; text-align: right; width: 98%; }
        .breack-page { page-break-after: always; }
    }
    .border{
        border-top:black solid 1px;
        border-left:black solid 1px;
        border-right:black solid 1px;
        border-bottom:black solid 1px;
    }
    .header{ position: fixed; top: 0px; text-align: right; width: 100%; }
</style>
@endpush
@push('scripts')
<script>
    $(document).ready(function () {
        var myCallBack = function() {/*window.close();*/};
        $('#myPrintArea').print({deferred: $.Deferred().done(myCallBack)});
    })
</script>
@endpush