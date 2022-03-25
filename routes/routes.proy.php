<?php

Route::get('proyectos/herramientas',  'Proy\tools\HerramientasC@index')->name('proyectos.herramientas.index');
Route::get('proyectos/inviertepe',  'Proy\ProyectoController@inviertepe')->name('proyectos.inviertepe');
//proyectos-actividades

Route::get('actividades/obtenerAdicionalObra','Proy\ActividadObraController@obtenerAdicionalObra')->name('actividades.obtenerAdicionalObra');
Route::resource('actividades',      'Proy\ActividadObraController');
//proyectos-contratos
Route::get('contratos/obtenerEstadoObra','Proy\ObraController@obtenerEstadoObra')->name('contratos.obtenerEstadoObra');
Route::get('/proyectos/reporteSiaf',	'Proy\ProyectoController@ReporteSiaf')->name('proyectos.reporte.siaf');
Route::resource('contratos',        'Proy\ObraController');
Route::view('proyectos', 'proyectos')->middleware('auth');
Route::view('proyectos/{id}', 'proyectos')->middleware('auth');
Route::view('proyectos/{id}/{any}', 'proyectos')->middleware('auth');
Route::view('proyectos/{id}/{any}/{any2}', 'proyectos')->middleware('auth');
Route::view('proyectos/{id}/{any}/{any2}/{any3}', 'proyectos')->middleware('auth');
Route::view('proyectos/{id}/{any}/{any2}/{any3}/{any4}', 'proyectos')->middleware('auth');





