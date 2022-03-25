@extends('layouts.proyectos.reporte')
@section('content')
<div class="container-fluid">
    <div style="height: 0.5px;">.</div>
    <table class="table modif" style="padding: 15px; border: black 1px solid !important;/*page-break-after: always;*/">
        <thead style="display: table-header-group">
            <tr class="sin-borde">
                <th colspan="13" class="text-center"><h1></h1></th>
            </tr>
            <tr class="sin-borde">
                <th colspan="13" class="text-center"><h4>{{$modificatoria->modif_titulo}}</h4></th>
            </tr>
            <tr class="sin-borde">
                <th colspan="3" class="text-left subtitle">PLIEGO</th>
                <th colspan="10" class="text-left subtitle">: 448 GOBIERNO REGIONAL HUANUCO</th>
            </tr>
            <tr class="sin-borde">
                <th colspan="3" class="text-left subtitle">FTE. DE FTO.</th>
                <th colspan="10" class="text-left subtitle">: {{$fuenteFinanciamiento}}</th>
            </tr>
            <tr class="info">
                <th rowspan="2" class="v">PROG</th>
                <th rowspan="2" class="x">PROD / PROY</th>
                <th rowspan="2" class="x">ACT / AL / OBRA</th>
                <th rowspan="2" class="v">FUNC</th>
                <th rowspan="2" class="v">DIV FUNC.</th>
                <th rowspan="2" class="v">GRUP FUNC.</th>
                <th rowspan="2" class="v">SEC/ FUNC.</th>
                <th rowspan="2" class="x">FINALI DAD</th>
                <th colspan="2">LOC</th>
                <th rowspan="2" class="w">ESP DE GASTO</th>
                <th rowspan="2" class="w">PIM</th>
                <th colspan="2">MODIFICACIONES</th>
                <th rowspan="2" class="w">PIM</th>
                <th rowspan="2" class="z">JUSTIFICACION</th>
            </tr>
            <tr class="info">
                <th class="w">DE</th>
                <th class="w">A</th>
            </tr>
        </thead>
        <tbody>
        @foreach($modificaciones as $proyecto)
            <tr class="info">
                <td class="text-justify" colspan="11">{{$proyecto['modif']->proy_nombre}}</td>
                <td class="text-right"></td>
                <td class="text-right">{{Money::toMoney($proyecto['d']['de'],'')}}</td>
                <td class="text-right">{{Money::toMoney($proyecto['d']['a'],'')}}</td>
                <td class="text-right"></td>
                <td class="text-justify">{{ false ? $proyecto['modif']->det_justificacion:''}}</td>
            </tr>
            <?php $curr_comp_act_al_obra=0; $printed=true;?>
            @foreach($proyecto as $id_proy =>$modificacion)
                @if($id_proy!='d'&&$id_proy!='modif')

                    @if($modificacion->sec_func==null&&($curr_comp_act_al_obra!=$modificacion->comp_act_al_obra&&$curr_comp_act_al_obra!=0))
                        <?php $printed=true;?>
                        <tr>
                            <td class="text-center" colspan="2"></td>
                            <td class="text-center" colspan="4" style="margin: 0px !important;padding: 0px !important;">
                                <table class="table" style="border: black solid 1px; margin: 0px !important;    ">
                                    <tr class="info">
                                        <td class="text-center border">UM</td>
                                        <td class="text-center border">SEM</td>
                                        <td class="text-center border">AN</td>
                                    </tr>
                                    <tr>
                                        <td class="border"><br></td>
                                        <td class="border"></td>
                                        <td class="border"></td>
                                    </tr>
                                </table>
                            </td>
                            <td class="text-center" colspan="7"></td>
                        </tr>
                    @endif
                    @if($modificacion->sec_func==null)
                        <?php $curr_comp_act_al_obra=$modificacion->comp_act_al_obra;$printed=false;?>
                    @endif
            <tr>
                <td class="text-center">{{sprintf("%04s",$modificacion->comp_programa)}}</td>
                <td class="text-center">{{$modificacion->comp_prod_proy}}</td>
                <td class="text-center">{{$modificacion->comp_act_al_obra}}</td>
                <td class="text-center">{{$modificacion->comp_funcion}}</td>
                <td class="text-center">{{sprintf("%03s",$modificacion->comp_division_funcional)}}</td>
                <td class="text-center">{{sprintf("%04s",$modificacion->comp_grupo_funcional)}}</td>
                <td class="text-center">{{($modificacion->sec_func!=null)?sprintf("%04s",$modificacion->sec_func):'NNNN'}}</td>
                <td class="text-center">{{sprintf("%07s",$modificacion->comp_finalidad)}}</td>
                <!--<td class="text-justify">{{1/*$modificacion->proy_nombre*/}}</td>-->
                <td class="text-center">{{$modificacion->especifica}}</td>
                <td class="text-right">{{Money::toMoney($modificacion->pim,'')}}</td>
                <td class="text-right">{{Money::toMoney($modificacion->det_de,'')}}</td>
                <td class="text-right">{{Money::toMoney($modificacion->det_a,'')}}</td>
                <td class="text-right">{{Money::toMoney($modificacion->det_nuevo_pim,'')}}</td>
                <td class="text-justify">{{$modificacion->det_justificacion}}</td>
            </tr>
                @endif
            @endforeach
            @if(!$printed)
                <?php $printed=true;?>
                <tr>
                    <td class="text-center" colspan="2"></td>
                    <td class="text-center" colspan="4" style="margin: 0px !important;padding: 0px !important;">
                        <table class="table" style="border: black solid 1px; margin: 0px !important; width: 100% !important; ">
                            <tr class="info">
                                <td class="text-center border">UM</td>
                                <td class="text-center border">SEM</td>
                                <td class="text-center border">AN</td>
                            </tr>
                            <tr>
                                <td class="border"><br></td>
                                <td class="border"></td>
                                <td class="border"></td>
                            </tr>
                        </table>
                    </td>
                    <td class="text-center" colspan="10"></td>
                </tr>
            @endif
        @endforeach

        </tbody>
    </table>
    <table>
        <tbody>
        <tr style="border-left: hidden;border-right: hidden; border-top: hidden;">
            <td colspan="8"><br><br></td>
        </tr>
        <tr class="sin-borde">
            <td colspan="6"></td>
            <td colspan="2" class="text-left">
                <table class="table" cellspacing="0" style="width: 150px!important;">
                    <tr>
                        <td colspan="2" class="text-center prio" style="border: solid 1px black; font-size: 1.4em !important;"><strong>PRIORIZACION</strong></td>
                    </tr>
                    @foreach($priorizaciones as $priorizacion)
                        @if($priorizacion->monto>0)
                        <tr class="priorizacion">
                            <td style="border: solid 1px black"><strong>{{$priorizacion->especifica}}</strong></td>
                            <td class="text-right" style="border: solid 1px black"><strong>{{Money::toMoney($priorizacion->monto,'')}}</strong></td>
                        </tr>
                        @endif
                    @endforeach
                </table>
            </td>
        </tr>

        <tr class="sin-borde">
            <td colspan="4" style="border-bottom: hidden;">
                <table class="table" style="width: 150px !important;">
                    <tr>
                        <td style="border-bottom: hidden;">AAAA <br>CEHCO N 00486</td>
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

    table thead tr.info .v{width: 30px;}
    table thead tr.info .w{width: 50px;}
    table thead tr.info .x{width: 50px;}
    table thead tr.info .y{width: 25px;font-size: 7px !important;}
    table thead tr.info .z{width: 400px;}

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

        @page {
            size: auto;
            margin-top: 0.2in;
            margin-bottom: 0.75in;
        }

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
        //$('#myPrintArea').print({deferred: $.Deferred().done(myCallBack)});
    })
</script>
@endpush
