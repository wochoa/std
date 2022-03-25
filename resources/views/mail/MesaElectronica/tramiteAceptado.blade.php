<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
  <title>Solicitud de tramite</title>
</head>
<body>
<h1 style="text-align: center; background-color: #4F81BD">Notificación de Aceptación de Trámite Documentario</h1>
<p>Estimado(a) Sr(a): <strong>{{$doc->docu_firma}}</strong>
  Se le comunica a usted que el registro de su trámite ha sido validado.</p>
<ul>
  <li>Entidad: {{$doc->docu_detalle}}</li>
  <li>Firmante: {{$doc->docu_firma}}</li>
  @if($doc->docu_dni!=null)
    <li>DNI: {{$doc->docu_dni}}</li>
  @elseif($doc->docu_ruc!=null)
    <li>RUC: {{$doc->docu_ruc}}</li>
  @endif
  <li>Teléfono: {{$doc->docu_telef}}</li>
  <li>eMail: {{$doc->docu_emailorigen}}</li>
</ul>
<p>Recuerde que puede hacer el seguimiento de su trámite <a href="{{route('tramite.buscar.buscarExpedienteModal', $doc->docu_idexma) }}">
aquí
  </a> o a través de nuestra página Web usando el Registro : <strong>{{$doc->iddocumento}}</strong> y Expediente: <strong>{{$doc->docu_idexma}}</strong> </p>

<p>{{$dependencia->depe_nombre}}</p>

    <img src="{{asset('https://www.regionhuanuco.gob.pe/img/logosgrh/Logo-Oficial-2-300x98.png')}}" alt="Gobierno Regional Huánuco" />
    <p>Por favor no responder a esta dirección de correo, ya que este buzón es de envío automático.</p>
</body>
</html>
