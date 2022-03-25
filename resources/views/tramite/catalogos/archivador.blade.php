@extends('layouts.plantillaVue')

@section('titulo')
    Nuevo| Archivador
@endsection

@section('contenido')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    <ul class="nav nav-tabs card-header-tabs">
                        <router-link to="/tramite/catalogo/archivador" tag="li"><a href="">Explorar Archivador</a></router-link>
                        <router-link to="/tramite/catalogo/archivador/create" tag="li" v-if="this.$route.name != 'CataArchivadorEdit'"><a href="">Nuevo Archivador</a></router-link>
                        <router-link :to="this.$route.path" tag="li" v-if="this.$route.name == 'CataArchivadorEdit'"><a href="">Editar Archivador</a></router-link>
                    </ul>
                </div>
                
                <router-view
                    route-archivador="{{route('tramite.archivador.index')}}"
                    route-guardar="{{route('tramite.archivador.store')}}"
                    route-get-archivador="{{route('tramite.archivador.show','%s')}}"
                    :limit='{{env("PAGINATION_LIMIT")}}'
                >
                </router-view>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/archivadores.js') }}"></script>
@endpush
