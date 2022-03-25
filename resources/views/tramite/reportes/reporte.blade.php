@extends('layouts.plantillaVue')

@section('titulo')
    Reporte
@endsection

@section('estilo')
@parent
@endsection


@section('contenido')
    <div class="container">
        
        
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">REPORTES</div>
                <div class="panel-body">
                <buscar-reporte
                route-user="{{route('tramite.usuarios.obtenerUserDependenciaActivo')}}?tipo=4"
                route-archivador="{{route('tramite.archivador.obtenerArchivadores')}}?tipo=3"
                route-reporte="{{route('tramite.reporte.obtenerReporte')}}"
                titulo="{{env('TITULO_PAGINA')}}"
                :opciones='{!! json_encode($opciones) !!}'
                :tipo='{!! 1 !!}'
                >
                </buscar-reporte>
                </div>
            </div> 
        </div>
    
       
    </div> 

@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/reporte.js') }}"></script>
@endpush

