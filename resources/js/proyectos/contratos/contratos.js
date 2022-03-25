window.Vue = require('vue');

import Vue from 'vue';
import Vuetify from 'vuetify'
window.axios = require('axios');
import VueRouter from 'vue-router'
import { routes } from '@/js/routes.js'
import store from '@/js/store'


Vue.component('pagination', require('laravel-vue-pagination'));

Vue.component('proy-contratos',require('../../components/proyectos/ProyContratos').default);

Vue.component('proy-listado', require('../../components/proyectos/ProyListado').default);



const app = new Vue({
    el: '#app',
    store
});
