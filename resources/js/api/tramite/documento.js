import auth from '../auth'

export default class File {

  constructor (file) {
    this.file = file
    this.file_url = null
    this.md5 = null
    this.file_name = file.name
    this.file_tipo = file.type
    this.file_size = file.size
    this.file_mostrar = true
    this.file_principal = null
    this.id_documento = null
    this.id_documento_externo = null
    this.id = null
  }

  cargarFile (uploadProcess=function (e) {}) {
    let f = new FormData()
    f.append('file', this.file)
    return axios.post('/tramite/documento/upload', f, { headers: { 'Content-Type': 'multipart/form-data' },onUploadProgress :uploadProcess })
      .catch((e) => {
        console.log('FAILURE!!')
      })
  }

  getData () {
    return {
      file_url: this.file_url,
      file_mostrar: this.file_mostrar,
      file_principal: this.file_principal,
      file_name: this.file_name,
      file_tipo: this.file_tipo,
      file_size: this.file_size,
      md5: this.md5,
      id_documento: this.id_documento,
      id_documento_externo: this.id_documento_externo,
      id: this.id
    }
  }
}
