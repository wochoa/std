@extends('layouts.proyectos.plantilla_proyectos')

@section('content')

<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" {{(Route::currentRouteName()=='proyectos.herramientas.certificar.index')? 'class=active':null}} data-data="{{Route::currentRouteName()  }}">
        <a href="{!! route('proyectos.herramientas.certificar.index',['proy'=>$proy,'anio'=>$anio]) !!}">Certificados</a>
    </li>
    <li role="presentation" {{(Route::currentRouteName()=='proyectos.herramientas.certificar.list')? 'class=active':null}}>
        <a href="{!! route('proyectos.herramientas.certificar.list',['proy'=>$proy,'anio'=>$anio]) !!}">Solicitudes</a>
    </li>
</ul>

<div class="panel panel-default">
    @yield('tabContent')
</div>
@endsection