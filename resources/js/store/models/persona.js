import Model from 'vuex-model-store-generator/src/ModelLight'

const configpersona = {
  alias     : 'documento',
  route     : '/tramite/persona',
  selectable: true,
  default   : {
    id         : null,
    dni        : null,
    apPrimer   : null,
    apSegundo  : null,
    direccion  : null,
    estadoCivil: null,
    foto       : null,
    prenombres : null,
    restriccion: null,
    ubigeo     : null
  },
}


export const Persona = new Model(configpersona)
