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
	<link rel="stylesheet" href="{{asset('vendor/metisMenu/metisMenu.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/sb-admin-2.css')}}">
	<link rel="stylesheet" href="{{asset('vendor/morrisjs/morris.css')}}">
	<link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
	@stack('style')

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body style="overflow-x: hidden;">
<header>
	@yield('header')

</header>
	<div id="page" style="margin-left: 15px;">@yield('content')</div>

	<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
	<script src="{{asset('js/bootstrap.min.js')}}"></script>
	<script src="{{asset('vendor/metisMenu/metisMenu.min.js')}}"></script>
	<script src="{{asset('vendor/raphael/raphael.min.js')}}"></script>
	<script src="{{asset('vendor/morrisjs/morris.js')}}"></script>
	<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
@stack('scripts')
</body>
</html>