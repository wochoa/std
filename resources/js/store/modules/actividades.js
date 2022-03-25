import Vue from 'vue'
import actividad from '@/js/api/proyectos/actividad'
import actividadAccion from '@/js/api/proyectos/actividadAccion'
import contratos from '@/js/api/proyectos/contratos'

const state = {
  actividades: [],
  actividadAccion: [],
  contratos: [],
  contrato: {
    idobra: null,
    proy_proyecto_idproy_proyecto: null,
    obr_nombre: null,
    obr_componentes_metas: null,
    obr_modalidad_ejecucion: null,
    obr_estado: null,
    obr_tipo_contrato: null,
    obr_monto_exp_tec: null,
    obr_numero_contrato: null,
    obr_fecha_exp_tec: null,
    obr_proceso_seleccion: null,
    obr_nombre_ejecutor: null,
    obr_direccion_ejecutor: null,
    obr_representante_ejecutor: null,
    obr_contratista_ruc: null,
    obr_contrato_ejecucion: null,
    obr_monto_contrato: null,
    obr_fecha_contrato: null,
    obr_fecha_inicio_ejecucion: null,
    obr_plazo: null,
    obr_otros: null,

    loaded: false
  },
  actividadesOfContrato: [],
  adicionalObras: [],
  valorizaciones: {
    data: [],
    contrato: {
      obr_monto_contrato: 0,
      total_deductivo: 0
    }
  },
  actividadesPlazos: []
}

const getters = {
  getActividades: (state) => {
    return state.actividades
  },
  getActividad: (state) => (id) => {
    return state.actividades[id]
  },
  getActividadDescripcion: (state) => (id) => {
    var arr = state.actividades.filter(d => d.idactividad == id)[0]
    if (arr !== undefined)
      return arr.act_descripcion
    else
      return null
  },
  getActividadAccionDescripcion: (state) => (id) => {
    var arr = state.actividadAccion.filter(d => d.id == id)[0]
    if (arr !== undefined)
      return arr.descripcion
    else
      return null
  },
  getActividadAccion: (state) => (id) => {
    var u = state.actividades.filter(d => d.idactividad === id)[0]
    if (u !== undefined)
      return u.act_accion
    else
      return null
  },
  getActividadAccionSelect: (state) => {
    return state.actividadAccion
  },
  showContratos: (state) => {
    return state.contratos
  },
  getOneContrato: (state) => (id) => {
    return state.contratos.filter(d => d.idobra == id)[0]
  },
  showActividades: (state) => {
    return state.actividadesOfContrato
  },
  getOneActividad: (state) => (id) => {
    return state.actividadesOfContrato.filter(d => d.idactividades == id)[0]
  },
  showAdicionalObra: (state) => {
    var arr = []
    var arr1 = state.adicionalObras
    for (var i = 0; i < arr1.length; i++) {
      arr[i] = {
        text: arr1[i].act_descripcion + ' ' + ((arr1[i].idactividades != 0 && arr1[i].idactividades != -1) ? arr1[i].aco_numero : ''),
        value: arr1[i].idactividades
      }
    }
    return arr

  },
  getOneValorizacion: (state) => (id) => {
    return state.valorizaciones.data.filter(d => d.idactividades == id)[0]
  },
  showActividadesPlazos: (state) => {
    return state.actividadesPlazos
  },
  getOneActividadesPlazos: (state) => (id) => {
    return state.actividadesPlazos.filter(d => d.idactividades == id)[0]
  },
  mostrarContratoNombreSelectd: (state) => {
    return state.contrato.obr_nombre
  },
  showValorizaciones: (state) => {
    return state.valorizaciones.contrato
  },
  showValorizacionesData: state => {
    return state.valorizaciones.data
  }
}

const actions = {

  selectContrato ({ commit, dispatch }, id) {
    let p = state.contratos.filter(d => d.idobra == id)
    if (p.length === 1) {
      p[0].loaded = true
      commit('setContrato', p[0])
      dispatch('afterSelectContrato')
    } else
      return new Promise((resolve, reject) => {
        contratos.requestContrato(id).then(response => {
          commit('setContrato', response.data)
          dispatch('afterSelectContrato')
        }).catch(error => {
          reject(error)
        })
      })
  },
  afterSelectContrato ({ dispatch }) {
    /*if(state.proyecto.loadAnalitico)
        dispatch('obternerAnalitico');*/
  },

  obtenerActividadAccion ({ commit }) {
    if (!actividadAccion.saved())
      return new Promise((resolve, reject) => {
        actividadAccion.requestActividadAccion().then(response => {
          commit('llenarActividadAccion', response.data)
          resolve(response)
        }).catch(error => {
          reject(error)
        })
      })
    else
      commit('llenarActividadAccion', actividadAccion.getActividadAccion())
  },

  obtenerActividad ({ commit }) {
    if (!actividad.saved())
      return new Promise((resolve, reject) => {
        actividad.requestActividad().then(response => {
          commit('llenarActividad', response.data)
          resolve(response)
        }).catch(error => {
          reject(error)
        })
      })
    else
      commit('llenarActividad', actividad.getActividad())
  },

  getContratos ({ commit }, formContrato) {
    return new Promise((resolve, reject) => {
      contratos.requestContratos(formContrato).then(response => {
        commit('setContratos', response.data)
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  },

  getActividadesOfContrato ({ commit }, formActividad) {
    return new Promise((resolve, reject) => {
      actividad.requestActividades(formActividad).then(response => {
        switch (formActividad.tipo) {
          case 1:
            commit('setActividades', response.data)
            break
          case 2: {
            let v = response.data.data
            let c = response.data.contrato
            if (c !== null)
              c.sinigv = parseFloat((c.obr_monto_contrato - c.total_deductivo) / 1.18).toFixed(2)
            var acarreo = 0
            var acarreoVb = 0

            for (var i = 0; i < v.length; i++) {
              acarreo += parseFloat((v[i].aco_meta_financiero !== null) ? v[i].aco_meta_financiero : 0)
              v[i].acumulado = acarreo.toFixed(2)
              acarreoVb += parseFloat((v[i].aco_avance_financiero !== null) ? v[i].aco_avance_financiero : 0)
              v[i].acumuladoVb = acarreoVb.toFixed(2)
            }

            var actResumen = []
            for (var i = 0; i < v.length; i++) {
              if (actResumen[v[i].actividad_idactividad] == undefined)
                actResumen[v[i].actividad_idactividad] = 1
              else {
                actResumen[v[i].actividad_idactividad]++
              }
            }
            for (var i = 0; i < v.length; i++) {
              var a = v[i].actividad_idactividad
              v[i].act_descripcion = (actResumen[a] == 1) ? v[i].act_descripcion : (v[i].act_descripcion + ' ' + ((v[i].aco_numero == null) ? v[i].aco_orden : v[i].aco_numero))
            }
            commit('setValorizaciones', { data: v, contrato: c })
          }
            break
          case 3:
          case 4:
            commit('setActividadesPlazos', response.data)
            break
          default:
            break
        }

        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  },

  getAdicionalObra ({ commit }, idcontrato) {
    return new Promise((resolve, reject) => {
      actividad.requestAdicionalObra(idcontrato).then(response => {
        commit('setAdicionalObra', response.data)
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  },

  saveContratos ({ commit }, formContrato) {
    contratos.saveContrato(formContrato)
  },

  saveActividades ({ commit }, formActividad) {
    actividad.saveActividad(formActividad)
  }
}

const mutations = {

  llenarActividad (state, u) {
    state.actividades = u
    actividad.save(state.actividades)
  },
  llenarActividadAccion (state, u) {
    state.actividadAccion = u
    if (state.actividadAccion.length == 6)
      state.actividadAccion.push({ 'id': 0, 'descripcion': 'Ninguno' })
    actividadAccion.save(state.actividadAccion)
  },
  setContratos (state, u) {
    state.contratos = u
  },
  setActividades (state, actividades) {
    state.actividadesOfContrato = actividades
    var actResumen = []
    for (var i = 0; i < state.actividadesOfContrato.length; i++) {
      if (actResumen[state.actividadesOfContrato[i].actividad_idactividad] == undefined)
        actResumen[state.actividadesOfContrato[i].actividad_idactividad] = 1
      else
        actResumen[state.actividadesOfContrato[i].actividad_idactividad]++
    }
    for (var i = 0; i < state.actividadesOfContrato.length; i++) {
      var a = state.actividadesOfContrato[i].actividad_idactividad
      state.actividadesOfContrato[i].act_descripcion = (actResumen[a] == 1) ? state.actividadesOfContrato[i].act_descripcion : (state.actividadesOfContrato[i].act_descripcion + ' ' + ((state.actividadesOfContrato[i].aco_numero == null) ? state.actividadesOfContrato[i].aco_orden : state.actividadesOfContrato[i].aco_numero))
    }
  },
  setAdicionalObra (state, adicionalObras) {
    state.adicionalObras = adicionalObras
    state.adicionalObras.unshift({ 'idactividades': -1, 'act_descripcion': 'Gastos Generales' })
    state.adicionalObras.unshift({ 'idactividades': 0, 'act_descripcion': 'Contractual' })
  },
  setValorizaciones (state, valorizaciones) {
    state.valorizaciones = valorizaciones

  },
  setActividadesPlazos (state, plazos) {
    state.actividadesPlazos = plazos
  },
  setContrato (state, d) {
    state.contrato = Vue.set(state, 'contrato', d)
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
