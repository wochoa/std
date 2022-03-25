
export default {
  assistanceSave (data) {
    return axios.post('/asistencias/create', data)
  },
  getAssistances(data) {

    return axios.get('/asistencias', data)
  },
  assistanceActive(data) {
    return axios.get('/asistencias/activa', data)
  },
  assistanceClosed(assistance, data) {
    return axios.post(`/asistencias/${assistance}/closed`, data)
  },
  assistanceValidate(assistance) {
    return axios.post(`/asistencias/${assistance}/validated`)
  },
  assistanceReportExcel(data) {
    return axios.get('/asistencias/report/excel', data)
  },
  ipPublicLocal() {
    return axios.get('https://api.ipify.org?format=json')
  },
  assistanceInvalidate(assistance) {
    return axios.post(`/asistencias/${assistance}/invalidated`)
  },
  ballotSave(data) {
    return axios.post('/papeleta/create', data)
  },
  ballotAuthorize(ballot) {
    return axios.post(`/papeleta/${ballot}/autorizar`)
  },
  ballotOpening(ballot) {
    return axios.post(`/papeleta/${ballot}/aperturar`)
  },
  ballotClosed(ballot) {
    return axios.post(`/papeleta/${ballot}/cerrar`)
  },
  ballotExcel(data) {
    return axios.get('/papeleta/reporte-excel', data)
  }

}
