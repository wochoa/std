import auth from '../auth'
import hash from '@/js/api/hash'

export default {
  requestGruposFuncionales () {
    return axios.get('/app/presupuesto/gruposFuncionales')
  },
  saved () {

    hash.verificarHash('gruposFuncionales', this.destroyGruposFuncionales)
    return !!localStorage.getItem('gruposFuncionales')
  },
  save (gruposFuncionales) {
    localStorage.setItem('gruposFuncionales', JSON.stringify(gruposFuncionales))
  },
  getGruposFuncionales () {
    return JSON.parse(localStorage.getItem('gruposFuncionales'))
  },
  destroyGruposFuncionales () {
    localStorage.removeItem('gruposFuncionales')
  }
}
