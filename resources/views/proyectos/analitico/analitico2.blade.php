@extends('layouts.proyectos.plantilla_black ')

@section('titulo'){{ $proyecto->proy_cod_siaf.' Analitico de Gastos ('.$proyecto->proy_nombre.')'}}@endsection

@section('content')
    @include('proyectos.analitico.analitico')

@endsection