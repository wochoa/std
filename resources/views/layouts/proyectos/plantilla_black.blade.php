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

		<div class="theme-showcase" role="main">
			@yield('content')
		</div>
	<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
	<script src="{{asset('js/jQuery.print.js')}}"></script>
	<script src="{{asset('js/bootstrap.min.js')}}"></script>
	<script src="{{asset('js/bootstrap-multiselect.js')}}"></script>
	<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

	<!--<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>-->
	<script src="{{asset('js/proy.js?v=0.0.1')}}"></script>
@stack('scripts')
</body>
</html>