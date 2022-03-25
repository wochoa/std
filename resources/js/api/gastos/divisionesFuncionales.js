import auth from '../auth'
import hash from '@/js/api/hash'

export default {
  requestDivisionesFuncionales () {
    return axios.get('/app/presupuesto/divisionesFuncionales')
  },
  saved () {
    hash.verificarHash('divisionesFuncionales', this.destroyDivisionesFuncionales)
    return !!localStorage.getItem('divisionesFuncionales')
  },
  save (divisionesFuncionales) {
    localStorage.setItem('divisionesFuncionales', JSON.stringify(divisionesFuncionales))
  },
  getDivisionesFuncionales () {
    return JSON.parse(localStorage.getItem('divisionesFuncionales'))
  },
  destroyDivisionesFuncionales () {
    localStorage.removeItem('divisionesFuncionales')
  }
}
