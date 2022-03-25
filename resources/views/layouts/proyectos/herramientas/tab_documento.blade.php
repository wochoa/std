@extends('layouts.proyectos.plantilla_proyectos')

@section('content')

<ul class="nav nav-tabs" role="tablist">
    <li role="presentation">
        <a href="{!! route('proyectos.herramientas.index') !!}">Herramientas</a>
    </li>
    <li role="presentation" {{(Route::currentRouteName()=='proyectos.herramientas.{anio}.certificar.index')? 'class=active':null}}>
        <a href="{!! route('proyectos.herramientas.{anio}.certificar.index',[$anio]) !!}">Doc. Certificaci&oacute;n</a>
    </li>
    @if(Route::currentRouteName()=='proyectos.herramientas.certificar.solicitud.index'||Route::currentRouteName()=='proyectos.herramientas.certificar.detalle.index')
        <li role="presentation" {{(Route::currentRouteName()=='proyectos.herramientas.certificar.solicitud.index')? 'class=active':null}} data-data="{{Route::currentRouteName()  }}">
            <a href="{!! route('proyectos.herramientas.certificar.solicitud.index', [$anio,$doc]) !!}">Certificados</a>
        </li>
    @endif
    @if(Route::currentRouteName()=='proyectos.herramientas.certificar.detalle.index')
        <li role="presentation" {{(Route::currentRouteName()=='proyectos.herramientas.certificar.detalle.index')? 'class=active':null}} data-data="{{Route::currentRouteName()  }}">
            <a href="#">Detalle</a>
        </li>
    @endif
</ul>

<div class="panel panel-default">
    @yield('tabContent')
</div>
@endsection