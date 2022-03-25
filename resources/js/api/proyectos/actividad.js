import auth from '../auth'
import hash from '@/js/api/hash'

export default {
  requestActividad () {
    return axios.get('/app/proyectos/actividad/obtenerActividad')
  },
  requestActividades (formActividad) {
    return axios.get('/app/proyectos/actividades/index', { params: formActividad })
  },
  saveActividad (formActividad) {
    return axios.post('/app/proyectos/actividades/store', formActividad)
  },
  requestAdicionalObra (idcontrato) {
    const id = {
      idobra: idcontrato
    }
    return axios.get('/app/proyectos/actividades/obtenerAdicionalObra', { params: id })
  },
  saved () {
    hash.verificarHash('actividad', this.destroyActividad)
    return !!localStorage.getItem('actividad')
  },
  save (actividad) {
    localStorage.setItem('actividad', JSON.stringify(actividad))
  },
  getActividad () {
    return JSON.parse(localStorage.getItem('actividad'))
  },
  destroyActividad () {
    localStorage.removeItem('actividad')
  }
}
