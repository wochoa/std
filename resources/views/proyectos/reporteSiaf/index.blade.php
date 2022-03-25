@extends('layouts.proyectos.dashboard')
@section('titulo'){{ 'Ejecucion ('.$anio.')'}}@endsection

@section('header')
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Desplegar / Ocultar Menu</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="{{route('proyectos.reporte.siaf', array('anio' => $anio))}}" class="navbar-brand" style="color: white;">EJECUCION {{$anio}}</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
            <ul class="nav navbar-nav">
                <li class="dropdown" id="when">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-texto="Hasta ">Hasta<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Alternar
                            <div class="material-switch pull-right" style="top: 10px;position: inherit;">
                                <input id="alternar_tiempo" name="alternar_tiempo" type="checkbox" checked/>
                                <label for="alternar_tiempo" class="label-success"></label>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Año <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @foreach($anios as $a)
                        <li {{($a==$anio)?'class=active':''}}><a href="{{route('proyectos.reporte.siaf', array('anio' => $a))}}" data-oficina="0">{{$a}}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Oficina (todos) <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="oficinas">
                        <li class="active"><a href="#" data-oficina="0" data-obras="all">Reporte General</a></li>
                        <li class="dropdown-submenu">
                            <a class="submenu no-action" href="#">Sub Gerencia de Obras <span class="caret"></span></a>
                            <ul class="dropdown-menu ul-submenu">
                                <li><a href="#" data-oficina="1" data-obras="all">Todas las obras</a></li>
                                <li><a href="#" data-oficina="1" data-obras="1">Paquete 1</a></li>
                            </ul>
                        </li>
                        <li><a href="#" data-oficina="2" data-obras="all">Sub Gerencia de Estudios</a></li>
                        <li><a href="#" data-oficina="3" data-obras="all">Sub Gerencia de Liquidaciones</a></li>
                        <li class="dropdown-header" data-oficina="4" data-obras="all">Direccion Regional de Transportes y Conmunicaciones</li>
                    </ul>
                </li>
                <li class="dropdown" id="personas">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-texto="Hasta "> Persona<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Alternar
                            <div class="material-switch pull-right" style="top: 10px;position: inherit;">
                                <input id="alternar_tiempo" name="alternar_tiempo_persona" type="checkbox"/>
                                <label for="alternar_tiempo" class="label-success"></label>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
            </div>
        </div>
    </nav>
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
            <div class="panel panel-default">
                <div class="panel-heading ">
                    <div class="row">
                        <div class="col-xs-6 col-sm-8 col-lg-10"><p class="nombre_proyecto">Todos los Proy</p><a class="btn_clean_proy hide  right col-xs-6 col-sm-4 col-lg-2">Liberar Seleccion</a></div>

                        <a data-toggle="collapse" href="#list_proyectos" class="btn_proy collapsed right col-xs-6 col-sm-4 col-lg-2">Seleccionar Proyecto</a>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body collapse" id="list_proyectos">
                    <div class="table-responsive">
                        <table class="table table-striped" id="obras-table">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>SIAF</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-8 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i>  Reporte General
                </div>
                <div class="panel-body">
                    @foreach($resumen as $id=>$dato)
                    <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 resumen" id="{{$id}}">
                        <div class="panel {{$dato['class']}}">
                            @if(isset($dato['color']))
                            <div class="panel-heading chng_progress" data-show="{{$id}}" data-color="{{$dato['color']}}">
                            @else
                                    <div class="panel-heading">
                            @endif
                                <div class="row">
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="padding: 0 5px;"><div class="pres_titulo">{{$dato['titulo']}}</div></div>
                                    @if(isset($dato['color']))
                                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text-right" style="padding: 0 5px;"><div class="percent">Cargando..</div></div>
                                    @endif
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right" style="padding: 0 5px;"><div class="monto">Cargando..</div></div>
                                </div>
                            </div>
                            <a><div class="panel-footer"><span class="pull-left updated_to">Actualizado hasta (<strong>Cargando</strong>)</span><div class="clearfix"></div></div></a>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 resumen" id="progress"><div class="progress"><div class="progress-bar progress-bar-danger" role="progressbar" data-color="danger" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0"></div></div></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 resumen" id="meses">
                        <div class="progress">
                            @foreach(["Ene", "Feb", "Mar", "Abr", "May", "Jun","Jul", "Ago", "Set", "Oct", "Nov", "Dic"] as $mes)
                            <div class="progress-bar progress-bar-info" role="progressbar" style="width:8.333%">{{$mes}}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Avance Diario (Solo Devengado)
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="morris-area-chart" class="chart"></div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-8 -->
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Prog Vs Ejec
                    <div style="position:  absolute;right:  50px;top: 13px;width: 140px"> Detalle diario?
                    <div class="material-switch pull-right" style="top: 10px;position: relative;">
                        <input id="detalle_diario" name="detalle_diario" type="checkbox"/>
                        <label for="detalle_diario" class="label-success"></label>
                    </div>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" style="padding: 0;">
                    <div id="prg_vs_ejec" class="chart"></div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-8 -->
    </div>
@endsection
@push('style')
<style>
    .ul-submenu{position: inherit;border: white;box-shadow: none;padding-left: 15px;width: 100%;}
    #page{margin-top: 55px;}
    /* Icon when the collapsible content is shown */
    .btn_proy:after {
        font-family: "Glyphicons Halflings";
        content: "\e114";
        float: right;
        margin-left: 15px;
    }
    /* Icon when the collapsible content is hidden */
    .btn_proy.collapsed:after {
        content: "\e080";
    }
    .material-switch > input[type="checkbox"] {
        display: none;
    }

    .material-switch > label {
        cursor: pointer;
        height: 0px;
        position: relative;
        width: 40px;
    }

    .material-switch > label::before {
        background: rgb(0, 0, 0);
        box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
        border-radius: 8px;
        content: '';
        height: 16px;
        margin-top: -8px;
        position:absolute;
        opacity: 0.3;
        transition: all 0.4s ease-in-out;
        width: 40px;
    }
    .material-switch > label::after {
        background: rgb(255, 255, 255);
        border-radius: 16px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        content: '';
        height: 24px;
        left: -4px;
        margin-top: -8px;
        position: absolute;
        top: -4px;
        transition: all 0.3s ease-in-out;
        width: 24px;
    }
    .material-switch > input[type="checkbox"]:checked + label::before {
        background: inherit;
        opacity: 0.5;
    }
    .material-switch > input[type="checkbox"]:checked + label::after {
        background: inherit;
        left: 20px;
    }

    body, .panel-body {background-color: white !important;}
    .progress{margin-bottom: 0 !important;}
    .progress-bar {padding: 0 0 0 0;font-weight: bolder;}
    .morris-hover.morris-default-style{font-size:20px !important;}
    #meses .progress-bar{border-right: white 1px solid;}
    table.dataTable tbody td {
        padding: 2px 10px; !important;
    }
    .panel{margin-bottom: 5px !important;}
    @media screen and (max-width: 399px) {
        .monto{font-size: 0.8em;}
        .percent{font-size: 18px}
        .pres_titulo{font-size: 20px;}
        .resumen .panel{margin: 0}
        .resumen{padding: 1px}
        .panel-body{padding: 1px}
        .panel-default{margin: 0}
        .progress{height: 20px !important;}
        .progress-bar {font-size: 10px;}
        .updated_to{font-size: 10px;}
        .panel-footer{padding: 2px;}
        circle{r:2}
    }
    @media screen and (min-width: 400px) and (max-width: 767px) {
        .monto{font-size: 1em;}
        .percent{font-size: 21px}
        .pres_titulo{font-size: 23px;}
        .progress{height: 20px !important;}
        .progress-bar {font-size: 14px;}
        .updated_to{font-size: 13px;}
        .panel-footer{padding: 2px;}
        circle{r:2}
    }
    @media screen and (min-width: 768px) and (max-width: 991px)  {
        .monto{font-size: 1.2em;}
        .percent{font-size: 24px}
        .pres_titulo{font-size: 26px;}
        .progress{height: 23px !important;}
        .progress-bar {font-size: 16px;}
        .updated_to{font-size: 14px;}
        .panel-footer{padding: 2px;}
    }
    @media screen and (min-width: 992px) and (max-width: 1199px)  {
        .monto{font-size: 1.3em;}
        .percent{font-size: 27px}
        .pres_titulo{font-size: 29px;}
        .progress{height: 23px !important;}
        .progress-bar {font-size: 18px;}
        .updated_to{font-size: 15px;}
        .panel-footer{padding: 2px;}
    }
    @media screen and (min-width: 1200px) {
        .monto{font-size: 1.7em;}
        .percent{font-size: 30px}
        .pres_titulo{font-size: 32px;}
        .progress{height: 23px !important;}
        .progress-bar {font-size: 20px;}
        .updated_to{font-size: 16px;}
        .panel-footer{padding: 2px;}
    }
    @media screen and (max-height: 800px){
        .chart{height: 300px}
    }
    @media screen and (min-height: 801px){
        .chart{height: 500px}
    }
</style>
@endpush
@push('scripts')
            <!--{!!Html::script('/js/reporteSiaf.js')!!}-->
<script>
    Number.prototype.formatMoney = function(c, d, t){
        var n = this,
            c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };
    $(document).ready(function (e) {

        var graph=null;
        var prg_ejec = null;
        var dt=null;
        var oficina=0;
        var obra = 'all';
        var diario = false;
        var proy = null;
        morris=$("#morris-area-chart");
        when=$('#when .dropdown-menu');
        prog=$('#progress').find('.progress-bar');
        actualizado_hasta=$('.updated_to strong');
        meses=$('#meses .progress-bar');
        alternar=$('#alternar_tiempo');
        alternar_proy=$('#alternar_tiempo_proyecto');
        detalle_diario=$("#detalle_diario");
        oficinas=$('#oficinas li a');
        loadDates=true;
        $(meses[(new Date).getMonth()]).removeClass('progress-bar-info');
        $(meses[(new Date).getMonth()]).addClass('progress-bar-danger');
        morris.height($(window).height()*0.43);
        $('#prg_vs_ejec').height($(window).height()*0.43);
        show='dev';
        var curBtn=0;
        var data = [];
        function loadOficina(reload) {
            reload = typeof reload !== 'undefined' ?  reload : true;
            $.ajax({
                method: "GET",
                url: "{{route('proyectos.reporte.siaf')}}",
                data: {anio: "{{$anio}}", option: "prog_vs_ejecutado",oficina: oficina, obras:obra, diario:detalle_diario.is(':checked')},
                dataType: 'json'
            }).done(loadProgramadoVsEjecutado);
            $.ajax({
                method: "GET",
                url: "{{route('proyectos.reporte.siaf')}}",
                data: {anio: "{{$anio}}", option: "general",oficina: oficina, obras:obra},
                dataType: 'json'
            }).done(function (msg) {
                data = msg;
                //loadDates variable que sirve para controlar que se cargue una sola ves el listado de puntos cronologicos disponibles
                if (loadDates) {
                    $.each(msg, function (index, value) {
                        li=$('<li></li>');
                        btn = $('<a href="#"></a>').append(' ' + value.name).addClass(index.toString()).data("index", index).data("name", value.name);
                        if (index === msg.length - 1)
                            li.addClass('active');
                        li.append(btn)
                        when.append(li)
                    });
                    loadDates=false;
                }
                curBtn = msg.length-1;
                var hoy = msg[msg.length - 1];
                loadReporteDiario(hoy);
            });
            if(reload)
                if (dt==null){
                    dt = $('#obras-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: '{{route('proyectos.reporte.siaf')}}?option=listado&oficina='+oficina+'&anio={{$anio}}&obras='+obra,
                        displayLength: 10,
                        columns: [
                            { data: 'proy_nombre', name: 'proy_nombre' },
                            { data: 'proy_cod_siaf', name: 'proy_cod_siaf', visible: false },
                            {data: 'action', name: 'action', orderable: false, searchable: false}
                        ]
                    });
                }
                else
                    dt.ajax.url('{{route('proyectos.reporte.siaf')}}?option=listado&oficina='+oficina+'&anio={{$anio}}&obras='+obra).load();

        }
        function hoverFunction(index, options, content, row) {
            table=$('<table data-fecha="'+new Date(row[options.xkey]).getDate()+'" class="btn"></table>');
            table.append('<thead><tr><th colspan=\"2\" class="text-center">'+options.dateFormat(row[options.xkey])+'</th></tr></thead>');
            tbody=$('<tbody title="Click para ver detalle"></tbody>');
            $.each(options.labels, function (index, value) {
                if (row[value]!=null) {
                    tr=$('<tr style="color: ' + options.lineColors[index] + ';" class="text-left"></tr>');
                    tr.append('<td>' + value + '</td>').append('<td class="text-right">' + options.preUnits + row[value].formatMoney(2, '.', ',') + '</td>')
                    tbody.append(tr);
                }
            });
            table.append(tbody);
            return table;
        };
        //load programado vs Ejecutado
        function loadProgramadoVsEjecutado(dato){
            if (prg_ejec==null) {
                prg_ejec = Morris.Line({
                    element: 'prg_vs_ejec',
                    data: dato,
                    xkey: 'dia',
                    ykeys: ['programado', 'ejecutado'],
                    labels: ['programado', 'ejecutado'],
                    pointSize: 0,
                    xLabels: 'month',
                    hideHover: 'auto',
                    resize: true,
                    preUnits: 'S/ ',
                    lineColors: ['#0b62a4', '#ff0000'],
                    lineWidth: 2,
                    xLabelFormat: function (x) {
                        months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                            "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"];
                        return months[x.getMonth()]
                    }
                });
            }
            else
                prg_ejec.setData(dato);
        }
        function loadReporteDiario(dato){
            //load reporte diario
            cuando = when.find('li.active').find('a').data('name');
            actualizado_hasta.html(cuando);
            if (graph==null)
                graph = Morris.Line({
                    element: 'morris-area-chart',
                    data: dato.reportediario,
                    xkey: 'dia',
                    ykeys: ['enero', 'febrero', 'marzo','abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'],
                    labels: ['enero', 'febrero', 'marzo','abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'],
                    pointSize: 3,
                    xLabels:'day',
                    hideHover: 'auto',
                    resize: true,
                    preUnits: 'S/ ',
                    lineWidth:1,
                    hoverCallback: hoverFunction,
                    xLabelFormat:function (x) {return x.getDate(); },
                    dateFormat:function (x) {return 'Día '+new Date(x+' GMT-0500').getDate(); }
                });
            else
                graph.setData(dato.reportediario);
            $(morris.find('path')[5]).css('stroke-width',4);
            //fin load reporte diario
            //carga de presupuesto
            $('#pim').find('.row .text-right div').html('S/ '+dato.presupuesto.formatMoney(2, '.', ','));
            //fin de carga presupuesto
            //carga de certificado
            cert = $('#cert').find('.row .text-right div');
            $(cert[0]).html(((dato.certificado/dato.presupuesto)*100).formatMoney(2, '.', ',')+'%');
            $(cert[1]).html('S/ '+dato.certificado.formatMoney(2, '.', ','));
            //fin de carga certificado
            //carga de compromiso
            comp = $('#comp').find('.row .text-right div');
            $(comp[0]).html(((dato.comprometido/dato.presupuesto)*100).formatMoney(2, '.', ',')+'%');
            $(comp[1]).html('S/ '+dato.comprometido.formatMoney(2, '.', ','));
            //fin de carga compromiso
            //carga de compromiso
            dev = $('#dev').find('.row .text-right div');
            $(dev[0]).html(((dato.devengado/dato.presupuesto)*100).formatMoney(2, '.', ',')+'%');
            $(dev[1]).html('S/ '+dato.devengado.formatMoney(2, '.', ','));
            //fin de carga compromiso
            //carga de progreso
            porcentaje=0;
            switch (show){
                case 'dev':{porcentaje=((dato.devengado/dato.presupuesto)*100);break;}
                case 'comp':{porcentaje=((dato.comprometido/dato.presupuesto)*100);break;}
                case 'cert':{porcentaje=((dato.certificado/dato.presupuesto)*100);break;}
            }
            prog.animate({
                width: porcentaje+'%'
            }, 0, "linear");
            prog.html(porcentaje.formatMoney(2, '.', ',')+'%');
            //fin de carga de proceso
            //console.log(divs);
        }
        function update() {
            if(alternar.is(':checked')) {
                curBtn++;
                curBtn = curBtn % data.length;

                when.find('a').parent().removeClass('active');
                when.find('.' + (curBtn)).parent().addClass('active');
                loadReporteDiario(data[curBtn]);
            }
            if(alternar_proy.is(':checked')) {
                curBtn++;
                curBtn = curBtn % data.length;

                when.find('a').parent().removeClass('active');
                when.find('.' + (curBtn)).parent().addClass('active');
                loadReporteDiario(data[curBtn]);
            }
        }
        function update_proy() {
            if(alternar_proy.is(':checked')) {
                curBtn++;
                curBtn = curBtn % data.length;

                when.find('a').parent().removeClass('active');
                when.find('.' + (curBtn)).parent().addClass('active');
                loadReporteDiario(data[curBtn]);
            }
        }
        /**evento que se desencadena cuando hacemos click en los recuadros para cambiar el color de el progressbar*/
        $('.chng_progress').click(function () {
            prog.removeClass('progress-bar-'+prog.data('color'));
            prog.addClass('progress-bar-'+$(this).data('color'));
            prog.data('color',$(this).data('color'));
            show=$(this).data('show');
            loadReporteDiario(data[curBtn]);
        });
        /**evento que se desencadena cuando cambiamos la oficina*/
        oficinas.click(function (event) {
            event.preventDefault();
            if (!$(this).hasClass('disabled')&&!$(this).hasClass('no-action')) {
                obra=$(this).data('obras');
                oficina =$(this).data('oficina');
                loadOficina(true);
                oficinas.parent().removeClass('active');
                $(this).parent().addClass('active');
            }
        });
        /**evento que se desencadena cuando cambiamos el periodo que se muestra el reporte*/
        when.on('click', 'a', function (event) {
            event.preventDefault();
            when.find('li').removeClass('active');
            $(this).parent().addClass('active');
            curBtn=$(this).data('index');
            loadReporteDiario(data[curBtn]);
        });
        morris.on('contextmenu', '.morris-hover table', function (e) {
            e.preventDefault();

            morris.find('.dropdown').remove();
            div=$('<div class="dropdown bootstrapMenu" style="z-index:10000;position:fixed;display:block;width:158px;"></div>');
            ul=$('<ul class="dropdown-menu" style="position:static;display:block;font-size:0.9em;">');
            ul.append('<li role="presentation" data-action="0" class=""><a href="#" role="menuitem"><span class="actionName">Ver Detalle</span></a></li>');
            div.append(ul);
            position=morris.position();
            div.css('top',event.clientY+'px');
            div.css('left',event.clientX+'px');
            morris.append(div);
        });
        detalle_diario.change(function (e) {
            e.preventDefault();
            loadOficina(false);
        });
        $('.btn_clean_proy').click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            obra='all';
            $('.nombre_proyecto').html('Todos los Proy');
            loadOficina(false);
            $(this).addClass("hide")
        })

        $('#obras-table').on('click', '.return', function (e) {
            e.preventDefault();
            obra=$(this).data('data').proy_cod_siaf;
            $('.nombre_proyecto').html($(this).data('data').proy_nombre);
            loadOficina(false);
            $('#list_proyectos').collapse("hide")
            $('.btn_clean_proy').removeClass("hide")
        });
        $('.dropdown-submenu a.submenu').on("click", function(e){
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
        });
        loadOficina(true);
        setInterval(update, 10000);
        setInterval('location.reload()',3600000)
    })
</script>
@endpush