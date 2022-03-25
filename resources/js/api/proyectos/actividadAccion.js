import auth from '../auth'
import hash from '@/js/api/hash'

export default {
  requestActividadAccion () {
    return axios.get('/app/proyectos/actividad/obtenerActividadAccion')
  },
  saved () {
    hash.verificarHash('actividadAccion', this.destroyActividadAccion)
    return !!localStorage.getItem('actividadAccion')
  },
  save (actividadAccion) {
    localStorage.setItem('actividadAccion', JSON.stringify(actividadAccion))
  },
  getActividadAccion () {
    return JSON.parse(localStorage.getItem('actividadAccion'))
  },
  destroyActividadAccion () {
    localStorage.removeItem('actividadAccion')
  }
}
