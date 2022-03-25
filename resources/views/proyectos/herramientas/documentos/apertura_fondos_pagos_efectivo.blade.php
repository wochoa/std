
<div class="form-group col-xs-14 col-sm-12 col-lg-12">
    {{ Form::label('doc_obra', 'OBRA') }}
    {{ Form::textarea('doc_obra', null, array('class' => 'form-control send', 'size' => '30x2') )}}
	<button type="button" class="btn btn btn-info btn-lg" id="search_obra" style="float: left;position: absolute;top: 25px;right: 16px;"><i class="glyphicon glyphicon-search"></i></button>
	{{ Form::hidden('doc_idobra', null, array('class' => 'form-control send') )}}
	{{ Form::hidden('tda_destinoNombre', json_decode($dest)->dest_nombre, array('class' => 'form-control send') )}}
	{{ Form::hidden('tda_destinoCargo', json_decode($dest)->dest_oficina, array('class' => 'form-control send') )}}
</div>

<div class="form-group col-xs-4 col-sm-4 col-lg-4">
   {{ Form::label('doc_meta', 'META') }}
   {{ Form::select('doc_meta', [''=>'SELECCIONE'], null, array('class' => 'form-control send') )}}
</div>

<div class="form-group col-xs-4 col-sm-4 col-lg-4">
    {{ Form::label('doc_especifica', 'ESPECIFICA') }}
    {{ Form::select('doc_especifica[]', [''=>'SELECCIONE'], null, array('class' => 'form-control send especifica', 'multiple'=>'multiple') )}}
</div>

<div class="form-group col-xs-4 col-sm-4 col-lg-4">
    {{ Form::label('doc_ff', 'FUENTE DE FINANCIAMIENTO') }}
    {{ Form::select('doc_ff', [''=>'SELECCIONE'], null,array('class' => 'form-control send') )}}
</div>

<div class="form-group col-xs-4 col-sm-4 col-lg-4">
    {{ Form::label('doc_cp', 'CERTIFICACION PRESUPUESTAL') }}
   {{ Form::select('doc_cp', [''=>'SELECCIONE'], null,array('class' => 'form-control send') )}}
</div>

<div class="form-group col-xs-4 col-sm-4 col-lg-4">
    {{ Form::label('doc_monto', 'MONTO') }}
    {{ Form::text('doc_monto', null, array('class' => 'form-control send') )}}
</div>


