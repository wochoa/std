window.Vue = require('vue');

import Vue from 'vue';
import Vuetify from 'vuetify'
window.axios = require('axios');
import store from '@/js/store'


import VeeValidate, {ValidationProvider, Validator } from 'vee-validate'
import es from 'vee-validate/dist/locale/es';
Validator.localize({ es: es });
Vue.use(VeeValidate, {locale: 'es'} );

Vue.use(Vuetify);

Vue.component('proy-informes',require('../../components/proyectos/ProyInformes').default);

const app = new Vue({
    el: '#app',
    store,
    vuetify : new Vuetify({
        icons: {
            iconfont: 'mdi'
        },
    })
});
