@extends('layouts.plantillaVue')

@section('titulo')
    Nuevo| Tipo Prioridad
@endsection


@section('contenido')
    <div class="container" id="app">
        <cata-prioridades
            route-prioridad="{{route('tramite.prioridades.index')}}"
        >
        </cata-prioridades>                   
    </div>
@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/prioridades.js') }}"></script>
@endpush
