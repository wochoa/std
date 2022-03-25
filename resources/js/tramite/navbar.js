import Vue from "vue"
window.Vue = require('vue');
import Vuex from 'vuex'
window.axios = require('axios');

require('../bootstrap');
require('../jquery.commits-graph');

/*import VDragged from 'v-dragged';
Vue.use(VDragged);*/
window.VDragged = require('v-dragged');
Vue.use(window.VDragged);

window.toastr = require('toastr');
Vue.use(window.toastr);

// inerceptor para verificar la session
window.axios.interceptors.response.use(function (response) {return response;}, function (error) {
    //console.log(error.response);
    if(error.response.status===401)
        $('#login').modal({backdrop:'static', keyboard:false})
    return Promise.reject(error);
});

import VueMq from 'vue-mq'
Vue.use(VueMq, {
    breakpoints: {
        mobile: 450,
        tablet: 900,
        laptop: 1250,
        desktop: Infinity,
    },
    defaultBreakpoint: 'sm' // customize this for SSR
});

import VeeValidate, {ValidationProvider, Validator } from 'vee-validate'
import es from 'vee-validate/dist/locale/es';
Validator.localize({ es: es });
Vue.use(VeeValidate, {locale: 'es'} );

import store from './store'
window.store = store;

window.moment = require('moment');
import VueRouter from 'vue-router'
Vue.use(VueRouter);
//COMPONENTES GENERALES
Vue.component('pagination', require('laravel-vue-pagination'));
//import moment from 'moment'
//componente Buscar Docuemnto y navbar
Vue.component('buscar-docu',require('../components/tramite/buscar-documento/buscarDocu').default);
//compone Buscar Documento Modal
Vue.component('buscar-modal',require('../components/tramite/buscar-documento/buscadorModal').default);
//componente buscar expediente modal
Vue.component('buscar-expediente',require('../components/tramite/buscar-documento/buscarExpediente').default);
Vue.component('slider', require('../components/tramite/buscar-documento/slider').default);
Vue.component('validation-provider', ValidationProvider);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

var f = new Date();
document.act=f.getTime();
document.modal = false;
document.first = true;

const navbar = new Vue({
    el: '#navbar',
    store,
    mounted: function () {
        // Attach event listener to the root vue element
        document.addEventListener('mousemove', this.reiniciar, {passive: true});
        document.addEventListener('keypress', this.reiniciar, {passive: true});
        setInterval(this.verificarActividad , 500)
        // Or if you want to affect everything
        // document.addEventListener('click', this.onClick)
    },
    beforeDestroy: function () {
        document.removeEventListener('mousemove', this.reiniciar);
        document.removeEventListener('keypress', this.reiniciar);
        //
    },
    computed: {
        ...Vuex.mapGetters(['getBuscarImagenesCantidad']),
    },
    methods: {
        reiniciar: function () {
            var f = new Date();
            document.act=f.getTime();
        },
        verificarActividad: function(){
            var f = new Date();
            //aqui se configura el tiempo que se espera apara que salga la imagen
            if (document.act+60000<f.getTime()&&!document.modal&&this.getBuscarImagenesCantidad>=1)
            {
                document.modal=true;
                $('#comunicacion').modal()
            }
        }
    }
});