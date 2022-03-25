<?php
	$id = $_GET['id'];
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	 
	<title>
	@section('titulo')
	Gobierno Regional Huánuco
	@show
	</title>
    
    <!--MENSAJE ALERTA-->
    
    <!--FIN MENSAJE ALERTA-->
	<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/print_doc.css')}}" media="print">
	@stack('style')
</head>

<body>
	<div class="form-body" id="doc_print" style="text-align: float;">
	<div id="cabecera">
		{{ Html::image('img/head_doc.jpg') }}
		<table border="1">
			<tr>
			  <td>Reg.Doc.</td>
			  <td width="85px">&nbsp;</td>
			</tr>
			<tr>
			  <td>Reg.Exp.</td>
			  <td>{{$documento->td_expeSISGEDO}}</td>
			</tr>
		</table>
	</div> 
	<div id="referencia" style="margin: 10px 0px 0px 70px">
		<?php
			$contenido = json_decode($documento->td_contenido); 
			$destino = json_decode($asunto->tda_destino);
			$referencia = explode("\n", $documento->td_referencia);
			$ccs = json_decode($documento->td_cc);
		?>
		<div class="form-group col-xs-12 col-sm-12 col-lg-12">
			{{ Form::label('memo', 'MEMORANDUM Nº_____2017 GRH-GRI') }}
		</div>
		<div class="form-group col-xs-3 col-sm-3 col-lg-3">
			{{ Form::label('destino', 'A:') }}
		</div>
		<div class="form-group col-xs-9 col-sm-9 col-lg-9">
			{{ Form::label('doc_desNombre', $destino->dest_nombre) }}
			<br>
			@if($destino->dest_oficina != '')
				{{ Form::label('doc_desOficina', $destino->dest_oficina) }}
			@endif
			
		</div>
		<div class="form-group col-xs-3 col-sm-3 col-lg-3">
			{{ Form::label('asunto', 'ASUNTO: ') }}
		</div>
		<div class="form-group col-xs-9 col-sm-9 col-lg-9">
			{{ Form::label('doc_asunto',  $documento->td_asunto_txt) }}
		</div>
		<div class="form-group col-xs-3 col-sm-3 col-lg-3">
			{{ Form::label('referencia', 'REFERENCIA: ') }}
		</div>
		<div id="ref" class="form-group col-xs-9 col-sm-9 col-lg-9">
		@foreach($referencia as $ref)
			@if($ref != "")
				{{ Form::label('doc_referencia', $ref) }}<br>
			@endif
		@endforeach
		</div>
		<div class="form-group col-xs-3 col-sm-3 col-lg-3">
			{{ Form::label('fecha', 'FECHA: ') }}
		</div>
		<div class="form-group col-xs-9 col-sm-9 col-lg-9">
			{{ Form::label('fecha_doc', 'fecha') }}
		</div>
	</div>  
	<div id="contenido" style="margin: 10px 0px 0px 70px">
	{!!$asunto->td_contenido!!}
	<div id="sello" style="margin-left:40px;margin-top:60px">
	{{ Html::image('img/selloGerente.PNG', 'sello', array('height' => '110', 'width' => '300')) }}
	</div>
	</div>
	<div id="pie" class="foo" style="float:bottom; font-size:0.6em">
		<div class="form-group col-xs-3 col-sm-3 col-lg-3" style="margin: 10px 0px 0px 70px">
			{{ Form::label('cc1', 'Cc:') }}<br>
			@foreach($ccs as $cc)
				@if($cc != '')
				{{ Form::label('cc1', strtoupper($cc)) }}<br>
				@endif
			@endforeach
			{{ Form::label('cc_archivo', 'ARCHIVO') }}<br>
		</div>
		{{ Html::image('img/footer_doc.JPG') }}
	</div>
</div>
	<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('js/jQuery.print.js')}}"></script>
	<script src="{{asset('js/bootstrap.min.js')}}"></script>
	<script>
		function decodeEntities(encodedString) {
			var textArea = document.createElement('textarea');
			textArea.innerHTML = encodedString;
			return textArea.value;
		}
		
		function formatCurrency(total) {
			var neg = false;
			if(total < 0) {
				neg = true;
				total = Math.abs(total);
			}
			return (neg ? "-$" : 'S/.') + parseFloat(total, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
		}
		
		function zeroFill( number, width ){
			width -= number.toString().length;
			if ( width > 0 )
			{
				return new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
			}
			return number + ""; // always return a string
		}
	
		$( document ).ready(function() {
			
			d=new Date('{{$documento->td_fecha}}');
			option = { year: 'numeric', month: 'long', day: 'numeric' };
					
			$("label[for='fecha_doc']").html('HUANUCO, '+d.toLocaleDateString("es-ES", option));

			$( "#contenido obra" ).html('{!!$contenido->doc_obra or ''!!}');
			$( "#contenido proced" ).html('{{$contenido->doc_proced or 'xxx'}}');
			$( "#contenido snip" ).html('{{$contenido->doc_snip or ''}}');
			$( "#contenido pedido" ).html('{{$contenido->doc_nro_pedido or ''}}');
			$( "#contenido cp" ).html(zeroFill('{{$contenido->doc_cp or ''}}', 5));
			$( "#contenido metas" ).html(zeroFill('{{$contenido->doc_meta or ''}}', 4));
			$( "#contenido ff" ).html('{{$ff or ''}}');
			$( "#contenido esp" ).html('{{$contenido->doc_especifica or ''}}');
			$( "#contenido monto" ).html(formatCurrency('{{$contenido->doc_monto or ''}}'));

            $( "#contenido afd" ).html('{{$contenido->doc_afd or ''}}');
			$( "#contenido val" ).html('{{$contenido->doc_val or ''}}');
			$( "#contenido contrato" ).html('{{$contenido->doc_contrato or ''}}');
			$( "#contenido nrocontrato" ).html('{{$contenido->doc_nro_contrato or ''}}');
			
			
			 var myCallBack = function() {window.close();};
				$('#myPrintArea').print({
					deferred: $.Deferred().done(myCallBack)
				});
		});
			
	</script>
</body>
</html>
