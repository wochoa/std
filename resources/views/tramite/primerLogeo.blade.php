<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <!-- Put favicon.ico and apple-touch-icon(s).png in the images folder -->
    <link rel="icon" type="image/png" href="/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @section('titulo')
        {{env("TITULO_PAGINA")}}
        @show
        </title>
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
	<link rel="stylesheet" href="{{asset('css/estilos.css')}}">
</head>

<body>
    <div>
        <nav class="navbar navbar-gorehco navbar-static-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                <a href="#" class="navbar-brand">{{env('titulo')}}</a>
                </div>
                <div class="collapse navbar-collapse" id="navegacion-fm">
                   
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                        <li v-else class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->adm_name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{route('logout')}}"><i class="fa fa-btn fa-sign-out"></i>Cerrar Session</a></li>
                            </ul>
                        </li>
                </ul>
                </div>
            </div>
        </nav>
        <section class="jumbotron">
            <div class="container">
                
            </div>
        </section>
    </div>
    <header id="logeo">
        <admin-cambiar-contrasenia
            route-inicio="{{route('tramite.inicio')}}"
            route-user="{{route('tramite.usuarios.cambiarContrasenia')}}"
            route-principal="{{route('principal')}}"
            route-webservice-dni="{{route('tramite.persona.dni','%s')}}"
            :user='{{$user}}'
            :tipo='{!! 1 !!}'
        >
        </admin-cambiar-contrasenia>
    </header>
  

  
<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/logeo.js') }}"></script>
</body>
</html>

