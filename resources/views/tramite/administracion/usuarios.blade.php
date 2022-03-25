@extends('layouts.plantillaVue') 
@section('titulo') Nuevo| Usuarios
@endsection 
@section('contenido')

<div class="container-fluid">
      <div class="row">
         <div class="col-sm-12">
               <div class="container">
                  <ul class="nav nav-tabs card-header-tabs">
                     <router-link to="/tramite/administrador/usuario" tag="li"><a href="">Explorar Usuarios</a></router-link>
                     <router-link to="/tramite/administrador/usuario/create" tag="li" v-if="this.$route.name != 'AdminUsuarioEdit'"><a href="">Nuevo Usuario</a></router-link>
                     <router-link :to="this.$route.path" tag="li" v-if="this.$route.name == 'AdminUsuarioEdit'"><a href="">Editar Usuario</a></router-link>
                  </ul>
               </div>
               <router-view 
                  route-usuario="{{route('tramite.usuarios.index')}}"
                  route-guardar="{{route('tramite.usuarios.store')}}"
                  route-get-user="{{route('tramite.usuarios.show','%s')}}"
                  route-webservice-dni="{{env('DNI_WEBSERVICE')}}"
                  route-user="{{route('tramite.usuarios.cambiarContrasenia')}}"
                  :tipo="{!! 1 !!}"
                  :tipo-usuarios = "{!! 2 !!}"
                  :limit='{{env("PAGINATION_LIMIT")}}'
                     >
               </router-view>
               
         </div>
    </div>
</div>
@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/usuarios.js') }}"></script>
@endpush