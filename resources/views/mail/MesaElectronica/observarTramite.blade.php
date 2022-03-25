<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
  <title>Tramite Observado</title>
</head>
<body>
<h1 style="text-align: center; background-color: #4F81BD">Notificación de Observación de Trámite Documentario</h1>
<p>Estimado(a) Sr(a): <strong>{{$doc->docu_firma}}</strong>
  Se comunica a usted que su registro de trámite ha sido observado.</p>
<ul>
  <li>Observaciones: {{$doc->docu_motivo_archivamiento}}</li>
</ul>
<p>Puede levantar las observaciones <a href="{{route('registro.mesaPartesVirtual.token', [$doc->id_dependencia, $doc->docu_token]) }}">
        aquí
    </a> o puede volver a presentar su trámite una vez subsanado el motivo de la observación.</p>
<p>{{$dependencia->depe_nombre}}</p>
    <img src="{{asset('https://www.regionhuanuco.gob.pe/img/logosgrh/Logo-Oficial-2-300x98.png')}}" alt="Gobierno Regional Huánuco" />
    <p>Por favor no responder a esta dirección de correo, ya que este buzón es de envío automático.</p>
</body>
</html>
