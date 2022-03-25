@extends('layouts.proyectos.herramientas.tab_documento')
@section('tabContent')
    <div class="panel-body" id="detalle_module">
        <div class="col-md-12 load_table" id="p_c_i_table" style="background-color:#fff"></div>
    </div>
@endsection
@push('scripts')
<script>
    rList='{{route('proyectos.herramientas.certificar.detalle.index',[$anio,$doc,$sol] )}}?listar=1';
    rSave='{{route('proyectos.herramientas.certificar.detalle.store',[$anio,$doc,$sol] )}}';
    rDelete='{{route('proyectos.herramientas.certificar.detalle.destroy',[$anio,$doc,$sol,'%s'] )}}';
    rSave='{{route('proyectos.herramientas.certificar.detalle.store',[$anio,$doc,$sol] )}}';
    token='{{csrf_token()}}';

    function showTable() {
        $('#detalle_module').find('.load_table').load(rList);
    }
    showTable();
$('#detalle_module').on('change','.inc_sol',function (event) {
    envio = $(this).data('data');
    envio._token=token;
    console.log($(this).is(':checked'));
    ajaxData={
        type: "POST",
        url: rSave,
        data: envio,
        dataType :'json',
        success: function(d)
        {
            if(d.ok)
            {
                showTable();
            }
            else
                alert(d.msg);
        },
        error:function(d){
            //console.log(d);
        }
    };
    if ($(this).is(':checked')){
        ajaxData.url=rSave;
        ajaxData.type="POST";
    } else {
        ajaxData.url= rDelete.replace(/%s/g, envio.id);
        ajaxData.type="DELETE";
    }
    $.ajax(ajaxData);
})
</script>
@endpush