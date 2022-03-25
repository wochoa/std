@extends('layouts.proyectos.herramientas.tab_modificar')
@section('titulo'){{ 'Detalle de Modificatoria'}}@endsection
@section('homeText'){{ $modif_nombre.' ('.$modif_fecha.')'}}@endsection
@section('tabContent')
    <style>.fstResults{ width: 55em !important;} .fstControls { width: 45em !important;} .fstGroupTitle,.fstResultItem{ padding: 1px 5px !important;} .fstGroup{padding: 0px!important;}</style>
    <div class="panel-body" id="modificar_module">
        <div class="mod_ad modal fade" tabindex="-1" role="dialog" aria-labelledby="SelAnioModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content form-group col-md-12 ">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-xs-12 col-sm-12">
                                {{ Form::label('proy_nombre', 'Proyecto') }}
                                <div>
                                    {{ Form::textarea('proy_nombre', null, array('class' => 'form-control reset', 'style'=>'padding-right: 50px;resize: none;height: 100px;', 'readonly'=>1)) }}
                                    <button type="button" class="btn btn btn-info serach" style="float: left;position: absolute;top: 19px;right: 16px;"><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-xs-12 col-sm-12">
                                {{ Form::label('comp_nombre', 'Componente') }}
                                <div>
                                    {{ Form::text('comp_nombre', null, array('class' => 'form-control reset', 'style'=>'padding-right: 50px;', 'readonly'=>1)) }}
                                    <button type="button" class="btn btn btn-info serach" style="float: left;position: absolute;top: 19px;right: 16px;"><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                                {{ Form::label('det_fuente_financiamiento', 'Fuente de Financiamiento') }}
                                {{ Form::select('det_fuente_financiamiento', $fuenteFinanciamiento, null, array('class' => 'form-control send reset', 'required'=>1) )}}
                            </div>
                            {{ Form::label('det_id_clasif', 'Especifica') }}
                            <div class="form-group col-xs-12 col-sm-6 col-lg-6" style="font-size: 8px">
                                {{ Form::select('det_id_clasif', $especificas, null, array('class' => 'form-control send reset', 'required'=>1, 'multiple'=>'multiple') )}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-xs-12 col-sm-12">
                        {{ Form::hidden('id', null, array('class' => 'send'))}}
                        {{ Form::hidden('modificatoria_id', $modif, array('class' => 'send'))}}
                        {{ Form::hidden('componente_id', -1, array('class' => 'send'))}}
                        {{ Form::hidden('_token', csrf_token(), array('class' => 'send'))}}
                        {{ Form::button('Guardar', array('type' => 'button', 'class' => 'btn btn-warning btn_guardar')) }}
                        {{ Form::button('Cancelar', array('type' => 'button', 'class' => 'btn btn-danger btn_cancelar')) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="mod_ad_btn">
            <div class="row">
                <div class="col-xs-3 col-sm-2 col-lg-1">
                {{Form::button('Agregar', array('type' => 'button', 'class' => 'btn btn-primary btn_agregar')) }}
                </div>
                <div class="form-group  col-xs-3 col-sm-3 col-lg-3">
                    {{ Form::select('fft', $fuenteFinanciamiento, $fft, array('class' => 'form-control change_type', 'required'=>1) )}}
                </div>
                <div class="form-group  col-xs-3 col-sm-3 col-lg-3">
                    {{ Form::select('tipo', [ 'APnoP'=>'ASIGNACIONES PRESUPUESTARIAS QUE NO RESULTAN EN PRODUCTOS', 'PP'=>'PROGRAMAS PRESUPUESTALES', 'all'=>'TODOS'], $opt, array('class' => 'form-control change_type', 'required'=>1) )}}
                </div>
                <div class="col-xs-1 col-sm-1 col-lg-1">
                    <button type="button" class="btn btn-danger btn_print"><i class="glyphicon glyphicon-print"></i> Especificas</button>
                </div>
                <div class="col-xs-1 col-sm-1 col-lg-1">
                    <button type="button" class="btn btn-warning btn_print_proyectos"><i class="glyphicon glyphicon-print"></i> Proy</button>
                </div>
                <div class="col-xs-1 col-sm-1 col-lg-1">
                    <button type="button" class="btn btn-info btn_print_general"><i class="glyphicon glyphicon-print"></i> General</button>
                </div>
            </div>
        </div>
        <div class="load_table" id="p_c_i_table" style="background-color:#fff"></div>
    </div>
    <style>
        #modificar_module table input{padding: 6px 3px 6px 3px;}
        #modificar_module table tbody textarea{height: 50px;padding: 0;font-size: 12px;}
        #modificaciones tbody tr td{padding: 0px;}
        .justificacion{padding: 2px !important;}
    </style>
@endsection
@push('scripts')
<script>
    function resolver(str) {
        if (str.substring(0,1)=='='||str.substring(0,1)=='+'){
            str = str.substring(1);
            if((dividido = str.split("+")).length == 2){
                return parseInt(dividido[0])+ parseInt(dividido[1]);
            }
            else if((dividido = str.split("-")).length == 2){
                return parseInt(dividido[0])- parseInt(dividido[1]);
            }
            else if((dividido = str.split("/")).length == 2){
                return parseInt(dividido[0])/ parseInt(dividido[1]);
            }
            else if((dividido = str.split("*")).length == 2){
                return parseInt(dividido[0])* parseInt(dividido[1]);
            }
            else
                return '='+str;
        }else
            return str;
    }
    function afterList_(e) {
        if(location.hash!='') {
            console.log($(location.hash))
            top_s = $(location.hash+'_').position().top - 51;
            $('html, body').animate({ scrollTop: top_s},250);
        }
    }
    module=$('#modificar_module');
    module.saveModule({
        rList: '{{route('proyectos.herramientas.modif.det.index',[$anio, $modif, $fft, $opt] )}}?option=listar',
        rDelete:'{{route('proyectos.herramientas.modif.det.destroy',[$anio, $modif, $fft, $opt,'%s'])}}',
        rSave:'{{route('proyectos.herramientas.modif.det.store',[$anio, $modif, $fft, $opt] )}}',
        token:'{{csrf_token()}}',
        requiredFields:['modificatoria_id','componente_id'],
        afterSave:function (res) {
            r= '{{route('proyectos.herramientas.modif.det.index',[$anio, $modif, '%x', '%y'] )}}';
            r = r.replace(/%x/g, res.fft);
            r = r.replace(/%y/g, res.opt);
            if(res.fft != '{{$fft}}' && !(res.opt == '{{$opt}}' || '{{$opt}}'=='all'))
            location.href=r

        },
        beforeEdit:function (e) {
            fastSelectInstance.destroy();
            fastSelectInstance = $select.fastselect(options).data('fastselect');
        },
        beforeAdd:function (e) {
            fastSelectInstance.destroy();
            fastSelectInstance = $select.fastselect(options).data('fastselect');
        },
        afterList:afterList_
    });
    module.find('.btn_print').click(function (e) {
        e.preventDefault();
        window.open(window.location+'?option=imprimir', 'Popup', "height=700,width=1025,scrollTo,resizable=1,scrollbars=1,location=0");
    });
    module.find('.btn_print_proyectos').click(function (e) {
        e.preventDefault();
        window.open(window.location+'?option=imprimir_proyectos', 'Popup', "height=700,width=1025,scrollTo,resizable=1,scrollbars=1,location=0");
    });
    module.find('.btn_print_general').click(function (e) {
        e.preventDefault();
        window.open(window.location+'?option=imprimir_general', 'Popup', "height=700,width=1025,scrollTo,resizable=1,scrollbars=1,location=0");
    });
    module.find('.serach').click(function (event) {
        event.preventDefault();
        window.open('{{route('proyectos.herramientas.modif.buscar',[$anio] )}}', 'Popup', "height=700,width=1050,scrollTo,resizable=1,scrollbars=1,location=0")
    });

    module.find('.mod_ad_btn .change_type').change( function() {
        r= '{{route('proyectos.herramientas.modif.det.index',[$anio, $modif, '%x', '%y'] )}}';
        row = $($(this).closest('.row'));
        console.log(row);
        r = r.replace(/%x/g, row.find('select[name=\'fft\']').val());
        r = r.replace(/%y/g, row.find('select[name=\'tipo\']').val());
        location.href=r
    });
    module.on( "focusin", "table tbody tr td .modif", function(e) {
        e.preventDefault();
        location.hash=$(this).data('position');
        top_s=$(location.hash+'_').position().top-51;
        $('html, body').animate({ scrollTop: top_s},250);
    });

    module.on( "focusout", "table tbody tr td .modif", function() {
        este = $(this);
        valor = resolver(este.val());
        este.val(valor);
        tr = $(this).closest('tr');
        id=tr.data('id');
        pim=tr.find('.pim');
        de=tr.find('.modif_de');
        a=tr.find('.modif_a');
        just=tr.find('.modif_just');
        var dato = tr.find('input');
        validate = true;
        dato.each(function () {
            if (!$(this)["0"].reportValidity()) {
                $(this).val($(this).data('value'));
                validate = false;
                return false;
            }
        });
        if(!(parseInt(de.data('value'))!=parseInt(de.val())||parseInt(a.data('value'))!=parseInt(a.val())||just.data('value')!=just.val()))
            validate = false;
        if(validate)
        guardarModificacion(id, pim.val(), de.val(), a.val(), just.val());
    });
    //called from buscar module
    function update(datos) {
        selectModule = '';
        module.saveModule({actions:'rellenar',parameter:datos});
    }
    function guardarModificacion(id, pim, de, a, just) {
        $.ajax({
            url:'{{route('proyectos.herramientas.modif.det.store',[$anio, $modif, $fft, $opt] )}}?option=1',
            method:'POST',
            data:{'id':id, 'pim':pim, 'de':de, 'a':a, 'justificacion':just, '_token': '{{csrf_token()}}'},
            success:function (result) {
                if (result.ok){
                    module.saveModule({rList: '{{route('proyectos.herramientas.modif.det.index',[$anio, $modif, $fft, $opt] )}}?option=listar',actions:'recargar',
                        afterList:afterList_
                    });
                }
                else
                    alert(result.msg);
            }
        });
    }
    options = {
        placeholder: 'Seleccione',
        searchPlaceholder: 'Buscar',
        noResultsText: 'Sin resultados',
        userOptionPrefix: 'Agregar '};
    /*var search = $('#det_id_clasif').fastselect();*/
    var $select = $('#det_id_clasif');

    // Run, fire and forget
    //$select.fastselect()

    // Run via plugin facade and get instance
    var fastSelectInstance = $select.fastselect(options).data('fastselect');
</script>
@endpush