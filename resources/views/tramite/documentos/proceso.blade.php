@extends('layouts.plantillaVue')
@section('titulo') Documentos| En Proceso
@endsection
@section('contenido')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="container ">
                <ul class="nav nav-tabs card-header-tabs">
                    <router-link to="/tramite/enproceso" tag="li"><a href="#">Explorar Documentos en proceso</a></router-link>
                    <router-link to="/tramite/enproceso/create" tag="li" v-if="this.$route.name.search('Generado')<0 && this.$route.name !='DocuEdit'"><a href="#">Nuevo Documento</a></router-link>
                    <router-link :to="this.$route.path" tag="li" v-if="this.$route.name.search('Generado')<0 && (this.$route.name ==='DocuEdit'||this.$route.name === 'DocuGeneradoEdit2')"><a href="#">Editar Documento</a></router-link>

                    <router-link tag='li' to="/tramite/docs-generados" v-if="this.$route.name.search('Generado')>0"><a>Explorar Documentos generados</a></router-link>
                    <router-link tag='li' to="/tramite/docs-generados/create" v-if="this.$route.name.search('Generado')>0 && this.$route.name != 'DocuGeneradoEdit' && this.$route.name != 'DocuGeneradoEdit2'"><a>Nuevo Documento generado</a></router-link>
                    <router-link tag='li' :to="this.$route.path" v-if="this.$route.name.search('Generado')>0 && this.$route.name === 'DocuGeneradoEdit'"><a>Editar documento generado</a></router-link>
                    <router-link tag='li' :to="this.$route.path" v-if="this.$route.name === 'DocuGeneradoEdit2'"><a>Editar documento generado</a></router-link>

                </ul>
            </div>
            <router-view
                    route-correlativo="{{route('tramite.correlativo.buscar')}}"
                    route-usuarios-derivar="{{route('tramite.usuarios.derivar')}}"
                    route-documentos-list="{{route('tramite.documento.index')}}"
                    route-devolver="{{route('tramite.documento.devolverProceso')}}"
                    route-eliminar-derivacion="{{route('tramite.documento.eliminarDerivacion')}}"
                    route-liberar-documento="{{route('tramite.documento.liberarDocumento')}}"
                    route-generar-observacion="{{route('tramite.documento.generarObservacion')}}"
                    route-derivar="{{route('tramite.documento.documentoDerivar')}}"
                    route-archivar="{{route('tramite.documento.documentoArchivar')}}"
                    route-adjuntar="{{route('tramite.documento.documentoAdjuntar')}}"
                    route-invoker-get="{{route('invoker.getArguments')}}"
                    route-invoker-post="{{route('invoker.postArguments')}}"
                    route-print-pdf="{{route('tramite.documento.printPdf','%s')}}"
                    route-print="{{route('tramite.docs.generados.print','%s')}}"
                    route-guardar-doc-generado="{{route('tramite.docGenerado.store')}}"
                    route-get-doc-generado="{{route('tramite.docGenerado.show','%s')}}"
                    route-doc-generado-list="{{route('tramite.docGenerado.index')}}"
                    route-plantillas="{{route('tramite.plantillaC.index')}}"
                    route-webservice-dni="{{route('tramite.persona.dni','%s')}}"
                    route-webservice-ruc="{{route('tramite.persona.ruc','%s')}}"
                    route-webservice-entidad="{{route('tramite.documento.entidadByCategoria','%s')}}"
                    route-archivador="{{route('tramite.papeletas.obtenerArchivador')}}"
                    :can-interoperabilidad="{!! Auth::user()->can('interoperabilidad.view') ? 'true' : 'false'!!}"
                    :can-super="{!! Auth::user()->can('admin') ? 'true' : 'false' !!}"
                    route-cuo="{{route('tramite.documento.cuo')}}"
                    :prioridades='{!! $prioridades !!}'
                    now="{{date('Y-m-d')}}"
                    user-id='{!! Auth::user()->id !!}'
                    :usuario='{{json_encode($usuario)}}'
                    :recepciones='{!! json_encode($recepciones) !!}'
                    :limit='{{config("proyectos.pagination_limit")}}'
            ></router-view>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ mix('js/enproceso.js') }}"></script>
@endpush
