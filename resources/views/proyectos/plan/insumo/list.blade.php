<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" width="100%">
    <thead>
    <tr>
        <th width="200px">Componente / Tarea</th>
        <th>Insumo</th>
        <th>UM</th>
        <th>Cant Insumo</th>
        <th>Especifica</th>
        <th>Monto</th>
        <th>Programacion</th>
        <th>Editar</th>
    </tr>
    </thead>
    <tbody>
    @foreach($componentes as $componente)<?php $insumos=$componente->insumos()->get(); ?>
    <tr class="alert-info">
        <td rowspan="{{(count($insumos)>1)?count($insumos):1}}">{{$componente->comp_nombre}}</td>
        @if(count($insumos)==0)
            <td colspan="6">No se registraron Insumos</td>
        @else
        <td>{{$insumos[0]->insu_nombre}}</td>
        <td>{{$insumos[0]->insu_unidad_medida}}</td>
        <td>{{$insumos[0]->insu_cantidad}}</td>
        <td>{{$espeficicas[$insumos[0]->insu_id_clasifi]}}</td>
        <td></td>
        <td><a href="#" data-data="{{json_encode($insumos[0])}}" class="program">Programar</a></td>
        <td><a href="#" data-data="{{json_encode($insumos[0])}}" class="edit_p_c_i">Editar</a></td>
        @unset($insumos[0])
        @endif
    </tr>
        @foreach($insumos as $insumo)
            <tr class="alert-info">
                <td>{{$insumo->insu_nombre}}</td>
                <td>{{$insumo->insu_unidad_medida}}</td>
                <td>{{$insumo->insu_cantidad}}</td>
                <td>{{$espeficicas[$insumo->insu_id_clasifi]}}</td>
                <td></td>
                <td><a href="#" data-data="{{json_encode($insumo)}}" class="program">Programar </a></td>
                <td><a href="#" data-data="{{json_encode($insumo)}}" class="edit">Editar</a></td>
            </tr>
        @endforeach
        <tr>
        </tr>
    @endforeach
    </tbody>
</table>