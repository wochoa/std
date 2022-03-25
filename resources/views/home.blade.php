@extends('layouts.plantillaVue')

@section('titulo')
    Home
@endsection

@section('contenido')
    <div id="inicio" class="TramiteInicio">
        
        @php
        
        $routes=[
            'tramite.enproceso.index'           =>(Object)['route'=>route('tramite.enproceso.index')],
            'tramite.recibir.index'             =>(Object)['route'=>route('tramite.recibir.index')],
            'tramite.archivado.index'           =>(Object)['route'=>route('tramite.archivado.index')],
            'tramite.view.plantilla'            =>(Object)['route'=>route('tramite.view.plantilla')],
            'tramite.view.docs.generados'       =>(Object)['route'=>route('tramite.view.docs.generados')],
            'tramite.buscador'                  =>(Object)['route'=>route('tramite.buscador')],
            'tramite.cambiarContrasenia'        =>(Object)['route'=>route('tramite.cambiarContrasenia')],
        ];
        @endphp
        <tramite-inicio :routes="{{json_encode($routes)}}" />
    </div>
@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/inicio.js') }}"></script>
@endpush
