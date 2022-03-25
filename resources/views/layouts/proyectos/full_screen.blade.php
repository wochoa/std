<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	 
	<title>
		@yield('titulo', env("TITULO_PAGINA"))
	</title>
    
    <!--MENSAJE ALERTA-->
    
    <!--FIN MENSAJE ALERTA-->

	<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/estilos.css')}}">
	<link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/fastselect.min.css')}}">
	@stack('style')
</head>

<body>

	<header>
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">

				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navegacion-fm">
						<span class="sr-only">Desplegar / Ocultar Menu</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="#" class="navbar-brand">@yield('homeText', 'Huánuco')</a>
				</div>
				<!-- Inicia Menu -->
				<div class="collapse navbar-collapse" id="navegacion-fm">
					@if (!Auth::guest())
						<ul class="nav navbar-nav">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
									Proy <span class="caret"></span>
								</a>
								<ul class="dropdown-menu" role="menu">
									<li><a tabindex="-1" href="{{route('proyectos.index')}}">Listado</a></li>
								</ul>
							</li>

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
									Reportes <span class="caret"></span>
								</a>
								<ul class="dropdown-menu" role="menu">
									<li><a tabindex="-1" href="http://doceditor.regionhuanuco.gob.pe/tramite/public/reporte">Reportes</a></li>
								</ul>
							</li>

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
									Documentos <span class="caret"></span>
								</a>
								<ul class="dropdown-menu" role="menu">
									<li><a tabindex="-1"  href="http://doceditor.regionhuanuco.gob.pe/tramite/public/enproceso">En Proceso</a></li>
									<li class="divider"></li>
									<li><a tabindex="-1" href="http://doceditor.regionhuanuco.gob.pe/tramite/public/porrecibir">Por Recibir</a></li>
									<li><a tabindex="-1" href="http://doceditor.regionhuanuco.gob.pe/tramite/public/archivado">Archivados</a></li>
								</ul>
							</li>

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
									Catálogos <span class="caret"></span>
								</a>
								<ul class="dropdown-menu" role="menu">
									<li><a tabindex="-1" href="http://doceditor.regionhuanuco.gob.pe/tramite/public/archivadorexplorar">Archivadores</a></li>
									<li class="divider"></li>
									<li><a tabindex="-1" href="http://doceditor.regionhuanuco.gob.pe/tramite/public/tipodocexplorar">Tipos de Documentos</a></li>
									<li><a tabindex="-1" href="http://doceditor.regionhuanuco.gob.pe/tramite/public/formaexplorar">Formas de Recepción</a></li>
									<li><a tabindex="-1" href="http://doceditor.regionhuanuco.gob.pe/tramite/public/tprioridadexplorar">Tipos de Prioridades</a></li>
									<li><a tabindex="-1" href="http://doceditor.regionhuanuco.gob.pe/tramite/public/tupa">Tupa</a></li>
								</ul>
							</li>

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
									Administración<span class="caret"></span>
								</a>
								<ul class="dropdown-menu" role="menu">
									<li><a tabindex="-1" href="http://doceditor.regionhuanuco.gob.pe/tramite/public/entidadesexternas">Entidades Externas</a></li>
									<li><a tabindex="-1" href="http://doceditor.regionhuanuco.gob.pe/tramite/public/unidadorganica">Unidades Orgánicas</a></li>
									<li class="divider"></li>
									<li><a tabindex="-1" href="http://doceditor.regionhuanuco.gob.pe/tramite/public/usuarios">Usuarios</a></li>
									<li><a tabindex="-1" href="http://doceditor.regionhuanuco.gob.pe/tramite/public/correlativos">Correlativos</a></li>
									<li><a tabindex="-1" href="http://doceditor.regionhuanuco.gob.pe/tramite/public/bloques">Bloques</a></li>
									<li><a tabindex="-1" href="http://doceditor.regionhuanuco.gob.pe/tramite/public/dependencias">Dependecias</a></li>
								</ul>
							</li>
						</ul>
					@endif
                    <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <!--<li><a href="{{ url('/register') }}">Register</a></li>-->
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->adm_name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
				</div>
			</div>
		</nav>
	</header>
		<div class="theme-showcase" role="main" style="margin-top: 51px">
			@yield('content')
		</div>
	<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
	<script src="{{asset('js/jQuery.print.js')}}"></script>
	<script src="{{asset('js/bootstrap.min.js')}}"></script>
	<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('js/fastselect.standalone.min.js')}}"></script>
	<script src="{{asset('js/proy.js?v=0.001')}}"></script>
@stack('scripts')
</body>
</html>