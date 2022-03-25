<?php

use Illuminate\Database\Seeder;

class TramDependenciaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //dependencia
        DB::table('tram_dependencia')->insert([
            [
                'depe_nombre'     => 'SEDE CENTRAL',
                'depe_abreviado'  => 'SEDE',
                'depe_tipo'       => 0,
                'depe_proyectado' => 0,
                'depe_estado'     => 1,
                'depe_agente'     => 0,
            ],
        ]);
        DB::table('tram_dependencia')->insert([
            [
                'depe_nombre'           => 'OFICINA INFORMÁTICA',
                'depe_abreviado'        => 'INFO',
                'depe_sigla'            => 'OF',
                'depe_representante'    => 'REPRESENTANTE',
                'depe_cargo'            => 'DIRECTOR',
                'depe_dni'              => '46181970',
                'depe_depende'          => 1,
                'depe_superior'         => '{"dependencia":2,"nombre":"SUB GERENCIA DE DESARROLLO INSTITUCIONAL Y SISTEMAS"}',
                'depe_tipo'             => 1,
                'depe_proyectado'       => 1,
                'depe_estado'           => 1,
                'depe_idusuario'        => 1,
                'depe_recibetramite'    => 1,
                'depe_agente'           => 0,
                'depe_mesa_virtual'     => 1,
                'depe_diasmaxenproceso' => 100,
            ],
            [
                'depe_nombre'           => 'OFICINA INFRAESTRUCTURA',
                'depe_abreviado'        => 'GRI',
                'depe_sigla'            => 'GRI',
                'depe_representante'    => 'REPRESENTANTE',
                'depe_cargo'            => 'GERENTE',
                'depe_dni'              => '46181975',
                'depe_depende'          => 1,
                'depe_superior'         => '{"dependencia":3,"nombre":"GERENCIA DE INFRAESTRUCTURA"}',
                'depe_tipo'             => 1,
                'depe_proyectado'       => 1,
                'depe_estado'           => 1,
                'depe_idusuario'        => 1,
                'depe_recibetramite'    => 1,
                'depe_agente'           => 0,
                'depe_mesa_virtual'     => 0,
                'depe_diasmaxenproceso' => 100,
            ],
        ]);
        DB::table('tram_dependencia')->insert([
            [

                'depe_nombre'           => 'PERSONA NATURAL',
                'depe_abreviado'        => 'PN',
                'depe_tipo'             => 2,
                'depe_proyectado'       => 0,
                'depe_estado'           => 1,
                'depe_idusuario'        => 1,
                'depe_recibetramite'    => 0,
                'depe_agente'           => 0,
                'depe_mesa_virtual'     => 0,
                'depe_diasmaxenproceso' => 100,
            ],
            [
                'depe_nombre'           => 'OTRAS EMPRESAS',
                'depe_abreviado'        => 'OE',
                'depe_tipo'             => 2,
                'depe_proyectado'       => 0,
                'depe_estado'           => 1,
                'depe_idusuario'        => 1,
                'depe_recibetramite'    => 0,
                'depe_agente'           => 0,
                'depe_mesa_virtual'     => 0,
                'depe_diasmaxenproceso' => 100,
            ],
            [
                'depe_nombre'           => 'OTRAS ENTIDADES',
                'depe_abreviado'        => 'OE',
                'depe_tipo'             => 2,
                'depe_proyectado'       => 0,
                'depe_estado'           => 1,
                'depe_idusuario'        => 1,
                'depe_recibetramite'    => 0,
                'depe_agente'           => 0,
                'depe_mesa_virtual'     => 0,
                'depe_diasmaxenproceso' => 100,
            ],
        ]);
        //tipo documento
        DB::table('tram_tipodocumento')->insert([
            [
                'tdoc_descripcion' => 'OFICIO',
                'tdoc_abreviado'   => 'OFI',
                'tdoc_correlativo' => 0,
                'tdoc_mpv'         => 1,
            ],
            [
                'tdoc_descripcion' => 'OFICIO MULTIPLE',
                'tdoc_abreviado'   => 'OFI.MULT.',
                'tdoc_correlativo' => 0,
                'tdoc_mpv'         => 1,
            ],
            [
                'tdoc_descripcion' => 'MEMO',
                'tdoc_abreviado'   => 'MEMO',
                'tdoc_correlativo' => 0,
                'tdoc_mpv'         => 0,
            ],
            [
                'tdoc_descripcion' => 'MEMO MULTIPLE',
                'tdoc_abreviado'   => 'MEMO MULT.',
                'tdoc_correlativo' => 0,
                'tdoc_mpv'         => 0,
            ],
            [
                'tdoc_descripcion' => 'CARTA',
                'tdoc_abreviado'   => 'CARTA',
                'tdoc_correlativo' => 0,
                'tdoc_mpv'         => 1,
            ],
            [
                'tdoc_descripcion' => 'SOLICITUD - OTROS',
                'tdoc_abreviado'   => 'SOLIC.',
                'tdoc_correlativo' => 0,
                'tdoc_mpv'         => 0,
            ],
            [
                'tdoc_descripcion' => 'MEMORIAL',
                'tdoc_abreviado'   => 'MEMORIAL',
                'tdoc_correlativo' => 0,
                'tdoc_mpv'         => 0,
            ],
            [
                'tdoc_descripcion' => 'INFORME',
                'tdoc_abreviado'   => 'INF.',
                'tdoc_correlativo' => 0,
                'tdoc_mpv'         => 0,
            ],
            [
                'tdoc_descripcion' => 'RESOLUCION',
                'tdoc_abreviado'   => 'RESOL.',
                'tdoc_correlativo' => 0,
                'tdoc_mpv'         => 0,
            ],
            [
                'tdoc_descripcion' => 'SOLICITUD PAPELETA',
                'tdoc_abreviado'   => 'PAPELETA',
                'tdoc_correlativo' => 0,
                'tdoc_mpv'         => 0,
            ],
        ]);

        //tipo recepción
        DB::table('tram_recepcion')->insert([
            [
                'rece_descripcion' => 'DIRECTA',
                'rece_abreviado'   => 'DIRECTA',
            ],
            [
                'rece_descripcion' => 'FAX',
                'rece_abreviado'   => 'FAX',
            ],
            [
                'rece_descripcion' => 'VIA WEB',
                'rece_abreviado'   => 'VIA WEB',
            ],
            [
                'rece_descripcion' => 'CEN.MED. S.M.CAUTIVO',
                'rece_abreviado'   => 'C.M',
            ],
        ]);
        //prioridad
        DB::table('tram_prioridad')->insert([
            [
                'prio_descripcion' => 'NORMAL',
                'prio_abreviado'   => 'NORMAL',
            ],
            [
                'prio_descripcion' => 'URGENTE',
                'prio_abreviado'   => 'URGENTE',
            ],
            [
                'prio_descripcion' => 'DOCU MINEDU',
                'prio_abreviado'   => 'OFICIOS',
            ],
            [
                'prio_descripcion' => 'DOCU DRE',
                'prio_abreviado'   => 'OFICIO',
            ],
        ]);
    }
}
