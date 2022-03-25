@extends('layouts.plantillaVue')

@section('titulo')
    Nuevo| Correlativos
@endsection

@section('contenido')
    <div class="container" id="app">
        <admin-correlativo
            route-correlativo="{{route('tramite.correlativos.index')}}"
            route-user="{{route('tramite.usuarios.obtenerUserDependenciaActivo')}}?tipo=4"
            route-update="{{route('tramite.correlativos.update','%s')}}"
            :limit='{{env("PAGINATION_LIMIT")}}'
            :tipo-correlativos='{!! 1 !!}'
        >
        </admin-correlativo>
    </div>

@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/correlativos.js') }}"></script>
@endpush
