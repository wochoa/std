import auth from '../auth'
import hash from '@/js/api/hash'

export default {
  requestOficinas () {
    return axios.get('/app/proyectos/oficinas',
      //{headers: {'Authorization': 'Bearer ' + auth.getToken()}}
    )
  },
  saved () {
    hash.verificarHash('oficinas',this.destroyOficinas);
    return !!localStorage.getItem('oficinas')
  },
  save (oficinas) {
    localStorage.setItem('oficinas', JSON.stringify(oficinas))
  },
  getOficinas () {
    return JSON.parse(localStorage.getItem('oficinas'))
  },
  destroyOficinas () {
    localStorage.removeItem('oficinas')
  },
  requestSecfuncOficina (anio) {
    return axios.get('/app/gastos/reporte/secfuncOficina', { params: {
        'anio': anio
      }})
  }
}
