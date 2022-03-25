@extends('layouts.tema')

@section('content')

<div class="Login">
    <div class="pt-2 pb-4" align="center">
        <img src="{{asset("img/logosgdsinfondo.png")}}" width="60%" class="img-fluid">
        {{-- <br><br> --}}
        {{-- <center><h1><strong>SISTEMA DE GESTIÓN DIGITAL</strong></h1></center> --}}
    </div>
    <div class="panel panel-default" style="background-color: #8bc6da !important;">
        <div class="panel-heading text-center text-light" style="background: #044ba266 !important;"><h4>Iniciar Sesión</h4></div>
        <div class="panel-body text-center">
            <!-- <img class="LoginLogo img-fluid" src="{{asset("img/Logo-Oficial-2-300x98.png")}}">
            <br><br> -->
            <small>Inicie sesión con su cuenta para realizar trámites digitales</small>
            <hr>
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('adm_email') ? ' has-error' : '' }}">
                    <div class="LoginGroup">
                        <span class="glyphicon glyphicon-user"></span>
                        <input 
                            id="adm_email" 
                            type="text" 
                            class="form-control" 
                            name="adm_email"
                            value="{{ old('adm_email') }}" 
                            onkeyup="javascript:this.value=this.value.toUpperCase();"
                            placeholder="Usuario"
                        />
                    </div>

                    @if ($errors->has('adm_email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('adm_email') }}</strong>
                        </span>
                    @endif
                
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="LoginGroup">
                        <span class="glyphicon glyphicon-lock"></span>
                        <input id="password" type="password" class="form-control" name="password" 
                        placeholder="Contraseña">
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                
                </div>
                <div class="LoginActions">
                    
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Recordarme
                        </label>
                    </div>
                    <button  type="submit" class="btn btn-primary LoginButton">
                        <i class="fa fa-btn fa-sign-in"></i>Iniciar Sesión
                    </button>
                
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
