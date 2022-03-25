@extends('layouts.plantillaVue')
@section('titulo') Documentos| Plantilla
@endsection 
@section('contenido')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="container">
                <ul class="nav nav-tabs card-header-tabs">
                    <router-link to="/tramite/plantilla" tag="li"><a href="#">Explorar Plantilla</a></router-link>
                    <router-link to="/tramite/plantilla/create" tag="li" v-if="this.$route.name != 'DocuPlantillaEdit'"><a href="#">Nueva Plantilla</a></router-link>
                    <router-link :to="this.$route.path" tag="li" v-if="this.$route.name == 'DocuPlantillaEdit'"><a href="#">Editar Plantilla</a></router-link>
                </ul>
            </div>

            <router-view
                    route-usuarios-derivar="{{route('tramite.usuarios.derivar')}}"
                    route-guardar-plantilla="{{route('tramite.plantillaC.store')}}"
                    route-get-plantilla="{{route('tramite.plantillaC.show','%s')}}"
                    route-plantilla-list="{{route('tramite.plantillaC.index')}}"
                    :prioridades='{!! $prioridades !!}'
                    user-id='{!! Auth::user()->id !!}'
                    :usuario='{!!e(json_encode($usuario), true) !!}'
                    :recepciones='{!! json_encode($recepciones) !!}'
                    :limit='{{env("PAGINATION_LIMIT")}}'
                    csrf="{{ csrf_token() }}"
            ></router-view>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ mix('js/makePlantilla.js') }}"></script>
@endpush