import auth from '../auth';

export default {

    requestContrato(id) {
        return axios.get('/app/proyectos/contratos/show', {params:{id:id}});
            //{headers: {'Authorization': 'Bearer ' + auth.getToken()}});
    },
    requestContratos(formContrato){
        return axios.get('/app/proyectos/contratos/index', {params:formContrato});
    },
    saveContrato(formContrato){
        return axios.post('/app/proyectos/contratos/store', formContrato);
    }
}