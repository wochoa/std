<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <header id="expediente">
        <buscar-digitales
            titulo="{{env('TITULO_PAGINA')}}"
            route-print-pdf="{{route('tramite.documento.printPdf','documento.pdf')}}?id=%s&id_documento=%s"
            route-buscar-digital="{{route('tramite.documento.buscarDocDigital')}}"
        >
        
        </buscar-digitales>
    </header>
<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/expediente.js') }}"></script>
@stack('scripts')
</body>
</html>