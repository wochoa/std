<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>
        @section('titulo')
        {{env("TITULO_PAGINA")}}
        @show
    </title>
    
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/estilos.css')}}">
    <base href="{{route('principal')}}">
</head>
<body>
    <header id="navbar">
        <buscar-expediente
        route-expediente="{{route('tramite.expediente.index')}}"
        route-documento="{{route('tramite.buscar.buscarModal','%s')}}"
        :form-data={!!json_encode((Object)['iddocumento'=>$iddocumento])!!}
        >
        </buscar-expediente>
    </header>
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/navbar.js')}}"></script>
</body>
</html>