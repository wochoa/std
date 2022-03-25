@extends('layouts.proyectos.tab_edit')

@section('tabContent')
    
<div id="app">
    <control-informes
        :proyecto={!!json_encode((Object)['idproy_proyecto'=>$proyecto->idproy_proyecto])!!}
    >
    
    </control-informes>
</div>
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/informes.js') }}"></script>
<script src="https://unpkg.com/pure-md5@0.1.9/lib/index.js"></script>
@endsection
@push('style')
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" rel="stylesheet">
    <!-- Styles -->
<link href="{{ mix('css/gastos.css') }}" rel="stylesheet">
@endpush

