<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<!-- Put favicon.ico and apple-touch-icon(s).png in the images folder -->
	<link rel="icon" type="image/png" href="/img/favicon.png" />
	<link rel="stylesheet" type="text/css" href="printFormato.css" media="print"> 
	<title>
	@section('titulo')
	   POI
	@show
	</title>
    
     <style>
        table, th, td {
            font-size:11px;
            font-family: Tahoma;
        }
        table-act, th, td{
            border-style: hidden;
            border-bottom: hidden;
            border-top: hidden;
            border-left: hidden;
            border-right: hidden;
         }
        /*------------------------------class = "table"------------------------------------*/
        table{
            border-collapse: collapse;
            text-align: left;
            width: 100%;  
            font-family: Tahoma;  
            background: #fff;
            border: 1px solid #DDDDDD; 
            margin-bottom: 10px;
        }
         
        table thead th {    
            color: #333333;  
            padding-top: 2px;
            padding-bottom: 2px;
            padding-left: 3px;
            padding-right: 3px;
            font-size: 11px;
            font-weight: bold;
            border-bottom: 2px solid #DDDDDD;  
            border-left: 1px solid #DDDDDD;  
        }

        table tbody td {
            color: #333333;    
            padding-top: 2px;
            padding-bottom: 2px;
            padding-left: 3px;
            padding-right: 3px;
            font-size: 11px;  
            font-weight: normal;  
            border: 1px solid #DDDDDD; 
        }
        /*------------------------------class = "table"------------------------------------*/

        /*------------------------------class = "primary"------------------------------------*/
        .info {
            background-color: #D9EDF7; 
        }

        .info th {
            background-color: #D9EDF7; 
        }

        .info td {
            background-color: #D9EDF7; 
        }
        /*------------------------------class = "primary"------------------------------------*/

        /*------------------------------class = "info"------------------------------------*/
        .active {
            background-color: #F5F5F5; 
        }

        .active th {
            background-color: #F5F5F5; 
        }

        .active td {
            background-color: #F5F5F5; 
        }
        /*------------------------------class = "info"------------------------------------*/
        .footnotes { 
            page-break-after:always; 
        }
        .table-mihoverreporte>tbody>tr:hover {
            background-color: #7DAFC9
        }
        .table-xtra-condensed > thead > tr > th,
        .table-xtra-condensed > tbody > tr > th,
        .table-xtra-condensed > tfoot > tr > th,
        .table-xtra-condensed > thead > tr > td,
        .table-xtra-condensed > tbody > tr > td,
        .table-xtra-condensed > tfoot > tr > td {
          padding: 2px;
        }
    </style>
        
@include('tramite.stylesheet')
@include('tramite.scripts')			
</head>

<body>
	
<!--HEADER-->
	<header>
		<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
		<!--<nav class="navbar navbar-inverse navbar-static-top" role="navigation">-->		
			<div class="container">

				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navegacion-fm">
						<span class="sr-only">Desplegar / Ocultar Menu</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!--<a href="#" class="navbar-brand"> PROMYPE </a>-->
					
				</div>
				<!-- Inicia Menu INICIO AUT ↓↓ -->
				<div class="collapse navbar-collapse" id="navegacion-fm">
						<ul class="nav navbar-nav">
							<li class="active"><a href="#">POI >></a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
									ANTEPROYECTO <span class="caret"></span>
								</a>
								<ul class="dropdown-menu" role="menu">
									<li><a tabindex="-1" href="{{url('poi/huamalies/show')}}">Actividades</a></li>
									<li class="divider"></li>
									<li><a tabindex="-1" href="{{url('poi/reporte')}}">Reporte F2</a></li>
									<li><a tabindex="-1" href="{{url('poi/comparar')}}">Comparar</a></li>
								</ul>
							</li>
							
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
									SEGUIMIENTO <span class="caret"></span>
								</a>
								<!--<ul class="dropdown-menu" role="menu">
									<li><a tabindex="-1" href="http://doceditor.regionhuanuco.gob.pe/tramite/public/cliente">Explorar Cliente</a></li>
									<li class="divider"></li>
									<li><a tabindex="-1" href="http://doceditor.regionhuanuco.gob.pe/tramite/public/cliente/create">Nuevo Cliente</a></li>
								</ul>-->
							</li>

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
									REPROGRMACIÓN <span class="caret"></span>
								</a>
								<!--<ul class="dropdown-menu" role="menu">
									<li><a tabindex="-1" href="http://doceditor.regionhuanuco.gob.pe/tramite/public/credito/create">Nuevo Crédito</a></li>
								</ul>-->
							</li>

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
									REPORTE  <span class="caret"></span>
								</a>
								<ul class="dropdown-menu" role="menu">
									<li><a tabindex="-1"  href="{{url('poi/actividad/reporte')}}">Control</a></li>
								</ul>
							</li>
						</ul>
                   
                   
					<ul class="nav navbar-nav navbar-right">
						<!--	<li><a href="#"><span class="glyphicon glyphicon-user"></span> Usuario</a></li>
						<!-- FIN AUT ↑↑ Authentication Links -->
							<li><a href="{{ url('/salir') }}"><span class="glyphicon glyphicon-log-in"></span> Salir</a></li>
						<!--@if (Auth::guest())
							<li><a href="{{ url('/ingresar') }}"><span class="glyphicon glyphicon-log-in"></span> Ingresar</a></li>
							<!--<li><a href="{{ url('/register') }}">Register</a></li>-->
						<!--@else
							<li><a href="#"><span class="glyphicon glyphicon-user"></span> {{ Auth::user()->adm_name }}</a></li>
							<!--<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
									{{ Auth::user()->adm_name }} <span class="caret"></span>
								</a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
								</ul>								
							</li>
						@endif-->
					</ul>
				</div>
			</div>
		</nav>
		<!--<div class="container-fluid" style="background-color:#337AB7;color:#fff;height:90px;">
			<img src="{{asset('img/logo3.png')}}" width="500" height="50" class="img-responsive center-block" alt="Responsive image">
		</div>-->
	</header>
<!--FIN  HEADER-->
	
	<!--<section class="jumbotron">
		<div class="container">
			<img src="{{asset('img/logo3.png')}}" width="500" height="50" class="img-responsive" alt="Responsive image">			
		</div>
	</section>-->

	<!--CONTENIDO-->
	<br><br>
	@yield('contenido')	

	<!--FIN DE CONTENIDO-->
	
	<!--FOOTER
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-xs-6">
					<p>&copy;Derechos Reservados 2016</p>
				</div>
				
			</div>
		</div>
	</footer>
	FIN FOOTER-->

</body>
</html>