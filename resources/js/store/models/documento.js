import Model from 'vuex-model-store-generator/src/ModelLight'

const configDocumento = {
  alias     : 'documento',
  route     : '/tramite/documento',
  selectable: true,
  methods   : {
    getBloqueoDocumentos(params = {}) {
      return this.get('bloqueoDocumentos', params)
    },
    getFileHtml(file = {}) {
      return this.get('getFileHtml/' + file.id)
    },
    buscarDocumento(params = {}) {
      return this.get('buscarDocumento', params)
    },

  },
  default   : {
    iddocumento              : null,
    docu_idexma              : null,
    docu_fecha               : null,
    docu_idprioridad         : 1,
    docu_origen              : 1,
    docu_tipo                : false, //personal, de la oficina
    docu_digital             : false,
    docu_iddependencia       : null,
    oficina                  : null,
    docu_firma               : null,
    docu_cargo               : null,
    docu_detalle             : null,
    docu_fecha_doc           : null,
    docu_siglas_doc          : null,
    docu_numero_doc          : null,
    docu_idusuario           : null,
    docu_idusuariodependencia: null,
    docu_idtipodocumento     : null,
    docu_proyectado          : null,
    docu_telef               : null,
    docu_emailorigen         : null,
    docu_domic               : null,
    docu_idrecepcion         : 1,
    docu_folios              : null,
    docu_asunto              : null,
    docu_clastupa            : 9,
    docu_diasatencion        : null,
    correlativo              : null,
    docu_contrasenia         : null,
    docu_dni                 : null,
    docu_ruc                 : null,
    docu_archivo             : [],
    docu_referencias         : []
  },
}
const configOperacion = {
  alias     : 'operacion',
  route     : '/tramite/documento/operacion',
  selectable: true,
  methods   : {},
  default   : {
    idoperacion        : null,
    oper_iddocumento   : null,
    oper_iddependencia : null,
    oper_idusuario     : null,
    oper_idarchivador  : null,
    oper_idtope        : null,
    oper_es_destino    : true,
    oper_manual        : false,
    oper_forma         : false,
    oper_depeid_d      : null,
    oper_detalledestino: null,
    oper_persona       : null,
    oper_cargo         : null,
    oper_acciones      : null,
    oper_usuid_d       : null,
  },
}

const configPlantilla = {
  alias  : 'plantilla',
  route  : '/tramite/plantillaC',
  methods: {},
  default: {
    id              : null,
    plt_nombre      : null,
    plt_plantilla   : '',
    plt_datos       : {
      documento: {
        iddocumento              : null,
        docu_idexma              : null,
        docu_idprioridad         : null,
        docu_origen              : 1,
        docu_tipo                : null, //personal, de la oficina
        docu_digital             : false,
        docu_iddependencia       : null,
        oficina                  : null,
        docu_firma               : null,
        docu_cargo               : null,
        docu_detalle             : null,
        docu_fecha_doc           : null,
        docu_siglas_doc          : null,
        docu_numero_doc          : null,
        docu_idusuario           : null,
        docu_idusuariodependencia: null,
        docu_idtipodocumento     : null,
        docu_proyectado          : null,
        docu_idrecepcion         : null,
        docu_folios              : null,
        docu_asunto              : null,
        docu_clastupa            : null,
        docu_diasatencion        : null,
        docu_archivo             : [],
        docu_dni                 : null,
        docu_telef               : null,
        docu_emailorigen         : null,
        docu_domic               : null,
        correlativo              : null,
        docu_contrasenia         : null
      },
      required : []
    },
    plt_referencias : [],
    plt_derivaciones: []
  },
}


export const Documento = new Model(configDocumento)
export const Operacion = new Model(configOperacion)
export const Plantilla = new Model(configPlantilla)
