@extends('layouts.plantillaVue')
@section('titulo')
    Documentos|Por Recibir
@endsection

@section('contenido')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel-group">
                    <div class="panel panel-primary">
                        <div class="panel-heading">DOCUMENTOS POR RECIBIR</div>
                        <div class="panel-body">
                           <docu-recibir
                           route-recibir="{{route('tramite.documento.porRecibir')}}"
                           route-recepcionar="{{route('tramite.documento.recepcionar')}}"
                           route-print-pdf="{{route('tramite.documento.printPdf','%s')}}"
                           route-usuarios-dependencia="{{route('tramite.usuarios.obtenerUserDependenciaActivo')}}?tipo=2"
                           :user='{!! Auth::user()->id!!}'
                           :limit='{{env("PAGINATION_LIMIT")}}'
                           >
                           </docu-recibir>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/porrecibir.js') }}"></script>
@endpush