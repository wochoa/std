
export default {
    requestModificatorias(anio) {
        const params = {
            anio: anio
        }
        return axios.get('/app/herramientas/modificatoria/index', {params:params});
    },

    saveModificatoria(formModificatoria){
         return axios.post('/app/herramientas/modificatoria/store', formModificatoria);
    },
    deleteModificatoria(id){
        const params = {
            id : id
        }
        return axios.post('/app/herramientas/modificatoria/destroy', params)
    },
    requestModificatoriaDetalle(form){
        return axios.get('/app/herramientas/modificatoria/detalle', {params:form});
    }

}