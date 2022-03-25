@extends('layouts.plantillaVue')
@section('titulo')
    Nuevo|Dependencias
@endsection
@section('contenido')
<div class="container-fluid" id="app">
    <div class="row">
        <div class="col-sm-12">
            <div class="container">
                <ul class="nav nav-tabs card-header-tabs">
                    <router-link to="/tramite/administrador/dependencias" tag="li"><a href="">Explorar Dependencia</a></router-link>
                    <router-link to="/tramite/administrador/dependencias/create" tag="li" v-if="this.$route.name != 'AdminDependenciaEdit'"><a href="">Nueva Dependencia</a></router-link>
                    <router-link :to="this.$route.path" tag="li" v-if="this.$route.name == 'AdminDependenciaEdit'"><a href="">Editar Dependencia</a></router-link>
                </ul>
            </div>
            <router-view
                route-dependencia="{{route('tramite.dependencias.index')}}"
                route-guardar="{{route('tramite.dependencias.store')}}"
                route-get-dependencia="{{route('tramite.dependencias.show','%s')}}"                
                :tipo="{!! 1 !!}"
                :limit='{{env("PAGINATION_LIMIT")}}'
            ></router-view>
            
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/dependencias.js') }}"></script>
@endpush