<?php

Route::group(['prefix' => 'app', 'as' => 'app.'], function () {
    include('app.php');
});
Route::view('prueba', 'mail.MesaElectronica.solicitudTramite');
Route::get('/', 'Tramite\HomeController@index')->name('principal');

Route::auth();
Route::get('/logout', 'Auth\LoginController@logout');
Route::post('/loginModal', 'Auth\LoginController@loginModal')->name('loginModal');

Route::get('getRoute', 'routerController@show')->name('getRoute');
/*Route::get('/home', function () {
    return redirect('/tramite/inicio');
})->name('home');*/

Route::view('presupuesto/listadoMetas', 'proyectos')->middleware('auth');
Route::view('presupuesto/gastosCorriente', 'proyectos')->middleware('auth');
//vista de presupuesto
Route::view('gastos', 'proyectos')->middleware(['auth'])->name('presupuesto.general');
Route::view('proyecto-presupuesto', 'proyectos')->name('proyectoPresupuesto.inicio')->middleware(['auth',
                                                                                                  'can:proyectoPresupuesto.inicio']);
Route::view('unauthorized', 'proyectos');
Route::view('gastos/{any}', 'proyectos')->middleware('auth');
Route::view('gastos/{any}/{any2}', 'proyectos')->middleware('auth');
Route::view('fichaCertificacion', 'proyectos')->middleware('auth');
Route::view('fichaCertificacion/{any}', 'proyectos')->middleware('auth');
Route::view('fichaCertificacion/{any}/{any2}', 'proyectos')->middleware('auth');
Route::view('fichaCertificacion/{any}/{any2}/{any3}', 'proyectos')->middleware('auth');
Route::view('herramientas/modificatorias', 'proyectos')->middleware('auth');
Route::view('herramientas/modificatorias/{any}/{any2}/{any3}', 'proyectos')->middleware('auth');

Route::get('/tramite', 'Tramite\TramiteController@index');
//administrador-roles
Route::group(['prefix' => 'administrador', 'as' => 'administrador.'], function () {
    Route::get('roles', 'Administracion\AdministradorController@rol')->name('roles.rol')->middleware('can:administrador.roles.rol');
    Route::get('roles/create', 'Administracion\AdministradorController@createRol')->middleware('can:administrador.roles.create');
    Route::get('roles/{id}/edit', 'Administracion\AdministradorController@editRol')->middleware('can:administrador.roles.edit');

    Route::get('rol', 'Administracion\RolesController@index')->name('rol.index');
    Route::post('rol', 'Administracion\RolesController@store')->name('rol.store');
    Route::get('rol/obtenerRolesDepe', 'Administracion\RolesController@obtenerRolesDepe')->name('rol.obtenerRolesDepe');
    Route::get('rol/obtenerRoles', 'Administracion\RolesController@obtenerRoles')->name('rol.obtenerRoles');
    Route::get('rol/{id}', 'Administracion\RolesController@show')->name('rol.show');

    //administrador-usuarios
    Route::get('usuarios', 'Administracion\AdministradorController@usuario')->name('usuarios.usuario')->middleware('can:administrador.usuarios.usuario');
    Route::get('usuarios/create', 'Administracion\AdministradorController@create')->middleware('can:administrador.usuarios.create');
    Route::get('usuarios/{id}/edit', 'Administracion\AdministradorController@edit')->middleware('can:administrador.usuarios.edit');
    Route::get('usuarios/rrhh', 'Administracion\AdministradorController@usuarioRrhh')->name('usuarios.rrhh')->middleware('can:administrador.usuarios.rrhh'); 
    Route::get('usuarios/rrhh/create', 'Administracion\AdministradorController@createRrhh')->middleware('can:administrador.usuarios.rrhh.create');
    Route::get('usuarios/rrhh/{id}/edit', 'Administracion\AdministradorController@editRrhh')->middleware('can:administrador.usuarios.rrhh.edit');

    //administrador comunicacion interna
    Route::get('publicaciones', 'Administracion\AdministradorController@comunicacionIntena')->name('publicaciones.comunicacionIntena')->middleware('can:administrador.publicaciones.comunicacionIntena');
    Route::get('publicaciones/create', 'Administracion\AdministradorController@createComunicacionInterna')->middleware('can:administrador.publicaciones.createComunicacionInterna');
    Route::get('publicaciones/{id}/edit', 'Administracion\AdministradorController@editComunicacionInterna')->middleware('can:administrador.publicaciones.editComunicacionInterna');

    Route::get('comunicacionInterna/index', 'Administracion\ComunicacionInternaController@index')->name('comunicacionIntena.index');
    Route::post('comunicacionInterna/create', 'Administracion\ComunicacionInternaController@store')->name('comunicacionIntena.store');
    Route::get('comunicacionInterna/print/{id}', 'Administracion\ComunicacionInternaController@printImagenes')->name('comunicacionIntena.printImagenes');
    Route::get('comunicacionInterna/{id}', 'Administracion\ComunicacionInternaController@show')->name('comunicacionIntena.show');
    //administrador-general
    Route::get('administrador', 'Administracion\AdministradorController@administrador')->name('administrador.administrador')->middleware('can:administrador.administrador.administrador');
    //correos
    Route::view('correos','administrador.correos')->name('correos');
    //holidays
    Route::view('dias-feriado','administrador.holidays')->name('holidays');
    Route::get('dias-feriado/index','Administracion\HolidaysController@index');
    Route::post('dias-feriado/store','Administracion\HolidaysController@store');
    Route::post('dias-feriado/update','Administracion\HolidaysController@update');
});
//modulo controversia
Route::group(['prefix' => 'controversia', 'as' => 'controversia.'], function () {
    //vista controversia
    Route::get('controversia', 'Controversia\ControversiaController@controversia')->name('controversia.controversia');//->middleware('can:controversia.controversia.controversia');
    Route::get('/controversia/registroExpediente', 'Controversia\ControversiaController@registroExpediente');
    Route::get('/controversia/consultaExpedientes', 'Controversia\ControversiaController@consultaExpedientes');
    Route::get('/controversia/controversiaUsuario', 'Controversia\ControversiaController@controversiaUsuario');
});

Route::group(['prefix' => 'tramite', 'as' => 'tramite.'], function () {

    Route::post('persona', 'Tramite\personaController@store');
    Route::get('persona/correos', 'Tramite\personaController@correos');
    Route::post('persona/correos/store', 'Tramite\personaController@storeCorreo');
    Route::get('persona/ruc/{id}', 'Tramite\personaController@ruc')->name('persona.ruc');
    Route::get('persona/dni/{id}', 'Tramite\personaController@dni')->name('persona.dni');
    Route::post('persona/dni/{id}/registrarCorreo', 'Tramite\personaController@registrarCorreo')->name('persona.dni.create');
    Route::delete('persona/dni/{id}/eliminarCorreo/{correo}', 'Tramite\personaController@eliminarCorreo')->name('persona.dni.delete');
    Route::post('persona/dni/{id}/validateCorreo', 'Tramite\personaController@validarCorreo')->name('persona.dni.validate');

    Route::get('documento/json/{id}', 'Tramite\TramiteController@printJsonVuex')->name('documento.json');
    Route::get('documento/jsonAdministracion/{id}', 'Tramite\TramiteController@printJsonVuexAdministrador')->name('documento.jsonAdministrador');
    Route::get('documento/porRecibir', 'Tramite\DocumentoController@porRecibir')->name('documento.porRecibir');
    Route::get('documento/archivados', 'Tramite\DocumentoController@archivados')->name('documento.archivados');
    Route::post('documento/recepcionar', 'Tramite\DocumentoController@recepcionar')->name('documento.recepcionar');
    Route::post('documento/devolverProceso', 'Tramite\DocumentoController@devolverProceso')->name('documento.devolverProceso');
    Route::post('documento/eliminarDerivacion', 'Tramite\DocumentoController@eliminarDerivacion')->name('documento.eliminarDerivacion');
    Route::post('documento/liberarDocumento', 'Tramite\DocumentoController@liberarDocumento')->name('documento.liberarDocumento');
    Route::post('documento/documentoDerivar', 'Tramite\DocumentoController@documentoDerivar')->name('documento.documentoDerivar');
    Route::post('documento/documentoArchivar', 'Tramite\DocumentoController@documentoArchivar')->name('documento.documentoArchivar');
    Route::post('documento/documentoAdjuntar', 'Tramite\DocumentoController@documentoAdjuntar')->name('documento.documentoAdjuntar');
    Route::get('documento/buscarDocumento', 'Tramite\DocumentoController@buscarDocumento')->name('documento.buscarDocumento');
    Route::get('documento/bloqueoDocumentos', 'Tramite\DocumentoController@bloqueoDocumentos')->name('documento.bloqueoDocumentos');
    Route::get('documento/bloquedoDocumentoRecibirLiberar', 'Tramite\DocumentoController@bloquedoDocumentoRecibirLiberar')->name('documento.bloquedoDocumentoRecibirLiberar');
    Route::post('documento/liberarDocCas', 'Tramite\DocumentoController@liberarDocCas')->name('documento.liberarDocCas');
    Route::post('documento/generarObservacion', 'Tramite\DocumentoController@generarObservacion')->name('documento.generarObservacion');
    Route::get('documento/obtenerTotal', 'Tramite\DocumentoController@obtenerTotal')->name('documento.obtenerTotal');
    Route::get('documento/buscarDocDigital', 'Tramite\DocumentoController@buscarDocDigital')->name('documento.buscarDocDigital');
    Route::get('documento/buscarDocExterno', 'Tramite\DocumentoController@buscarDocExterno')->name('documento.buscarDocExterno');
    Route::get('documento/listarAnexos/{psw}/{idDocumento}', 'Tramite\DocumentoController@listarAnexos')->name('documento.listarAnexos');
    Route::get('documento/printR/{idFile}/{idDocumento}', 'Tramite\DocumentoController@printPdfR')->name('documento.printPdfRefirma');
    Route::get('documento/print/{idFile}/{psw}/{name}', 'Tramite\DocumentoController@printPdf2')->name('documento.printPdf2');
    Route::get('documento/print/{name}', 'Tramite\DocumentoController@printPdf')->name('documento.printPdf');
    Route::post('documento/mesa-virtual','Tramite\DocumentoController@nuevoDocExterno')->name('documento.virtual');
    Route::post('documento/upload','Tramite\DocumentoController@upload')->name('documento.upload');
    Route::get('documento/cuo','Tramite\DocumentoController@cuo')->name('documento.cuo');
    Route::post('documento/remplaceFile','Tramite\DocumentoController@remplaceFile')->name('documento.remplaceFile');
    Route::get('documento/entidadByCategoria/{id}', 'Tramite\DocumentoController@entidadByCategoria')->name('documento.entidadByCategoria');
    Route::get('documento/getFileHtml/{file}','Tramite\DocumentoController@getFileHtml')->name('documento.upload');
    Route::resource('documento', 'Tramite\DocumentoController');
    Route::post('/expediente/buscar', 'Tramite\ExpedienteController@buscar')->name('expediente.buscar');
    Route::get('expediente', 'Tramite\ExpedienteController@index')->name('expediente.index');
    Route::get('/inicio', 'Tramite\HomeController@tramite')->name('inicio')->middleware('can:tramite.inicio');


//REPORTE----
//Route::get('indexdocumento', 'Tramite\ReporteController@indexdocumento');
    Route::get('reporte/obtenerReporte', 'Tramite\ReporteController@obtenerReporte')->name('reporte.obtenerReporte');
    Route::resource('reporte', 'Tramite\ReporteController');


//en proceso

    Route::post('enproceso/upload', 'Tramite\EnProcesoController@upload')->name('enproceso.upload');
    Route::get('enproceso/test','Tramite\EnProcesoController@index');
    Route::view('enproceso/editor','tramite.documentos.editor');
    Route::get('enproceso/preview', 'Tramite\EnProcesoController@preview')->name('docs.generados.print');
    Route::get('enproceso/response','Tramite\EnProcesoController@response');
    Route::resource('enproceso', 'Tramite\EnProcesoController');

//proyectar Documento
    Route::get('plantilla', 'Tramite\EnProcesoController@makePlantilla')->name('view.plantilla');
    Route::get('plantilla/create', 'Tramite\EnProcesoController@makePlantilla')->name('view.plantilla.create');
    Route::get('plantilla/{id}/edit', 'Tramite\EnProcesoController@makePlantilla')->name('view.plantilla.edit');
    Route::get('docs-generados', 'Tramite\EnProcesoController@index')->name('view.docs.generados');
    Route::get('docs-generados/create', 'Tramite\EnProcesoController@index')->name('view.docs.generados.create');
    Route::get('docs-generados/{id}/edit', 'Tramite\EnProcesoController@generarDocumentosEdit');
    Route::get('docs-gen/{id}/edit', 'Tramite\EnProcesoController@generarDocumentosEdit');
    Route::resource('plantillaC', 'Tramite\PlantillasController');
    Route::get('docGenerado/{id}/print', 'Tramite\DocGeneradoController@imprimir')->name('docs.generados.print');
    Route::resource('docGenerado', 'Tramite\DocGeneradoController');


//por recibir
    Route::resource('recibir', 'Tramite\PorRecibirController');

//archvador
    Route::resource('archivado', 'Tramite\ArchivadosDocController');

//CATALOGOS
//---archivadores
    Route::get('archivador/obtenerArchivadores', 'Tramite\ArchivadorController@obtenerArchivadores')->name('archivador.obtenerArchivadores');
    Route::resource('archivador', 'Tramite\ArchivadorController');
//--tipos de documentos
    Route::get('tipoDocumento/get', 'Tramite\TipoDocumentoController@getTipos')->name('tipoDocumento.get');
    Route::get('tipoDocumento/mpv', 'Tramite\TipoDocumentoController@mpv');
    Route::get('tipoDocumento/obtenerTipoDocumento', 'Tramite\TipoDocumentoController@obtenerTipoDocumento')->name('tipoDocumento.obtenerTipoDocumento');
    Route::resource('tipoDocumento', 'Tramite\TipoDocumentoController');
//--formas de recepción
    Route::resource('recepciones', 'Tramite\RecepcionController');
//--Tipos de prioridades
    Route::resource('prioridades', 'Tramite\PrioridadController');
//--Tupa
    Route::resource('tupa', 'Tramite\TupaController');
// Catalogos
//catalogo-archivador
    Route::get('catalogo/archivador', 'Tramite\CatalogoController@archivador')->name('catalogo.archivador');
    Route::get('catalogo/archivador/create', 'Tramite\CatalogoController@create');
    Route::get('catalogo/archivador/{id}/edit', 'Tramite\CatalogoController@edit');

//catalogo-tipoDocumento
    Route::get('catalogo/tipoDocumento', 'Tramite\CatalogoController@tipoDocumento')->name('catalogo.tipoDocumento')->middleware('can:tramite.catalogo.tipoDocumento');
    Route::get('catalogo/tipoDocumento/create', 'Tramite\CatalogoController@createTipoDocumento')->middleware('can:tramite.catalogo.tipoDocumento.create');
    Route::get('catalogo/tipoDocumento/{id}/edit', 'Tramite\CatalogoController@editTipoDocumento')->middleware('can:tramite.catalogo.tipoDocumento.edit');
//catalogo-prioridad
    Route::get('catalogo/prioridades', 'Tramite\CatalogoController@prioridades')->name('catalogo.prioridades');
//catalogo-formarecepcion
    Route::get('catalogo/recepcion', 'Tramite\CatalogoController@recepcion')->name('catalogo.recepcion');

//TRAMITES
//recepcion de documentos por Tramite Documentario
    Route::get('recepcion/recepcionDocumento', 'Tramite\TramiteController@recepcionDocumento')->name('recepcion.recepcionDocumento')->middleware('can:tramite.recepcion.recepcionDocumento');
//liberar documentos generados por CAS
    Route::get('liberar/liberarDocCas', 'Tramite\TramiteController@liberarDocCas')->name('liberar.liberarDocCas')->middleware('can:tramite.liberar.liberarDocCas');

//PAPELETAS
    Route::get('papeleta/solicitarPapeleta', 'Tramite\TramiteController@solicitarPapeleta')->name('papeleta.solicitarPapeleta');
    Route::get('papeleta/solicitarPapeleta/create', 'Tramite\TramiteController@createPapeleta');
    Route::get('papeleta/solicitarPapeleta/{id}/edit', 'Tramite\TramiteController@editPapeleta');
    //autorizar papeleta
    Route::get('papeleta/papeletaPendiente', 'Tramite\TramiteController@papeletaPendiente')->name('papeleta.papeletaPendiente');
    Route::get('papeleta/papeletasAutorizadas', 'Tramite\TramiteController@papeletasAutorizadas');

    //supervisar-papeleta
    Route::get('papeleta/papeletasSolicitadas', 'Tramite\TramiteController@papeletasSolicitadas')->name('papeleta.papeletasSolicitadas')->middleware('can:tramite.papeleta.papeletasSolicitadas');
    Route::get('papeleta/papeletasUsadas', 'Tramite\TramiteController@papeletasUsadas')->middleware('can:tramite.papeleta.papeletasUsadas');

    //cambiar contraseña
    Route::get('cambiarContrasenia', 'Tramite\TramiteController@cambiarContrasenia')->name('cambiarContrasenia');
    //primer logeo
    Route::get('primerLogeo', 'Tramite\TramiteController@primerLogeo')->name('primerLogeo');
    Route::get('papeletas/obtenerDependenciaRecursosHumanos', 'Tramite\TramiteController@obtenerDependenciaRecursosHumanos')->name('papeletas.obtenerDependenciaRecursosHumanos');
    Route::get('papeletas/autorizarPapeletas', 'Tramite\PapeletaController@autorizarPapeletas')->name('papeletas.autorizarPapeletas');
    Route::get('papeletas/papeletasAutorizadas', 'Tramite\PapeletaController@papeletasAutorizadas')->name('papeletas.papeletasAutorizadas');
    Route::get('papeletas/papeletasSolicitadas', 'Tramite\PapeletaController@papeletasSolicitadas')->name('papeletas.papeletasSolicitadas');
    Route::get('papeletas/papeletasUsadas', 'Tramite\PapeletaController@papeletasUsadas')->name('papeletas.papeletasUsadas');
    Route::post('papeletas/obtenerArchivador', 'Tramite\PapeletaController@obtenerArchivador')->name('papeletas.obtenerArchivador');
    Route::resource('papeletas', 'Tramite\PapeletaController');

//ADMINISTRACIÓN
//--Entiddaes externas
    //Route::resource('entidades','Tramite\EntidadExternaController');
    Route::get('entidades', 'Tramite\EntidadExternaController@index')->name('entidades.index');
    Route::post('entidades', 'Tramite\EntidadExternaController@store')->name('entidades.store');
    Route::get('entidades/{id}', 'Tramite\EntidadExternaController@show')->name('entidades.show');

//unidad Orgánica
    //Route::resource('unidades','Tramite\UnidadOrganicaController');
    Route::get('unidades', 'Tramite\UnidadOrganicaController@index')->name('unidades.index');
    Route::post('unidades', 'Tramite\UnidadOrganicaController@store')->name('unidades.store');
    Route::get('unidades/obtenerUnidadOrganica', 'Tramite\UnidadOrganicaController@obtenerUnidadOrganica')->name('unidades.obtenerUnidadOrganica');
    Route::get('unidades/{id}', 'Tramite\UnidadOrganicaController@show')->name('unidades.show');

//usuario
    //Route::resource('usuarios','Tramite\UsuarioController');
    Route::get('usuarios/generarRolUser', 'Tramite\UsuarioController@generarRolUser');
    Route::get('usuarios/obtenerUserDependenciaActivo', 'Tramite\UsuarioController@obtenerUserDependenciaActivo')->name('usuarios.obtenerUserDependenciaActivo');
    Route::get('usuarios', 'Tramite\UsuarioController@index')->name('usuarios.index');
    Route::post('usuarios', 'Tramite\UsuarioController@store')->name('usuarios.store');
    Route::get('usuarios/{id}', 'Tramite\UsuarioController@show')->name('usuarios.show');
    Route::post('usuarios/derivar', 'Tramite\UsuarioController@usersforDerivar')->name('usuarios.derivar');
    Route::post('usuarios/checkUsuario', 'Tramite\UsuarioController@checkUsuario')->name('usuarios.checkUsuario');
    Route::post('usuarios/cambiarContrasenia', 'Tramite\UsuarioController@cambiarContrasenia')->name('usuarios.cambiarContrasenia');
//DEPENDENCIAS
    //Route::resource('dependencias','Tramite\DependenciaController');
    Route::post('dependencia/buscar', 'Tramite\DependenciaController@buscar')->name('dependencia.buscar');
    Route::get('dependencias', 'Tramite\DependenciaController@index')->name('dependencias.index');
    Route::post('dependencias', 'Tramite\DependenciaController@store')->name('dependencias.store');
    Route::get('dependencias/print', 'Tramite\DependenciaController@print');
    Route::post('dependencias/upload', 'Tramite\DependenciaController@upload');
    Route::get('dependencia/dependenciaMesaPartesVirtual', 'Tramite\DependenciaController@dependenciaMesaPartesVirtual')->name('dependencia.dependenciaMesaPartesVirtual');
    Route::get('dependencia/schedules', 'Tramite\DependenciaController@schedules');
    Route::get('dependencias/{id}', 'Tramite\DependenciaController@show')->name('dependencias.show');

//administrador
    //Route::resource('administrador','Tramite\AdministradorController');
    Route::get('administrador/usuario', 'Tramite\TramiteController@usuario')->name('administrador.usuario')->middleware('can:tramite.administrador.usuario');
    Route::get('administrador/usuario/create', 'Tramite\TramiteController@create')->middleware('can:tramite.administrador.usuario.create');
    Route::get('administrador/usuario/{id}/edit', 'Tramite\TramiteController@edit')->middleware('can:tramite.administrador.usuario.edit');
    //administrador-entidades
    Route::get('administrador/entidades', 'Tramite\TramiteController@entidades')->name('administrador.entidades')->middleware('can:tramite.administrador.entidades');
    Route::get('administrador/entidades/create', 'Tramite\TramiteController@createEntidad')->middleware('can:tramite.administrador.entidades.create');
    Route::get('administrador/entidades/{id}/edit', 'Tramite\TramiteController@editEntidad')->middleware('can:tramite.administrador.entidades.edit');
    //administrador-unidadesOrganicar
    Route::get('administrador/unidades', 'Tramite\TramiteController@unidades')->name('administrador.unidades')->middleware('can:tramite.administrador.unidades');
    Route::get('administrador/unidades/create', 'Tramite\TramiteController@createUnidades')->middleware('can:tramite.administrador.unidades.create');
    Route::get('administrador/unidades/{id}/edit', 'Tramite\TramiteController@editUnidades')->middleware('can:tramite.administrador.unidades.edit');
    //administrador-unidades organicas sedes
    Route::get('administrador/unidadesSedes', 'Tramite\TramiteController@unidadesSedes')->name('administrador.unidadesSedes')->middleware('can:tramite.administrador.unidadesSedes');
    Route::get('administrador/unidadesSedes/{id}/edit', 'Tramite\TramiteController@editUnidadesSedes')->middleware('can:tramite.administrador.unidadesSedes.edit');
    //administrador-dependencias
    Route::get('administrador/dependencias', 'Tramite\TramiteController@dependencias')->name('administrador.dependencias')->middleware('can:tramite.administrador.dependencias');
    Route::get('administrador/dependencias/create', 'Tramite\TramiteController@createDependencias')->middleware('can:tramite.administrador.dependencias.create');
    Route::get('administrador/dependencias/{id}/edit', 'Tramite\TramiteController@editDependencias')->middleware('can:tramite.administrador.dependencias.edit');
    //editar-dependencias-sedes-es edit
    Route::get('administrador/dependenciasSedes/', 'Tramite\TramiteController@editDependenciasSedes')->name('administrador.editDependenciasSedes')->middleware('can:tramite.administrador.editDependenciasSedes');
    //administrador-correlativo
    Route::get('administrador/correlativos', 'Tramite\TramiteController@correlativos')->name('administrador.correlativos')->middleware('can:tramite.administrador.correlativos');

    //administrador-correlativos dependencia
    Route::get('administrador/correlativosDependencia', 'Tramite\TramiteController@correlativosDependencia')->name('administrador.correlativosDependencia')->middleware('can:tramite.administrador.correlativosDependencia');

    //mostrar vista de buscarModal
    Route::get('buscar/buscarModal/{id}', 'Tramite\TramiteController@buscarModal')->name('buscar.buscarModal');

    //mostrar vista de buscar expediente
    Route::get('buscar/buscarExpedienteModal/{id}', 'Tramite\TramiteController@buscarExpedienteModal')->name('buscar.buscarExpedienteModal');

    //mostrar digital
    Route::get('buscar/buscarDigital', 'Tramite\TramiteController@buscarDigital')->name('buscar.buscarDigital');
    //buscar-docexternos
    Route::get('buscar/buscarDocExterno', 'Tramite\TramiteController@buscarDocExterno')->name('buscar.buscarDocExterno');
    //mostrar vista buscar
    Route::get('buscador', 'Tramite\TramiteController@buscador')->name('buscador');

    //Buscar----
    Route::resource('buscar', 'Tramite\BuscarController');
    Route::get('buscar/{id}/unidad', 'Tramite\BuscarController@unidad');


//correlatvo
    Route::post('correlativos/buscar', 'Tramite\CorrelativoController@buscar')->name('correlativo.buscar');
    Route::get('correlativos/{id}/usuarios', 'Tramite\CorrelativoController@usuarios');
    Route::resource('correlativos', 'Tramite\CorrelativoController');
//BLOQUES
    Route::resource('bloques', 'Tramite\BloqueController');
    Route::get('bloques/{id}/usuarios', 'Tramite\BloqueController@usuarios');

});

//route invoker
Route::get('invoker/postArguments', 'Tramite\InvokerController@postArguments')->name('invoker.postArguments');
Route::post('invoker/upload', 'Tramite\InvokerController@upload')->name('invoker.upload');
Route::get('invoker/getArguments', 'Tramite\InvokerController@getArguments')->name('invoker.getArguments');
Route::get('invoker/getFile', 'Tramite\InvokerController@getFile')->name('invoker.getFile');
//registro para mesa de partes virtual
Route::view('/registro/mesa-partes-virtual/{id}','tramite.tramiteVarios.mesaPartesVirtual')->name('registro.mesaPartesVirtual');
Route::get('/registro/mesa-partes-virtual/{id}/{token}','Tramite\DocumentoExternoController@observaciones')->name('registro.mesaPartesVirtual.token');

route::get('/registro/mpv/obs/{depe}','Tramite\DocumentoExternoController@documentos_observados')->name('documentos_observados');
route::post('/registro/mpv/lista','Tramite\DocumentoExternoController@bus_documentos_observados')->name('bus_documentos_observados');


//control de mesa de partes virtual
Route::post('/mpv/archivar', 'Tramite\DocumentoExternoController@archivar')->middleware('auth');
Route::post('/mpv/derivar', 'Tramite\DocumentoExternoController@derivar')->middleware('auth');
Route::get('/mpv/derivados', 'Tramite\DocumentoExternoController@derivados')->middleware('auth');
Route::get('/mpv/pdf', 'Tramite\DocumentoExternoController@pdf')->middleware('auth');
Route::post('/mpv/transferir', 'Tramite\DocumentoExternoController@transferir');
Route::post('/mpv/{mpv}', 'Tramite\DocumentoExternoController@editar')->middleware('auth');
Route::view('/mesa-partes-virtual','mpv.index')->name('mpv.view')->middleware('auth');
Route::view('/mesa-partes-virtual/derivados','mpv.index')->name('mpv.derivative')->middleware('auth');
Route::view('/mesa-partes-virtual/reporte','mpv.index')->name('mpv.report')->middleware('auth');
Route::resource('/mpv', 'Tramite\DocumentoExternoController')->middleware('auth');
//Asistencia
//control de asistencia
Route::view('/asistencia/inicio', 'assistance.inicio')->name('assistance.inicio')->middleware('can:assistance.inicio');
Route::view('/asistencia/rrhh', 'assistance.inicio')->name('assistance.rrhh')->middleware('can:assistance.rrhh');
Route::view('/asistencia/jefe', 'assistance.inicio')->name('assistance.manager')->middleware('can:assistance.manager');
Route::post('/asistencias/create','Assistance\AssistanceController@store');
Route::get('/asistencias','Assistance\AssistanceController@index');
Route::get('/asistencias/activa','Assistance\AssistanceController@activa');
Route::get('/asistencias/report/excel','Assistance\AssistanceController@excel');
Route::post('/asistencias/{assistance}/closed','Assistance\AssistanceController@closed');
Route::post('/asistencias/{assistance}/validated','Assistance\AssistanceController@validated');
Route::post('/asistencias/{assistance}/invalidated','Assistance\AssistanceController@invalidated');

//Papeleta ultimo
Route::post('/papeleta/create','Assistance\BallotController@store');
Route::get('/papeleta/reporte-excel','Assistance\BallotController@excel');
Route::post('/papeleta/{ballot}/autorizar','Assistance\BallotController@autorizar');
Route::post('/papeleta/{ballot}/aperturar','Assistance\BallotController@aperturar');
Route::post('/papeleta/{ballot}/cerrar','Assistance\BallotController@cerrar');

//interoperabilidad
Route::view('/interoperabilidad/despachos','interoperabilidad.index')->name('interoperabilidad.view')->middleware('auth');
Route::view('/interoperabilidad/recepciones','interoperabilidad.index')->name('interoperabilidad.recepciones')->middleware('auth');
Route::post('/interoperabilidad/store','Interoperabilidad\InteroperabilidadController@store');
Route::get('/interoperabilidad','Interoperabilidad\InteroperabilidadController@despachos');
Route::get('/interoperabilidad/recepcionados','Interoperabilidad\InteroperabilidadController@recepcionados');


//-----------------------------------

//Route::get('tabla', 'RecepcionController@index' );


/************************************************************POI************************************************************/
/*
//formulación f1
Route::resource('poi/anteproyecto','Poi\AnteproyectoFormatoF2@index');
//enlace para crear nueva actividad al formato f2
Route::post('poi/nuevo_formato_f2','Poi\AnteproyectoFormatoF2@create_actividad');
//ruta del ajax obtener pdrc oet
Route::get('poi/oet/{tipo}/{ce}','Poi\AnteproyectoFormatoF2@obtener_oets');
//ruta del ajax obtener pdrc aet
Route::get('poi/aet/{tipo}/{padre}/{ce}','Poi\AnteproyectoFormatoF2@obtener_aets');
//ruta del ajax obtener datos del siaf meta por id
Route::get('poi/siafmetadatos/{id}','Poi\AnteproyectoFormatoF2@obtener_datos_siaf_meta_por_id');
//seguimiento por actividad
//Route::resource('seguimientoact','Poi\PoiSeguimientoController');
//actividades o proyectos para administración
Route::resource('actividad','Poi\PoiActividadController');
//reprogramacion

//-----------------POI MAKE JIM-----------------------------------------------------------

//Route::resource('reprogramacion','Poi\PoiReprogramacionController');
Route::resource('reprogramar_index','Poi\PoiReprogramarController');
//enviado desde el portal
Route::get('reprogramar/{proy}/{nro_mod}/{est_func_prog}/{clas}','Poi\PoiReprogramarController@indice');

//Presupuesto Modificatoria
Route::resource('poi/presupuestomod', 'Poi\PresupuestoModController');

//enviado desde el portal
Route::get('poi/presupuestomod/{usuario}/{unidad}','Poi\PresupuestoModController@create');

//SEGUIMIENTO
Route::resource('poiSeguimiento', 'Poi\PoiSeguimientoController');
//holanoguarda routes
//COMPARAR POI-PIA
Route::resource('poi/comparar', 'Poi\CompararController');
Route::get('poi/comparar/{id}/clasificador', 'Poi\CompararController@clasificador');

//-----------------POI SEGUIMIENTO--------------------------------
Route::resource('poiSeguimiento', 'Poi\PoiSeguimientoController');

//REPORTE
Route::resource('poi/reporte', 'Poi\ReporteF2Controller');
Route::get('poi/reportef2/{id}/{uniorg}/{anio}', 'Poi\ReporteF2Controller@inicio');
Route::get('poi/metasid/{id}', 'Poi\ReporteF2Controller@metaID');
//ruta del ajax obtener pdrc oet
Route::get('poi/oetid/{tipo}/{ce}','Poi\ReporteF2Controller@obtener_oets');

Route::resource('poi/huamalies', 'Poi\HuamaliesController');
Route::get('poi/huamalies/oet/{tipo}/{ce}','Poi\HuamaliesController@obtener_oets');
Route::get('poi/huamalies/aet/{tipo}/{padre}/{aet}/{indicador?}','Poi\HuamaliesController@obtener_aets');
Route::get('poi/huamalies/oei/{tipo}/{ce}','Poi\HuamaliesController@obtener_oeis');
Route::post('poi/huamalies/tarea','Poi\HuamaliesController@tareas');
Route::post('poi/huamalies/edittarea/{id}','Poi\HuamaliesController@edittareas');
Route::post('poi/huamalies/especificas','Poi\HuamaliesController@especificas');
Route::post('poi/huamalies/editespecificas/{id}','Poi\HuamaliesController@editespecificas');
Route::get('poi/huamalies/deleteespecificas/{act}/{tar}/{id}','Poi\HuamaliesController@deleteespecificas');
Route::get('poi/huamalies/uniorganica/{id}','Poi\HuamaliesController@uniorganica');

Route::resource('poi/actividad/reporte', 'Poi\ActividadReporteController');
Route::get('poi/actividad/reporte/ejecutora/{id}', 'Poi\ActividadReporteController@uniorganica');

Route::get('poi/huamalies/siafmetadatos/{id}','Poi\HuamaliesController@obtener_datos_siaf_meta_por_id');
Route::get('poi/huamalies/ver/{id}','Poi\HuamaliesController@ver');
Route::get('poi/huamalies/verf3/{id}','Poi\HuamaliesController@verf3');
Route::get('poi/huamalies/exportarf3/{id}','Poi\ExportarFormatosController@exportarf3');
Route::get('poi/huamalies/insumos/{act}/{tar}','Poi\HuamaliesController@insumos');
Route::get('poi/huamalies/imprimir/{id}','Poi\HuamaliesController@imprimir');
Route::get('poi/huamalies/imprimirf3/{act}','Poi\HuamaliesController@imprimirf3');

Route::get('poi/exportarf2/{id}', 'Poi\Excel\FormatoF2Controller@exportarf2');
Route::get('poi/exportarf3/{id}', 'Poi\Excel\FormatoF3Controller@exportarf3');

include('routes.poi.php');
//-----------------FIN POI MAKE JIM-----------------------------------------------------------
*/
/************************************************************FIN POI************************************************************/


/*********DIRECTORIO INSTITUCIONAL*********/
/*//Buscador del directorio
Route::resource('directorio/directorio','Directorio\DirectorioController');

//Buscador del datatable forma inicial
//Route::controller('directorio/ver_data', 'Directorio\DirectorioController@anyData');
Route::get('directorio/directorio_ver', 'Directorio\DirectorioController@anyData');
//Buscador del clasificador del directorio
Route::resource('directorio/clasificacion','Directorio\ClasificacionController');*/
/*********FIN DIRECTORIO INSTITUCIONAL*********/

/*********PROCESO SELECCION*********/
/*//procesos de seleccion
Route::resource('procesocas','ProcesoSeleccion\ProcesoSeleccionController');
//puestos del procesos de seleccion
Route::resource('procesocas/puesto','ProcesoSeleccion\PuestoController');*/
/*********FIN PROCESO SELECCION*********/

include('routes.proy.php');
