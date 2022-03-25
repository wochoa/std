<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <!-- Put favicon.ico and apple-touch-icon(s).png in the images folder -->
  <link rel="icon" type="image/png" href="/img/favicon.png" />

  <title>
Editor
  </title>
  <link rel="stylesheet" href="{{mix('css/app.css')}}">
  <link rel="stylesheet" href="{{asset('css/estilos.css')}}">
  <link rel="stylesheet" href="{{asset('css/styles.css')}}">
  <style>
    body {
      background-color: rgb(230, 230, 230);
    }
    html{overflow: hidden;}
  </style>
</head>
<body>

<div id="app" class="TramiteReporte">
  <editor></editor>
</div>

<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/editor.js') }}"></script>
<script>
	</script>
</body>
</html>
