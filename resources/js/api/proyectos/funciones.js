import auth from '../auth';
import hash from '../hash';
export default {
    requestFunciones() {
        return axios.get('/app/presupuesto/funciones',
            //{headers: {'Authorization': 'Bearer ' + auth.getToken()}}
            );
    },
    saved() {
        hash.verificarHash('funciones',this.destroyFunciones);
        return !!localStorage.getItem('funciones');
    },
    save(funciones){
        localStorage.setItem('funciones', JSON.stringify(funciones));
    },
    getFunciones(){
        return JSON.parse(localStorage.getItem('funciones'));
    },
    destroyFunciones() {
        console.log('destroy');
        localStorage.removeItem('funciones');
    }

}
