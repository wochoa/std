import Model from 'vuex-model-store-generator/src/ModelLight'

const configUsuario = {
  alias     : 'usuarios',
  route     : '/tramite/usuarios',
  selectable: true,
  methods   : {

  },
  default   : {
    adm_name: null,
    adm_lastname: null,
    adm_cargo: null,
    adm_correo: null,
    adm_inicial: null,
    adm_telefono: null,
    adm_dni: null,
    adm_direccion: null,
    adm_con_especialidad: null,
    depe_id: null,
    adm_email: null,
    adm_password: null,
    confirmPassword: null,
    adm_vigencia: null,
    adm_estado: null,
    adm_observacion: null,
    adm_primer_logeo: 1,
    id: null
  },
}

export const Usuario = new Model(configUsuario)
