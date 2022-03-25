const state = {
  dependencias: [],
    documentos: []
}
const mutations= {

  llenarDependencias (state, dependencias) {
    for (var i = 0; i < dependencias.length; i++) {
      state.dependencias.push({
                                iddependencia: dependencias[i][0],
                                depe_nombre: dependencias[i][1],
                                depe_depende: dependencias[i][2],
                                depe_tipo: dependencias[i][3],
                                depe_recibetramite: dependencias[i][4]
                              })
    }
  },
  setDocumentos (state, d) {
    for(var i = 0; i<d.length; i++){
      state.documentos.push({
                              idtdoc              : d[i][0],
                              tdoc_descripcion    : d[i][1]
                            });
    }
  }
}
const actions= {

  obtenerDependencias: async function ({ commit, state }, route) {
    if (state.dependencias.length === 0)
      axios.get(route).then(response => {
        commit('llenarDependencias', response.data)
      })
  },
  obtenerDocumentos: async function ({ commit, state }) {
    if (state.documentos.length === 0)
      axios.get('/tramite/tipoDocumento/get').then(response => {
        commit('setDocumentos', response.data)
      })
  },
  ejecutarRecursivamente: async  function({commit, dispatch},d ={}){
    var config ={context:null, h:0, after:function () {}};
    for (var i in d)
      if (config.hasOwnProperty(i))
        config[i] = d[i];
    for(i=0; i < config.context.$children.length; i++)
    {
      dispatch('ejecutarRecursivamente', {context:config.context.$children[i], after:config.after})
    }
    config.after(config.context);
  }
}
const getters=  {
  getEntidadesExternas: state => {return (state.dependencias !== undefined) ? state.dependencias.filter(d => d.depe_tipo === 2 && d.depe_depende === null) : null},
    getDocumentoNombre: state => id => {
    let u = state.documentos.filter(d => d.idtdoc === parseInt(id))
    if (u[0] !== undefined)
      return u[0].tdoc_descripcion
    else
      return null
  },
    getDocumentos: state => {
    return state.documentos
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
