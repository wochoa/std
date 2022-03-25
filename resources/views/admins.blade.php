@extends('layouts.tema')
@section('content')
<h2>Listado de usuarios</h2>
<ul>
    @foreach($admins as $admin)
    <li>
        {{$admin->adm_name.$admin->adm_email}}
    </li>
    @endforeach
</ul>
@endsection