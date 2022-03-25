@extends('layouts.plantillaVue')
@section('titulo') Buscar
@endsection 
@section('contenido')
    <buscador-doc
    route-user="{{route('tramite.usuarios.obtenerUserDependenciaActivo')}}?tipo=4"
    route-buscar-doc="{{route('tramite.buscar.index')}}"
    :limit='{{env("PAGINATION_LIMIT")}}'
    >
    </buscador-doc>
@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/buscar.js') }}"></script>
@endpush
