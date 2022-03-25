const state     = {
  buscar             : {
    codigoBusqueda    : null,
    formBusqueda      : {
      iddocumento: null,
      modal      : true
    },
    documento         : {},
    relacionados      : {},
    operaciones       : [],
    digitales         : [],
    acarreoOperaciones: [],
    grafico           : [],
    numeroBranchs     : 0,
    imagenes          : []
  },
  rutas              : {},
  dependenciaUser    : [],
  archivadores       : [],
  usuarios           : [],
  tiposDocumento     : [],
  dependencias       : [],
  periodosCorrelativo: [],
  roles              : [],
  usuario            : [],
  derivar            : {
    soloCopia: false
  },
  inicio             : {
    totalDocGenerados         : 1,
    usuarioDocGenerados       : 0,
    totalPlantilla            : 1,
    usuarioPlantilla          : 0,
    totalArchivados           : 1,
    usuarioArchivados         : 0,
    totalRecibir              : 1,
    usuarioRecibir            : 0,
    totalProceso              : 1,
    derivadosProceso          : 0,
    usuarioProceso            : 1,
    usuarioDerivadosProceso   : 0,
    usuariosArchivadosTemporal: 0,
    totalMpv                  : 0,
    usuariosMpv               : 0
  }
}
const mutations = {

  llenarInicio(state, inicio) {
    state.inicio.totalDocGenerados          = inicio.totalDocGenerados
    state.inicio.usuarioDocGenerados        = inicio.usuarioDocGenerados
    state.inicio.totalPlantilla             = inicio.totalPlantilla
    state.inicio.usuarioPlantilla           = inicio.usuarioPlantilla
    state.inicio.totalArchivado             = inicio.totalArchivado
    state.inicio.usuarioArchivados          = inicio.usuarioArchivados
    state.inicio.totalRecibir               = inicio.totalRecibir
    state.inicio.usuarioRecibir             = inicio.usuarioRecibir
    state.inicio.totalProceso               = inicio.totalProceso
    state.inicio.derivadosProceso           = inicio.derivadosProceso
    state.inicio.usuarioProceso             = inicio.usuarioProceso
    state.inicio.usuarioDerivadosProceso    = inicio.usuarioDerivadosProceso
    state.inicio.usuariosArchivadosTemporal = inicio.usuariosArchivadosTemporal
    state.inicio.totalMpv                   = inicio.totalMpv
    state.inicio.usuariosMpv                = inicio.usuariosMpv
  },
  llenarDependencias(state, dependencias) {
    for (var i = 0; i < dependencias.length; i++) {
      state.dependencias.push({
                                iddependencia     : dependencias[i][0],
                                depe_nombre       : dependencias[i][1],
                                depe_depende      : dependencias[i][2],
                                depe_tipo         : dependencias[i][3],
                                depe_recibetramite: dependencias[i][4]
                              })
    }
  },
  llenarDependenciaUser(state, dependencia) {
    state.dependenciaUser = dependencia
  },
  llenarArchivadores(state, archivadores) {
    for (var i = 0; i < archivadores.length; i++) {
      state.archivadores.push({
                                idarch      : archivadores[i][0],
                                arch_periodo: archivadores[i][1],
                                arch_nombre : archivadores[i][2]
                              })
    }
  },
  llenarUsuarios(state, usuarios) {
    for (var i = 0; i < usuarios.length; i++) {
      state.usuarios.push({
                            id         : usuarios[i][0],
                            adm_name   : usuarios[i][1],
                            adm_cargo  : usuarios[i][2],
                            adm_inicial: usuarios[i][3],
                            adm_estado : usuarios[i][4]
                          })
    }
  },
  llenarRutas(state, rutas) {
    state.rutas = rutas
  },
  llenarTiposDocumento(state, tiposDocumento) {
    for (var i = 0; i < tiposDocumento.length; i++) {
      state.tiposDocumento.push({
                                  idtdoc          : tiposDocumento[i][0],
                                  tdoc_descripcion: tiposDocumento[i][1]
                                })
    }
  },
  llenarPeriodos(state, periodos) {
    state.periodosCorrelativo = periodos
  },
  llenarRoles(state, roles) {
    state.roles = roles
  },
  llenarUsuario(state, usuario) {
    state.usuario = usuario
  },
  llenarBuscarImagenes(state, imagenes) {
    state.buscar.imagenes = imagenes
  },
  llenarDerivarSoloCopia(state, soloCopia) {
    state.derivar.soloCopia = soloCopia
  },

  pushRuta(state, d) {
    state.rutas[d.name] = d.route
  },
  setCodigoBusqueda(state, codigo) {
    state.buscar.codigoBusqueda = codigo
  },
  setBuscarData(state, data) {
    state.buscar.documento    = data.documento
    state.buscar.operaciones  = data.operaciones
    state.buscar.relacionados = data.relacionados
    state.buscar.digitales    = data.digitales
  },
  setBuscarFormId(state, id) {
    state.buscar.formBusqueda.iddocumento = id
  },
  setBuscarNumeroBranchs(state, nro) {
    state.buscar.numeroBranchs = nro
  },
  incrementBuscarNumeroBranchs(state) {
    state.buscar.numeroBranchs++
  },
  setBuscarGrafico(state, grafico) {
    state.buscar.grafico = grafico
  },
  setBuscarFormModal(state, modal) {
    state.buscar.formBusqueda.modal = modal
  }
}
const actions   = {

  obtenerTotal              : async function ({commit, getters}) {
    axios.get(getters.getRuta('tramite.documento.obtenerTotal')).then(response => {
      commit('llenarInicio', response.data)
    })
  },
  obtenerDependenciaUser    : async function ({commit, getters, state}) {
    if (state.dependenciaUser.length === 0) {
      await axios.get(getters.getRuta('tramite.unidades.obtenerUnidadOrganica') + '?tipo=5').then(response => {
        commit('llenarDependenciaUser', response.data)
      })
    }
  },
  obtenerArchivadores       : async function ({getters, commit, state}) {
    if (state.archivadores.length === 0) {
      await axios.get(getters.getRuta('tramite.archivador.obtenerArchivadores')).then(response => {
        commit('llenarArchivadores', response.data)
      })
    }
  },
  obtenerJsonAll            : async function ({getters, commit, state}) {
    if (state.dependencias.length === 0 || state.tiposDocumento.length === 0) {
      await axios.get(getters.getRuta('tramite.documento.json') + "?user=" + state.usuario.id + "&dependencia=" + state.usuario.depe_id).then(response => {
        commit('llenarDependencias', response.data.dependencias)
        commit('llenarTiposDocumento', response.data.tiposDocumentos)
        commit('llenarDependenciaUser', response.data.dependenciaUser)
        commit('llenarUsuarios', response.data.usersOfDependencia)
        commit('llenarBuscarImagenes', response.data.imagenes)
      })
    }
  },
  obtenerPeriodosCorrelativo: async function ({commit, getters, state}) {
    var a = []
    for (var i = 2015; i <= new Date().getFullYear(); i++) {
      a.push({tdco_periodo: i})
    }
    commit('llenarPeriodos', a)
  },
  obtenerRoles              : async function ({commit, getters, state}) {
    if (state.roles.length === 0) {
      axios.get(getters.getRuta('administrador.rol.obtenerRolesDepe')).then(response => {
        commit('llenarRoles', response.data)
      })
    }
  },
  obtenerUsuario            : async function ({commit, getters, state}, user) {
    commit('llenarUsuario', user)
  },
  imprimirDocumentoPdf      : async function ({getters}, data) {
    let f     = ''
    f += '&id=' + data.id
    f += '&tipo=' + data.tipo
    if(data.tipo ===1) {
      f += '&id_documento=' + data.id_documento
    } else {
      f += '&id_documento_externo=' + data.id_documento_externo
    }
    let route = `/tramite/documento/print/${data.file_name}?`+ f
    if(data.file_tipo === 'application/pdf') {
      window.open(route, "Visor", "width=1000,height=750")
    } else {
      const link = document.createElement('a')
      link.href = route
      link.setAttribute('download', data.file_name) //or any other extension
      document.body.appendChild(link)
      link.click()
    }

  },
  obtenerRutas              : async function ({commit}, rutas) {
    commit('llenarRutas', rutas)
  },
  obtenerRuta               : async function ({commit, getters, state}, route) {
    const data = await fetch('http://127.0.0.1:8000/getRoute?route=' + route)//falta implementar
    const ruta = await data.json()
    await commit('pushRuta', ruta)
  },
  addRuta                   : async function ({commit}, d) {
    commit('pushRuta', d)
  },
  actualizarCodigoBusqueda  : async function ({commit}, codigo) {
    commit('setCodigoBusqueda', codigo)
  },
  buscarByDocumento         : async function ({dispatch, commit, state, getters}, d = null) {
    await commit('setBuscarFormId', (d !== null) ? d.iddocumento : state.buscar.codigoBusqueda)
    if (d !== null && d.modal !== undefined) {
      await commit('setBuscarFormModal', d.modal)
    }
    if (getters.getRuta('tramite.documento.buscarDocumento') == null) {
      await commit('pushRuta', d)
    }
    axios.get(getters.getRuta('tramite.documento.buscarDocumento'), {params: state.buscar.formBusqueda}).then(response => {
      if (response.data.operaciones.length > 0) {
        commit('setBuscarData', response.data)
        $("#buscar").modal()
        dispatch('graficar')
      } else {
        alert('No hay datos que mostrar, el registro no existe')
      }
    })
  },
  buscarByExpediente        : async function ({dispatch, commit, state, getters}, iddocumento = null, modal = false) {
    await commit('setBuscarFormId', (iddocumento !== null) ? iddocumento : state.buscar.codigoBusqueda)
    axios.get(getters.getRuta('tramite.documento.buscarDocumento'), {params: state.buscar.formBusqueda}).then(response => {
      if (response.data.operaciones.length > 0) {
        commit('setBuscarData', response.data)
        $("#buscar").modal()
        dispatch('graficar')
      } else {
        alert('No hay datos que mostrar, el registro no existe')
      }
    })
  },
  graficar                  : async function ({dispatch, commit, getters}) {
    commit('setBuscarNumeroBranchs', 0)
    var o          = []
    var ids        = []
    var r          = []
    var currBranch = 0
    var branchs    = [0]
    for (var i = 0; i < getters.getBusquedaCantidadOperaciones; i++) {
      ids[i] = getters.getBuscarOperacion(i).idoperacion
      o[i]   = {
        count       : 0,
        indx        : [],
        branch      : null,
        used        : false,
        childBranchs: []
      }
      if (getters.getBuscarOperacion(i).oper_idprocesado != null) {
        o[ids.indexOf(parseInt(getters.getBuscarOperacion(i).oper_idprocesado))].count++
        o[ids.indexOf(parseInt(getters.getBuscarOperacion(i).oper_idprocesado))].indx.push(i)
      }
    }
    //var changBranch = false;
    for (i = 0; i < getters.getBusquedaCantidadOperaciones; i++) {
      if (getters.getBuscarOperacion(i).oper_idprocesado != null) {
        if (o[ids.indexOf(parseInt(getters.getBuscarOperacion(i).oper_idprocesado))].used) {
          currBranch = o[ids.indexOf(parseInt(getters.getBuscarOperacion(i).oper_idprocesado))].childBranchs[0]
          o[ids.indexOf(parseInt(getters.getBuscarOperacion(i).oper_idprocesado))].childBranchs.splice(0, 1)
        } else {
          currBranch                                                                    = o[ids.indexOf(parseInt(getters.getBuscarOperacion(i).oper_idprocesado))].branch
          o[ids.indexOf(parseInt(getters.getBuscarOperacion(i).oper_idprocesado))].used = true
        }
      } else {
        currBranch = 0
      }
      o[i].branch = currBranch
      r[i]        = ["hola", [currBranch, currBranch], []]
      if (o[i].count === 0) {
        branchs.splice(branchs.indexOf(parseInt(currBranch)), 1)
      }
      for (var j = 0; j < branchs.length; j++) {
        r[i][2].push([branchs[j], branchs[j], branchs[j]])
      }
      for (j = 1; j < o[i].count; j++) {
        commit('incrementBuscarNumeroBranchs')
        var newBranch = branchs[branchs.length - 1] + 1
        o[i].childBranchs.push(newBranch)
        branchs.push(newBranch)
        r[i][2].push([currBranch, newBranch, newBranch])
      }
    }
    commit('setBuscarGrafico', r)
    this.acarreoOperaciones = o
    var canvas              = $("<div></div>")
    canvas.css('text-align', 'center')
    $("#commits-graph2").html("")
    $("#commits-graph2").append(canvas)
    var options = {
      width    : null,
      height   : getters.getBusquedaCantidadOperaciones * 90,
      y_step   : 90,
      data     : getters.getBuscarGrafico,
      x_step   : 4,
      dotRadius: 4,
      lineWidth: 2,
    }
    if (getters.getBuscarNroBranchs <= 10) {
      options.x_step    = 9
      options.dotRadius = 6
      options.lineWidth = 4
    } else {
      if (getters.getBuscarNroBranchs <= 20) {
        options.x_step    = 6
        options.dotRadius = 5
        options.lineWidth = 3
      } else {
        options.x_step    = 4
        options.dotRadius = 4
        options.lineWidth = 2
      }
    }
    options.width = getters.getBuscarNroBranchs * options.x_step + ((options.dotRadius) * 3)
    canvas.commits(options)
  },
  validarHijo               : async function ({commit}, d = {}) {
    var config = {
      context      : null,
      h            : 0,
      afterValidate: function () {
      },
      status       : true,
      focused      : false
    }
    for (var i in d) {
      if (config.hasOwnProperty(i)) {
        config[i] = d[i]
      }
    }
    config.context.$children[config.h].$validator.validate().then(function (result) {
      if (config.h === config.context.$children.length - 1) {
        if (config.status) {
          config.status = result
        }
        if (config.status) {
          config.afterValidate()
        } else {
          if (!config.focused) {
            config.context.$children[config.h].$refs[config.context.$children[config.h].errors.items[0].field].focus()
          }
        }
      } else {
        if (result) {
          config.h++
          config.context.validarHijo(config)
        } else {
          if (!config.focused) {
            config.context.$children[config.h].$refs[config.context.$children[config.h].errors.items[0].field].focus()
          }
          config.status  = false
          config.focused = true
          config.h++
          config.context.validarHijo(config)
        }
      }
    }, function (error) {
      console.log('Error' + error)
    })
  },
  ejecutarRecursivamente    : async function ({commit, dispatch}, d = {}) {
    var config = {
      context: null,
      h      : 0,
      after  : function () {
      }
    }
    for (var i in d) if (config.hasOwnProperty(i)) {
      config[i] = d[i]
    }
    for (i = 0; i < config.context.$children.length; i++) {
      dispatch('ejecutarRecursivamente', {
        context: config.context.$children[i],
        after  : config.after
      })
    }
    config.after(config.context)
  }
}
const getters   = {

  getRuta                             : (state) => (ruta) => {
    if (state.rutas[ruta] !== undefined) {
      return state.rutas[ruta].route
    } else {
      return null
    }
  },
  canRuta                             : (state) => (ruta) => {
    if (state.rutas[ruta] !== undefined) {
      return state.rutas[ruta].can
    } else {
      return false
    }
  },
  getCodigoBusqueda                   : state => {
    return state.buscar.codigoBusqueda
  },
  getBusquedaCantidadOperaciones      : state => {
    return state.buscar.operaciones.length
  },
  getBuscarNroBranchs                 : state => {
    return state.buscar.numeroBranchs
  },
  getBuscarGrafico                    : state => {
    return state.buscar.grafico
  },
  getBuscarOperaciones                : state => {
    return state.buscar.operaciones
  },
  getBuscarOperacion                  : (state) => (id) => {
    return state.buscar.operaciones[id]
  },
  getBuscarDocumento                  : state => {
    return state.buscar.documento
  },
  getBuscarDigitales                  : state => {
    return state.buscar.digitales
  },
  getBuscarRelacionados               : state => {
    return state.buscar.relacionados
  },
  getBuscarFormModal                  : state => {
    return state.buscar.formBusqueda.modal
  },
  getBuscarImagenes                   : state => {
    return state.buscar.imagenes
  },
  getBuscarImagenesCantidad           : state => {
    return state.buscar.imagenes.length
  },
  getBuscarImagenesRuta               : (state, getters) => {
    var a = []
    for (var i = 0; i < state.buscar.imagenes.length; i++) {
      a.push(getters.getRuta('administrador.comunicacionIntena.printImagenes').replace(/%s/g, state.buscar.imagenes[i].id))
    }
    return a
  },
  getDerivarSoloCopia                 : state => {
    return state.derivar.soloCopia
  },
  getDependencia                      : state => (id) => {
    var d = state.dependencias.filter(d => d.iddependencia === id)
    if (d[0] !== undefined) {
      return d[0]
    } else {
      return null
    }
  },
  getMiDependencia                    : state => {
    var d = state.dependencias.filter(d => d.iddependencia === state.dependenciaUser.iddependencia)
    if (d[0] !== undefined) {
      return d[0]
    } else {
      return null
    }
  },
  getDependenciaNombre                : state => (id) => {
    var d = state.dependencias.filter(d => d.iddependencia === parseInt(id))
    if (d[0] !== undefined) {
      return d[0].depe_nombre
    } else {
      return null
    }
  },
  getUsuariosActivoNombre             : state => (id) => {
    var u = state.usuarios.filter(d => d.id === parseInt(id))
    if (u[0] !== undefined) {
      return u[0].adm_name
    } else {
      return null
    }
  },
  getUnidadesForDerivacion            : state => {
    return (state.dependenciaUser === undefined) ? null : (state.dependencias !== undefined) ? state.dependencias.filter(d => d.depe_depende === state.dependenciaUser.depe_depende || d.depe_recibetramite) : null
  },
  getUnidadesForReporte               : state => (id) => {
    return (id === null) ? null : (state.dependencias !== undefined) ? state.dependencias.filter(d => d.depe_depende === id || d.depe_recibetramite) : null
  },
  getEntidadesExternas                : state => {
    return (state.dependencias !== undefined) ? state.dependencias.filter(d => d.depe_tipo === 2 && d.depe_depende === null) : null
  },
  getSedes                            : state => {
    return (state.dependencias !== undefined) ? state.dependencias.filter(d => d.depe_tipo === 0 && d.depe_depende === null) : null
  },
  getUnidadesDependenciaForCorrelativo: state => (tipo) => {
    return (parseInt(tipo) === 1) ? state.dependencias.filter(d => d.depe_tipo === 1) : state.dependencias.filter(d => d.depe_depende === state.dependenciaUser.depe_depende)
  },
  getUnidadesSede                     : state => (id) => {
    return (state.dependencias !== undefined) ? state.dependencias.filter(d => d.depe_depende === parseInt(id)) : null
  },
  getSedeDeUnidad                     : state => (id) => {
    var d = state.dependencias.filter(d => d.iddependencia === parseInt(id))
    if (d[0] !== undefined) {
      return d[0].depe_depende
    } else {
      return null
    }
  },
  getUsuariosActivo                   : state => {
    return (state.usuarios !== undefined) ? state.usuarios.filter(d => d.adm_estado === 1) : null
  },
  getTiposDocumento                   : state => {
    return (state.tiposDocumento !== undefined) ? state.tiposDocumento : null
  },
  getTipoDocumentoNombre              : state => (id) => {
    var u = state.tiposDocumento.filter(d => d.idtdoc === parseInt(id))
    if (u[0] !== undefined) {
      return u[0].tdoc_descripcion
    } else {
      return null
    }
  },
  getDependenciaUser                  : state => {
    return (state.dependenciaUser !== undefined) ? state.dependenciaUser : null
  },
  getInicio                           : state => {
    return (state.inicio !== undefined) ? state.inicio : null
  },
  getPeriodosCorrelativo              : state => {
    return (state.periodosCorrelativo !== undefined) ? state.periodosCorrelativo : null
  },
  getArchivadores                     : state => {
    return (state.archivadores !== undefined) ? state.archivadores : null
  },
  getUsuarios                         : state => {
    return (state.usuarios !== undefined) ? state.usuarios : null
  },
  getRoles                            : state => {
    return (state.roles !== undefined) ? state.roles : null
  },
  getUsuario : state => {
    return (state.usuario !== undefined) ? state.usuario : null
  },
  getFormatBytes: state => (bytes) => {
    if (bytes != null) {
      if (bytes === 0) return '0 Bytes';
      const decimals  =2
      const k = 1024;
      const dm = decimals < 0 ? 0 : decimals;
      const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

      const i = Math.floor(Math.log(bytes) / Math.log(k));

      return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    } else {
      return ''
    }
    
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
