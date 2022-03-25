@extends('layouts.plantillaVue')
@section('titulo') Supervisar|Papeleta
@endsection
@section('contenido')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="container">
                <ul class="nav nav-tabs card-header-tabs">
                    <router-link to="/tramite/papeleta/papeletasUsadas" tag="li"><a href="">Papeletas usadas</a></router-link>
                    <router-link to="/tramite/papeleta/papeletasSolicitadas" tag="li"><a href="">Papeletas solicitadas</a></router-link>
                </ul>
            </div>
            <router-view
                    route-papeletas-solicitadas="{{route('tramite.papeletas.papeletasSolicitadas')}}"
                    route-papeletas-usadas="{{route('tramite.papeletas.papeletasUsadas')}}"
                    route-archivador="{{route('tramite.papeletas.obtenerArchivador')}}"
                    route-recepcionar="{{route('tramite.documento.recepcionar')}}"
                    route-archivar="{{route('tramite.documento.documentoArchivar')}}"
                    :limit='{{env("PAGINATION_LIMIT")}}'
            >
            </router-view>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/supervisarPapeleta.js') }}"></script>
@endpush