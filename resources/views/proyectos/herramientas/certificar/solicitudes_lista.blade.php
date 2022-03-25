
<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" width="100%">
    <thead>
    <tr>
        <th>Meta</th>
        <th>Especifica</th>
        <th>FFT</th>
        <th>Cert</th>
        <th>PIA</th>
        <th>PIM</th>
        <th>Monto Solicitado</th>
        <th>Accion</th>
    </tr>
    </thead>
    <tbody>
    @foreach($solicitudes as $solicitud)
        <tr class="alert-info">
            <td>{{$solicitud->solc_sec_func}}</td>
            <td></td>
            <td>{{$solicitud->solc_fuente_financiamiento}}</td>
            <td>{{$solicitud->solc_certificado}}</td>
            <td>{{$solicitud->solc_pia}}</td>
            <td>{{$solicitud->solc_pim}}</td>
            <td>{{$solicitud->solc_certificacion}}</td>
            <td>
                <a href="#" class="print" data-id="{{$solicitud->id}}">Imprimir</a>
                <br>
                <a href="#" class="edit" data-data="{{json_encode($solicitud)}}">Editar</a>
                <br>
                <a href="#" class="delete" data-id="{{$solicitud->id}}">Eliminar</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>