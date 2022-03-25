@extends('layouts.plantillaVue')
@section('titulo')
    Nuevo|Dependencias
@endsection
@section('contenido')
<div class="container-fluid" id="app">
    <div class="row">
        <div class="col-sm-12">
            
            <admin-dependencia-nuevo
                route-dependencia="{{route('tramite.dependencias.index')}}"
                route-guardar="{{route('tramite.dependencias.store')}}"
                route-get-dependencia="{{route('tramite.dependencias.show','%s')}}"                
                :tipo="{!! 2 !!}"
                :dependencia-sede='{!! $dependencia !!}'
                :limit='{{env("PAGINATION_LIMIT")}}'
            >
            </admin-dependencia-nuevo>
            
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/dependencias.js') }}"></script>
@endpush