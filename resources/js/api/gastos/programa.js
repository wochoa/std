import auth from '../auth'
import hash from '@/js/api/hash'

export default {
  requestProgramasComponente () {
    return axios.get('/app/presupuesto/programasComponente')
  },
  saved () {
    hash.verificarHash('programa', this.destroyProgramasComponente)
    return !!localStorage.getItem('programa')
  },
  save (programa) {
    localStorage.setItem('programa', JSON.stringify(programa))
  },
  getProgramasComponente () {
    return JSON.parse(localStorage.getItem('programa'))
  },
  destroyProgramasComponente () {
    localStorage.removeItem('programa')
  }
}
