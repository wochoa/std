<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<!-- Put favicon.ico and apple-touch-icon(s).png in the images folder -->
	<link rel="icon" type="image/png" href="/img/favicon.png" />

	<title>
	@section('titulo')
	{{env("TITULO_PAGINA")}}
	@show
	</title>
    <!--MENSAJE ALERTA-->

    <!--FIN MENSAJE ALERTA-->
	<link rel="stylesheet" href="{{mix('css/app.css')}}">
	<link rel="stylesheet" href="{{asset('css/estilos.css')}}">
	<link rel="stylesheet" href="{{asset('css/styles.css')}}">
	<style>
		body {
			background-color: rgb(230, 230, 230);
		}
		.nav > li > a{padding: 15px 5px !important;}
	</style>
	@stack('style')
</head>
<body>

	<!--HEADER-->
	<header id="navbar">
		@php
		$routes=[
			'getRoute'										=>(Object)['route'=>route('getRoute'),										'can'=>Auth::user()->can('getRoute')],
			'tramite.inicio'								=>(Object)['route'=>route('tramite.inicio'),								'can'=>Auth::user()->can('tramite.inicio')],
			'tramite.documento.buscarDocumento'				=>(Object)['route'=>route('tramite.documento.buscarDocumento'),				'can'=>Auth::user()->can('tramite.documento.buscarDocumento')],
			'tramite.expediente.index'						=>(Object)['route'=>route('tramite.expediente.index'),						'can'=>Auth::user()->can('tramite.expediente.index')],
			'tramite.expediente.buscar'						=>(Object)['route'=>route('tramite.expediente.buscar'),						'can'=>Auth::user()->can('tramite.expediente.buscar')],
			'tramite.administrador.usuario'					=>(Object)['route'=>route('tramite.administrador.usuario'),					'can'=>Auth::user()->can('tramite.administrador.usuario')],
			'tramite.buscador'								=>(Object)['route'=>route('tramite.buscador'),								'can'=>Auth::user()->can('tramite.buscador')],
			'tramite.reporte.index'							=>(Object)['route'=>route('tramite.reporte.index'),							'can'=>Auth::user()->can('tramite.reporte.index')],
			'tramite.enproceso.index'						=>(Object)['route'=>route('tramite.enproceso.index'),						'can'=>Auth::user()->can('tramite.enproceso.index')],
			'tramite.view.docs.generados'					=>(Object)['route'=>route('tramite.view.docs.generados'),					'can'=>Auth::user()->can('tramite.view.docs.generados')],
			'tramite.view.plantilla'						=>(Object)['route'=>route('tramite.view.plantilla'),						'can'=>Auth::user()->can('tramite.view.plantilla')],
			'tramite.recibir.index'							=>(Object)['route'=>route('tramite.recibir.index'),							'can'=>Auth::user()->can('tramite.recibir.index')],
			'tramite.archivado.index'						=>(Object)['route'=>route('tramite.archivado.index'),						'can'=>Auth::user()->can('tramite.archivado.index')],
			'tramite.catalogo.archivador'					=>(Object)['route'=>route('tramite.catalogo.archivador'),					'can'=>Auth::user()->can('tramite.catalogo.archivador')],
			'tramite.catalogo.tipoDocumento'				=>(Object)['route'=>route('tramite.catalogo.tipoDocumento'),				'can'=>Auth::user()->can('tramite.catalogo.tipoDocumento')],
			'tramite.catalogo.recepcion'					=>(Object)['route'=>route('tramite.catalogo.recepcion'),					'can'=>Auth::user()->can('tramite.catalogo.recepcion')],
			'tramite.catalogo.prioridades'					=>(Object)['route'=>route('tramite.catalogo.prioridades'),					'can'=>Auth::user()->can('tramite.catalogo.prioridades')],
			'tramite.correlativo.buscar'					=>(Object)['route'=>route('tramite.correlativo.buscar'),					'can'=>Auth::user()->can('tramite.correlativo.buscar')],
			'tramite.recepcion.recepcionDocumento'			=>(Object)['route'=>route('tramite.recepcion.recepcionDocumento'),			'can'=>Auth::user()->can('tramite.recepcion.recepcionDocumento')],
			'tramite.liberar.liberarDocCas'					=>(Object)['route'=>route('tramite.liberar.liberarDocCas'),					'can'=>Auth::user()->can('tramite.liberar.liberarDocCas')],
			'tramite.papeleta.solicitarPapeleta'			=>(Object)['route'=>route('tramite.papeleta.solicitarPapeleta'),			'can'=>Auth::user()->can('tramite.papeleta.solicitarPapeleta')],
			'tramite.papeleta.papeletaPendiente'			=>(Object)['route'=>route('tramite.papeleta.papeletaPendiente'),			'can'=>Auth::user()->can('tramite.papeleta.papeletaPendiente')],
			'tramite.papeleta.papeletasSolicitadas'			=>(Object)['route'=>route('tramite.papeleta.papeletasSolicitadas'),			'can'=>Auth::user()->can('tramite.papeleta.papeletasSolicitadas')],
			'tramite.administrador.entidades'				=>(Object)['route'=>route('tramite.administrador.entidades'),				'can'=>Auth::user()->can('tramite.administrador.entidades')],
			'tramite.administrador.unidades'				=>(Object)['route'=>route('tramite.administrador.unidades'),				'can'=>Auth::user()->can('tramite.administrador.unidades')],
			'tramite.administrador.unidadesSedes'			=>(Object)['route'=>route('tramite.administrador.unidadesSedes'),			'can'=>Auth::user()->can('tramite.administrador.unidadesSedes')],
			'tramite.administrador.correlativos'			=>(Object)['route'=>route('tramite.administrador.correlativos'),			'can'=>Auth::user()->can('tramite.administrador.correlativos')],
			'tramite.administrador.correlativosDependencia'	=>(Object)['route'=>route('tramite.administrador.correlativosDependencia'),	'can'=>Auth::user()->can('tramite.administrador.correlativosDependencia')],
			'tramite.administrador.dependencias'			=>(Object)['route'=>route('tramite.administrador.dependencias'),			'can'=>Auth::user()->can('tramite.administrador.dependencias')],
			'tramite.administrador.editDependenciasSedes'	=>(Object)['route'=>route('tramite.administrador.editDependenciasSedes'),	'can'=>Auth::user()->can('tramite.administrador.editDependenciasSedes')],
			'tramite.enproceso.upload'						=>(Object)['route'=>route('tramite.enproceso.upload'),						'can'=>Auth::user()->can('tramite.enproceso.upload')],
			'tramite.unidades.obtenerUnidadOrganica'		=>(Object)['route'=>route('tramite.unidades.obtenerUnidadOrganica'),		'can'=>Auth::user()->can('tramite.unidades.obtenerUnidadOrganica')],
			'tramite.documento.printPdf'					=>(Object)['route'=>route('tramite.documento.printPdf','%s'),				'can'=>Auth::user()->can('tramite.documento.printPdf')],
			'tramite.tipoDocumento.get'						=>(Object)['route'=>route('tramite.tipoDocumento.get'),						'can'=>Auth::user()->can('tramite.tipoDocumento.get')],
			'tramite.usuarios.obtenerUserDependenciaActivo'	=>(Object)['route'=>route('tramite.usuarios.obtenerUserDependenciaActivo'),	'can'=>Auth::user()->can('tramite.usuarios.obtenerUserDependenciaActivo')],
			'tramite.usuarios.checkUsuario'					=>(Object)['route'=>route('tramite.usuarios.checkUsuario'),					'can'=>Auth::user()->can('tramite.usuarios.checkUsuario')],
			'tramite.archivador.obtenerArchivadores'		=>(Object)['route'=>route('tramite.archivador.obtenerArchivadores'),		'can'=>Auth::user()->can('tramite.archivador.obtenerArchivadores')],
			'administrador.rol.obtenerRolesDepe'			=>(Object)['route'=>route('administrador.rol.obtenerRolesDepe'),			'can'=>Auth::user()->can('administrador.rol.obtenerRolesDepe')],
			'tramite.documento.obtenerTotal'				=>(Object)['route'=>route('tramite.documento.obtenerTotal'),				'can'=>Auth::user()->can('tramite.documento.obtenerTotal')],
			'tramite.documento.json'						=>(Object)['route'=>route('tramite.documento.json','all.json'),				'can'=>Auth::user()->can('tramite.documento.json')],
			'administrador.comunicacionIntena.show'			=>(Object)['route'=>route('administrador.comunicacionIntena.show','%s'),	'can'=>Auth::user()->can('administrador.comunicacionIntena.show')],
			'administrador.comunicacionIntena.printImagenes'=>(Object)['route'=>route('administrador.comunicacionIntena.printImagenes','%s'),'can'=>Auth::user()->can('administrador.comunicacionIntena.show')],
			'tramite.persona.dni'							=>(Object)['route'=>route('tramite.persona.dni','%s'),						'can'=>Auth::user()->can('tramite.persona.dni')],
			'administrador.usuarios.rrhh'					=>(Object)['route'=>route('administrador.usuarios.rrhh'),					'can'=>Auth::user()->can('administrador.usuarios.rrhh')],

			'login'											=>(Object)['route'=>route('login'),											'can'=>Auth::user()->can('login')],
			'logout'										=>(Object)['route'=>route('logout'),										'can'=>Auth::user()->can('logout')],
			'principal'										=>(Object)['route'=>route('principal')],
			'tramite.buscar.buscarModal'					=>(Object)['route'=>route('tramite.buscar.buscarModal','%s')],
			'tramite.buscar.buscarExpedienteModal'			=>(Object)['route'=>route('tramite.buscar.buscarExpedienteModal','%s')]

		];
		$auth=['guest'=>Auth::guest()];
		@endphp

			<buscar-docu
			:routes="{{json_encode($routes)}}"
			:auth="{{json_encode($auth)}}"
			titulo="{{env('TITULO_PAGINA')}}"
			:user='{{Auth::user()}}'
			>
			</buscar-docu>
	</header>
	<!--FIN  HEADER-->

	<!--CONTENIDO-->
	<div id="app" class="TramiteReporte">
	@yield('contenido')
	</div>

	<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
	<script src="{{ mix('js/manifest.js') }}"></script>
	<script src="{{ mix('js/vendor.js') }}"></script>
	<script src="{{ mix('js/navbar.js') }}"></script>
	@stack('scripts')
	<script>

	</script>
</body>
</html>
