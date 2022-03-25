@section('content')
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation"><a>Pedidos</a></li>
    </ul>
    <div class="panel panel-default">
        <div class="panel-heading">Listado de Clientes</div>
        <div class="panel-body">
            <div id="list">
                <div class="table-responsive">
                    <table class="table table-striped" id="users-table">
                        <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Distrito</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop

@push('scripts')
<script>
    $(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('datatables.pedidos',['id' => $id_viaje ]) !!}',
            columns: [
                { data: 'cli_nombre', name: 'cli_nombre' },
                { data: 'cli_distrito', name: 'cli_distrito' },
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            displayLength: 25,
            language: {
                lengthMenu: "Mostrando _MENU_ Clientes por pagina.",
                zeroRecords: "No hay Clientes cargados en este momento (Intente modificando los filtros).",
                info: "Mostrando del _START_ al _END_ de _TOTAL_ Clientes",
                infoEmpty: "No se encontaron Clientes",
                infoFiltered: "(Filtrado de un total de _MAX_ Clientes)"
            },
            order: [[ 1, 'desc' ]]
        });
    });
</script>
@endpush