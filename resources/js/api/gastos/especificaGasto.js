import auth from '../auth'
import hash from '@/js/api/hash'

export default {
  requestEspecificaGasto () {
    return axios.get('/app/presupuesto/especificaGasto')
  },
  saved () {
    hash.verificarHash('especificaGasto', this.destroyEspecificaGasto)
    return !!localStorage.getItem('especificaGasto')
  },
  save (especificaGasto) {
    localStorage.setItem('especificaGasto', JSON.stringify(especificaGasto))
  },
  getEspecificaGasto () {
    return JSON.parse(localStorage.getItem('especificaGasto'))
  },
  destroyEspecificaGasto () {
    localStorage.removeItem('especificaGasto')
  }
}
