<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Users
        Permission::insert([
            [
                'name'        => 'Usuarios',
                'slug'        => 'administrador.usuarios.usuario',
                'description' => 'Usuarios',
            ],
            [
                'name'        => 'Roles',
                'slug'        => 'administrador.roles.rol',
                'description' => 'Roles',
            ],
            [
                'name'        => 'Usuarios dependencias',
                'slug'        => 'tramite.administrador.usuario ',
                'description' => 'Crear Usuarios de dependencias',
            ],
            [
                'name'        => 'Entidades externas',
                'slug'        => 'tramite.administrador.entidades',
                'description' => 'Crear entidades externas',
            ],
            [
                'name'        => 'Unidades Organicas',
                'slug'        => 'tramite.administrador.unidades',
                'description' => 'Crear Unidades Organicas',
            ],
            [
                'name'        => 'Dependencias',
                'slug'        => 'tramite.administrador.dependencias',
                'description' => 'Crear Dependencias generales',
            ],
            [
                'name'        => 'Correlativos',
                'slug'        => 'tramite.administrador.correlativos',
                'description' => 'Crear Correlativos',
            ],
            [
                'name'        => 'Tipo de documento',
                'slug'        => 'tramite.catalogo.tipoDocumento',
                'description' => 'Crear nuevo tipo de documento',
            ],
            [
                'name'        => 'Recepción',
                'slug'        => 'tramite.catalogo.recepcion',
                'description' => 'Crear  formas de recepción',
            ],
            [
                'name'        => 'Prioridades',
                'slug'        => 'tramite.catalogo.prioridades',
                'description' => 'Crea prioridades',
            ],
            [
                'name'        => 'Correlativos Dependencia',
                'slug'        => 'tramite.administrador.correlativosDependencia',
                'description' => 'Crea y edita los correlativos de las dependencias',
            ],
            [
                'name'        => 'Recepción Documentos',
                'slug'        => 'tramite.recepcion.recepcionDocumento',
                'description' => 'Recepción los documentos que llegan a tramite documentario',
            ],
            [
                'name'        => 'Administrador general',
                'slug'        => 'administrador.administrador.administrador',
                'description' => 'Administra todo el sistema',
            ],
            [
                'name'        => 'Supervisor de papeleta',
                'slug'        => 'tramite.papeleta.papeletasSolicitadas',
                'description' => 'Administra las papeletas según dependencia',
            ],
            [
                'name'        => 'Usuarios de STD',
                'slug'        => 'tramite.inicio',
                'description' => 'Usuarios generales de STD',
            ],
            [
                'name'        => 'Usuarios dependencia create',
                'slug'        => 'tramite.administrador.usuario.create',
                'description' => 'Permite crear nuevos usuarios',
            ],
            [
                'name'        => 'Usuarios dependencia edit',
                'slug'        => 'tramite.administrador.usuario.edit',
                'description' => 'Permite editar usuarios de dependencias',
            ],
            [
                'name'        => 'Entidades externas create',
                'slug'        => 'tramite.administrador.entidades.create',
                'description' => 'Permite crear nuevas entidades externas',
            ],
            [
                'name'        => 'Entidades externas edit',
                'slug'        => 'tramite.administrador.entidades.edit',
                'description' => 'Permite editar entidades externas',
            ],
            [
                'name'        => 'Unidades organicas create',
                'slug'        => 'tramite.administrador.unidades.create',
                'description' => 'Permite crear nuevas unidades organicas',
            ],
            [
                'name'        => 'Unidades organicas edit',
                'slug'        => 'tramite.administrador.unidades.edit',
                'description' => 'Permite editar nuevas unidades organicas',
            ],
            [
                'name'        => 'Dependencias create',
                'slug'        => 'tramite.administrador.dependencias.create',
                'description' => 'Permite crear nuevas dependencias',
            ],
            [
                'name'        => 'Dependencias edit',
                'slug'        => 'tramite.administrador.dependencias.edit',
                'description' => 'Permite editar las dependencias',
            ],
            [
                'name'        => 'Usuarios general create',
                'slug'        => 'administrador.usuarios.create',
                'description' => 'Permite crear nuevos usuarios general',
            ],
            [
                'name'        => 'Usuarios general edit',
                'slug'        => 'administrador.usuarios.edit',
                'description' => 'Permite editar usuarios generales',
            ],
            [
                'name'        => 'Roles create',
                'slug'        => 'administrador.roles.create',
                'description' => 'Permite crear nuevo rol',
            ],
            [
                'name'        => 'Roles edit',
                'slug'        => 'administrador.roles.edit',
                'description' => 'Permite editar un rol',
            ],
            [
                'name'        => 'Tipo documento create',
                'slug'        => 'tramite.catalogo.tipoDocumento.create',
                'description' => 'Permite crear nuevo tipo documento',
            ],
            [
                'name'        => 'Tipo documento edit',
                'slug'        => 'tramite.catalogo.tipoDocumento.edit',
                'description' => 'Permite editar un tipo documento',
            ],
            [
                'name'        => 'Supervisar papeletas usadas',
                'slug'        => 'tramite.papeleta.papeletasUsadas',
                'description' => 'Permite administrar las papeletas usadas',
            ],
            [
                'name'        => 'Liberar documentos CAS',
                'slug'        => 'tramite.liberar.liberarDocCas',
                'description' => 'Permite liberar documentos registrados para el proceso CAS los cuales no fueron presentados los físicos',
            ],
            [
                'name'        => 'Comunicación interna',
                'slug'        => 'administrador.publicaciones.comunicacionIntena',
                'description' => 'Permite realizar publicaciones',
            ],
            [
                'name'        => 'Comunicación interna create',
                'slug'        => 'administrador.publicaciones.createComunicacionInterna',
                'description' => 'Permite crear nueva publicacion',
            ],
            [
                'name'        => 'Comunicación interna edit',
                'slug'        => 'administrador.publicaciones.editComunicacionInterna',
                'description' => 'Permite editar publicaciones',
            ],
            [
                'name'        => 'Unidades organicas de las sedes',
                'slug'        => 'tramite.administrador.unidadesSedes',
                'description' => 'Permite el ingreso al modulo de unidades organicas x sedes',
            ],
            [
                'name'        => 'Unidades organicas sedes edit',
                'slug'        => 'tramite.administrador.unidadesSedes.edit',
                'description' => 'Permite la edicion de las firmas de unidades organicas de sedes',
            ],
            [
                'name'        => 'Editar dependencia por sede',
                'slug'        => 'tramite.administrador.editDependenciasSedes',
                'description' => 'Permite Editar los logos de la dependencia',
            ],
            [
                'name'        => 'Modulo de proyectos y financiero',
                'slug'        => 'proyectoPresupuesto.inicio',
                'description' => 'Permite el ingreso al modulo de proyectos y financiero',
            ],
            [
                'name'        => 'Visualizar Proyectos',
                'slug'        => 'proyectos.show',
                'description' => 'Permite visualizar los proyectos',
            ],
            [
                'name'        => 'Administrar Proyectos asignados',
                'slug'        => 'proyectos.edit',
                'description' => 'Permite administrar proyectos asignados',
            ],
            [
                'name'        => 'Administrar Proyectos General',
                'slug'        => 'proyectos.manage',
                'description' => 'Permite administrar el modulo de proyectos',
            ],
            [
                'name'        => 'Administrar plan de proyecto',
                'slug'        => 'proyectos.plan.manage',
                'description' => 'Permite administrar el plan de los proyectos asignados',
            ],
            [
                'name'        => 'Visualizar gastos',
                'slug'        => 'gastos.show',
                'description' => 'Permite visualizar los gastos',
            ],
            [
                'name'        => 'Administrar gastos',
                'slug'        => 'gastos.manage',
                'description' => 'Permite Administrar gastos',
            ],
            [
                'name'        => 'Asignar Metas Oficina',
                'slug'        => 'presupuesto.manage',
                'description' => 'Permite Asignar metas a las oficinas registradas',
            ],
            [
                'name'        => 'Gastos Corrientes',
                'slug'        => 'presupuesto.show',
                'description' => 'Permite Visualizar el presupuesto asignado a la oficina',
            ],
            //47
            [
                'name'        => 'Asistencias',
                'slug'        => 'assistance.inicio',
                'description' => 'Vista de asistencias',
            ],
            [
                'name'        => 'Asistencias RRHH',
                'slug'        => 'assistance.rrhh',
                'description' => 'Vista de asistencias para el control por RRHH',
            ],
            [
                'name'        => 'Asistencias Jefe',
                'slug'        => 'assistance.manager',
                'description' => 'Vista de asistencias para el control por el jefe',
            ],
            [
                'name'        => 'Mesa de Partes Virtual',
                'slug'        => 'mpv.view',
                'description' => 'Vista mesa de partes virtual gestión de los registros',
            ],
            [
                'name'        => 'interoperabilidad',
                'slug'        => 'interoperabilidad.view',
                'description' => 'Vista de Interoperatibilidad',
            ],
        ]);
    }
}
