
<style>
    .table-analitico tbody{border: solid #9e9c9c;border-width: 2px;}
    .table-analitico tbody tr td {padding: 00px 5px 0px 0px  !important;}
    .table-analitico thead tr th {padding: 0px !important; text-align: center !important;}
    .table-analitico thead tr .money {width: 100px;}
    .table-analitico tbody tr td:last-child {border-right:solid #9e9c9c 2px}
    .table-analitico tbody tr:first-child {border-top:solid #9e9c9c 2px }
    .table-analitico thead tr th{border-width: 1px;}
    .separador {border-left: hidden;border-right:  hidden !important;}
    .separador td {padding: 0px; height: 10px;border-right:  hidden !important; border-top: solid 2px #9e9c9c !important; border-bottom: solid 2px #9e9c9c !important;}
    .border-left { border-left: 2px solid #9e9c9c !important;}
    .border-right { border-right: 2px solid #9e9c9c !important;}
    .media-middle {vertical-align: middle !important;}
</style>
<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-analitico" width="100%">
    <thead>
        <tr>
            <th class="media-middle" rowspan="2">Especifica</th>
            <th class="media-middle" rowspan="2">Observación</th>
            <th colspan="3" class="text-center border-left border-right">MONTO SNIP</th>
            <th class="money media-middle" rowspan="2">Ejecutado</th>
            <th class="money media-middle" rowspan="2">Saldo</th>
            <th class="money media-middle" rowspan="2">Editar</th>
        </tr>
        <tr>
            <th class="money border-left">Inicial</th>
            <th class="money">Modif.</th>
            <th class="money border-right">Vigente</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total=0;
        $total_i=0;
        $total_m=0;
        $total_e=0;
        if(count($analitico)>0){
        $clas='even';
        $a=array_first(array_first($analitico));
        $componente         = $a->ana_componente;
        $componente_text    = (isset($componentes[$a->ana_componente]))?$componentes[$a->ana_componente]:'COMPONENTE DESCONOCIDO';
        $subtotal=0;
        $subtotal_modif=0;
        //dd($analitico);
        foreach($analitico as $d)
        {
            foreach ($d as $id => $dato ){
                $total+=$dato->ana_monto+$dato->ana_modificaciones;
            ?>
                @if($componente!=$dato->ana_componente)
                    <tr class="{{($subtotal>=(isset($ejecucion[$componente])?$ejecucion[$componente]['monto']:0))?'info':'alert-danger'}}">
                        <td colspan="2  ">Total : {{$componente_text. ' ('.$componente.')'}}</td>
                        <td class="text-right border-left">{{Money::toMoney($subtotal,'')}}</td>
                        <td class="text-right">{{Money::toMoney($subtotal_modif,'')}}</td>
                        <td class="text-right border-right">{{Money::toMoney($subtotal+$subtotal_modif,'')}}</td>
                        <td class="text-right">{{Money::toMoney((isset($ejecucion[$componente])?$ejecucion[$componente]['monto']:0),'')}}</td>
                        <td class="text-right">{{Money::toMoney($subtotal+$subtotal_modif-(isset($ejecucion[$componente])?$ejecucion[$componente]['monto']:0),'')}}</td>
                        <td></td>
                    </tr>
                    <tr class="separador"><td colspan="8"></td>
                    <?php
                    $componente         = $dato->ana_componente;
                    $componente_text    = isset($componentes[$dato->ana_componente])?$componentes[$dato->ana_componente]:'UNKNOW';
                    $total_i+=$subtotal;
                    $total_m+=$subtotal_modif;
                    $subtotal=0;
                    $subtotal_modif=0;
                    ?>
                @endif
                <?php
                $subtotal+=$dato->ana_monto;
                $subtotal_modif+=$dato->ana_modificaciones;
                $isclass =get_class ($dato)=='App\_clases\proyectos\analitico\Analitico';
                $icon = ($isclass)?'pencil':'plus';
                $ejecutado = isset($ejecucion[$dato->ana_componente])?(isset($ejecucion[$dato->ana_componente][$dato->ana_especifca])?$ejecucion[$dato->ana_componente][$dato->ana_especifca]:0):0;
                $total_e+=$ejecutado;
                ?>
                    <tr {{(!$isclass)?'style=color:red;':''}}>
                        <td>{!!(isset($espeficicas[$dato->ana_especifca]))?$espeficicas[$dato->ana_especifca]:$elemento[$dato->ana_especifca].'         <strong>(Clasificador antiguo)</strong'!!}</td>
                        <td>{{$dato->ana_descricion}}</td>
                        <td class="text-right border-left">{{Money::toMoney($dato->ana_monto,'')}}</td>
                        <td class="text-right">{{Money::toMoney($dato->ana_modificaciones,'')}}</td>
                        <td class="text-right border-right">{{Money::toMoney($dato->ana_monto+$dato->ana_modificaciones,'')}}</td>
                        <td class="text-right">{{Money::toMoney($ejecutado,'')}}</td>
                        <td class="text-right">{{Money::toMoney($dato->ana_monto+$dato->ana_modificaciones-$ejecutado,'')}}</td>
                        <td class="text-center">
                                {!!  sprintf('
                                <a href="#"  class="btn btn-default edit"  data-data="%s"><i class="glyphicon glyphicon-%s"></i></a>',
                                htmlentities(json_encode($dato)),
                                $icon)!!}
                            @if($isclass)
                            {!!  sprintf('
                                <a href="#" class="btn btn-default delete"  data-id="%s"><i class="glyphicon glyphicon-trash"></i></a>',
                                $dato->analitico_id)!!}
                                @endif
                        </td>
                    </tr>
                <?php
            }
        }?>

        <tr class="info">
            <td colspan="2  ">Total : {{$componente_text. ' ('.$componente.')'}}</td>
            <td class="text-right border-left">{{Money::toMoney($subtotal,'')}}</td>
            <td class="text-right">{{Money::toMoney($subtotal_modif,'')}}</td>
            <td class="text-right border-right">{{Money::toMoney($subtotal+$subtotal_modif,'')}}</td>
            <td class="text-right">{{Money::toMoney(isset($ejecucion[$componente])?$ejecucion[$componente]['monto']:0,'')}}</td>
            <td>{{Money::toMoney($subtotal+$subtotal_modif-(isset($ejecucion[$componente])?$ejecucion[$componente]['monto']:0),'')}}</td>
            <td></td>
        </tr>
        @php
            $total_i+=$subtotal;
            $total_m+=$subtotal_modif;
        @endphp
        <tr class="separador"><td colspan="8"></td>
        <tr class="info">
            <td colspan="2">TOTAL PROYECTO</td>
            <td class="text-right border-left">{{Money::toMoney($total_i,'')}}</td>
            <td class="text-right">{{Money::toMoney($total_m,'')}}</td>
            <td class="text-right border-right">{{Money::toMoney($total_i+$total_m,'')}}</td>
            <td class="text-right">{{Money::toMoney($total_e,'')}}</td>
            <td class="text-right">{{Money::toMoney($total_i+$total_m-$total_e,'')}}</td>
            <td></td>
        </tr>
        <?php
        } else {?>
        <tr class="odd gradeX">
            <td colspan="8"><center>
                    No existen Datos en el Analitico Cargados para este proyecto
                </center></td>
        </tr>
        <?php }?>
        <tr class="separador"><td colspan="8"></td>
        <tr class="">
            <td colspan="4">Monto PIP.</td>
            <td colspan="2" style="border-right:none;">{{Money::toMoney($proyecto->proy_pip_actualizado)}}</td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr class="">
            <td colspan="4">Total Programado.</td>
            <td colspan="2" style="border-right:none;">{{Money::toMoney($total)}}</td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr class="">
            <td colspan="4">Total Ejecutado GOREHCO.</td>
            <td colspan="2" style="border-right:none;">{{Money::toMoney($total_e)}}</td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr class="">
            <td colspan="4">Total Ejecutado OTRAS UNIDADES EJECUTORAS.</td>
            <td colspan="2" style="border-right:none;">{{Money::toMoney($proyecto->proy_ejecucion_otras_ejecutoras)}}</td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr class="{{($proyecto->proy_pip_actualizado-$proyecto->proy_ejecucion_otras_ejecutoras>=$total)?'':'alert-danger'}}">
            <td colspan="4">Saldo por programar.</td>
            <td colspan="2" style="border-right:none;">{{Money::toMoney($proyecto->proy_pip_actualizado-$proyecto->proy_ejecucion_otras_ejecutoras-$total)}}</td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr class="{{($total>=$total_e)?'active':'alert-danger'}}">
            <td colspan="4">Saldo por Ejecutar.</td>
            <td colspan="2" style="border-right:none;">{{Money::toMoney($total-$total_e)}}</td>
            <td colspan="2">&nbsp;</td>
        </tr>
    </tbody>
</table>