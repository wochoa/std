
import hash from '@/js/api/hash'

export default {
  requestActProyecto (anio) {
    return axios.get('/app/presupuesto/actProyecto', { params: {
        'anio': anio
      }})
  },
  saved () {
    hash.verificarHash('actProyecto',this.destroyActProyecto);
    return !!localStorage.getItem('actProyecto')
  },
  save (actProyecto) {
    localStorage.setItem('actProyecto', JSON.stringify(actProyecto))
  },
  getActProyecto() {
    return JSON.parse(localStorage.getItem('actProyecto'))
  },
  destroyActProyecto () {
    localStorage.removeItem('actProyecto')
  }
}
