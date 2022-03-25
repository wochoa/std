    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" width="100%">
        <thead>
            <tr>
                <th>Certificado</th>
                <th>Sec Func</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
        @if(count($solicitudes)>0)
        @foreach($solicitudes as $solicitud)
            <tr>
                <td>{{$solicitud->solc_certificado}}</td>
                <td>{{$solicitud->solc_sec_func}}</td>
                <td>
                    <a href="#" class="edit" data-data="{{json_encode($solicitud)}}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    <br>
                    <a href="#" class="delete" data-id="{{$solicitud->id}}"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
                    <br>
                    <a href="{{route('proyectos.herramientas.certificar.detalle.index',[$anio,$doc,$solicitud->id] )}}"><i class="glyphicon glyphicon-list-alt"></i> Detalle</a>
                    <br>
                    <a href="#" class="print" data-id="{{$solicitud->id}}"><i class="glyphicon glyphicon-print"></i> Imprimir</a>
                </td>
            </tr>
        @endforeach
        @else
        <tr>
            <td colspan="3" class="text-center">No existen Solicitudes</td>
        </tr>
        @endif
        </tbody>
    </table>