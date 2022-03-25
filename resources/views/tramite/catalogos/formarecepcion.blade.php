@extends('layouts.plantillaVue')

@section('titulo')
    Nuevo| Forma Recepción
@endsection


@section('contenido')
    <div class="container" id="app">
        <cata-recepcion
            route-recepcion="{{route('tramite.recepciones.index')}}"
        >
        </cata-recepcion>
    </div>

@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/prioridades.js') }}"></script>
@endpush
