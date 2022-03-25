import auth from '../auth'
import hash from '@/js/api/hash'

export default {
  requestProyectos () {
    return axios.get('/app/proyectos/obtenerProyectos')
  },

  requestSiaf (formProyecto) {
    return axios.get('app/proyectos/inviertepe?codigo=' + formProyecto.proy_cod_siaf).then(response => {
      formProyecto.proy_nombre = response.data[0].Nombre
      formProyecto.proy_cod_snip = response.data[0].CodigoSnip
      formProyecto.proy_fte_fto = response.data[0].FuenteFinanciamiento
      formProyecto.proy_beneficiarios = response.data[0].Beneficiario
      formProyecto.proy_perfil_viable = response.data[0].MontoAlternativa
      formProyecto.proy_snip15 = response.data[0].MontoF15
      formProyecto.proy_snip16 = response.data[0].MontoF16

      let arrayFecha0 = response.data[0].FechaViabilidadStr.split(['/'])
      let yymmdd0 = arrayFecha0[2] + '-' + arrayFecha0[1] + '-' + arrayFecha0[0]
      formProyecto.proy_verificacion_viabilidad = yymmdd0

      let arrayFecha = response.data[0].FechaRegistroStr.split(['/'])
      let yymmdd = arrayFecha[2] + '-' + arrayFecha[1] + '-' + arrayFecha[0]
      formProyecto.proy_fech_registro_perfil = yymmdd

      formProyecto.proy_pip_actualizado = response.data[0].Costo
    })
  },

  requestUniqueProyect (params) {
    return axios.post('app/proyectos/checkCodSnip', params)
  },

  requestProyecto (id) {
    return axios.get('/app/proyectos/show?id=' + id)
  },

  saveProyecto (formProyecto) {
    return axios.post('/app/proyectos/store', formProyecto)
  },

  saved () {
    hash.verificarHash('proyectos', this.destroyProyectos)
    return !!localStorage.getItem('proyectos')
  },
  save (proyectos) {
    localStorage.setItem('proyectos', JSON.stringify(proyectos))
  },
  getProyectos () {
    return JSON.parse(localStorage.getItem('proyectos'))
  },
  destroyProyectos () {
    localStorage.removeItem('proyectos')
  },
  excel(proyecto, formato) {
    return axios.get(`/app/proyectos/${proyecto}/${formato}/gastos`, {
      responseType: 'arraybuffer'
    })
  },
}
