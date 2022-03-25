import auth from '../auth';

export default {
    requestAnalitico(d) {
        return axios.get('/app/proyectos/analitico', {params:{'act_proy':d.proy_cod_siaf, 'version':d.versionAnalitico}}
            //{headers: {'Authorization': 'Bearer ' + auth.getToken()}}
        );
    },
    storeAnalitico(d) {
        return axios.post('/app/proyectos/analitico/store', d);
    },
    printAnalitico(version, id){
        let f = '';
        f+='id='+ id;
        f+='&version='+ version;
        return '/app/proyectos/analitico/print?'+f;
    },
    requestVersiones(id){
        const params = {
            act_proy : id
        }
        return axios.get('/app/proyectos/analitico/listarVersionesAnalitico', {params:params});
    },
    storeVersionAnalitico(formVersion){
        return axios.post('/app/proyectos/analitico/version/store', formVersion);
    }
}