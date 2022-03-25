import informes from '@/js/api/proyectos/informes'
import { md5 } from 'pure-md5'

const state = {
  informes: [],
  archivos: [],
}

const getters = {
  mostrarArchivos: (state) => {
    return state.archivos.filter((d) => d.file_mostrar)
  },
  getArchivoByMd5: (state) => (md5) => {
    return state.archivos.findIndex(d => d.md5 === md5)
  },
  getInformes: (state) => {
    return state.informes
  },
  getInf_FilesTrue: (state, getters) => (data) => {
    let index = getters.getIndexInformeFromId(data.id)
    let files = state.informes[index].inf_archivos.filter(d => d.file_mostrar)
    if (!data.edit)
      return files.slice(0, 6)
    else
      return files

  },
  getTotalFilesTrue: (state, getters) => (id) => {
    let index = getters.getIndexInformeFromId(id)
    return state.informes[index].inf_archivos.filter(d => d.file_mostrar).length
  },
  getIndexInformeFromId: (state) => (id) => {
    return state.informes.indexOf(state.informes.filter(d => d.id == id)[0])
  }
}

const actions = {
  newInforme ({ commit }) {
    commit('setNewInforme', [])
  },
  agregarFile ({ state, commit, getters }, file) {
    return new Promise((resolve, reject) => {
      let archivo = informes.crearArchivo(file)
      let reader = new FileReader()
      reader.onloadend = function () {
        archivo.file_tipo = file.type
        archivo.base64 = (archivo.file_tipo.indexOf('image') === 0) ? reader.result : null
        archivo.md5 = md5(reader.result)
        let indice = getters.getArchivoByMd5(archivo.md5)
        if (indice == -1) {
          archivo.cargarFile().then(response => {
            let indice = getters.getArchivoByMd5(archivo.md5)
            commit('setArchivoRuta', { id: indice, file_url: response.data })
          })
          commit('agregarArchivos', archivo)
        } else if (!state.archivos[indice].file_mostrar) {
          commit('mostrarArchivo', indice)
        } else
          alert('la imagen que desea cargar, ya se encuentra cargada!')
      }
      reader.readAsDataURL(file)
    })
  },
  updateArchivoDescripcion ({ commit, getters }, archivo) {
    let indice = getters.getArchivoByMd5(archivo.md5)
    commit('setArchivoDescripcion', { id: indice, file_name: archivo.file_name })
  },
  ocultarArchivo ({ commit, getters }, md5) {
    let indice = getters.getArchivoByMd5(md5)
    commit('ocultarArchivo', indice)

  },
  guardarInforme ({ state }, formInforme) {
    informes.enviarInforme(formInforme, state.archivos)
  },

  actualizarInforme ({ dispatch, commit, getters }, data) {

    informes.actualizarInforme(data.f, state.archivos).then(response => {

      dispatch('setInformeForEdit', { id: data.f.id, edit: false })
      let index = getters.getIndexInformeFromId(data.f.id)
      let d = response.data
      d.edit = false
      commit('updateInforme', { index: index, data: d })

      data.c.$forceUpdate()
    })
  },

  obtenerInformesByProyecto ({ commit }, id_proyecto) {
    return new Promise((resolve, reject) => {
      informes.obtenerInformes(id_proyecto).then(response => {
        let d = response.data
        for (let i = 0; i < d.length; i++)
          d[i].edit = false
        commit('setInformes', d)
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  },

  setInformeForEdit ({ state, commit, getters }, dato) {
    let index = getters.getIndexInformeFromId(dato.id)
    let d = Object.assign({}, state.informes[index])
    if (dato.edit ^ state.informes.filter(d => d.edit).length != 0) {
      d.edit = dato.edit
      commit('updateInforme', { index: index, data: d })
    }
  }

}

const mutations = {
  setArchivos (state, u) {
    state.archivos = u
  },
  agregarArchivos (state, u) {
    state.archivos.push(u)
  },
  setNewInforme (state, u) {
    state.archivos = u
  },
  ocultarArchivo (state, id) {
    state.archivos[id].file_mostrar = 0
    state.archivos[id].file_name = null
  },
  mostrarArchivo (state, id) {
    state.archivos[id].file_mostrar = 1
    state.archivos[id].file_name = null

  },
  setArchivoDescripcion (state, obj) {
    state.archivos[obj.id].file_name = obj.file_name
  },
  setArchivoRuta (state, obj) {
    state.archivos[obj.id].file_url = obj.file_url
  },
  setInformes (state, u) {
    state.informes = u
  },
  updateInforme (state, d) {
    state.informes[d.index] = d.data
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
