<?php

use Illuminate\Database\Seeder;

class ActividadTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('proy_etapa')->insert([
      [
        'eta_descripcion' => 'Contrato',
        'eta_plazo'       => 0,
      ],
      [
        'eta_descripcion' => 'Condiciones Previas',
        'eta_plazo'       => 15,
      ],
      [
        'eta_descripcion' => 'Ejecucion',
        'eta_plazo'       => 0,
      ],
      [
        'eta_descripcion' => 'Recepcion de Obra',
        'eta_plazo'       => 0,
      ],
      [
        'eta_descripcion' => 'Liquidacion',
        'eta_plazo'       => 0,
      ],
    ]);

    DB::table('proy_actividad_accion')->insert([
      [
        'descripcion' => 'Paralizacion de Obra',
      ],
      [
        'descripcion' => 'Ampliacion de Plazo',
      ],
      [
        'descripcion' => 'Adicional de Obra',
      ],
      [
        'descripcion' => 'Deductivo de Obra',
      ],
      [
        'descripcion' => 'Adenda',
      ],
      [
        'descripcion' => 'Otros',
      ],
    ]);

    //actividad
    DB::table('proy_actividad')->insert([
      [
        'act_descripcion'     => 'Firma de Contrato',
        'act_desc_corta'      => 'Cont',
        'act_plazo_probable'  => 1,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 1,
      ],
      [
        'act_descripcion'     => 'Entrega de Terreno',
        'act_desc_corta'      => 'Ent-Terr',
        'act_plazo_probable'  => 15,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 2,
      ],
      [
        'act_descripcion'     => 'Entrega de Expediente Técnico',
        'act_desc_corta'      => 'Ent-Exp',
        'act_plazo_probable'  => 15,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 2,
      ],
      [
        'act_descripcion'     => 'Designación del Inspector y/o Supervisor',
        'act_desc_corta'      => 'Des-Insp',
        'act_plazo_probable'  => 15,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 2,
      ],
      [
        'act_descripcion'     => 'Entrega de Adelanto Directo',
        'act_desc_corta'      => 'Ad-Dir',
        'act_plazo_probable'  => 15,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 2,
      ],
      [
        'act_descripcion'     => 'Entrega de Adelanto de Materiales',
        'act_desc_corta'      => 'Ad-Mat',
        'act_plazo_probable'  => 15,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 2,
      ],
      [
        'act_descripcion'     => 'Valorización',
        'act_desc_corta'      => 'Val',
        'act_plazo_probable'  => 30,
        'act_accion'          => 6,
        'etapa_idetapa_etapa' => 3,
      ],
      [
        'act_descripcion'     => 'Solicitud',
        'act_desc_corta'      => 'Solic',
        'act_plazo_probable'  => 15,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 3,
      ],
      [
        'act_descripcion'     => 'Inspección',
        'act_desc_corta'      => 'Insp',
        'act_plazo_probable'  => 1,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 3,
      ],
      [
        'act_descripcion'     => 'Inicio de Controversia',
        'act_desc_corta'      => 'Contr',
        'act_plazo_probable'  => 1,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 3,
      ],
      [
        'act_descripcion'     => 'Extemporáneo',
        'act_desc_corta'      => 'Extemp',
        'act_plazo_probable'  => 1,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 3,
      ],
      [
        'act_descripcion'     => 'Resolución Ejecutiva Regional',
        'act_desc_corta'      => 'RER',
        'act_plazo_probable'  => 1,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 3,
      ],
      [
        'act_descripcion'     => 'Paralización',
        'act_desc_corta'      => 'Par',
        'act_plazo_probable'  => 1,
        'act_accion'          => 1,
        'etapa_idetapa_etapa' => 3,
      ],
      [
        'act_descripcion'     => 'Comité de Recepción',
        'act_desc_corta'      => 'Com-Rec',
        'act_plazo_probable'  => 1,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 4,
      ],
      [
        'act_descripcion'     => 'Acta de Recepción',
        'act_desc_corta'      => 'Act-Rec',
        'act_plazo_probable'  => 1,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 3,
      ],
      [
        'act_descripcion'     => 'Solicitud de Liquidación',
        'act_desc_corta'      => 'Sol_Liq',
        'act_plazo_probable'  => 1,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 5,
      ],
      [
        'act_descripcion'     => 'Pronunciación de Entidad',
        'act_desc_corta'      => 'Pro-Ent',
        'act_plazo_probable'  => 1,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 5,
      ],
      [
        'act_descripcion'     => 'Pronunciación de Contratista',
        'act_desc_corta'      => 'Pron_Contr',
        'act_plazo_probable'  => 1,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 5,
      ],
      [
        'act_descripcion'     => 'Ampliación de plazo',
        'act_desc_corta'      => 'Amp-Plaz',
        'act_plazo_probable'  => 1,
        'act_accion'          => 2,
        'etapa_idetapa_etapa' => 3,
      ],
      [
        'act_descripcion'     => 'Adicional de Obra',
        'act_desc_corta'      => 'Ad-Obr',
        'act_plazo_probable'  => 1,
        'act_accion'          => 3,
        'etapa_idetapa_etapa' => 3,
      ],
      [
        'act_descripcion'     => 'Deductivo de Obra',
        'act_desc_corta'      => 'Ded-Obr',
        'act_plazo_probable'  => 1,
        'act_accion'          => 4,
        'etapa_idetapa_etapa' => 3,
      ],
      [
        'act_descripcion'     => 'Liquidación',
        'act_desc_corta'      => 'Liq',
        'act_plazo_probable'  => 1,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 4,
      ],
      [
        'act_descripcion'     => 'Adenda',
        'act_desc_corta'      => 'Adenda',
        'act_plazo_probable'  => 1,
        'act_accion'          => 1,
        'etapa_idetapa_etapa' => 3,
      ],
      [
        'act_descripcion'     => 'Intervención Económica',
        'act_desc_corta'      => 'Int-Eco',
        'act_plazo_probable'  => 1,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 3,
      ],
      [
        'act_descripcion'     => 'Suspensión de plazo',
        'act_desc_corta'      => 'Susp-Plaz',
        'act_plazo_probable'  => 1,
        'act_accion'          => 1,
        'etapa_idetapa_etapa' => 3,
      ],
      [
        'act_descripcion'     => 'Deductivo Vinculante de Obra',
        'act_desc_corta'      => 'Ded-Vinc',
        'act_plazo_probable'  => 1,
        'act_accion'          => 4,
        'etapa_idetapa_etapa' => 3,
      ],
      [
        'act_descripcion'     => 'Acta de constatación Física',
        'act_desc_corta'      => 'Act-Const',
        'act_plazo_probable'  => 1,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 3,
      ],
      [
        'act_descripcion'     => 'Ejecución fuera de plazo',
        'act_desc_corta'      => 'Ejec-f-Pla',
        'act_plazo_probable'  => 1,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 3,
      ],
      [
        'act_descripcion'     => 'Informe de avance',
        'act_desc_corta'      => 'Inf-Avan',
        'act_plazo_probable'  => 30,
        'act_accion'          => 6,
        'etapa_idetapa_etapa' => 3,
      ],
      [
        'act_descripcion'     => 'Actividad de la Entidad',
        'act_desc_corta'      => 'Act-Ent',
        'act_plazo_probable'  => 1,
        'act_accion'          => 6,
        'etapa_idetapa_etapa' => 3,
      ],
      [
        'act_descripcion'     => 'Planeamiento',
        'act_desc_corta'      => 'Plan',
        'act_plazo_probable'  => 1,
        'act_accion'          => 0,
        'etapa_idetapa_etapa' => 3,
      ],
    ]);

    //estados de obra
    DB::table('proy_obra_estados')->insert([
      [
        'descripcion' => 'En idea',
        'etapa'       => 0,
      ],
      [
        'descripcion' => 'En Perfil',
        'etapa'       => 0,
      ],
      [
        'descripcion' => 'Con Contrata',
        'etapa'       => 1,
      ],
      [
        'descripcion' => 'Expediente Tecnico',
        'etapa'       => 0,
      ],
      [
        'descripcion' => 'En ejecucion',
        'etapa'       => 1,
      ],
      [
        'descripcion' => 'Paralizado',
        'etapa'       => 1,
      ],
      [
        'descripcion' => 'Paralizado aprobado',
        'etapa'       => 1,
      ],
      [
        'descripcion' => 'Paralizado sin aprobar',
        'etapa'       => 1,
      ],
      [
        'descripcion' => 'Terminado',
        'etapa'       => 2,
      ],
      [
        'descripcion' => 'Entregado',
        'etapa'       => 2,
      ],
      [
        'descripcion' => 'Por Liquidar',
        'etapa'       => 2,
      ],
      [
        'descripcion' => 'Liquidado',
        'etapa'       => 3,
      ],
      [
        'descripcion' => 'Resuelto o nulo',
        'etapa'       => 2,
      ],
    ]);
    DB::table('proy_obra_estados')->insert([
      [
        'descripcion' => 'Desconocido',
      ],
    ]);
    DB::table('proy_obra_estados')->insert([
      [
        'descripcion' => 'Condiciones Previas',
        'etapa'       => 0,
      ],
    ]);
  }
}
