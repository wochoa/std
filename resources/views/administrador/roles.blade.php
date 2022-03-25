@extends('layouts.plantillaAdministrador')
@section('titulo') Roles
@endsection
@section('contenido')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="container">
                <ul class="nav nav-tabs card-header-tabs">
                    <router-link to="/administrador/roles" tag="li"><a href="">Explorar Roles</a></router-link>
                    <router-link to="/administrador/roles/create" tag="li" v-if="this.$route.name != 'editRol'"><a href="">Nuevo rol</a></router-link>
                    <router-link :to="this.$route.path" tag="li" v-if="this.$route.name == 'editRol'"><a href="">Editar rol</a></router-link>
                </ul>
            </div>
            <router-view
            route-roles="{{route('administrador.rol.index')}}"
            route-guardar="{{route('administrador.rol.store')}}"
            route-get-rol="{{route('administrador.rol.show','%s')}}"
            >
            </router-view>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/admin.js') }}"></script>
@endpush
