    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" width="100%">
        <thead>
            <tr>
                <th>Meta</th>
                <th>Especifica</th>
                <th>FFT</th>
                <th>Cert</th>
                <th>PIA</th>
                <th>PIM</th>
                <th>Monto Certificado</th>
                <th>Saldo por Certificar</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
        @foreach($arr as $sec_func=>$value)
            <tr>
                <td>{{$sec_func}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{$value['d']['pia']}}</td>
                <td>{{$value['d']['pim']}}</td>
                <td>{{$value['d']['monto_cert']}}</td>
                <td>{{$value['d']['pim']-$value['d']['monto_cert']}}</td>
                <td></td>
            </tr>
            @foreach($value as $esp=>$value_esp)
                @if($esp!='d'&&$value_esp['d']['pim']>0)
                    <tr>
                        <td></td>
                        <td>{{$value_esp['d']['ESPECIFICA']}}</td>
                        <td></td>
                        <td></td>
                        <td>{{$value_esp['d']['pia']}}</td>
                        <td>{{$value_esp['d']['pim']}}</td>
                        <td>{{$value_esp['d']['monto_cert']}}</td>
                        <td>{{$value_esp['d']['pim']-$value_esp['d']['monto_cert']}}</td>
                        <td></td>
                    </tr>
                    @foreach($value_esp as $fft=>$value_fft)
                        @if($fft!='d'&&$value_fft['d']['pim']>0)
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{$fft}}</td>
                                <td></td>
                                <td>{{$value_fft['d']['pia']}}</td>
                                <td>{{$value_fft['d']['pim']}}</td>
                                <td>{{$value_fft['d']['monto_cert']}}</td>
                                <td>{{$value_fft['d']['pim']-$value_fft['d']['monto_cert']}}</td>
                                <td>@if($value_fft['d']['pim']-$value_fft['d']['monto_cert']>0)
                                        <?php
                                        $value_fft['d']['d']['solc_saldo_por_certificar']=$value_fft['d']['pim']-$value_fft['d']['monto_cert']
                                        ?>
                                        <a href="#" class="edit" data-data="{{json_encode($value_fft['d']['d'])}}">Certificar</a>
                                    @endif
                                </td>
                            </tr>
                            @foreach($value_fft as $cert=>$value_cert)
                                @if($cert!='d'&&$value_fft['d']['pim']>0)
                                    <tr class="alert-info">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td colspan="3">{{$cert}}</td>
                                        <td>{{$value_cert['d']['monto_cert']}}</td>
                                        <td>{{$value_fft['d']['pim']-$value_fft['d']['monto_cert']}}</td>
                                        <td>
                                            @if($value_fft['d']['pim']-$value_fft['d']['monto_cert']>0)
                                                <?php
                                                    $dat=$value_fft['d']['d'];
                                                $dat['solc_certificado']=$cert;
                                                $dat['solc_saldo_por_certificar']=$value_fft['d']['pim']-$value_fft['d']['monto_cert'];
                                                $dat['solc_justificacion']=$value_cert['d']['glosa'];
                                                $dat['solc_id_clasif']=$esp;
                                                ?>
                                                <a href="#" class="edit" data-data="{{json_encode($dat)}}" data-cert="{{$cert}}">Ampliar</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                @endif
            @endforeach
        @endforeach
        </tbody>
    </table>