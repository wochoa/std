@extends('layouts.plantillaAdministrador')
@section('titulo') Publicaciones
@endsection
@section('contenido')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="container">
                <ul class="nav nav-tabs card-header-tabs">
                    <router-link to="/administrador/publicaciones" tag="li"><a href="">Explorar Publicaciones</a></router-link>
                    <router-link to="/administrador/publicaciones/create" tag="li" v-if="this.$route.name != 'editComunicacionInterna'"><a href="">Nueva Publicación</a></router-link>
                    <router-link :to="this.$route.path" tag="li" v-if="this.$route.name == 'editComunicacionInterna'"><a href="">Editar Publicación</a></router-link>
                </ul>
            </div>
            <router-view
                route-publicacion="{{route('administrador.comunicacionIntena.index')}}"
                route-guardar="{{route('administrador.comunicacionIntena.store')}}"
                route-get-publicacion="{{route('administrador.comunicacionIntena.show','%s')}}"
                route-print-imagenes="{{route('administrador.comunicacionIntena.printImagenes','%s')}}"
                user-id='{!! Auth::user()->id !!}'
                :limit='{{env("PAGINATION_LIMIT")}}'
            >
            
            </router-view>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/admin.js') }}"></script>
@endpush