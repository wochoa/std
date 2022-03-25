<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" width="100%">
    <thead>
        <tr>
            <th>Componente / CFP</th>
            <th width="50px">Año</th>
            <th width="50px">Sec Func</th>
            <th width="150px">Monto Dev</th>
            <th style="text-align: center">Monto Programado</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if(count($cadenas_funcionales)>0){
        $total=0;
        foreach($cadenas_funcionales as $id => $dato)
        {
            $total+=0;//$dato['ana_monto'];
            $data=$dato['data'];
            unset($dato['data']);
            $class=($data['id']=='-1')?'class=alert-warning':'class=alert-success';
        ?>
        <tr {{$class}}>
            <td rowspan="{{(count($dato)>0)?count($dato):1}}">{!!($data['id']=='-1')?$id:($data['comp_nombre'].'<br>'.$id)!!}
                @if(true)
                    <br>
                    <a href="#" data-data="{{json_encode($data)}}" class="edit">{!!($data['id']=='-1')?'<i class="glyphicon glyphicon-plus"></i> Registrar':'<i class="glyphicon glyphicon-pencil"></i> Editar'!!}</a>
                @endif
                @if(!isset($dato[key($dato)]))
                    <a href="#" data-id="{{$data['id']}}" class="delete">{!!'     <i class="glyphicon glyphicon-trash"></i> Eliminar'!!}</a>
                @endif
            </td>
            <td>{{key($dato)}}</td>
            <td>{{(isset($dato[key($dato)]))?$dato[key($dato)]['sec_func']:''}}</td>
            <td>{{(isset($dato[key($dato)]))?Money::toMoney($dato[key($dato)]['monto_dev']):''}}</td>
            <td rowspan="{{(count($dato)>0)?count($dato):1}}">{{Money::toMoney($data['comp_monto'])}}</td>
        </tr>
        <?php $count=0;?>
        @foreach($dato as $id2 => $dato2)
            @if($count++>0&&$id2!='data')
                <tr {{$class}}>
                    <td>{{$id2}}</td>
                    <td>{{$dato2['sec_func']}}</td>
                    <td>{{Money::toMoney($dato2['monto_dev'])}}</td>
                </tr>
            @endif
        @endforeach
        <?php }?>
        <tr class="alert-danger">
            <td colspan="2">Total.</td>
            <td colspan="2" style="border-right:none;">{{Money::toMoney($total)}}</td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <?php
        } else {?>
        <tr class="odd gradeX">
            <td colspan="4"><center>
                    No existen Datos en el Analitico Cargados para este proyecto
                </center></td>
        </tr>
        <?php }?>
    </tbody>
</table>