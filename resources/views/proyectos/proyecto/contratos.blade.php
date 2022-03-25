@extends('layouts.proyectos.tab_edit')

@section('tabContent')
    
<div id="app">
      <control-contratos
                route-obtener-contrato="{{route('contratos.index')}}"
                route-guardar-contrato="{{route('contratos.store')}}"
                route-actividades="{{route('proyectos.contratos.actividadObra',[$proyecto->idproy_proyecto,'%s'])}}"
                :proyecto={!!json_encode((Object)['idproy_proyecto'=>$proyecto->idproy_proyecto])!!}
      >
      </control-contratos>
</div>
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/contratos.js') }}"></script>
@endsection


