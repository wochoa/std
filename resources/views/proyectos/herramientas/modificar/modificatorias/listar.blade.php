    <table class="table table-striped" id="modificatorias_table">
        <thead>
            <tr>
                <th>Modificatoria</th>
                <th>Fecha</th>
                <th>Accion</th>
            </tr>
        </thead>
    </table>
    <script>
        $(function() {
            table=$('#modificatorias_table');
            table.DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('proyectos.herramientas.{anio}.modificar.index',[$anio] )}}?datatable=1',
                columns: [
                    { data: 'modif_titulo', name: 'proy_tools_modificatoria.modif_titulo' },
                    { data: 'modif_fecha_aprovacion', name: 'proy_tools_modificatoria.modif_fecha_aprovacion', 'type': 'num', 'render': { '_': 'display', 'sort': 'timestamp' }},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                displayLength: 10,
                language: {
                    lengthMenu: "Mostrando _MENU_ Documentos por pagina.",
                    zeroRecords: "No hay Documentos cargados en este momento (Intente modificando los filtros).",
                    info: "Mostrando del _START_ al _END_ de _TOTAL_ Documentos",
                    infoEmpty: "No se encontaron Documentos",
                    infoFiltered: "(Filtrado de un total de _MAX_ Documentos)"
                },
                order: [[ 2, 'desc' ]]
            });
        });
    </script>