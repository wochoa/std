<!DOCTYPE html>
<html lang="en">

<head>
    <title>COMPARAR PRECIOS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen">
    <style>
        table, th, td {
            font-size:11px;
            font-family: Tahoma;
        }
        
        /*------------------------------class = "table"------------------------------------*/
        table{
            border-collapse: collapse;
            text-align: left;
            width: 100%;  
            font-family: Tahoma;  
            background: #fff;
            border: 1px solid #DDDDDD; 
            margin-bottom: 10px;
        }

        table thead th {    
            color: #333333;  
            padding-top: 2px;
            padding-bottom: 2px;
            padding-left: 3px;
            padding-right: 3px;
            font-size: 11px;
            font-weight: bold;
            border-bottom: 2px solid #DDDDDD;  
            border-left: 1px solid #DDDDDD;  
        }

        table tbody td {
            color: #333333;    
            padding-top: 2px;
            padding-bottom: 2px;
            padding-left: 3px;
            padding-right: 3px;
            font-size: 11px;  
            font-weight: normal;  
            border: 1px solid #DDDDDD; 
        }
        /*------------------------------class = "table"------------------------------------*/

        /*------------------------------class = "primary"------------------------------------*/
        .info {
            background-color: #D9EDF7; 
        }

        .info th {
            background-color: #D9EDF7; 
        }

        .info td {
            background-color: #D9EDF7; 
        }
        /*------------------------------class = "primary"------------------------------------*/

        /*------------------------------class = "info"------------------------------------*/
        .active {
            background-color: #F5F5F5; 
        }

        .active th {
            background-color: #F5F5F5; 
        }

        .active td {
            background-color: #F5F5F5; 
        }
        /*------------------------------class = "info"------------------------------------*/
        .footnotes { 
            page-break-after:always; 
        }
    </style>
    
    @include('tramite.stylesheet')
    @include('tramite.scripts')
</head>

<body>
    {!! Form::open(array('url'=>'poi/comparar','method'=>'GET','autocomplete'=>'off','role'=>'search','class'=>'form-horizontal')) !!}
<!----------------------------------------------------------------------------------------------------------------->
    <!--TITULO-->
    <div class="content col-sm-10 col-sm-offset-1">   
        <table class="table table-bordered">
            <thead>
                <tr bgcolor="#98CCF4">
                    <th style="text-align: center" width="100%">COMPARAR GASTOS: RESUMEN DE PROGRAMACIÓN POR UNIDAD EJECUTORA</th>
                </tr>
            </thead>            
        </table>
    <!--FIN TITULO-->
        
        <div class="form-group">
            <label for="ex_ofi_codigo" class="col-sm-3">Unidad Ejecutora:</label>
            <div class="col-sm-8">
                <select class="form-control select2" id="ex_ofi_codigo" name="ex_ofi_codigo">
                    <option> ----- Seleccione una Unidad Orgánica ----- </option>
                    @foreach($oficina as $sel)
                        <option value="{{$sel->id}}"> {{$sel->id}}.- {{$sel->nombre}} </option>
                    @endforeach                
                </select>            
            </div>
        </div>
           
        <div class="form-group">
            <label for="cg_clasificador" class="col-sm-2">Clasificador:</label>
            <div class="col-sm-8">
                <select class="form-control select2" id="cg_clasificador" name="cg_clasificador">
                    <option> ----- Seleccione un Clasificador ----- </option>
                </select>
            </div>
            <div class="col-sm-1">
                {!! Form::button('<span class="glyphicon glyphicon-search"> Buscar</span>',
                array('class'=>'btn btn-primary', 'type'=>'submit', 'style'=>'font-size: 10px;')) !!}
            </div>
        </div>   

    <!--1. INFORMACIÓN GENERA-->    
        @foreach($poi as $p)
        <table class="table table-bordered table-condensed">    
            <thead>
                <tr class="info">
                    <th style="text-align:center">N°</th>
                    <th style="text-align:center" colspan="3">Unidad Ejecutora: {{ $p->codOfi }} - {{ $p->nomOfi }}</th>
                    <th style="text-align:center">Poi</th>
                    <th style="text-align:center">Pia</th>
                </tr>
            </thead>
            <tbody>                
                @php($cont=1)
                @foreach($total as $t)
                <tr>
                    <td style="text-align:center"><b>{{$cont}}</b></td>
                    <td style="text-align:right"><b>Cadena: </b></td>
                    <td>{{$t->clas}}-{{$t->cod}}-{{$t->prod}}-{{$t->act}}-{{$t->func}}-{{$t->div}}-{{$t->grup}}-{{$t->final}}-{{$t->met}}-{{$t->fuen}}</td>
                    <td style="text-align:center" class="active"><b>Total</b></td>
                    @if( $t->totalpoi == $t->totalpia)
                        <td class="success" style="text-align:right"><b>{{number_format($t->totalpoi, 2, '.', ', ')}}</b></td>
                        <td class="success" style="text-align:right"><b>{{number_format($t->totalpia, 2, '.', ', ')}}</b>
                    @else
                        <td class="danger" style="text-align:right"><b>{{number_format($t->totalpoi, 2, '.', ', ')}}</b></td>
                        <td class="danger" style="text-align:right"><b>{{number_format($t->totalpia, 2, '.', ', ')}}</b>
                    @endif
                </tr>
                @php($cont++)
                @endforeach  
            </tbody>
        </table>
        @endforeach  
    <!--FIN 1. INFORMACIÓN GENERA--> 
    
    <script>        
        $("#ex_ofi_codigo").change(function(){
            var id = $("#ex_ofi_codigo").val();
            $.ajax({
                url:  "comparar/"+id+"/clasificador",
                type: "GET",
                success: function(json){   
                    var select = '<option value>--Seleccione opción--</option>';                    
                    var option = '';
                    obj = json['clasificador']; 
                    $.each( obj, function( key, value ) {
                        option = option + '<option value="'+value['id']+'">'+value['id']+'</option>';
                    });                     
                    select = select + option;
                    $( "#cg_clasificador" ).html( select );                    
                }
            })
        });
    </script>
    </div>
    {{Form::close()}}
</body>
    
</html>
<!----------------------------------------------------------------------------------------------------------------->
                