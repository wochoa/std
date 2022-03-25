@extends('layouts.proyectos.plantilla_proyectos')

@section('content')

<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" >
    <a href={!! route('proyectos.contratos',['proyecto'=>$idproyecto]) !!}>
    Listado de contratos</a>
    </li>
    <li role="presentation" {{(Route::currentRouteName()=='proyectos.contratos.actividadObra')? 'class=active':null}}>
        <a href={!! route('proyectos.contratos.actividadObra',['proyecto'=>$idproyecto,'contrato'=>$idcontrato]) !!}>
        Actividades adicionales (Condiciones Previas)</a>
       
    </li>
    <li role="presentation" >
        <a href="">Control de avance</a>
    </li>
    <li role="presentation" >
        <a href="">Control de plazos</a>
    </li>
    <li role="presentation" >
        <a href="">Control de alcance</a>
    </li>
    
</ul>

<div class="panel panel-default">
    @yield('tabContent')
</div>
@endsection