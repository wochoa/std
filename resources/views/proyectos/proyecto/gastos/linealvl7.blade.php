@foreach($gastos as $id=>$d)
    @php($lvl=$class.'-'.$id)
<tr class="gradeU odd {{$lvl}}" data-level="{{$nivel}}" data-status="0" data-class="{{$lvl}}">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="text-align:right"></td>
    <td colspan="12">
        <strong>Expediente SIAF:</strong>{{$d->expediente}}
        <strong>Fecha:</strong> {{$d->fecha}}
        <strong>Monto:</strong> {{Money::toMoney($d->monto_dev)}}<br>
        @if($d->proveedor!=' - ')
        <strong>Proveedor:</strong> {{$d->proveedor}}<br>
        @endif

        <strong>Cp's:</strong> {{$d->cps}}<br>
        <strong>Concepto:</strong> {{$d->nota_c}}<br>
        <a href='#' class='s_more' data-status='0'>Ver nota completa...</a>
        <div class='hidden'><br>
            <strong>Notas del Devengado -</strong>{{$d->nota_d}}<br><br>
            <strong>Notas del Girado -</strong>{{$d->nota_g}}</div>
    </td>
    <td {{($hoy->month==1)?'class=c_m':''}}>{{Money::toMoney($d->g_1,'')}}<div class="prg"></div></td>
    <td {{($hoy->month==2)?'class=c_m':''}}>{{Money::toMoney($d->g_2,'')}}<div class="prg"></div></td>
    <td {{($hoy->month==3)?'class=c_m':''}}>{{Money::toMoney($d->g_3,'')}}<div class="prg"></div></td>
    <td {{($hoy->month==4)?'class=c_m':''}}>{{Money::toMoney($d->g_4,'')}}<div class="prg"></div></td>
    <td {{($hoy->month==5)?'class=c_m':''}}>{{Money::toMoney($d->g_5,'')}}<div class="prg"></div></td>
    <td {{($hoy->month==6)?'class=c_m':''}}>{{Money::toMoney($d->g_6,'')}}<div class="prg"></div></td>
    <td {{($hoy->month==7)?'class=c_m':''}}>{{Money::toMoney($d->g_7,'')}}<div class="prg"></div></td>
    <td {{($hoy->month==8)?'class=c_m':''}}>{{Money::toMoney($d->g_8,'')}}<div class="prg"></div></td>
    <td {{($hoy->month==9)?'class=c_m':''}}>{{Money::toMoney($d->g_9,'')}}<div class="prg"></div></td>
    <td {{($hoy->month==10)?'class=c_m':''}}>{{Money::toMoney($d->g_10,'')}}<div class="prg"></div></td>
    <td {{($hoy->month==11)?'class=c_m':''}}>{{Money::toMoney($d->g_11,'')}}<div class="prg"></div></td>
    <td {{($hoy->month==12)?'class=c_m':''}}>{{Money::toMoney($d->g_12,'')}}<div class="prg"></div></td>
</tr>
@endforeach