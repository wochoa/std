@extends('layouts.plantillaAdministrador')
@section('titulo') Dias Feriado
@endsection
@section('contenido')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <br />
                <administrador-holidays></administrador-holidays>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type='text/javascript' src="{{ mix('js/admin.js') }}"></script>
@endpush

