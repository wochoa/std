@foreach($gastos as $id=>$d)
    @php($lvl=$class.'-'.$id)
<tr class="gradeU lvl_6 {{$lvl}}" data-level="{{$nivel}}" data-status="0" data-class="{{$lvl}}">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="text-align:right">@if($d->monto_dev>0)
            <button type="button" class="ejec_plus btn btn-xs btn-link glyphicon glyphicon-plus"></button>
        @endif
    </td>
    <td colspan="10">
        <strong>Compromiso:</strong> {{$d->compromiso}}<br>
        <strong>Monto:</strong> {{Money::toMoney($d->monto_comp)}}<br>
        <strong>Concepto:</strong> {{$d->concepto}}</td>
    <td style="border-left: solid #000 2px;">{{Money::toMoney($d->monto_dev,'')}}</td>
    <td>{{($d->monto_comp>0)?Money::toMoney($d->monto_comp-$d->monto_dev,''):''}}</td>
    <td style="border-right: solid #000 2px;">{{($d->monto_comp>0)?Money::porcentaje($d->monto_dev/$d->monto_comp):''}}</td>
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