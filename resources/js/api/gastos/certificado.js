import auth from '../auth';

export default {
    getActividades() {
        return axios.get('/app/user/task',
            {headers: {'Authorization': 'Bearer ' + auth.getToken()}});
    },
    createActividade(text) {
        return axios.post('/app/user/task', {text}, {
            headers: {'Authorization': 'Bearer ' + auth.getToken()}
        });
    },
    updateActividade(task) {
        return axios.put('/app/user/task/' + task.id, {text: task.text}, {
            headers: {'Authorization': 'Bearer ' + auth.getToken()}
        });
    },
    deleteActividade(task) {
        return axios.delete('/app/user/task/' + task.id , {
            headers: {'Authorization': 'Bearer ' + auth.getToken()}
        });
    }
}