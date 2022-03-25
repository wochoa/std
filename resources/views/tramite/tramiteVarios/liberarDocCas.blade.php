@extends('layouts.plantillaVue')
@section('titulo') Liberar|Doc. CAS
@endsection
@section('contenido')
<div class="container" id="app">
    <oper-liberar-doccas
                route-doc-recibir="{{route('tramite.documento.bloquedoDocumentoRecibirLiberar')}}"
                route-liberar-cas="{{route('tramite.documento.liberarDocCas')}}"
    >
    </oper-liberar-doccas>
</div>
@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/recepcion.js') }}"></script>
@endpush
