@extends('layouts.plantillaVue')

@section('titulo')
    Nuevo| Tipo Documento
@endsection

@section('contenido')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    <ul class="nav nav-tabs card-header-tabs">
                        <router-link to="/tramite/catalogo/tipoDocumento" tag="li"><a href="">Explorar Tipos de Documentos</a></router-link>
                        <router-link to="/tramite/catalogo/tipoDocumento/create" tag="li" v-if="this.$route.name != 'CataTipoDocumentoEdit'"><a href="">Nuevo Tipo Documento</a></router-link>
                        <router-link :to="this.$route.path" tag="li" v-if="this.$route.name == 'CataTipoDocumentoEdit'"><a href="">Editar Tipo Documento</a></router-link>
                    </ul>
                </div>
               <router-view
                    route-tipo="{{route('tramite.tipoDocumento.index')}}"
                    route-guardar="{{route('tramite.tipoDocumento.store')}}"
                    route-get-tipo="{{route('tramite.tipoDocumento.show','%s')}}"
                    :limit='{{env("PAGINATION_LIMIT")}}'
               >
               </router-view>
            </div> 
        </div>
    </div>
@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/tipoDocumento.js') }}"></script>
@endpush

