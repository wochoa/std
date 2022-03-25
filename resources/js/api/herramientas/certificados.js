
export default {
    requestCertificados(certificacion) {
        const params = {
            certificacion: certificacion
        }
        return axios.get('/app/herramientas/certificacion/certificados/index', {params:params});
    },

    saveCertificados(formCertificado){
        return axios.post('/app/herramientas/certificacion/certificados/store', formCertificado);
    },

    deleteCertificado(id){
        const params = {
            id : id
        }
        return axios.post('/app/herramientas/certificacion/certificados/destroy', params)
    },

    requestCertificadoDetalle(id){
        const params = {
            id : id
        }
        return axios.get('/app/herramientas/certificacion/certificadoDetalle/index', {params:params});
    },

    saveDetalleCertificado(item){
        return axios.post('/app/herramientas/certificacion/certificadoDetalle/store', item);
    },
    deleteCertificadoDetalle(key){
        const params = {
            key : key
        }
        return axios.post('/app/herramientas/certificacion/certificadoDetalle/destroy', params);
    }
}