@extends('layouts.proyectos.plantilla_proyectos')

@section('content')
    
<div id="app">

      <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" >
                  <a href={!! route('proyectos.contratos',[$idproyecto]) !!}>Listado de contratos</a>
            </li>
            <router-link :to="{name:'controlActividades',params:{idproyecto:{{$idproyecto}},idcontrato:{{$idcontrato}}}}" tag="li" ><a href="#">Actividades adicionales</a></router-link>
            <router-link :to="{name:'controlValorizaciones',params:{idproyecto:{{$idproyecto}},idcontrato:{{$idcontrato}}}}" tag="li" ><a href="#">Control de avance</a></router-link>
            <router-link :to="{name:'controlPlazo',params:{idproyecto:{{$idproyecto}},idcontrato:{{$idcontrato}}}}" tag="li" ><a href="#">Control de plazos</a></router-link>
            <router-link :to="{name:'controlAlcance',params:{idproyecto:{{$idproyecto}},idcontrato:{{$idcontrato}}}}" tag="li" ><a href="#">Control de alcance</a></router-link>
      </ul>
      <router-view
            route-obtener-actividad="{{route('actividades.index')}}"
            route-guardar-actividad="{{route('actividades.store')}}"
            route-get-actividad="{{route('actividades.show','%s')}}"
            route-adicional-obra="{{route('actividades.obtenerAdicionalObra')}}"
            :limit='{{env("PAGINATION_LIMIT")}}'
            :contrato={!!json_encode((Object)['idobra'=>$idcontrato])!!}
      >
      
      </router-view>
</div>
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/actividades.js')}}"></script>
@endsection
