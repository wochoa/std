    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" width="100%">
        <thead>
            <tr>
                <th>Sec</th>
                <th>Estado</th>
                <th>Cadena</th>
                <th>Especifica</th>
                <th>DOCUMENTO</th>
                <th>Cert Actual</th>
                <th>Saldo por Certificar</th>
                <th>Monto Solicitado</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
        @foreach($arr as $anio =>$d_anio)
            @foreach($d_anio as $corr=>$d_corr)
                @foreach($d_corr as $meta=>$d_meta)
                    @foreach($d_meta as $esp=>$d_esp)
            <tr class=" alert alert-{{($d_esp['c']->ESTADO_REG=='A')?'info':'warning'}}">
                <td>{{$corr}}</td>
                <td>{{$d_esp['c']->ESTADO_REG}} <br>{{$d_esp['c']->FECHA}}</td>
                <td>{{$d_esp['c']->SEC_FUNC}}</td>
                <!--<td>{{$d_esp['c']->cadena_fun}}</td>-->
                <td>{{$d_esp['c']->ESPECIFICA}}</td>
                <td>{{$d_esp['c']->NUM_DOC}}</td>
                <td>{{$monto_cert=($d_esp['c']->monto_cert>$d_esp['c']->MONTO)?$d_esp['c']->monto_cert-$d_esp['c']->MONTO:0}}</td>
                <td>{{$d_esp['c']->pim-$monto_cert}}</td>
                <td>{{$d_esp['c']->MONTO}}</td>
                <td>{{ Form::label('inc_sol_'.$anio.$meta.$esp, 'Incluir') }}
                    {{Form::checkbox('inc_sol_'.$anio.$meta.$esp,0,($d_esp['c']->id!=-1), ['class'=>'inc_sol', 'data-data'=>json_encode($d_esp['c'])])}}</td>
            </tr>
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
        </tbody>
    </table>