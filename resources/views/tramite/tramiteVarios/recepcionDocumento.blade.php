@extends('layouts.plantillaVue')
@section('titulo') Recepcion|Documento
@endsection
@section('contenido')
<div  class="container" id="app">
   <recepcion-documento
         route-guardar-documento="{{route('tramite.documento.store')}}"
         now="{{date('Y-m-d')}}"
         user-id='{!! Auth::user()->id !!}'
         user-dependencia='{!! Auth::user()->depe_id !!}'
         >

   </recepcion-documento>
</div>
@endsection

@push('scripts')
<script type='text/javascript' src="{{ mix('js/recepcion.js') }}"></script>
@endpush