
<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" id="modificaciones" width="100%">
        <thead>
            <tr>
                <th width="20%">Proyecto</th>
                <th width="15%">Componente / Especifica</th>
                <th width="12%">PIM</th>
                <th width="8%">DE</th>
                <th width="8%">A</th>
                <th width="12%">Nuevo PIM</th>
                <th width="8%">Certificado</th>
                <th width="17%">Justificacion</th>
            </tr>
        </thead>
        <tbody>
        <tr class="alert alert-danger">
            <td colspan="2">Total</td>
            <td>{{Money::toMoney($total['pim'],'')}}</td>
            <td>{{Money::toMoney($total['de'],'')}}</td>
            <td>{{Money::toMoney($total['a'],'')}}</td>
            <td></td>
            <td>{{Money::toMoney($total['cert'])}}</td>
            <td></td>
        </tr>
        @if(count($detalles)>0)
            @foreach($detalles as $id_proy=>$proyecto)
                <tr class="alert alert-success">
                    <td rowspan="{{$proyecto['d']['rows']}}">{{$proyecto['d']['nombre']}}</td>
                    <td>Total</td>
                    <td>
                        <table width="100%">
                            <tr>
                                <td><strong>Limite: </strong></td>
                                <td>{{\App\_clases\utilitarios\Money::toMoney($proyecto['d']['limite'], '')}}</td>
                            </tr>
                            <tr>
                                <td><strong>Acumulado: </strong></td>
                                <td>{{\App\_clases\utilitarios\Money::toMoney($proyecto['d']['acumulado'], '')}}</td>
                            </tr>
                            @if($proyecto['d']['otras_ejecutoras']>0)
                                <tr>
                                    <td><strong>Otras Ejecutoras:</strong></td>
                                    <td>{{\App\_clases\utilitarios\Money::toMoney($proyecto['d']['otras_ejecutoras'], '')}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td><strong>PIM:</strong></td>
                                <td>{{\App\_clases\utilitarios\Money::toMoney($proyecto['d']['pim1'], '')}}</td>
                            </tr>
                            <tr {{(($proyecto['d']['limite']-($proyecto['d']['acumulado']+$proyecto['d']['otras_ejecutoras']+$proyecto['d']['pim1']))<0)?'style=background-color:#f5baba':''}}>
                                <td style="border-top: solid 1px;"><strong>Saldo:</strong></td>
                                <td style="border-top: solid 1px;">{{\App\_clases\utilitarios\Money::toMoney(($proyecto['d']['limite']-($proyecto['d']['acumulado']+$proyecto['d']['otras_ejecutoras']+$proyecto['d']['pim1'])), '')}}</td>
                            </tr>
                        </table>
                    </td>
                    <td>{{\App\_clases\utilitarios\Money::toMoney($proyecto['d']['de'], '')}}</td>
                    <td>{{\App\_clases\utilitarios\Money::toMoney($proyecto['d']['a'], '')}}</td>
                    <td>
                    <table width="100%">
                        <tr>
                            <td><strong>Limite: </strong></td>
                            <td>{{\App\_clases\utilitarios\Money::toMoney($proyecto['d']['limite'], '')}}</td>
                        </tr>
                        <tr>
                            <td><strong>Acumulado: </strong></td>
                            <td>{{\App\_clases\utilitarios\Money::toMoney($proyecto['d']['acumulado'], '')}}</td>
                        </tr>
                        @if($proyecto['d']['otras_ejecutoras']>0)
                            <tr>
                                <td><strong>Otras Ejecutoras:</strong></td>
                                <td>{{\App\_clases\utilitarios\Money::toMoney($proyecto['d']['otras_ejecutoras'], '')}}</td>
                            </tr>
                        @endif
                        <tr>
                            <td><strong>PIM:</strong></td>
                            <td>{{\App\_clases\utilitarios\Money::toMoney($proyecto['d']['pim'], '')}}</td>
                        </tr>
                        <tr {{(($proyecto['d']['limite']-($proyecto['d']['acumulado']+$proyecto['d']['otras_ejecutoras']+$proyecto['d']['pim']))<0)?'style=background-color:#f5baba':''}}>
                            <td style="border-top: solid 1px;"><strong>Saldo:</strong></td>
                            <td style="border-top: solid 1px;">{{\App\_clases\utilitarios\Money::toMoney(($proyecto['d']['limite']-($proyecto['d']['acumulado']+$proyecto['d']['otras_ejecutoras']+$proyecto['d']['pim'])), '')}}</td>
                        </tr>
                    </table></td>
                    <td>{{\App\_clases\utilitarios\Money::toMoney($proyecto['d']['certificado'], '')}}</td>
                    <td></td>
                </tr>
                @foreach($proyecto as $id_comp=>$componente)
                    @if($id_comp!='d')
                        <tr class="alert alert-info" style="font-weight: bold; background-color: #c5dfec" id="{{$id_proy.$id_comp}}_">
                            <td>{{$componente['d']['nombre']}}@if($componente['d']['sec_func']>0) <br><strong style="color: #000; text-decoration: underline;background-color: #f5baba;">SEC FUNC (META) - {{$componente['d']['sec_func']}}</strong> @endif</td>
                            <td>
                                <table>
                                    <tr>
                                        <td><strong>Acumulado: </strong></td>
                                        <td style="font-weight: 100;">{{\App\_clases\utilitarios\Money::toMoney($componente['d']['acumulado'], '')}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>PIM</strong></td>
                                        <td style="font-weight: 100;">{{\App\_clases\utilitarios\Money::toMoney($componente['d']['pim1'], '')}}</td>
                                    </tr>
                                </table>
                            </td>
                            <td>{{\App\_clases\utilitarios\Money::toMoney($componente['d']['de'], '')}}</td>
                            <td>{{\App\_clases\utilitarios\Money::toMoney($componente['d']['a'], '')}}</td>
                            <td>{{\App\_clases\utilitarios\Money::toMoney($componente['d']['pim'], '')}}</td>
                            <td>{{\App\_clases\utilitarios\Money::toMoney($componente['d']['certificado'], '')}}</td>
                            <td><a href="#{{$componente['d']['sec_func']}}_add" data-data="{{json_encode($componente['d']['add'])}}" class="edit" id="{{$componente['d']['sec_func']}}_add"><i class="glyphicon glyphicon-plus"></i> Agregar Especifica</a></td>
                        </tr>
                    @foreach($componente as $id_esp=>$especifica)
                        @if($id_esp!='d')
                        <tr class="alert alert-{{$especifica['d']['alert']}}" data-id="{{$especifica['d']['id']}}">
                            <td>{{$especifica['d']['nombre']}}
                                <br>
                                <a href="#" data-id="{{$especifica['d']['id']}}" class="delete"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>

                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td><strong>Acumulado: </strong></td>
                                        <td>{{\App\_clases\utilitarios\Money::toMoney($especifica['d']['acumulado'], '')}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>PIM</strong></td>
                                        <td>{{\App\_clases\utilitarios\Money::toMoney($especifica['d']['pim1'], '')
                                            /*\App\_clases\utilitarios\Money::toMoney($especifica['d']['pim1'], '').json_encode($especifica['d']['pim2']).json_encode($especifica['d']['pim1'])*/}}</td>
                                    </tr>
                                </table>
                            </td>
                            <td>{{ Form::text('solc_certificado', $especifica['d']['de'], array('class' => 'form-control modif modif_de seleccionar','required'=>1,
                            'max'=>$especifica['d']['pim1']-$especifica['d']['certificado'], 'data-value'=>$especifica['d']['de'], 'data-position'=> $id_proy.$id_comp )) }}
                            <div>max: {{\App\_clases\utilitarios\Money::toMoney($especifica['d']['pim1']-$especifica['d']['certificado'], '')}}</div></td>
                            <td>{{ Form::text('solc_certificado', $especifica['d']['a'] , array('class' => 'form-control modif modif_a seleccionar','required'=>1,
                            'data-value'=>$especifica['d']['a'], 'data-position'=> $id_proy.$id_comp)) }}
                            {{Form::hidden('pim',$especifica['d']['pim1'],array('class'=>'pim'))}}</td>
                            <td>{{\App\_clases\utilitarios\Money::toMoney($especifica['d']['pim'], '')}}</td>
                            <td>{{\App\_clases\utilitarios\Money::toMoney($especifica['d']['certificado'], '')}}
                                <br><strong>{{$especifica['d']['certificados']}}</strong></td>
                            <td class="justificacion">{{ Form::textarea('solc_certificado', $especifica['d']['justificacion'] , array('class' => 'form-control modif modif_just','required'=>1,
                             'data-value'=>$especifica['d']['justificacion'], 'data-position'=> $id_proy.$id_comp)) }}</td>
                        </tr>
                        @endif
                    @endforeach
                    @endif
                @endforeach
            @endforeach
        @else
        <tr>
            <td colspan="8" class="text-center">No existe informacion cargada</td>
        </tr>
        @endif
        </tbody>
    </table>