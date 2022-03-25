export default {
    registerUser(userData) {
        return axios.post('/app/register', {
            email: userData.email,
            name: userData.name,
            password: userData.password,
            password_c: userData.password_c
        });
    },

    loginUser(userData) {
        return axios.post('/app/login', {
            email: userData.email,
            password: userData.password,
        });
    },

    getUser() {
        return axios.get('/app/user',
            {headers: {'Authorization': 'Bearer ' + this.getToken()}});
    },

    loggedIn() {
      return true;
        return !!localStorage.getItem('token');
    },

    setToken(token) {
        localStorage.setItem('token', token)
    },

    destroyToken() {
        localStorage.removeItem('token')
    },

    getToken() {
        return localStorage.getItem('token');
    },
    requestUser() {
        return axios.get('/app/proyectos/user')
    }

}
