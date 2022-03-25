@extends('layouts.plantillaVue')
@section('titulo') Autorizar|Papeleta
@endsection
@section('contenido')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="container">
                <ul class="nav nav-tabs card-header-tabs">
                    <router-link to="/tramite/papeleta/papeletasAutorizadas" tag="li"><a href="">Papeletas autorizadas</a></router-link>
                    <router-link to="/tramite/papeleta/papeletaPendiente" tag="li"><a href="">Papeletas para autorizar</a></router-link>
                </ul>
            </div>
            <router-view
                    route-autorizar-papeleta="{{route('tramite.papeletas.autorizarPapeletas')}}"
                    route-papeletas-autorizadas="{{route('tramite.papeletas.papeletasAutorizadas')}}"
                    route-recursos-humanos="{{route('tramite.papeletas.obtenerDependenciaRecursosHumanos')}}"
                    route-recepcionar="{{route('tramite.documento.recepcionar')}}"
                    :limit='{{env("PAGINATION_LIMIT")}}'
                    :tipo-doc-papeleta='{{env("TIPO_DOC_PAPELETA")}}'
            >
            </router-view>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/papeleta.js') }}"></script>
@endpush