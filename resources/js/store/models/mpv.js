
export default {
  registroDerivar (data) {
    return axios.post('/mpv/derivar', data)
  },
  registrosIndex (data) {
    return axios.get('/mpv', data)
  },
  registroArchivar(data) {
    return axios.post('/mpv/archivar', data)
  },
  registroTransferir(data) {
    return axios.post('/mpv/transferir', data)
  },
  registroEdit(mpv, data) {
    return axios.post(`/mpv/${mpv}`, data)
  },
  registrosOfPdf(filtro) {
    return axios.get('/mpv/pdf', filtro)
  },
  registrosDerivados (data) {
    return axios.get('/mpv/derivados', data)
  }
}
