import auth from '../auth'
import hash from '@/js/api/hash'

export default {
  requestDispositivosLegales () {
    return axios.get('/app/presupuesto/dispositivosLegales')
  },
  saved () {
    hash.verificarHash('dispositivosLegales', this.destroyDispositivosLegales)
    return !!localStorage.getItem('dispositivosLegales')
  },
  save (dispositivosLegales) {
    localStorage.setItem('dispositivosLegales', JSON.stringify(dispositivosLegales))
  },
  getDispositivosLegales () {
    return JSON.parse(localStorage.getItem('dispositivosLegales'))
  },
  destroyDispositivosLegales () {
    localStorage.removeItem('dispositivosLegales')
  }
}
