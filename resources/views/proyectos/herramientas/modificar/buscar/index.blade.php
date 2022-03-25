@extends('layouts.proyectos.herramientas.tab_buscar')
@section('tabContent')
    <div class="panel-body" id="modificar_module">
        <div class="col-md-12 load_table" id="p_c_i_table" style="background-color:#fff">
            <table class="table table-striped" id="cadenas-table">
                <thead>
                <tr>
                    <th>Proyecto</th>
                    <th>Cod Unif </th>
                    <th>Componente</th>
                    <th>FFT</th>
                    <th>Especifica</th>
                    <th>Tipo</th>
                    <th>Pim</th>
                    <th>Sec Func</th>
                    <th>Accion</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    $(function() {
        table=$('#cadenas-table');
        table.DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('proyectos.herramientas.modif.buscar',[$anio ]) !!}?listar=1',
            columns: [
                { data: 'proy_nombre',                  name: 'proy_proyecto.proy_nombre' },
                { data: 'proy_cod_siaf',                  name: 'proy_proyecto.proy_cod_siaf',   visible: false},
                { data: 'comp_nombre',                  name: 'proy_plan_componente.comp_nombre',   visible: false},
                { data: 'det_fuente_financiamiento',    name: 'det_fuente_financiamiento',          searchable: false },
                { data: 'comp_programa',                name: 'comp_programa',                      searchable: false },
                { data: 'ESPECIFICA',                   name: 'siaf_wpresupuesto.ESPECIFICA' },
                { data: 'pim',                          name: 'siaf_wpresupuesto.pim' },
                { data: 'SEC_FUNC',                     name: 'siaf_meta.SEC_FUNC' },
                { data: 'action',                       name: 'action',                             orderable: false, searchable: false}
            ],
            displayLength: 25,
            language: {
                lengthMenu: "Mostrando _MENU_ Clientes por pagina.",
                zeroRecords: "No hay Clientes cargados en este momento (Intente modificando los filtros).",
                info: "Mostrando del _START_ al _END_ de _TOTAL_ Clientes",
                infoEmpty: "No se encontaron Clientes",
                infoFiltered: "(Filtrado de un total de _MAX_ Clientes)"
            },
            order: [[ 0, 'desc' ],[ 5, 'desc' ],[ 1, 'desc' ]]
        });
        table.on('click', '.return',function () {
            window.opener.update($(this).data('data'));
            window.close();
        })
    });
</script>
@endpush