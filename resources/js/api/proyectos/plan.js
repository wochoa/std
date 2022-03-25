import auth from '../auth';

export default {
    requestPlan(d) {
        return axios.get('/app/proyectos/plan', {params:{'anio':d.anio,'act_proy':d.proy_cod_siaf,'fftt':d.fftt, 'version':d.versionPlan}}
            //{headers: {'Authorization': 'Bearer ' + auth.getToken()}}
        );
    },
    requestVersiones(d) {
        return axios.get('/app/proyectos/plan/versiones', {params:{'anio':d.anio,'act_proy':d.proy_cod_siaf}}
            //{headers: {'Authorization': 'Bearer ' + auth.getToken()}}
        );
    },
    storePlan(d) {
        return axios.post('/app/proyectos/plan/programar', d
        );
    },
    storeVersionPlan(d) {
        return axios.post('/app/proyectos/plan/version/store', d
        );
    },
    saved(){
        return !!localStorage.getItem('oficinas');
    },
    save(oficinas){
        localStorage.setItem('oficinas', JSON.stringify(oficinas));
    },
    getOficinas(){
        return JSON.parse(localStorage.getItem('oficinas'));
    },
    destroyOficinas(){
        localStorage.removeItem('oficinas');
    }
}