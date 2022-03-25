import auth from '../auth'
import hash from '@/js/api/hash'

export default {
  requestComponente () {
    return axios.get('/app/presupuesto/componenteNombre')
  },
  saved () {
    hash.verificarHash('componente', this.destroyComponente)
    return !!localStorage.getItem('componente')
  },
  save (componente) {
    localStorage.setItem('componente', JSON.stringify(componente))
  },
  getComponente () {
    return JSON.parse(localStorage.getItem('componente'))
  },
  destroyComponente () {
    localStorage.removeItem('componente')
  }
}
