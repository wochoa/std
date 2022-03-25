@extends('layouts.plantillaVue')
@section('titulo') 
    Documentos | Archivados 
@endsection @section('contenido')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-group">
                <div class="panel panel-primary">
                    <div class="panel-heading">DOCUMENTOS ARCHIVADOS</div>
                    <docu-archivado
                    route-archivado="{{route('tramite.documento.archivados')}}"
                    route-devolver="{{route('tramite.documento.devolverProceso')}}"
                    route-print-pdf="{{route('tramite.documento.printPdf','%s')}}"
                    route-usuarios-dependencia="{{route('tramite.usuarios.obtenerUserDependenciaActivo')}}?tipo=3"
                    route-archivadores="{{route('tramite.archivador.obtenerArchivadores')}}?tipo=2"
                    :usuario='{!! Auth::user()->id !!}'
                    :limit='{{env("PAGINATION_LIMIT")}}'
                    >
                    </docu-archivado>
                </div>                
                <!--finpanel-->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/archivados.js') }}"></script>
@endpush