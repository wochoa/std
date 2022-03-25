import auth from '../auth'
import hash from '@/js/api/hash'

export default {
  requestEspecificaGasto () {
    return axios.get('/app/presupuesto/especificaDetalleGasto')
  },
  saved () {
    hash.verificarHash('especificaDetalleGasto', this.destroyEspecificaGasto)
    return !!localStorage.getItem('especificaDetalleGasto')
  },
  save (especificaGasto) {
    localStorage.setItem('especificaDetalleGasto', JSON.stringify(especificaGasto))
  },
  getEspecificaGasto () {
    return JSON.parse(localStorage.getItem('especificaDetalleGasto'))
  },
  destroyEspecificaGasto () {
    localStorage.removeItem('especificaDetalleGasto')
  }
}
