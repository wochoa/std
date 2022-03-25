@extends('layouts.plantillaVue')
@section('titulo')
    Nuevo| Unidades Orgánicas
@endsection
@section('contenido')
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    <ul class="nav nav-tabs card-header-tabs">
                        <router-link to="/tramite/administrador/unidades" tag="li"><a href="">Explorar Unidades Orgánicas</a></router-link>
                        <router-link to="/tramite/administrador/unidades/create" tag="li" v-if="this.$route.name != 'AdminUnidadOrganicaEdit'"><a href="">Nuevo Unidad Orgánica</a></router-link>
                        <router-link :to="this.$route.path" tag="li" v-if="this.$route.name == 'AdminUnidadOrganicaEdit'"><a href="">Editar Unidad Orgánica</a></router-link>
                    </ul>
                </div>
                <router-view
                    route-unidad="{{route('tramite.unidades.index')}}"
                    route-guardar="{{route('tramite.unidades.store')}}"
                    route-get-unidad="{{route('tramite.unidades.show','%s')}}"
                    route-webservice-dni="{{env('DNI_WEBSERVICE')}}"
                    :tipo="{!! 1 !!}"
                    :limit='{{env("PAGINATION_LIMIT")}}'
                >
                </router-view>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/unidad.js') }}"></script>
@endpush
