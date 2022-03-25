import auth from '../auth';
import hash from '../hash';

export default {
    requestUbigeo() {
        return axios.get('/app/proyectos/ubigeo',
            //{headers: {'Authorization': 'Bearer ' + auth.getToken()}}
            );
    },
    saved() {
        hash.verificarHash('ubigeo',this.destroyUbigeo);
        return !!localStorage.getItem('ubigeo');
    },
    save(ubigeo){
        localStorage.setItem('ubigeo', JSON.stringify(ubigeo))
    },
    getUbigeo(){
        return JSON.parse(localStorage.getItem('ubigeo'));
    },
    destroyUbigeo() {
        localStorage.removeItem('ubigeo')
    },
}