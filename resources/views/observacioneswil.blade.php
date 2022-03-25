@extends('layouts.tema')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="panel panel-default mt-5" style="background-color: #8bc6da !important;">
                        <div class="panel-heading text-center text-light" style="background: #044ba266 !important;"><h4>Consulta de documento</h4></div>
                        <!-- <div class="panel-heading">Consulta de documento</div> -->
                        <div class="panel-body">
                            <p class="text-center">Esta sección es para buscar documentos y ver su estado situacional, para ello debe ingresar su correo y dni/ruc al momento de tramitar.</p>
                            <form action="{{route('bus_documentos_observados')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="">Ingrese su correo</label>
                                    <!-- <input type="hidden" value="{{$depe}}" name="depe"> -->
                                    <input type="email" placeholder="Ingrese su correo que proporcionó" class="form-control form-control-sm" name="correo">
                                </div>
                                <div class="form-group">
                                    <label for="">Ingrese DNI/RUC</label>
                                    <input type="text" placeholder="Ingrese su Dni/Ruc que proporcionó" class="form-control form-control-sm" name="dni">
                                </div>
                                <div class="form-group">
                                    <label for="">Ingrese número tel.</label>
                                    <input type="number" placeholder="Ingrese núm. teléfono que proporcionó" class="form-control form-control-sm" name="numtel">
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary LoginButton">Consultar</button>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
    </div>

</div>
@endsection
