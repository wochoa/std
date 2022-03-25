<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Put favicon.ico and apple-touch-icon(s).png in the images folder -->
    <link rel="icon" type="image/png" href="/img/favicon.png" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

      <link rel="stylesheet" href="{{asset('css/app.css')}}">
      <link rel="stylesheet" href="{{asset('css/estilos.css')}}">
      <link rel="stylesheet" href="{{asset('css/styles.css')}}">
  </head>

  <body style="background: #d1e9f1 !important;">

        @if (Auth::guest())
        <div class="Navbar">
          <div class="Navbar-wrapper">
            <form action="">
              <a href="{{route('tramite.buscar.buscarDigital')}}" target="_blank" class="btn btn-sm btn-warning">Buscar Documentos Firmados</a>
              <a href="{{route('tramite.buscar.buscarDocExterno')}}" target="_blank" class="btn btn-sm btn-success">Buscar Documentos Externos</a>
            </form>
            <div id="expediente">
              <buscar-expediente-gen
                route-expediente="{{route('tramite.expediente.index')}}"
                route-documento="{{route('tramite.buscar.buscarExpedienteModal','%s')}}"
              >
              </buscar-expediente-gen>
            </div>
          </div>
        </div>
        @else
        <nav class="navbar navbar-gorehco">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </button>
          <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                      {{ Auth::user()->adm_name }} <span class="caret"></span>
                  </a>

                  <ul class="dropdown-menu" role="menu">
                      <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                  </ul>
              </li>
            </ul>

          </div><!--/.nav-collapse -->
        </nav>
        @endif


    <div class="container-fluid content">
        @yield('content')
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{asset('js/expediente.js')}}"></script>
  </body>
</html>
