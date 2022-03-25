@extends('layouts.plantillaAdministrador')
@section('titulo') Roles
@endsection
@section('contenido')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <br />
                <administrador-correo></administrador-correo>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type='text/javascript' src="{{ mix('js/admin.js') }}"></script>
@endpush

