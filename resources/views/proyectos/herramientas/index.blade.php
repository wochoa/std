@extends('layouts.proyectos.panel')
@section('titulo'){{ 'Heramientas'}}@endsection
@section('panelContent')
<div style="margin: 30px">
    <h2>
        <a href="{{route('proyectos.herramientas.{anio}.certificar.index',[2018])}}" class="btn btn-lg btn-primary">Ficha de Certificacion</a>
    </h2>
    <h2>
        <a href="{{route('proyectos.herramientas.documento.{an}.index',[2018])}}" class="btn btn-lg btn-primary">Documentos</a>
    </h2>
    <h2>
        <a href="{{route('proyectos.herramientas.{anio}.modificar.index',[2018])}}" class="btn btn-lg btn-primary">Nota Modificatoria</a>
    </h2>
</div>
@endsection