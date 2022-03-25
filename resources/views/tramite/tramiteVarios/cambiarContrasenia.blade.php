@extends('layouts.plantillaVue') 
@section('titulo') Cambiar| Contraseña
@endsection 
@section('contenido')

<div class="container" id="app">
        <admin-cambiar-contrasenia
            route-inicio="{{route('tramite.inicio')}}"
            route-user="{{route('tramite.usuarios.cambiarContrasenia')}}"
            route-principal="{{route('principal')}}"
            route-webservice-dni="{{route('tramite.persona.dni','%s')}}"
            :user='{{$user}}'
            :tipo='{!! 2 !!}'
        >
        </admin-cambiar-contrasenia>
    </div>
@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/usuarios.js') }}"></script>
@endpush