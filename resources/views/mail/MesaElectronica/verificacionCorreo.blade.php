<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
  <title>Solicitud de tramite</title>
</head>
<body>
<h1 style="text-align: center; background-color: #4F81BD">Código de Verificación del Correo Electrónico</h1>
@if(isset($persona->prenombres))
  <p>Estimado(a) Sr(a): <strong>{{$persona->prenombres}}</strong>
@else
  <p>Estimado(a) Sr(a): <strong>{{$persona->ddp_nombre}}</strong>
    @endif
    su código de verificación del correo electrónico {{$correo->correo}}  es: <br><strong>{{$correo->codigo}}</strong></p>
        <p>Le informamos que una vez confirmado el correo electrónico, las comunicaciones del Gobierno Regional Huánuco serán enviadas por este medio.</p>

        <img src="{{asset('https://www.regionhuanuco.gob.pe/img/logosgrh/Logo-Oficial-2-300x98.png')}}" alt="Gobierno Regional Huánuco" />
        <p>Por favor no responder a esta dirección de correo, ya que este buzón es de envío automático.</p>
</body>
</html>
