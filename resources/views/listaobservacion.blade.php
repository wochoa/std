@extends('layouts.tema')

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12 ">

            
            <div class="panel panel-default mt-2">

                <div class="panel-heading">Tramites Observados</div>

                <div class="panel-body">
                    
                    <div class="row">
                    
                   <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>N</th>
                                    <th>DNI/RUC</th>
                                    <th>DOCUMENTO</th>
                                    <th>FIRMANTE</th>
                                    <th>MOTIVO OBS</th>
                                    <th>FECHA OBS</th>
                                    <th nowrap>Link para subsanar</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach($externo as $ext)
                                    <tr>
                                        <td><small>{{$ext->id}}</small></td>
                                        <td>
                                        <small>
                                        @if($ext->docu_dni)
                                            {{$ext->docu_dni}}
                                            @else
                                            {{$ext->docu_ruc}}
                                            @endif
                                        </small>
                                        </td>
                                        <td><small>{{$ext->docu_numero_doc}}-{{$ext->docu_siglas_doc}}</small></td>
                                        <td>
                                            <small>
                                            {{$ext->docu_firma}} <br>
                                            <span class="badge bg-primary text-sm"><small>{{$ext->docu_telef}}</small></span><br>
                                            <span class="badge bg-info text-sm"><small>{{$ext->docu_emailorigen}}</small></span>
                                            </small>
                                        </td>
                                        <td>
                                            @if($ext->docu_motivo_archivamiento)
                                            <small>
                                            {{$ext->docu_motivo_archivamiento}} 
                                            </small>

                                            @else
                                             <p class="text-center">
                                             <span class="badge bg-success text-sm"><small>No presenta observación</small></span>
                                             </p>
                                            @endif
                                           
                                        </td>
                                        <td nowrap>
                                            <small>
                                                {{$ext->updated_at}}  
                                            </small>
                                        </td>
                                        <td>
                                            @if($ext->iddocumento)
                                            <p><small><strong>Reg. Doc:</strong> <a href="http://digital.regionhuanuco.gob.pe/tramite/buscar/buscarModal/{{$ext->iddocumento}}">{{$ext->iddocumento}} </a><br>
                                            <strong>Reg. Exp:</strong> <a href="http://digital.regionhuanuco.gob.pe/tramite/buscar/buscarExpedienteModal/{{$ext->docu_idexma}}" target="_blank">{{$ext->docu_idexma}} </a> </small></p>
                                            
                                            @else
                                            <small><a href="http://digital.regionhuanuco.gob.pe/registro/mesa-partes-virtual/{{$ext->id_dependencia}}/{{$ext->docu_token}}"target="_blank" class="btn btn-danger btn-sm">Subsanar</a></small>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                        {{ $externo->links() }}
                   </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
