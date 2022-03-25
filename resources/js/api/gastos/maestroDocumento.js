import auth from '../auth'
import hash from '@/js/api/hash'

export default {
  requestMaestroDocumento () {
    return axios.get('/app/presupuesto/maestroDocumento')
  },
  saved () {
    hash.verificarHash('maestroDocumento', this.destroyMaestroDocumento)
    return !!localStorage.getItem('maestroDocumento')
  },
  save (maestroDocumento) {
    localStorage.setItem('maestroDocumento', JSON.stringify(maestroDocumento))
  },
  getMaestroDocumento () {
    return JSON.parse(localStorage.getItem('maestroDocumento'))
  },
  destroyMaestroDocumento () {
    localStorage.removeItem('maestroDocumento')
  }
}
