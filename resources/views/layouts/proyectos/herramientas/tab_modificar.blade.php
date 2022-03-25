@extends('layouts.proyectos.full_screen')

@section('content')

<ul class="nav nav-tabs" role="tablist">
    <li role="presentation">
        <a href="{!! route('proyectos.herramientas.index') !!}">Herramientas</a>
    </li>
    <li role="presentation" {{(Route::currentRouteName()=='proyectos.herramientas.{anio}.modificar.index')? 'class=active':null}}>
        <a href="{!! route('proyectos.herramientas.{anio}.modificar.index',[$anio]) !!}">Modificatorias</a>
    </li>
    @if(Route::currentRouteName()=='proyectos.herramientas.modif.det.index')
        <li role="presentation" {{(Route::currentRouteName()=='proyectos.herramientas.modif.det.index')? 'class=active':null}}>
            <a href="">Detalle</a>
        </li>
    @endif
</ul>

<div class="panel panel-default">
    @yield('tabContent')
</div>
@endsection