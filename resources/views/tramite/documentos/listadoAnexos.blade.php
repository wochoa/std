<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Put favicon.ico and apple-touch-icon(s).png in the images folder -->
  <link rel="icon" type="image/png" href="/img/favicon.png" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Listado de anexos</title>
  <link rel="stylesheet" href="{{mix('css/app.css')}}">
  <link rel="stylesheet" href="{{asset('css/estilos.css')}}">
</head>
<body>
<header id="expediente">
  <div>
    <nav role="navigation" class="navbar navbar-gorehco navbar-static-top">
      <div class="container">
        <div class="navbar-header"><a href="" class="navbar-brand">Municipalidad distrital de Monzon</a></div>
      </div>
    </nav>
    <section class="jumbotron"><!----></section>
    <div class="container">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel-group">
          <div class="panel panel-success">

            <div class="panel-heading">Listado de anexos del documento: {{$doc->numero_documento}}</div>
            <div class="panel-body text-left">
              @if(count($doc->anexos)>0)
                @foreach($doc->anexos as $anexo)
                  <p>
                    <a
                      href="{{route('tramite.documento.printPdf2',['idFile'=>$anexo->id,'psw'=>$doc->docu_contrasenia,'name'=>$doc->iddocumento.'.pdf'])}}"
                      target="_blank">anexo1</a>
                  </p>
                @endforeach
              @else
                <p>el documento no tiene anexos</p>
              @endif
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="col-md-10"><!----></div>
    </div>
  </div>
</header>
</body>
</html>