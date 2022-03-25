import Model from 'vuex-model-store-generator/src/ModelLight'

const configInteroperabilidad = {
  alias: 'interoperabilidad',
  route: '/tramite/documento',
  selectable: true,
  methods: {
    saveForDispatch(params) {
      return axios.post('/interoperabilidad/store', params)
    },
    getDespachos(params) {
      return axios.get('/interoperabilidad', params)
    },
    getRecepcionados(params) {
      return axios.get('/interoperabilidad/recepcionados', params)
    }
  },

}

export const Interoperabilidad = new Model(configInteroperabilidad)
