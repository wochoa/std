<?php

Route::group(['middleware'=>'can:gastos.show', 'prefix'=>'gastos','as'=>'gastos.'],function() {
    Route::get('reporte', 'GastosController@reporte');
    Route::get('reporte/reporteGeneral', 'GastosController@reporteGeneral');
    Route::get('presupuesto', 'Siaf\PresupuestoController@index');
    Route::get('metas', 'Proy\GastosController@metas');
    Route::post('storePresupuesto', 'Proy\GastosController@storePresupuesto');
    Route::get('reporte/cicloGasto', 'GastosController@cicloGasto');
    Route::get('reporte/secfuncOficina','GastosController@secfuncOficina');
    Route::get('presupuestoGastoProyecto','GastosController@presupuestoGastoProyecto');
});
Route::group(['prefix'=>'presupuesto','as'=>'presupuesto.'],function() {
    Route::get('fuenteFinanciamiento', 'Siaf\PresupuestoController@fuenteFinanciamiento');
    Route::get('especificaDetalleGasto', 'Siaf\PresupuestoController@especificaDetalleGasto');
    Route::get('especificaGasto', 'Siaf\PresupuestoController@especificaGasto');
    Route::get('componenteNombre', 'Siaf\PresupuestoController@componenteNombre');
    Route::get('dispositivosLegales', 'Siaf\PresupuestoController@dispositivosLegales');
    Route::get('maestroDocumento', 'Siaf\PresupuestoController@maestroDocumento');
    Route::get('programasComponente', 'Siaf\PresupuestoController@programasComponente');
    Route::get('funciones', 'Siaf\PresupuestoController@funciones');
    Route::get('divisionesFuncionales', 'Siaf\PresupuestoController@divisionesFuncionales');
    Route::get('gruposFuncionales', 'Siaf\PresupuestoController@gruposFuncionales');
    Route::get('actProyecto', 'Siaf\PresupuestoController@actProyecto');
    Route::get('totalProyecto', 'Siaf\PresupuestoController@totalProyecto');
});
Route::group(['prefix' => 'herramientas', 'as'=>'herramientas'], function () {
    Route::get('certificacion/index','Proy\tools\cert\DocumentoC@index');
    Route::post('certificacion/store','Proy\tools\cert\DocumentoC@store');
    Route::get('certificacion/buscarRegistroDocumento','Tramite\DocumentoController@buscarRegistroDocumento');
    Route::get('certificacion/certificados/index','Proy\tools\cert\SolicitudC@index');
    Route::post('certificacion/certificados/store','Proy\tools\cert\SolicitudC@store');
    Route::post('certificacion/certificados/destroy','Proy\tools\cert\SolicitudC@destroy');
    Route::get('certificacion/certificados/imprimir','Proy\tools\cert\SolicitudC@imprimir');
    Route::get('certificacion/certificadoDetalle/index', 'Proy\tools\cert\DetalleC@index');
    Route::post('certificacion/certificadoDetalle/store', 'Proy\tools\cert\DetalleC@store');
    Route::post('certificacion/certificadoDetalle/destroy', 'Proy\tools\cert\DetalleC@destroy');
    //modificatorias
    Route::get('modificatoria/index','Proy\tools\ModificatoriaC@index');
    Route::post('modificatoria/store','Proy\tools\ModificatoriaC@store');
    Route::post('modificatoria/destroy','Proy\tools\ModificatoriaC@destroy');
    //modificatoria-detalle
    Route::get('modificatoria/detalle','Proy\tools\ModificatoriaDetalleC@index');
});

Route::group(['middleware'=>'can:proyectos.show', 'prefix'=>'proyectos','as'=>'proyectos.'],function() {
    //datos in localStorage
    Route::get('ubigeo', 'Proy\ProyectoController@ubigeo');
    Route::get('estados', 'Proy\ProyectoController@estados');
    Route::get('oficinas', 'Proy\ProyectoController@oficinas');
    Route::get('usuarios', 'Proy\ProyectoController@usuarios');
    Route::get('user','Proy\ProyectoController@getUser');

    Route::post('store', 'Proy\ProyectoController@store')->middleware('can:proyectos.edit');
    Route::post('checkCodSnip', 'Proy\ProyectoController@checkCodSnip');
    Route::get('inviertepe', 'Proy\ProyectoController@inviertepe');
    Route::get('show', 'Proy\ProyectoController@show');
    Route::get('obtenerProyectos', 'Proy\ProyectoController@obtenerProyectos');

    Route::get('contratos/index', 'Proy\ObraController@index');
    Route::get('contratos/show', 'Proy\ObraController@show');
    Route::post('contratos/store','Proy\ObraController@store');
    //dato in localStorage
    Route::get('actividad/obtenerActividad', 'Proy\ActividadObraController@obtenerActividad');
    Route::get('actividad/obtenerActividadAccion', 'Proy\ActividadObraController@obtenerActividadAccion');
    //proyecto-actividades
    Route::get('actividades/index', 'Proy\ActividadObraController@index');
    Route::post('actividades/store', 'Proy\ActividadObraController@store');
    Route::get('actividades/obtenerAdicionalObra', 'Proy\ActividadObraController@obtenerAdicionalObra');
    //proyecto-gastos
    Route::get('gastos','Proy\ProyectoController@moduloGastos');
    Route::get('getGastosLvl','Proy\ProyectoController@getGastosLvl');
    Route::get('{p}/{f}/gastos','Proy\ProyectoController@Gastos');

    Route::post('informe/guardarTemporal', 'Proy\ProyectoInformeController@guardarTemporal');
    Route::post('informe/store', 'Proy\ProyectoInformeController@store');
    Route::get('informe/index', 'Proy\ProyectoInformeController@index');
    Route::get('informe/print', 'Proy\ProyectoInformeController@printImagenesInforme');

    Route::get('analitico',   'Proy\AnaliticoController@index');
    Route::post('analitico/store','Proy\AnaliticoController@store');
    Route::get('analitico/print','Proy\AnaliticoController@print');
    Route::get('analitico/listarVersionesAnalitico','Proy\AnaliticoController@listarVersionesAnalitico');
    Route::post('analitico/version/store','Proy\AnaliticoController@storeVersion');

    Route::get('plan', 'Proy\plan\ProgramarController@index');
    Route::get('plan/versiones', 'Proy\plan\ProgramarController@listarVersiones');
    Route::post('plan/version/store', 'Proy\plan\ProgramarController@saveVersion');
    Route::post('plan/programar', 'Proy\plan\ProgramarController@savePlan');
    //componentes-tareas
    Route::get('componentesTareas','Proy\plan\ComponenteController@listar');
    Route::post('componentesTareas/store','Proy\plan\ComponenteController@store');
    Route::post('componentesTareas/destroy','Proy\plan\ComponenteController@destroy');

    //reporte excel
    //Route::get('{p}/{f}/gastos-project-excel','Proy\ProyectoController@exportExcel');


});
