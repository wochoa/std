<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>
    @section('titulo')
      {{env("TITULO_PAGINA")}}
    @show
  </title>
  <!-- <link href="https://fonts.googleapis.com/css?family=Solway&display=swap" rel="stylesheet"> -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{mix('css/app.css')}}">
  <link rel="stylesheet" href="{{asset('css/estilos.css')}}">
  <link rel="stylesheet" href="{{asset('css/styles.css')}}">
  <base href="{{route('principal')}}">
</head>

<body>
<header id="admin">
  @php
    $routes=[
      'administrador.administrador.administrador' =>(Object)['route'=>route('administrador.administrador.administrador'), 'can'=>Auth::user()->can('administrador.administrador.administrador')],
      'tramite.inicio'                            =>(Object)['route'=>route('tramite.inicio'),                            'can'=>Auth::user()->can('tramite.inicio')],
      'controversia.controversia.controversia'    =>(Object)['route'=>route('controversia.controversia.controversia'),    'can'=>Auth::user()->can('controversia.controversia.controversia')],
      'proyectoPresupuesto.inicio'                =>(Object)['route'=>route('proyectoPresupuesto.inicio'),                'can'=>Auth::user()->can('proyectoPresupuesto.inicio')],
      'assistance.inicio'                         =>(Object)['route'=>route('assistance.inicio'),                         'can'=>Auth::user()->can('assistance.inicio')],
      'mpv.view'                                 =>(Object)['route'=>route('mpv.view'),                                   'can'=>Auth::user()->can('mpv.view')],
      'interoperabilidad.view'                   =>(Object)['route'=>route('interoperabilidad.view'),                     'can'=>Auth::user()->can('interoperabilidad.view')],
      'login'                                     =>(Object)['route'=>route('login'),                                     'can'=>Auth::user()->can('login')],
      'logout'                                    =>(Object)['route'=>route('logout'),                                    'can'=>Auth::user()->can('logout')],
      'principal'							      =>(Object)['route'=>route('principal')],

    ];
    $auth=['guest'=>Auth::guest()]
  @endphp
  <menu-general
    :routes="{{json_encode($routes)}}"
    :auth="{{json_encode($auth)}}"
    titulo="{{env('TITULO_PAGINA')}}"
    user-name='{{Auth::user()->adm_name}}'
    user-sede='{!! Auth::user()->dependencia->sede->iddependencia !!}'
  >
  </menu-general>
</header>


<div id="app" style="display: none;">
  @yield('contenido')
</div>
<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/administrador.js') }}"></script>
@stack('scripts')
</body>
</html>

