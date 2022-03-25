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
    <link rel="stylesheet" href="{{ mix('css/styles.css') }}">

</head>
<body>
    <header id="expediente">
        <exter-mesa-partes-virtual
            titulo="{{env('TITULO_PAGINA')}}"
            route-persona-dni="{{route('tramite.persona.dni','%s')}}"
            route-webservice-ruc="{{route('tramite.persona.ruc','%s')}}"
            route-guardar-documento="{{route('tramite.documento.virtual')}}"
            :form-data-view="{{($externo)}}"
            :limit='{{env("PAGINATION_LIMIT")}}'
            :persona='{{env("PERSONA_NATURAL")}}'
            :empresa='{{env("OTRAS_EMPRESAS")}}'
        >

        </exter-mesa-partes-virtual>
    </header>
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/expediente.js') }}"></script>
    @stack('scripts')
</body>
</html>
