    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" width="100%">
        <thead>
            <tr>
                <th>Documento</th>
                <th>SISGEDO</th>
                <th>Fecha</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
        @if(count($documentos)>0)
        @foreach($documentos as $documento)
            <tr>
                <td>{{$documento->doc_documento}}</td>
                <td>{{sprintf("%08s",$documento->doc_reg_sisgedo)}}</td>
                <td>{{$documento->doc_fecha}}</td>
                <td>
                    <a href="#" class="edit" data-data="{{json_encode($documento)}}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    <br>
                    <a href="{{route('proyectos.herramientas.certificar.solicitud.index',[$anio,$documento->id])}}"><i class="glyphicon glyphicon-list-alt"></i> Listar</a></td>
            </tr>
        @endforeach
        @else
        <tr>
            <td colspan="2" class="text-center">No existen documentos</td>
        </tr>
        @endif
        </tbody>
    </table>