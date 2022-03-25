@extends('layouts.proyectos.plantilla_proyectos')

@section('content')

<div class="container">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" >
            <a href="{!! route('proyectos.index') !!}">Listado de Proyecto</a>
        </li>
        <li role="presentation" {{(Route::currentRouteName()=='proyectos.edit')? 'class=active':null}}>
            <a href="{!! route('proyectos.edit',[$proyecto->idproy_proyecto]) !!}">Administrar proyecto</a>
        </li>
        <li role="presentation" {{(Route::currentRouteName()=='proyectos.gastos')? 'class=active':null}}>
            <a href="{{route('proyectos.gastos',[$proyecto->idproy_proyecto,'default'] )}}">Gastos</a>
        </li>
        <li role="presentation" {{(Route::currentRouteName()=='proyectos.{proy}.plan.componente.index')? 'class=active':null}}>
            <a href="{{route('proyectos.{proy}.plan.componente.index',$proyecto->idproy_proyecto )}}">Componentes Tareas</a>
        </li>
        <li role="presentation" {{(Route::currentRouteName()=='proyectos.plan.programar.index')? 'class=active':null}}>
            <a href="{{route('proyectos.plan.programar.index', [$proyecto->idproy_proyecto , (isset($selectedAnio))?$selectedAnio:'null',1,'00'])}}" da>Programar</a>
        </li>
        <li role="presentation" {{(Route::currentRouteName()=='proyectos.contratos')? 'class=active':null}}>
            <a href="{!! route('proyectos.contratos',$proyecto->idproy_proyecto) !!}">Contratos</a>
        </li>
        <li role="presentation" {{(Route::currentRouteName()=='proyectos.informes')? 'class=active':null}}>
            <a href="{!! route('proyectos.informes',$proyecto->idproy_proyecto) !!}">Informes</a>
        </li>
    </ul>
</div>
<div class=" {{(in_array(Route::currentRouteName(), ['proyectos.plan.programar.index','proyectos.gastos']))? null:'container '}}">
<div class="panel panel-default">
    @yield('tabContent')
</div>
</div>
@endsection