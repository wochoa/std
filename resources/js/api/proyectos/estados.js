import auth from '../auth'
import hash from '@/js/api/hash'

export default {
  requestEstados () {
    return axios.get('/app/proyectos/estados')
  },
  saved () {
    hash.verificarHash('estados', this.destroyEstados)
    return !!localStorage.getItem('estados')
  },
  save (estados) {
    localStorage.setItem('estados', JSON.stringify(estados))
  },
  getEstados () {
    return JSON.parse(localStorage.getItem('estados'))
  },
  destroyEstados () {
    localStorage.removeItem('estados')
  }

}
