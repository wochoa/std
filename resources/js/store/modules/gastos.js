import reporte                from '@/js/api/gastos/reporte'
import fuenteFinanciamiento   from '@/js/api/gastos/fuenteFinanciamiento'
import especificaGasto        from '@/js/api/gastos/especificaGasto'
import especificaDetalleGasto from '@/js/api/gastos/especificaDetalleGasto'
import componente             from '@/js/api/gastos/componente'
import dispositivosLegales    from '@/js/api/gastos/dispositivosLegales'
import maestroDocumento       from '@/js/api/gastos/maestroDocumento'
import programa               from '@/js/api/gastos/programa'
import divisionesFuncionales  from '@/js/api/gastos/divisionesFuncionales'
import gruposFuncionales      from '@/js/api/gastos/gruposFuncionales'
import funciones              from '@/js/api/proyectos/funciones'
import oficinas               from '@/js/api/proyectos/oficinas'
import actProyecto            from '@/js/api/gastos/actProyecto'
import metas from '@/js/api/proyectos/metas'

const state = {
  diasMes               : [
    1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31],
  meses                 : [
    'Enero',
    'Febrero',
    'Marzo',
    'Abril',
    'Mayo',
    'Junio',
    'Julio',
    'Agosto',
    'Setiembre',
    'Octubre',
    'Noviembre',
    'Diciembre'],
  mesesCorto            : [
    'Ene.',
    'Feb.',
    'Mar.',
    'Abr.',
    'May.',
    'Jun.',
    'Jul.',
    'Ago.',
    'Set.',
    'Oct.',
    'Nov.',
    'Dic.'],
  anioInicio            : 2002,
  colores               : [
    '#e11d21',
    '#fbca04',
    '#009800',
    '#424242',
    '#3ccee5',
    '#000000',
    '#5319e7',
    '#00CC6F',
    '#FA8258',
    '#00FF00',
    '#FE2EF7',
    '#0040FF',
    '#886A08',
    '#0B615E',
    '#04B486',
    '#B40404',
    '#FB275D',
    '#AEB404',
    '#FFBF00',
    '#0040FF'],
  reporte               : {
    estiloReporteGeneral: {
      presupuesto : {
        text : 'P.I.M.',
        color: 'primary'
      },
      certificado : {
        text : 'Cert.',
        color: 'success'
      },
      comprometido: {
        text : 'Comp.',
        color: 'warning'
      },
      devengado   : {
        text : 'Dev.',
        color: '#dc3545'
      },
      girado   : {
        text : 'Gir.',
        color: '#35c0dc'
      }
    },
    cursorReporteGeneral: 0,
    general             : [
      {
        presupuesto : 0,
        certificado : 0,
        comprometido: 0,
        devengado   : 0,
        girado      : 0
      }],
    graficoGeneral      : {},
    graficoDiario       : {},
    graficoAsignacion   : {},
    graficoProgramado   : {},
    prioritarios        : [],
    certificados        : [],
    compromisosAnual    : [],
    compromisosMes      : [],
    devengados          : [],
    girados             : [],
    filtro              : {}
  },
  fuenteFinanciamiento  : [],
  especificaGasto       : [],
  especificaDetalleGasto: [],
  componente            : [],
  dispositivosLegales   : [],
  maestroDocumento      : [],
  programasComponente   : [],
  divisionesFuncionales : [],
  gruposFuncionales     : [],
  funciones             : [],
  secfuncOficinas       : [],
  actProyecto           : []
}

const getters = {
  getEstiloReporteGeneral : state => {
    return state.reporte.estiloReporteGeneral
  },
  getReporeteGeneralAvance: state => id => {
    if (id != 'presupuesto') {
      return (Math.round((state.reporte.general[state.reporte.cursorReporteGeneral][id] / state.reporte.general[state.reporte.cursorReporteGeneral].presupuesto) * 10000) / 100 + ' %')
    } else {
      return ''
    }
  },
  getReporeteGeneralMonto : state => id => {
    return ('S/ ' + Math.round(state.reporte.general[state.reporte.cursorReporteGeneral][id])
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ','))
  },
  getAniosReporte         : state => {
    var arr   = []
    var count = 0
    for (var i = new Date().getFullYear(); i >= state.anioInicio; i--) {
      arr[count++] = {
        text : i,
        value: i
      }
    }
    return arr
  },
  getGraficoDiario        : state => {
    var grafico = {
      labels  : state.diasMes,
      datasets: []
    }
    Object.keys(state.reporte.graficoDiario).forEach(mes => {
      var data = []
      for (var i = 0; i < 31; i++) {
        var last = i === 0 ? 0 : data[i - 1]
        data[i]  = last + (state.reporte.graficoDiario[mes][i + 1] !== undefined ? state.reporte.graficoDiario[mes][i + 1] : 0)
      }
      if (mes > 2) {
        grafico.datasets[mes - 3].hidden = true
      }

      if (mes > 1) {
        grafico.datasets[mes - 2].borderWidth = 1
        grafico.datasets[mes - 2].pointRadius = 1
      }
      grafico.datasets[mes - 1] = {
        label           : state.mesesCorto[mes - 1],
        backgroundColor : 'rgba(0, 0, 0, 0)',
        borderColor     : state.colores[mes - 1],
        pointBorderWidth: 3,
        pointRadius     : 2,
        borderWidth     : 2,
        hidden          : false,
        data            : data
      }
    })
    console.log(grafico)
    return grafico
  },
  getGraficoAcumulado     : state => {
    var grafico = {
      labels  : state.meses,
      datasets: []
    }
    var dataset = []
    Object.keys(state.reporte.graficoDiario).forEach(mes => {
      mes              = parseInt(mes)
      dataset[mes - 1] = mes === 1 ? 0 : dataset[mes - 2]
      //dataset[mes-1]=((dataset[mes-1]!==undefined)?dataset[mes-1]:0);
      for (var i = 0; i < 31; i++) {
        dataset[mes - 1] += state.reporte.graficoDiario[mes][i + 1] !== undefined ? state.reporte.graficoDiario[mes][i + 1] : 0
      }
    })
    grafico.datasets[0] = {
      label           : 'Ejecucion',
      backgroundColor : 'rgba(0, 0, 0, 0)',
      borderColor     : state.colores[0],
      pointBorderWidth: 3,
      pointRadius     : 2,
      borderWidth     : 2,
      data            : dataset
    }
    dataset             = []
    Object.keys(state.reporte.graficoAsignacion).forEach(key => {
      var last     = key == 0 ? 0 : dataset[key - 1]
      dataset[key] = last
      dataset[key] += parseInt(state.reporte.graficoAsignacion[key].monto)
    })
    grafico.datasets[1] = {
      label           : 'Presupuesto',
      backgroundColor : 'rgba(0, 0, 0, 0)',
      borderColor     : '#1976d2',
      pointBorderWidth: 3,
      pointRadius     : 2,
      borderWidth     : 2,
      data            : dataset
    }
    dataset             = []
    Object.keys(state.reporte.graficoProgramado).forEach(key => {
      var last     = key == 0 ? 0 : dataset[key - 1]
      dataset[key] = last
      dataset[key] += Math.round(parseFloat(state.reporte.graficoProgramado[key]))
    })
    grafico.datasets[2] = {
      label           : 'Programado',
      backgroundColor : 'rgba(0, 0, 0, 0)',
      borderColor     : state.colores[2],
      pointBorderWidth: 3,
      pointRadius     : 2,
      borderWidth     : 2,
      data            : dataset
    }
    return grafico
  },
  getPrioritarios         : state => {
    return state.reporte.prioritarios
  },
  showCertificadosGeneral : state => {
    return state.reporte.certificados
  },
  showCompromisosAnual    : state => {
    return state.reporte.compromisosAnual
  },
  showCompromisosMes      : state => {
    return state.reporte.compromisosMes
  },
  showDevengados          : state => {
    return state.reporte.devengados
  },
  showGirados : state => {
    return state.reporte.girados
  },
  formatMoney             : state => data => {
    data = data == null ? 0 : data
    return ('S/ ' + parseFloat(data)
        .toFixed(2)
        .replace(/\B(?=(\d{3})+(?!\d))/g, ','))
  },
  formatDecimal           : state => data => {
    data = data == null ? 0 : data
    return parseFloat(data)
      .toFixed(2)
      .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  },
  showNameLvl             : state => data => {
    switch (data.caso) {
      case 'ano_eje':
        return ''
        break
      case 'fuente_financ':
        var u = state.fuenteFinanciamiento.filter(d => d.fuente_financ === data.data)[0]
        if (u !== undefined) {
          return u.nombre
        } else {
          return null
        }
        break
      case 'sec_func':
        var u = state.componente.filter(d => d.componente == data.componente)[0]
        if (u !== undefined) {
          return u.nombre
        } else {
          return null
        }
        break
      case 'id_clasificador':
        var u = state.especificaDetalleGasto.filter(d => d.id_clasificador === data.data)[0]
        if (u !== undefined) {
          return u.descripcion
        } else {
          return null
        }
        break
    }
  },
  showComponenteNombre    : state => id => {
    var u = state.componente.filter(d => d.componente == id)[0]
    if (u !== undefined) {
      return id + ' - ' + u.nombre
    } else {
      return id + ' - ' + 'COMPONENTE DESCONOCIDO'
    }
  },

  showOneComponente        : state => data => {
    let arr = state.componente.filter(d => d.componente == data)[0]
    if (arr != undefined) {
      return arr.componente + ' - ' + arr.nombre
    } else {
      return data + '-' + 'Componente Desconocido'
    }
  },
  showFuentesFinanciamiento: state => {
    var arr1 = state.fuenteFinanciamiento.filter(d => true)
    var arr  = []
    for (var i = 0; i < arr1.length; i++) {
      arr[i] = {
        text : arr1[i].fuente_financ + ' - (' + fuenteFinanciamiento.iniciales(arr1[i].nombre) + ') ' + arr1[i].nombre,
        value: arr1[i].fuente_financ
      }
    }
    return arr
  },
  showComponentes          : state => {
    return state.componente
  },
  showEspecificaDescripcion: state => id => {
    var u = state.especificaDetalleGasto.filter(d => d.id_clasificador === id)
    if (u.length == 1) {
      return u[0].clasifi + ' - ' + u[0].descripcion
    } else {
      return 'ESPECIFICA DESCONOCIDA'
    }
  },
  showEspecificasForSelect : state => {
    var arr  = []
    var j    = 0
    var arr1 = state.especificaDetalleGasto.filter(d => d.clasifi.startsWith('2.6'))

    var especifica = ''
    for (var i = 0; i < arr1.length; i++) {
      let tempEsp = arr1[i].clasifi.substring(0, arr1[i].clasifi.lastIndexOf('.'))
      if (tempEsp !== especifica) {
        especifica = tempEsp
        arr[j++]   = {
          header: tempEsp + ' - ' + (state.especificaGasto[tempEsp] !== undefined ? state.especificaGasto[tempEsp] : '')
        }
        arr[j++]   = {divider: true}
      }
      arr[j++] = {
        text : arr1[i].clasifi + ' - ' + arr1[i].descripcion,
        value: arr1[i].id_clasificador
      }
    }

    return arr
    //return state.especificaDetalleGasto;
  },
  showNameLvl3             : state => data => {
    var u = state.especificaDetalleGasto.filter(d => d.id_clasificador === data)[0]
    if (u !== undefined) {
      return u.clasifi
    } else {
      return null
    }
  },
  showProgramasComponente  : state => {
    return state.programasComponente
  },
  showOneProgramaComponente: state => data => {
    let arr = state.programasComponente.filter(d => d.programa_ppto == data)[0]
    if (arr != undefined) {
      return arr.programa_ppto + ' - ' + arr.nombre
    } else {
      return data + '-' + 'Programa Desconocido'
    }
  },
  showDivisionesFuncionales: state => {
    return state.divisionesFuncionales
  },
  showOneDivisionFuncional : state => data => {
    let arr = state.divisionesFuncionales.filter(d => d.programa == data)[0]
    if (arr != undefined) {
      return arr.programa + ' - ' + arr.nombre
    } else {
      return data + '-' + 'División Funcional Desconocido'
    }
  },
  showGrupoFuncionales     : state => {
    return state.gruposFuncionales
  },
  showOneGrupoFuncional    : state => data => {
    let arr = state.gruposFuncionales.filter(d => d.sub_programa == data)[0]
    if (arr != undefined) {
      return arr.sub_programa + ' - ' + arr.nombre
    } else {
      return data + '-' + 'Grupo Funcional Desconocido'
    }
  },
  mostrarFunciones         : state => {
    return state.funciones
  },
  showOneFuncion           : state => data => {
    let arr = state.funciones.filter(d => d.funcion == data)[0]
    if (arr != undefined) {
      return arr.funcion + ' - ' + arr.nombre
    } else {
      return data + '-' + 'Función Desconocido'
    }
  },
  showOficinaSecfunc       : (state, getters) => data => {
    let arr = state.secfuncOficinas.filter(d => d.proy_siaf_anio == parseInt(data.ano_eje) && d.proy_siaf_sec_func == data.sec_func)[0]
    if (arr != undefined) {
      return getters.showNameOficina(arr.proy_tram_dependencia)
    } else {
      return 'Oficina Desconocida'
    }
  },
  mostrarProyectosForSelect: state => {
    let arr = []
    let arr1 = state.actProyecto
    let j = 0
    for (let i = 0; i < arr1.length; i++) {
      arr[j++] = {
        text: `${arr1[i].act_proy}  ${arr1[i].nombre}`,
        value: arr1[i].act_proy
      }
    }
    return arr
  },
}

const actions = {
  obtenerReporteGeneral({commit}, filtro) {
    return new Promise((resolve, reject) => {
      reporte
        .getReporteGeneral(filtro)
        .then(response => {
          commit('setFiltro', filtro)
          commit('setReporteGeneral', response.data.resumen)
          commit('setGraficoDiario', response.data.reportediario)
          commit('setGraficoAsignacion', response.data.asignacion)
          commit('setGraficoProgramado', response.data.programado)
          commit('setPrioritarios', response.data.prioritario)
          commit('setCertificados', response.data.certificados)
          commit('setCompromisoAnual', response.data.compromisosAnual)
          commit('setCompromisoMes', response.data.compromisosMes)
          commit('setDevengados', response.data.devengados)
          commit('setGirados', response.data.girados)

          resolve(response)
        })
        .catch(error => {
          reject(error)
        })
    })
  },
  obtenerCicloGasto({state, commit}, data) {
    return new Promise((resolve, reject) => {
      reporte
        .getCicloGasto(data, state.reporte.filtro)
        .then(response => {
          switch (data.tipo) {
            case 0:
              commit('setCertificados', response.data)
              break
            case 1:
              commit('setCompromisoAnual', response.data)
              break
            case 2:
              commit('setCompromisoMes', response.data)
              break
            case 3:
              commit('setDevengados', response.data)
              break
            case 4:
              commit('setGirados', response.data)
              break
          }
          resolve(response)
        })
        .catch(error => {
          reject(error)
        })
    })
  },
  getfuenteFinanciamiento({commit}) {
    if (!fuenteFinanciamiento.saved()) {
      return new Promise((resolve, reject) => {
        fuenteFinanciamiento
          .requestFuenteFinanciamiento()
          .then(response => {
            commit('setFuenteFinanciamiento', response.data)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    } else {
      commit('setFuenteFinanciamiento', fuenteFinanciamiento.getfuenteFinanciamiento())
    }
  },
  getEspecificaGasto({commit}) {
    if (!especificaGasto.saved()) {
      return new Promise((resolve, reject) => {
        especificaGasto
          .requestEspecificaGasto()
          .then(response => {
            commit('setEspecificaGasto', response.data)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    } else {
      commit('setEspecificaGasto', especificaGasto.getEspecificaGasto())
    }
  },
  getEspecificaDetalleGasto({commit}) {
    if (!especificaDetalleGasto.saved()) {
      return new Promise((resolve, reject) => {
        especificaDetalleGasto
          .requestEspecificaGasto()
          .then(response => {
            commit('setEspecificaDetalleGasto', response.data)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    } else {
      commit('setEspecificaDetalleGasto', especificaDetalleGasto.getEspecificaGasto())
    }
  },
  getComponente({commit}) {
    if (!componente.saved()) {
      return new Promise((resolve, reject) => {
        componente
          .requestComponente()
          .then(response => {
            commit('setComponente', response.data)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    } else {
      commit('setComponente', componente.getComponente())
    }
  },
  getDispositivosLegales({commit}) {
    if (!dispositivosLegales.saved()) {
      return new Promise((resolve, reject) => {
        dispositivosLegales
          .requestDispositivosLegales()
          .then(response => {
            commit('setDispositivosLegales', response.data)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    } else {
      commit('setDispositivosLegales', dispositivosLegales.getDispositivosLegales())
    }
  },
  getMaestroDocumento({commit}) {
    if (!maestroDocumento.saved()) {
      return new Promise((resolve, reject) => {
        maestroDocumento
          .requestMaestroDocumento()
          .then(response => {
            commit('setMaestroDocumento', response.data)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    } else {
      commit('setMaestroDocumento', maestroDocumento.getMaestroDocumento())
    }
  },
  getProgramasComponente({commit}) {
    if (!programa.saved()) {
      return new Promise((resolve, reject) => {
        programa
          .requestProgramasComponente()
          .then(response => {
            commit('setProgramasComponente', response.data)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    } else {
      commit('setProgramasComponente', programa.getProgramasComponente())
    }
  },
  getDivisionesFuncionales({commit}) {
    if (!divisionesFuncionales.saved()) {
      return new Promise((resolve, reject) => {
        divisionesFuncionales
          .requestDivisionesFuncionales()
          .then(response => {
            commit('setDivisionesFuncionales', response.data)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    } else {
      commit('setDivisionesFuncionales', divisionesFuncionales.getDivisionesFuncionales())
    }
  },
  getGruposFuncionales({commit}) {
    if (!gruposFuncionales.saved()) {
      return new Promise((resolve, reject) => {
        gruposFuncionales
          .requestGruposFuncionales()
          .then(response => {
            commit('setGruposFuncionales', response.data)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    } else {
      commit('setGruposFuncionales', gruposFuncionales.getGruposFuncionales())
    }
  },
  getFunciones({commit}) {
    if (!funciones.saved()) {
      return new Promise((resolve, reject) => {
        funciones
          .requestFunciones()
          .then(response => {
            commit('setFunciones', response.data)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    } else {
      commit('setFunciones', funciones.getFunciones())
    }
  },
  getSecfuncOficinas({commit}, anio) {
    return new Promise((resolve, reject) => {
      oficinas
        .requestSecfuncOficina(anio)
        .then(response => {
          commit('setSecfuncOficinas', response.data)
          resolve(response)
        })
        .catch(error => {
          reject(error)
        })
    })
  },
  getActProyecto({commit}, anio) {
    if (!actProyecto.saved() || anio != curryear){
      return new Promise((resolve, reject) => {
        actProyecto.requestActProyecto(anio).then(response => {
          if (response.data.length > 0) {
            commit('setActProyecto', response.data)
            resolve(response)
          } else {
            alert('No hay datos que mostrar')
          }
        }).catch(error => {
          reject(error)
        })
      })
    }
    else {
      commit('setActProyecto', actProyecto.getActProyecto())
    }
  }
}

const mutations = {
  setReporteGeneral(state, data) {
    state.reporte.general = data
  },
  setGraficoGeneral(state, data) {
    state.reporte.graficoGeneral = data
  },
  setGraficoDiario(state, data) {
    let max = 0
    Object.keys(data).forEach(key => {
      max = max < parseInt(key) ? parseInt(key) : max
    })
    for (var i = 1; i <= max; i++) {
      if (data[i] === undefined) {
        data[i] = {}
      }
    }
    state.reporte.graficoDiario = data
  },
  setGraficoAsignacion(state, data) {
    state.reporte.graficoAsignacion = data
  },
  setGraficoProgramado(state, data) {
    state.reporte.graficoProgramado = data
  },
  setPrioritarios(state, data) {
    state.reporte.prioritarios = data
  },
  setCertificados(state, u) {
    state.reporte.certificados = u
  },
  setCompromisoAnual(state, u) {
    state.reporte.compromisosAnual = u
  },
  setCompromisoMes(state, u) {
    state.reporte.compromisosMes = u
  },
  setDevengados(state, u) {
    state.reporte.devengados = u
  },
  setGirados(state, u) {
    state.reporte.girados = u
  },
  setFuenteFinanciamiento(state, u) {
    state.fuenteFinanciamiento = u
    fuenteFinanciamiento.save(state.fuenteFinanciamiento)
  },
  setEspecificaGasto(state, u) {
    state.especificaGasto = u
    especificaGasto.save(state.especificaGasto)
  },
  setEspecificaDetalleGasto(state, u) {
    state.especificaDetalleGasto = u
    especificaDetalleGasto.save(state.especificaDetalleGasto)
  },
  setComponente(state, u) {
    state.componente = u
    componente.save(state.componente)
  },
  setDispositivosLegales(state, u) {
    state.dispositivosLegales = u
    dispositivosLegales.save(state.dispositivosLegales)
  },
  setMaestroDocumento(state, u) {
    state.maestroDocumento = u
    maestroDocumento.save(state.maestroDocumento)
  },
  setProgramasComponente(state, u) {
    state.programasComponente = u
    programa.save(state.programasComponente)
  },
  setDivisionesFuncionales(state, u) {
    state.divisionesFuncionales = u
    divisionesFuncionales.save(state.divisionesFuncionales)
  },
  setGruposFuncionales(state, u) {
    state.gruposFuncionales = u
    gruposFuncionales.save(state.gruposFuncionales)
  },
  setFunciones(state, u) {
    state.funciones = u
    funciones.save(state.funciones)
  },
  setFiltro(state, u) {
    state.reporte.filtro = u
  },
  setSecfuncOficinas(state, u) {
    state.secfuncOficinas = u
  },
  setActProyecto(state, u) {
    state.actProyecto = u
    console.log(curryear)
    console.log(u[0].ano_eje)
    if (u[0].ano_eje == curryear) {
      actProyecto.save(state.actProyecto)
    }
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
