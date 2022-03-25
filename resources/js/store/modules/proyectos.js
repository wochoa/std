import ubigeo from '@/js/api/proyectos/ubigeo'
import oficinas from '@/js/api/proyectos/oficinas'
import estados from '@/js/api/proyectos/estados'
import proyectos from '@/js/api/proyectos/proyectos'
import usuarios from '@/js/api/proyectos/usuarios'
import analitico from '@/js/api/proyectos/analitico'
import gastos from '@/js/api/proyectos/gastos'
import plan from '@/js/api/proyectos/plan'
import componente from '@/js/api/proyectos/componente'

const state = {
  ubigeo: [],
  oficinas: [],
  estados: [],
  usuarios: [],
  proyectos: [],
  proyecto: {
    idproy_proyecto: null,
    proy_cod_siaf: null,
    proy_nombre: null,
    analitico: [],
    plan: [],
    versionesPlan: [],
    versionesAnalitico: [],
    loadGastos: false,
    loadAnalitico: false,
    loadPlan: false,
    loadVersionsPlan: false,
    loadVersionsAnalitico: false,
    versionAnalitico: 1,
    versionPlan: 1,
    anio: null,
    fftt: null,
    loaded: false
  },
  gastos: [],
  gastosCalculado: [],
  formatoGastos: {
    formato: ['ano_eje', 'fuente_financ', 'sec_func', 'id_clasificador', 'cert', 'compromiso', 'expediente'],
    anio: null,
    user_id: null,
    sec_func: null
  },
  componentesTareas: [],
  tiposContrato: [
    { id: null, descripcion: 'Seleccione' },
    { id: 1, descripcion: 'Expediente Técnico' },
    { id: 2, descripcion: 'Ejecución' },
    { id: 3, descripcion: 'Supervisión' },
    { id: 4, descripcion: 'Inspección' },
    { id: 99, descripcion: 'Otros' }
  ]
}

const getters = {
  mostratUbigeo2: state => {
    var arr = []
    var arr1 = state.ubigeo.filter(d => parseInt(d.ubi_id_dep) === parseInt(process.env.MIX_UBIGEO_REGION) && parseInt(d.ubi_id_prov) != 0)
    var j = 0
    let provincia = ''
    for (var i = 0; i < arr1.length; i++) {
      if (arr1[i].ubi_id_dist == 0) {
        arr[j++] = { header: 'Provincia de ' + arr1[i].ubi_nombre }
        provincia = arr1[i].ubi_nombre
        arr[j++] = { divider: true }
      } else {
        arr[j++] = {
          text: provincia + ' ' + arr1[i].ubi_nombre,
          value: arr1[i].id
        }
      }
    }

    return arr
  },
  getProyectoGastos2: state => {
    return state.gastosCalculado
  },
  getProyectoGastosCalculados: state => data => {
    let value = state.gastosCalculado.filter(d => d.ano_eje === data.ano_eje && d.fuente_financ === data.fuente_financ && d.componente === data.componente && d.id_clasificador === data.id_clasificador)
    if (value.length === 1) {
      return value[0]
    } else {
      return {}
    }
  },
  mostarOficinas: state => {
    return state.oficinas
  },
  mostarOficinasForSelect: state => {
    var arr = []
    var arr1 = state.oficinas
    var j = 0
    for (var i = 0; i < arr1.length; i++) {
      arr[j++] = {
        text: `${arr1[i].iddependencia} - ${arr1[i].depe_nombre}`,
        value: arr1[i].iddependencia
      }
    }
    return arr
  },
  showNameOficina: state => id => {
    let arr = state.oficinas.filter(d => d.iddependencia == id)[0]
    if (arr !== undefined) {
      return arr.depe_nombre
    } else {
      return 'META NO ASIGNADA'
    }
  },
  mostrarEstados: state => {
    return state.estados
  },
  showNameEstate: (state) => (id) => {
    let arr = state.estados.filter(d => d.id === id)[0]
    if (arr !== undefined)
      return arr.descripcion
    else
      return 'Estado Desconocido'
  },
  showTiposContrato: state => {
    return state.tiposContrato
  },
  showNameTiposDocumento: (state) => (id) => {
    let arr = state.tiposContrato.filter(d => d.id === id)[0]
    if (arr !== undefined)
      return arr.descripcion
    else
      return 'Estado Desconocido'
  },

  getUsuariosNameById: state => id => {
    var u = state.usuarios.filter(d => d.id_admin === id)
    if (u[0] !== undefined) {
      return u[0].adm_name
    } else {
      return null
    }
  },

  showProyectos: state => {
    return state.proyectos
  },
  mostrarProyectos: state => {
    return state.proyectos
  },
  mostrarProyectoByActProy: state => act_proy => {
    let arr = state.proyectos.filter(d => d.proy_cod_siaf == act_proy)
    if (arr.length === 1) {
      return arr[0]
    } else {
      return {
        idproy_proyecto: null,
        proy_cod_siaf: null,
        proy_cod_snip: null,
        proy_nombre: 'Proyecto Desconocido'
      }
    }
  },
  mostrarProyectoSelected: state => {
    return state.proyecto
  },
  mostrarProyectoNombreSelected: state => {
    return state.proyecto.proy_nombre
  },
  mostrarAnaliticoProyectoSelected: state => {
    return state.proyecto.analitico
  },
  mostrarCodigoSiafProyectoSelect: state => {
    return state.proyecto.proy_cod_siaf
  },
  mostrarVersionsPlanProyetoSelected: state => {
    var arr = []
    var arr1 = state.proyecto.versionesPlan
    for (var i = 0; i < arr1.length; i++) {
      arr[i] = {
        text: `(${arr1[i].vers_anio}.${arr1[i].vers_version})  ${arr1[i].created_at}`,
        value: arr1[i].id
      }
    }

    return arr
  },
  mostrarPlanProyectoSelected: state => data => {
    let filtered = state.proyecto.plan.filter(d => d.plan_comp_id === data.ana_componente && d.plan_id_clasifi === data.ana_especifca && d.plan_fftt === data.plan_fftt && d.plan_anio === data.plan_anio)
    if (filtered.length === 1) {
      filtered = filtered[0]
    } else {
      filtered = {
        id: -1,
        plan_comp_id: data.ana_componente,
        plan_fftt: data.plan_fftt,
        plan_id_clasifi: data.ana_especifca,
        plan_anio: data.plan_anio,
        version_id: state.proyecto.versionPlan,
        plan_proyecto: data.ana_act_proy,
        plan_m1: 0,
        plan_m2: 0,
        plan_m3: 0,
        plan_m4: 0,
        plan_m5: 0,
        plan_m6: 0,
        plan_m7: 0,
        plan_m8: 0,
        plan_m9: 0,
        plan_m10: 0,
        plan_m11: 0,
        plan_m12: 0
      }
    }
    return filtered
  },
  showComponentesTareas: state => {
    return state.componentesTareas
  },
  getOneComponenteTarea: state => item => {
    return state.componentesTareas.filter(d => d.id === item)[0]
  },
  showVersionsAnaliticoProyectSelect: state => {
    var arr = []
    var arr1 = state.proyecto.versionesAnalitico
    for (var i = 0; i < arr1.length; i++) {
      arr[i] = {
        text: `(${arr1[i].vers_version})  ${arr1[i].created_at}`,
        value: arr1[i].id
      }
    }
    return arr
  }
}

const actions = {
  selectProyecto ({state, commit, dispatch }, id) {
    //commit('setProyectoSelected', state.default)
    let p = [...state.proyectos].filter(d => d.idproy_proyecto == id)
    if (p.length === 1) {
      p[0].loaded = true
      commit('setProyectoSelected', Object.assign(p[0],{loaded:true}))
      dispatch('afterSelectProyecto')
    } else {
      return new Promise((resolve, reject) => {
        proyectos
          .requestProyecto(id)
          .then(response => {
            commit('setProyectoSelected', Object.assign(response.data,{loaded:true}))
            dispatch('afterSelectProyecto')
          })
          .catch(error => {
            reject(error)
          })
      })
    }
  },
  afterSelectProyecto({state, dispatch}){
    if (state.proyecto.loadAnalitico) {
      dispatch('obternerAnalitico')
    }
    if (state.proyecto.loadPlan) {
      dispatch('obternerPlan')
    }
    if (state.proyecto.loadVersionsPlan) {
      dispatch('obternerVersionesPlan')
    }
    if (state.proyecto.loadGastos) {
      dispatch('getProyectoGastos')
    }
    if (state.proyecto.loadVersionsAnalitico) {
      dispatch('getVersionesAnalitico')
    }
  },
  getUbigeo ({ commit }) {
    if (!ubigeo.saved()) {
      return new Promise((resolve, reject) => {
        ubigeo
          .requestUbigeo()
          .then(response => {
            commit('setUbigeo', response.data)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    } else {
      commit('setUbigeo', ubigeo.getUbigeo())
    }
  },
  obternerAnalitico ({ state, commit }) {
    if (state.proyecto.loaded) {
      return new Promise((resolve, reject) => {
        analitico
          .requestAnalitico(state.proyecto)
          .then(response => {
            commit('setProyectoSelectedAnalitico', response.data)
            commit('setProyectoSelected', { loadAnalitico: false })
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    } else {
      commit('setProyectoSelected', { loadAnalitico: true })
    }
  },
  obternerPlan ({ state, commit }, d) {
    commit('setProyectoSelected', d)
    if (state.proyecto.loaded) {
      return new Promise((resolve, reject) => {
        plan
          .requestPlan(state.proyecto)
          .then(response => {
            commit('setProyectoSelectedPlan', response.data)
            commit('setProyectoSelected', { loadPlan: false })
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    } else {
      commit('setProyectoSelected', { loadPlan: true })
    }
  },
  obternerVersionesPlan ({ state, commit }, d) {
    commit('setProyectoSelected', d)
    if (state.proyecto.loaded) {
      return new Promise((resolve, reject) => {
        plan
          .requestVersiones(state.proyecto)
          .then(response => {
            commit('setProyectoSelectedVersionsPlan', response.data)
            commit('setProyectoSelected', { loadVersionsPlan: false })
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    } else {
      commit('setProyectoSelected', { loadVersionsPlan: true })
    }
  },
  updatePlan ({ state, commit }, data) {
    let index = state.proyecto.plan.findIndex(d => d.id === data.plan.id)
    let p = JSON.parse(JSON.stringify(data.plan))
    p['plan_m' + data.n] = parseInt(data.value.replace(/,/g, ''))

    return new Promise((resolve, reject) => {
      plan
        .storePlan(p)
        .then(response => {
          if (index === -1) {
            commit('addProyectoSelectedPlan', Object.assign(data.plan, response.data))
          } else {
            commit('updateProyectoSelectedPlan', {
              index: index,
              value: response.data
            })
          }
          resolve(response)
        })
        .catch(error => {
          reject(error)
        })
    })
  },
  saveVersionPlan ({ state, commit }, data) {
    return new Promise((resolve, reject) => {
      plan
        .storeVersionPlan(data)
        .then(response => {
          commit('addProyectoSelectedVersionPlan', response.data)
          resolve(response)
        })
        .catch(error => {
          reject(error)
        })
    })
  },
  getOficinas ({ commit }) {
    if (!oficinas.saved()) {
      return new Promise((resolve, reject) => {
        oficinas
          .requestOficinas()
          .then(response => {
            commit('setOficinas', response.data)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    } else {
      commit('setOficinas', oficinas.getOficinas())
    }
  },
  getEstados ({ commit }) {
    if (!estados.saved()) {
      return new Promise((resolve, reject) => {
        estados
          .requestEstados()
          .then(response => {
            commit('setEstados', response.data)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    } else {
      commit('setEstados', estados.getEstados())
    }
  },
  getUsuarios ({ commit }) {
    if (!usuarios.saved()) {
      return new Promise((resolve, reject) => {
        usuarios
          .requestUsuarios()
          .then(response => {
            commit('setUsuarios', response.data)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    } else {
      commit('setUsuarios', usuarios.getUsuarios())
    }
  },
  getProyectos ({ commit }) {
    if (!proyectos.saved()) {
      return new Promise((resolve, reject) => {
        proyectos
          .requestProyectos()
          .then(response => {
            commit('setProyectos', response.data)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    } else {
      commit('setProyectos', proyectos.getProyectos())
    }
  },
  ejecutarRecursivamente: async function ({ dispatch }, d = {}) {
    var config = {
      context: null,
      h: 0,
      after: function () {
      }
    }
    for (var i in d) if (config.hasOwnProperty(i)) {
      config[i] = d[i]
    }
    for (i = 0; i < config.context.$children.length; i++) {
      dispatch('ejecutarRecursivamente', {
        context: config.context.$children[i],
        after: config.after
      })
    }
    config.after(config.context)
  },
  getProyectoGastos ({ commit }, force = false) {
    if (state.proyecto.loaded || force) {
      let params = {
        act_proy: state.proyecto.proy_cod_siaf,
        ano_eje: state.formatoGastos.anio,
        user_id: state.formatoGastos.user_id,
        sec_func: state.formatoGastos.sec_func
      }
      return new Promise((resolve, reject) => {
        gastos
          .requestProyectoGastos(params)
          .then(response => {
            commit('setProyectoGastos', response.data)
            commit('setProyectoGastosCalculado', gastos.groupBy(state.gastos, state.formatoGastos.formato))
            commit('setProyectoSelected', { loadGastos: false })
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    } else {
      commit('setProyectoSelected', { loadGastos: true })
    }
  },
  establecerFormGastos ({ commit }, formato) {
    commit('setFormatoGastos', formato)
    commit('setProyectoGastosCalculado', gastos.groupBy(state.gastos, state.formatoGastos.formato))
  },
  getProyectoGastosCertificado ({ commit }, params) {
    return new Promise((resolve, reject) => {
      gastos
        .requestGastosLvl(params)
        .then(response => {
          commit('setAddProyectoGastosCertificado', response.data)
          resolve(response)
        })
        .catch(error => {
          reject(error)
        })
    })
  },
  getComponentesTareas ({ commit }, id_proyecto) {
    return new Promise((resolve, reject) => {
      componente
        .requestComponentesTareas(id_proyecto)
        .then(response => {
          commit('setComponentesTareas', response.data)
          resolve(response)
        })
        .catch(error => {
          reject(error)
        })
    })
  },
  saveComponenteTarea ({ commit }, formComponente) {
    return new Promise((resolve, reject) => {
      componente
        .saveComponenteTarea(formComponente)
        .then(response => {
          commit('setAddComponenteTarea', response.data)
          resolve(response)
        })
        .catch(error => {
          reject(error)
        })
    })
  },
  saveProyecto ({ commit }, formProyecto) {
    return new Promise((resolve, reject) => {
      proyectos
        .saveProyecto(formProyecto)
        .then(response => {
          commit('setAddProyecto', response.data)
          resolve(response)
        })
        .catch(error => {
          reject(error)
        })
    })
  },
  saveAnalitico ({ state, commit }, formAnalitico) {
    return new Promise((resolve, reject) => {
      formAnalitico.ana_act_proy = state.proyecto.proy_cod_siaf
      analitico
        .storeAnalitico(formAnalitico)
        .then(response => {
          commit('setAddAnalitico', response.data)
          resolve(response)
        })
        .catch(error => {
          reject(error)
        })
    })
  },
  printAnalitico ({ state, commit }, version) {
    window.open(analitico.printAnalitico(version, state.proyecto.proy_cod_siaf), 'Visor', 'width=1000,height=750')
  },
  getVersionesAnalitico ({ state, commit }) {
    if (state.proyecto.loaded) {
      return new Promise((resolve, reject) => {
        analitico
          .requestVersiones(state.proyecto.proy_cod_siaf)
          .then(response => {
            commit('setVersionesAnalitico', response.data)
            commit('setProyectoSelected', { loadVersionsAnalitico: false })
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    } else {
      commit('setProyectoSelected', { loadVersionsAnalitico: true })
    }
  },
  saveVersionAnalitico ({ commit }, formVersion) {
    return new Promise((resolve, reject) => {
      analitico
        .storeVersionAnalitico(formVersion)
        .then(response => {
          commit('addVersionAnalitico', response.data)
          resolve(response)
        })
        .catch(error => {
          reject(error)
        })
    })
  },
  deleteComponente ({ commit }, id) {
    if (confirm('Esta seguro de eliminar el componente?')) {
      return new Promise((resolve, reject) => {
        componente
          .deleteComponenteTarea(id)
          .then(response => {
            commit('deleteOneComponenteTarea', response.data)
            resolve(response)
          })
          .catch(error => {
            reject(error)
            //console.log(error.response.data.message);
          })
      })
    }
  },
  newFormGastos ({ commit }) {
    commit('setNewFormGastos', {
      formato: ['ano_eje', 'fuente_financ', 'sec_func', 'id_clasificador', 'cert', 'compromiso', 'expediente'],
      anio: null,
      user_id: null,
      sec_func: null
    })
  },
  newGastosCalculado ({ commit }) {
    commit('setNewGastosCalculado', [])
  },
  deleteReferenceProyectGasto ({ commit }) {
    commit('setReferenceProyectGasto', {
      idproy_proyecto: null,
      proy_cod_siaf: null,
      proy_nombre: null,
      analitico: [],
      plan: [],
      versionesPlan: [],
      versionesAnalitico: [],
      loadGastos: false,
      loadAnalitico: false,
      loadPlan: false,
      loadVersionsPlan: false,
      loadVersionsAnalitico: false,
      versionAnalitico: 1,
      versionPlan: 1,
      anio: null,
      fftt: null,
      loaded: false
    })
  }
}

const mutations = {
  setUbigeo (state, u) {
    state.ubigeo = u
    if (u.length > 0) {
      ubigeo.save(state.ubigeo)
    }
  },
  setOficinas (state, u) {
    state.oficinas = u
    if (u.length > 0) {
      oficinas.save(state.oficinas)
    }
  },
  setEstados (state, u) {
    state.estados = u
    if (u.length > 0) {
      estados.save(state.estados)
    }
  },
  setUsuarios (state, u) {
    state.usuarios = u
    if (u.length > 0) {
      usuarios.save(state.usuarios)
    }
  },
  setProyectos (state, u) {
    state.proyectos = u
    proyectos.save(state.proyectos)
  },
  setProyectoGastos (state, gastos) {
    state.gastos = gastos
  },
  setProyectoGastosCalculado (state, gastos) {
    state.gastosCalculado = gastos
  },
  setFormatoGastos (state, formato) {
    state.formatoGastos = Object.assign(state.formatoGastos, formato)
  },
  setProyectoSelected (state, d) {
    state.proyecto = Object.assign(state.proyecto, d)
  },
  setProyectoSelectedAnalitico (state, d) {
    state.proyecto.analitico = d
  },
  setProyectoSelectedPlan (state, d) {
    state.proyecto.plan = d
  },
  addProyectoSelectedPlan (state, d) {
    state.proyecto.plan.push(d)
  },
  updateProyectoSelectedPlan (state, d) {
    state.proyecto.plan[d.index] = d.value
  },
  setProyectoSelectedVersionsPlan (state, d) {
    state.proyecto.versionesPlan = d
  },
  addProyectoSelectedVersionPlan (state, u) {
    state.proyecto.versionesPlan.push(u)
  },
  setAddProyectoGastosCertificado (state, u) {
    for (var i in u) {
      u[i].ano_eje = u[i].ano_eje
      u[i].sec_func = u[i].sec_func
      state.gastos.push(u[i])
    }
    state.gastosCalculado = gastos.groupBy(state.gastos, state.formatoGastos.formato)
  },
  setComponentesTareas (state, u) {
    state.componentesTareas = u
  },
  setAddProyecto (state, u) {
    var arr = state.proyectos.filter(d => d.idproy_proyecto == u.idproy_proyecto)[0]
    if (arr !== undefined) {
      arr.proy_nombre = u.proy_nombre
      arr.proy_cod_siaf = u.proy_cod_siaf
      arr.proy_cod_snip = u.proy_cod_snip
      proyectos.save(state.proyectos)
    } else {
      state.proyectos.push(u)
      proyectos.save(state.proyectos)
    }
  },
  setAddAnalitico (state, u) {
    let analitico = state.proyecto.analitico
    let indexC = analitico.findIndex(d => d[0].ana_componente === u.ana_componente)
    let indexE = -1
    if (indexC === -1) {
      analitico.push([
        {
          ana_act_proy: null,
          ana_componente: u.ana_componente,
          ana_descricion: null,
          ana_especifca: u.ana_especifca,
          ana_modificaciones: null,
          ana_monto: null,
          analitico_id: null,
          analitico_version_id: null,
          program: true
        }])
      indexC = analitico.length - 1
      indexE = 0
    }
    if (indexE === -1) {
      indexE = analitico[indexC].findIndex(d => d.ana_especifca === u.ana_especifca)
    }
    if (indexE === -1) {
      analitico[indexC].push({
        ana_act_proy: null,
        ana_componente: null,
        ana_descricion: null,
        ana_especifca: null,
        ana_modificaciones: null,
        ana_monto: null,
        analitico_id: null,
        analitico_version_id: null,
        program: true
      })
      indexE = analitico[indexC].length - 1
    }
    analitico[indexC][indexE] = Object.assign(analitico[indexC][indexE], u)
  },
  setVersionesAnalitico (state, u) {
    state.proyecto.versionesAnalitico = u
  },
  addVersionAnalitico (state, u) {
    state.proyecto.versionesAnalitico.push(u)
  },
  deleteOneComponenteTarea (state, u) {
    if (u.status) {
      let index = state.componentesTareas.findIndex(d => d.id == u.id)
      state.componentesTareas.splice(index, 1)
    } else {
      alert('El componente ya es utilizado en la modificatoria')
    }
  },
  setAddComponenteTarea (state, u) {
    let index = state.componentesTareas.findIndex(d => d.id === u.id)
    if (index === -1) {
      state.componentesTareas.push(u)
    } else {
      state.componentesTareas[index] = Object.assign(state.componentesTareas[index], u)
    }
  },
  setNewFormGastos (state, u) {
    state.formatoGastos = u
  },
  setNewGastosCalculado (state, u) {
    state.gastos = u
    state.gastosCalculado = u
  },
  setReferenceProyectGasto (state, u) {
    state.proyecto = u
  },
  setSelectId (state, u) {
    state.selectId = u
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
