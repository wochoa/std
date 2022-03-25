@extends('layouts.tema')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Iniciar Sesión</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('ingresar') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('usu_login') ? ' has-error' : '' }}">
                            <label for="usu_login" class="col-md-4 control-label">Login</label>

                            <div class="col-md-6">
                                <input id="usuario" type="text" class="form-control" name="usuario" value="{{ old('usu_login') }}">

                                @if ($errors->has('usu_login'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('usu_login') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('usu_password') ? ' has-error' : '' }}">
                            <label for="usu_password" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="usu_password" type="password" class="form-control" name="usu_password">

                                @if ($errors->has('usu_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('usu_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Recordarme
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>Iniciar Sesión
                                </button>
                                <!--<a class="btn btn-link" href="{{ url('/usu_password/reset') }}">¿Olvidaste tu contraseña?</a>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
