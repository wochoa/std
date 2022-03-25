require('../../bootstrap');

window.Vue = require('vue');
window.axios = require('axios');

import VeeValidate, { Validator } from 'vee-validate'
import es from 'vee-validate/dist/locale/es';
Validator.localize({ es: es });
Vue.use(VeeValidate, {locale: 'es'} );

Vue.component('admin-cambiar-contrasenia',require('../../components/tramite/administracion/AdminUsuarioCambiarContrasenia').default);

const logeo = new Vue({
    el: '#logeo'
});