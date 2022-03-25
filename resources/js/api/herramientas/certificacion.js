
export default {
    requestCertificaciones(anio) {
        const params = {
            anio: anio
        }
        return axios.get('/app/herramientas/certificacion/index', {params:params});
    },

    requestRegistroDocumento(reg){
        const params = {
            registro: reg
        }
        return axios.get('/app/herramientas/certificacion/buscarRegistroDocumento', {params:params});
    },

    saveDocCertificacion(formCertificacion){
        return axios.post('/app/herramientas/certificacion/store', formCertificacion);
    }
}