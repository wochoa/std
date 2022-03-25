<div class="panel-body" id="modificar_module">
        <div class="col-md-12 load_table" id="p_c_i_table" style="background-color:#fff">
            <table class="table table-striped" id="cadenas-table">
                <thead>
                <tr>
                    <th>OBRA</th>
                    <th>SNIP</th>
                    <th>SIAF</th>
					<th>Seleccionar</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
<script>
    $(function() {
        table=$('#cadenas-table');
        table.DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('proyectos.herramientas.documento.buscar') }}?listar=1',
			columns: [
                { data: 'proy_nombre', name: 'proy_proyecto.proy_nombre' },
                { data: 'proy_cod_snip', name: 'proy_proyecto.proy_cod_snip'},
                { data: 'proy_cod_siaf', name: 'proy_proyecto.proy_cod_siaf'},
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            displayLength: 25,
            language: {
                lengthMenu: "Mostrando _MENU_ Obras por pagina.",
                zeroRecords: "No hay Obras cargados en este momento (Intente modificando los filtros).",
                info: "Mostrando del _START_ al _END_ de _TOTAL_ Obras",
                infoEmpty: "No se encontaron Obras",
                infoFiltered: "(Filtrado de un total de _MAX_ Obras)"
            },
            order: [[ 0, 'desc' ],[ 1, 'desc' ]]
        });
    });
</script>

    