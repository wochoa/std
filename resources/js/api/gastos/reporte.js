import auth from '../auth'

export default {
  getReporteGeneral (filtro) {
    return axios.get('/app/gastos/reporte/reporteGeneral', {
      params: {
        'anio': filtro.anio,
        'oficina': filtro.oficina,
        'act_proy': filtro.act_proy
      }
    })
    // headers: {'Authorization': 'Bearer ' + auth.getToken()}});
  },
  getCicloGasto (data, filtro) {
    return axios.get('/app/gastos/reporte/cicloGasto', {
      params: {
        'anio': filtro.anio,
        'act_proy': filtro.act_proy,
        'oficina': filtro.oficina,
        'show': data.show,
        'tipo': data.tipo,
        'notas' : data.notas,
        'cuentaCorriente' : data.cuentaCorriente,
        'anulaciones' : data.anulaciones
      }
    })
  },
  getResumenGlobal () {
    return axios.get('/app/presupuesto/totalProyecto')
  }
}
