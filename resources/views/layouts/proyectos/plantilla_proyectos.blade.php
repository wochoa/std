<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	 
	<title>
	@section('titulo')
		{{env("TITULO_PAGINA")}}
	@show
	</title>
    
    <!--MENSAJE ALERTA-->
    
    <!--FIN MENSAJE ALERTA-->

	<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/estilos.css')}}">
	<link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/bootstrap-multiselect.css')}}">
	@stack('style')
</head>

<body>

	<header>
		<!--<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
			<div class="container">

				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navegacion-fm">
						<span class="sr-only">Desplegar / Ocultar Menu</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="#" class="navbar-brand">Huánuco</a>
				</div>-->
				<!-- Inicia Menu -->
				<!--<div class="collapse navbar-collapse" id="navegacion-fm">
					@if (!Auth::guest())

					@endif
                    <ul class="nav navbar-nav navbar-right">
						@if (Auth::guest())
							<li><a href="{{ url('/login') }}">Login</a></li>
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
				</div>-->
			</div>
		</nav>
	</header>
		<div class="theme-showcase" role="main">
			@yield('content')
		</div>
	<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
	<script src="{{asset('js/jQuery.print.js')}}"></script>
	<script src="{{asset('js/bootstrap.min.js')}}"></script>
	<script src="{{asset('js/bootstrap-multiselect.js')}}"></script>
	<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

	<!--<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>-->
	<script src="{{asset('js/proy.js?v=0.0.2')}}"></script>
@stack('scripts')
</body>
</html>