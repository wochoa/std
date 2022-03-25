<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name'        => 'SUPER ADMINISTRADOR',
                'slug'        => 'ADMIN',
                'description' => 'ADMINISTRADOR GENERAL DEL SISTEMA',
                'special'     => 'all-access',
            ],
        ]);

        DB::table('roles')->insert([
            [
                'name'        => 'ADMINISTRADOR SGD DEPENDENCIAS',
                'slug'        => 'TRAMITE.DEPENDENCIAS',
                'description' => 'ADMINISTRA LOS USUARIOS DE LAS DEPENDENCIAS',
            ],
            [
                'name'        => 'USUARIO DE SGD',
                'slug'        => 'USUARIO.SGD',
                'description' => 'TODOS LOS USUARIOS DEL SGD',
            ],
            [
                'name'        => 'RECEPCIONISTA DE DOCUMENTOS EXTERNOS',
                'slug'        => 'RECEPCION.DOCUMENTOS',
                'description' => 'RECEPCIÓN DOCUMENTOS EXTERNOS DE LA INSTITUCIÓN',
            ],
            [
                'name'        => 'JEFE',
                'slug'        => 'JEFE',
                'description' => 'JEFE DE LA UNIDAD',
            ],
            [
                'name'        => 'RECURSOS HUMANOS',
                'slug'        => 'RECURSOS.HUMANOS',
                'description' => 'ADMINISTRA LAS ASISTENCIA DE LOS USUARIOS',
            ],
            [
                'name'        => 'ADMINISTRADOR DE PROYECTOS',
                'slug'        => 'SUPERVISOR.PROYECTOS',
                'description' => 'ADMINISTRA LOS PROYECTOS DE LA DEPENDENCIA',
            ],
            [
                'name'        => 'GESTOR DE PRESUPUESTO',
                'slug'        => 'GESTOR.PRESUPUESTO',
                'description' => 'GESTIONA EL PRESUPUESTO DE LA DEPENDENCIA',
            ],
            [
                'name'        => 'VISOR DE PRESUPUESTO',
                'slug'        => 'VISOR.PRESUPUESTO',
                'description' => 'GESTIONA EL PRESUPUESTO DE LA DEPENDENCIA',
            ],
            [
                'name'        => 'MESA DE PARTES VIRTUAL',
                'slug'        => 'MDP',
                'description' => 'GESTIONA LOS REGISTROS INGRESADOS POR LA MESA DE PARTES VIRTUAL, ACEPTANDO O DENEGANDO EL TRAMITE',
            ],
            [
                'name'        => 'INTEROPERATIVIDAD',
                'slug'        => 'INTEROPERATIVIDAD',
                'description' => 'TIENE FACULTAD DE USAR EL MODULO DE INTEROPERATIVIDAD',
            ],
        ]);

        DB::table('admin')->insert([
            [
                'adm_name'         => 'ADMINISTRADOR',
                'adm_lastname'     => 'ADMINISTRADOR',
                'adm_inicial'      => 'ADMIN',
                'adm_email'        => 'ADMIN',
                'adm_password'     => bcrypt('123456'),
                'adm_estado'       => 1,
                'adm_cargo'        => 'ADMINISTRADOR',
                'depe_id'          => 2,
                'adm_vigencia'     => '2021-12-09',
                'adm_caseta'       => 0,
                'adm_esjefe'       => 0,
                'adm_primer_logeo' => 1,
            ],
        ]);

        if (env("APP_ENV") == 'local') {
            DB::table('admin')->insert([
                [
                    'adm_name'         => 'MUNICIPALIDAD',
                    'adm_lastname'     => 'MUNICIPALIDAD',
                    'adm_inicial'      => 'MUNI',
                    'adm_email'        => 'MUNI',
                    'adm_password'     => bcrypt('123456'),
                    'adm_estado'       => 1,
                    'adm_cargo'        => 'ESPECIALISTA',
                    'depe_id'          => 2,
                    'adm_vigencia'     => '2021-12-09',
                    'adm_caseta'       => 0,
                    'adm_esjefe'       => 0,
                    'adm_primer_logeo' => 1,
                ],
                [
                    'adm_name'         => 'WALTHER RAUL II BENJAMIN',
                    'adm_lastname'     => 'AGUIRRE TELLO',
                    'adm_inicial'      => 'WARAT',
                    'adm_email'        => 'WAGUIRRE',
                    'adm_password'     => bcrypt('123456'),
                    'adm_estado'       => 1,
                    'adm_cargo'        => 'PROGRAMADOR EN GRI',
                    'depe_id'          => 3,
                    'adm_vigencia'     => '2021-12-09',
                    'adm_caseta'       => 0,
                    'adm_esjefe'       => 0,
                    'adm_primer_logeo' => 1,
                ],
                [
                    'adm_name'         => 'JHONATTAN',
                    'adm_lastname'     => 'CARLOS SIMON',
                    'adm_inicial'      => 'JRCS',
                    'adm_email'        => 'JCARLOS',
                    'adm_password'     => bcrypt('123456'),
                    'adm_estado'       => 1,
                    'adm_cargo'        => 'ADMINISTRADOR DE TICS',
                    'depe_id'          => 2,
                    'adm_vigencia'     => '2021-12-09',
                    'adm_caseta'       => 0,
                    'adm_esjefe'       => 0,
                    'adm_primer_logeo' => 1,
                ],
            ]);
        }

        DB::table('permission_role')->insert([
            [
                'permission_id' => 3,
                'role_id'       => 2,
            ],
            [
                'permission_id' => 4,
                'role_id'       => 2,
            ],
            [
                'permission_id' => 11,
                'role_id'       => 2,
            ],
            [
                'permission_id' => 16,
                'role_id'       => 2,
            ],
            [
                'permission_id' => 17,
                'role_id'       => 2,
            ],
            [
                'permission_id' => 18,
                'role_id'       => 2,
            ],
            [
                'permission_id' => 19,
                'role_id'       => 2,
            ],
            [
                'permission_id' => 35,
                'role_id'       => 2,
            ],
            [
                'permission_id' => 36,
                'role_id'       => 2,
            ],
            [
                'permission_id' => 37,
                'role_id'       => 2,
            ],
            [
                'permission_id' => 15,
                'role_id'       => 3,
            ],
            [
                'permission_id' => 4,
                'role_id'       => 4,
            ],
            [
                'permission_id' => 12,
                'role_id'       => 4,
            ],
            [
                'permission_id' => 18,
                'role_id'       => 4,
            ],
            [
                'permission_id' => 19,
                'role_id'       => 4,
            ],
            [
                'permission_id' => 14,
                'role_id'       => 6,
            ],
            [
                'permission_id' => 38,
                'role_id'       => 5,
            ],
            [
                'permission_id' => 39,
                'role_id'       => 5,
            ],
            [
                'permission_id' => 43,
                'role_id'       => 5,
            ],
            [
                'permission_id' => 38,
                'role_id'       => 7,
            ],
            [
                'permission_id' => 39,
                'role_id'       => 7,
            ],
            [
                'permission_id' => 38,
                'role_id'       => 8,
            ],
            [
                'permission_id' => 39,
                'role_id'       => 8,
            ],
            [
                'permission_id' => 43,
                'role_id'       => 8,
            ],
            [
                'permission_id' => 45,
                'role_id'       => 8,
            ],
            [
                'permission_id' => 46,
                'role_id'       => 8,
            ],
            [
                'permission_id' => 39,
                'role_id'       => 9,
            ],
            [
                'permission_id' => 46,
                'role_id'       => 9,
            ],

            [
                'permission_id' => 47,
                'role_id'       => 5,
            ],
            [
                'permission_id' => 49,
                'role_id'       => 5,
            ],
            [
                'permission_id' => 47,
                'role_id'       => 6,
            ],
            [
                'permission_id' => 48,
                'role_id'       => 6,
            ],
            [
                'permission_id' => 50,
                'role_id'       => 10,
            ],
            [
                'permission_id' => 51,
                'role_id'       => 11,
            ],
        ]);

        DB::table('role_user')->insert([
            [
                'role_id' => 1,
                'user_id' => 1,
            ],
        ]);

        if (env("APP_ENV") == 'local') {
            DB::table('role_user')->insert([
                [
                    'role_id' => 3,
                    'user_id' => 2,
                ],
                [
                    'role_id' => 5,
                    'user_id' => 2,
                ],
                [
                    'role_id' => 2,
                    'user_id' => 3,
                ],
                [
                    'role_id' => 3,
                    'user_id' => 3,
                ],
                [
                    'role_id' => 4,
                    'user_id' => 3,
                ],
                [
                    'role_id' => 7,
                    'user_id' => 3,
                ],
                [
                    'role_id' => 3,
                    'user_id' => 4,
                ],
                [
                    'role_id' => 8,
                    'user_id' => 4,
                ],

            ]);
        }

    }
}
