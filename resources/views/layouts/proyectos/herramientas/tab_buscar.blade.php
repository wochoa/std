@extends('layouts.proyectos.popup')

@section('content')

<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" {{(Route::currentRouteName()=='proyectos.herramientas.modif.buscar')? 'class=active':null}}>
        <a href="{!! route('proyectos.herramientas.modif.buscar',[$anio]) !!}">Modificatorias</a>
    </li>
</ul>
<div class="panel panel-default">
    @yield('tabContent')
</div>
@endsection