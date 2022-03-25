import metas from '@/js/api/proyectos/metas'

const state = {
  metas: []
}

const getters = {

  mostrarMetas: (state) => {
    return state.metas.filter(d => d.act_proy != 0)
  },
  getOneMeta: (state) => (item) => {
    return state.metas.filter(d => d.ano_eje == item.ano_eje && d.sec_ejec == item.sec_ejec && d.sec_func == item.sec_func)[0]
  }
}
const actions = {

  getMetas ({ commit }, anio) {
    if (!metas.saved() || anio != curryear)
      return new Promise((resolve, reject) => {
        metas.requestMetas(anio).then(response => {
          if (response.data.length > 0) {
            commit('setMetas', response.data)
            resolve(response)
          } else {
            alert('No hay datos que mostrar')
          }
        }).catch(error => {
          reject(error)
        })
      })
    else
      commit('setMetas', metas.getMetas())
  },
  savePresupuesto ({ commit }, formPresupuesto) {
    return new Promise((resolve, reject) => {
      metas.storePresupuesto(formPresupuesto).then(response => {
        commit('setUpdatePresupuesto', response.data)
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  }
}
const mutations = {
  setMetas (state, u) {
    state.metas = u

    if (u[0].ano_eje == curryear) {
      metas.save(state.metas)
    }
  },
  setUpdatePresupuesto (state, u) {
    let arr = state.metas.filter(d => d.ano_eje == u.proy_siaf_anio && d.sec_ejec == u.proy_sec_ejec && d.sec_func == u.proy_siaf_sec_func)[0]
    if (arr != undefined) {
      arr.id_presupuesto = u.id
      arr.proy_tram_dependencia = u.proy_tram_dependencia
      if (arr.ano_eje == curryear) {
        metas.save(state.metas)
      }
    } else {
      console.log('no se actualizo')
    }
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
