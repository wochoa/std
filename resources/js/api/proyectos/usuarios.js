import auth from '../auth';

export default {
    requestUsuarios() {
        return axios.get('/app/proyectos/usuarios',
            //{headers: {'Authorization': 'Bearer ' + auth.getToken()}}
            );
    },
    saved(){
        return !!localStorage.getItem('usuarios');
    },
   save(usuarios){
    localStorage.setItem('usuarios', JSON.stringify(usuarios));
   },
   getUsuarios(){
       return JSON.parse(localStorage.getItem('usuarios'));
   },
   destroyUsuarios(){
       localStorage.removeItem('usuarios');
       
   }
}