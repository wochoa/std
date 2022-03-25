@extends('layouts.plantillaVue')
@section('titulo') Solicitar|Papeleta
@endsection
@section('contenido')
<div  class="container-fluid">

   <div class="row">
      <div class="col-sm-12">
         <div class="container">
            <ul class="nav nav-tabs card-header-tabs">
               <router-link to="/tramite/papeleta/solicitarPapeleta" tag="li"><a href="">Papeletas Solicitadas</a></router-link>
               <router-link to="/tramite/papeleta/solicitarPapeleta/create" tag="li" v-if="this.$route.name != 'OperPapeletaEdit'"><a href="">Nueva Papeleta</a></router-link>
               <router-link :to="this.$route.path" tag="li" v-if="this.$route.name == 'OperPapeletaEdit'"><a href="">Editar Papeleta</a></router-link>
            </ul>
         </div>
   
         <router-view
                  route-papeletas="{{route('tramite.papeletas.index')}}"
                  route-guardar="{{route('tramite.documento.store')}}"
                  route-get-papeleta="{{route('tramite.papeletas.show','%s')}}"
                  route-correlativo="{{route('tramite.correlativo.buscar')}}"
                  route-derivar="{{route('tramite.documento.documentoDerivar')}}"
                  route-eliminar-derivacion="{{route('tramite.documento.eliminarDerivacion')}}"
                  route-archivar="{{route('tramite.documento.documentoArchivar')}}"
                  :limit="{{env('PAGINATION_LIMIT')}}"
                  user-id='{!! Auth::user()->id !!}'
                  user-dependencia='{!! Auth::user()->depe_id !!}'
                  user-cargo='{{Auth::user()->adm_cargo}}'
                  user-name='{{Auth::user()->adm_name." ".Auth::user()->adm_lastname}}'
                  user-inicial='{{Auth::user()->adm_inicial}}'
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