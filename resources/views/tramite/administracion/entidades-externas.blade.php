@extends('layouts.plantillaVue')

@section('titulo')
    Nuevo| Entidades Externas
@endsection
@section('contenido')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!--tapmenu-->
                <div class="container">
                    <ul class="nav nav-tabs card-header-tabs">
                        <router-link to="/tramite/administrador/entidades" tag="li"><a href="">Explorar Entidades</a></router-link>
                        <router-link to="/tramite/administrador/entidades/create" tag="li" v-if="this.$route.name != 'AdminEntidadExternaEdit'"><a href="">Nuevo Entidad</a></router-link>
                        <router-link :to="this.$route.path" tag="li" v-if="this.$route.name == 'AdminEntidadExternaEdit'"><a href="">Editar Entidad</a></router-link>
                    </ul>
                </div>
                <!--fintapmenu-->
                <router-view 
                  route-entidades="{{route('tramite.entidades.index')}}"
                  route-guardar="{{route('tramite.entidades.store')}}"
                  route-get-entidad="{{route('tramite.entidades.show','%s')}}"
                  :limit='{{env("PAGINATION_LIMIT")}}'
                  >
                </router-view>
              
            </div>
        </div>
    </div>
      
@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/entidad.js') }}"></script>
@endpush
