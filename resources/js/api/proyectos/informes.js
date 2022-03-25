import auth from '../auth'

export default {

  crearArchivo (file) {
    return {
      base64: null,
      file: file,
      file_mostrar: 1,
      file_name: null,
      file_url: null,
      md5: null,
      file_tipo: null,
      fecha: file.lastModifiedDate.toISOString(),
      id : null,
      cargarFile: function () {
        let f = new FormData()
        f.append('arch_archivo', this.file)
        return axios.post('/app/proyectos/informe/guardarTemporal', f, { headers: { 'Content-Type': 'multipart/form-data' } }).catch(function () {
          console.log('FAILURE!!')
        })
      }
    }
  },
  enviarInforme (formInforme, archivos) {
    const params = {
      id: formInforme.id,
      id_proyecto: formInforme.id_proyecto,
      inf_descripcion: formInforme.inf_descripcion,
      inf_cordenadas: formInforme.inf_cordenadas,
      edit: false,
      archivos: []

    }
    for (var i = 0; i < archivos.length; i++) {
      params.archivos.push({
        'file_url': archivos[i].file_url,
        'file_name': archivos[i].file_name,
        'file_tipo': archivos[i].file_tipo,
        'file_mostrar': archivos[i].file_mostrar,
        'fecha': archivos[i].fecha,
        'id': archivos[i].id
      })
    }
    return axios.post('/app/proyectos/informe/store', params)
  },

  obtenerInformes (id_proyecto) {
    return axios.get('/app/proyectos/informe/index', { params: { 'id_proyecto': id_proyecto } })
  },

  actualizarInforme (formInformeEdit, archivos) {
    const params = {
      id: formInformeEdit.id,
      id_proyecto: formInformeEdit.id_proyecto,
      inf_descripcion: formInformeEdit.inf_descripcion,
      inf_archivos: formInformeEdit.inf_archivos,
      archivos: [],
      edit: true

    }
    for (var i = 0; i < archivos.length; i++) {
      params.archivos.push({
        'file_url': archivos[i].file_url,
        'file_name': archivos[i].file_name,
        'file_tipo': archivos[i].file_tipo,
        'file_mostrar': archivos[i].file_mostrar,
        'fecha': archivos[i].fecha,
        'id': archivos[i].id
      })
    }
    return axios.post('/app/proyectos/informe/store', params)
  }
}
