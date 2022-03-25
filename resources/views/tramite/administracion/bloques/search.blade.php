{!! Form::open(array('url'=>'bloques','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
    
        <div class="form-group">
           {{ Form::label('', '', ['class'=>'col-sm-3 control-label', 'for'=>'FormGroup'])}}
            <div class="col-sm-7">
               {{ Form::button('<span class="glyphicon glyphicon-search"> Buscar</span>',
                                    array('class'=>'btn btn-primary','type'=>'submit')) }}
            </div>
        </div>
 
{{Form::close()}}