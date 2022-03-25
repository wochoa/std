<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <!-- Put favicon.ico and apple-touch-icon(s).png in the images folder -->
    <link rel="icon" type="image/png" href="/img/favicon.png" />
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
  <header id="admin">
      @php
          $routes=[
            'getRoute'										  =>(Object)['route'=>route('getRoute'),										'can'=>Auth::user()->can('getRoute')],
            'administrador.roles.rol'                         =>(Object)['route'=>route('administrador.roles.rol'),                         'can'=>Auth::user()->can('administrador.roles.rol')],
            'administrador.usuarios.usuario'                  =>(Object)['route'=>route('administrador.usuarios.usuario'),                  'can'=>Auth::user()->can('administrador.usuarios.usuario')],
            'administrador.publicaciones.comunicacionIntena'  =>(Object)['route'=>route('administrador.publicaciones.comunicacionIntena'),  'can'=>Auth::user()->can('administrador.publicaciones.comunicacionIntena')],
            'tramite.unidades.obtenerUnidadOrganica'	      =>(Object)['route'=>route('tramite.unidades.obtenerUnidadOrganica'),		    'can'=>Auth::user()->can('tramite.unidades.obtenerUnidadOrganica')],
            'administrador.rol.obtenerRoles'				  =>(Object)['route'=>route('administrador.rol.obtenerRoles'),					'can'=>Auth::user()->can('administrador.rol.obtenerRoles')],
            'tramite.usuarios.checkUsuario'					  =>(Object)['route'=>route('tramite.usuarios.checkUsuario'),					'can'=>Auth::user()->can('tramite.usuarios.checkUsuario')],
            'tramite.documento.jsonAdministrador'			  =>(Object)['route'=>route('tramite.documento.jsonAdministrador','all.json')],
            'tramite.persona.dni'							  =>(Object)['route'=>route('tramite.persona.dni','%s'),						'can'=>Auth::user()->can('tramite.persona.dni')],
            'administrador.correos'                           =>(Object)['route'=>route('administrador.correos'),                           'can'=>Auth::user()->can('administrador.correos')],
            'administrador.holidays'                          =>(Object)['route'=>route('administrador.holidays'),                          'can'=>Auth::user()->can('administrador.holidays')],

            'login'                                           =>(Object)['route'=>route('login'),                                           'can'=>Auth::user()->can('login')],
            'logout'                                          =>(Object)['route'=>route('logout'),                                          'can'=>Auth::user()->can('logout')],
            'principal'										  =>(Object)['route'=>route('principal')],
          ];
          $auth=['guest'=>Auth::guest()]
      @endphp
            <menu-administrador
            :routes="{{json_encode($routes)}}"
            :auth="{{json_encode($auth)}}"
            titulo="{{env('TITULO_PAGINA')}}"
            :user='{{ Auth::user() }}'
            >
            </menu-administrador>
  </header>


  <div  id="app">
    @yield('contenido')
  </div>
<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/administrador.js') }}"></script>
@stack('scripts')
</body>
</html>

