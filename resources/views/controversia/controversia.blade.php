<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <link rel="icon" type="image/png" href="/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Controversia</title>
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
	<link rel="stylesheet" href="{{asset('css/estilos.css')}}">
</head>
<body>
    <header id="app">
        <nav class="navbar navbar-gorehco navbar-static-top" role="navigation">
            <div class="navbar-header">                
                <a href="{{route('principal')}}" class="navbar-brand">{{env('TITULO_PAGINA')}}</a>
            </div>
            <div class="navbar-collapse collapse" id="navegacion-fm">
                <ul class="nav navbar-nav">
                    <router-link :to="{name:'controversiaInicio'}" tag="li" class="dropdown"><a href="#" class="dropdown-toggle">Inicio</a></router-link>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            Registro Expediente<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <router-link :to="{name:'registroExpediente'}" tag="li"><a href="#" tabindex="-1">Procesos Judiciales</a></router-link>
                            <li><a tabindex="-1"  href="#">Procesos Penales</a></li>
                            <li><a tabindex="-1"  href="#">Arbitraje y Conciliaciones</a></li>
                        </ul>
                    </li>
                    <router-link :to="{name:'consultaExpedientes'}" tag="li" class="dropdown"><a href="#" tabindex="-1">Consulta Expedientes</a></router-link>
                    <router-link :to="{name:'controversiaUsuario'}" tag="li" class="dropdown"><a href="#" tabindex="-1">Usuarios</a></router-link>
                </ul>
            </div>
        </nav>
        <section class="jumbotron"><div class="container"></div></section>
        
        <!--<ul class="nav nav-tabs">
            <li role="presentation">
                <a href="{{route('principal')}}">{{env('TITULO_PAGINA')}}</a>
            </li>
            <router-link :to="{name:'controversiaInicio'}" tag="li"><a href="#">Inicio</a></router-link>
            <router-link :to="{name:'registroExpediente'}" tag="li"><a href="#">Registro Expediente</a></router-link>
            <router-link :to="{name:'consultaExpedientes'}" tag="li"><a href="#">Consulta Expedientes</a></router-link>
            <router-link :to="{name:'controversiaUsuario'}" tag="li"><a href="#">Usuarios</a></router-link>            
        </ul> -->     
        <router-view>
        </router-view>
    </header>
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ mix('js/controversia.js') }}"></script>
</body>
</html>