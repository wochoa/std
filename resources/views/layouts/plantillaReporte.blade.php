<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>
        @section('titulo') Gobierno Regional Huánuco @show
    </title>

    <!--MENSAJE ALERTA-->


    <!--FIN MENSAJE ALERTA-->

    @include('tramite.stylesheet') 
    @include('tramite.scripts')
</head>

<body>

    <!--HEADER-->
    <header>
        <!--<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
            <div class="container">
                <div class="collapse navbar-collapse" id="navegacion-fm">
                    <ul class="nav navbar-nav">
                    </ul>
                </div>
            </div>
        </nav>-->
    </header>
    <!--FIN  HEADER-->

    <!--<section class="jumbotron">
        <h3>DOCUMENTOS GENERADOS POR UNIDAD ORGANICA</h3>
    </section>-->

    <!--CONTENIDO-->
    @yield('contenido')



</body>

</html>