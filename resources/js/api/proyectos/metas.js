import auth from '../auth';
import hash from '../hash';
export default {
    requestMetas(anio) {
        const params = {
            anio: anio
        }
        return axios.get('/app/gastos/metas', {params:params});
    },
    saved(){
        hash.verificarHash('metas',this.destroyMetas);
        return !!localStorage.getItem('metas');
    },
   save(metas){
    localStorage.setItem('metas', JSON.stringify(metas));
   },
   getMetas(){
       return JSON.parse(localStorage.getItem('metas'));
   },
   destroyMetas(){
       localStorage.removeItem('metas');
   },
   storePresupuesto(formPresupuesto){
        return axios.post('/app/gastos/storePresupuesto', formPresupuesto);
   }
}