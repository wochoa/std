
<div class="form-group col-xs-14 col-sm-12 col-lg-12">
	{{ Form::hidden('tda_destinoNombre', json_decode($dest)->dest_nombre, array('class' => 'form-control send') )}}
	{{ Form::hidden('tda_destinoCargo', json_decode($dest)->dest_oficina, array('class' => 'form-control send') )}}
</div>



