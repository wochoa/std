import Vue from 'vue'

require('../../bootstrap');

window.Vue = require('vue');
window.axios = require('axios');

window.xlsx = require('xlsx');
Vue.use(window.xlsx);

window.jsPDF = require('jspdf');
Vue.use(window.jsPDF);
import 'jspdf-autotable';

window.toastr = require('toastr');
Vue.use(window.toastr);
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
import store from '../store'

window.moment = require('moment');

import VueRouter from 'vue-router'
Vue.use(VueRouter);

import VeeValidate, {ValidationProvider, Validator } from 'vee-validate'
import es from 'vee-validate/dist/locale/es';
Validator.localize({ es: es });
Vue.use(VeeValidate, {locale: 'es'} );

Vue.component('pagination', require('laravel-vue-pagination'));
let Assistance = Vue.component('assistance',require('../../components/assistance/Assistance').default);
Vue.component('assistance-menu',require('../../components/assistance/AssistanceMenu').default);
let Mpv = Vue.component('Mpv',require('../../components/mpv/Mpv').default);
let MpvReport = Vue.component('MpvReport',require('../../components/mpv/MpvReport').default);
let MpvDerivative = Vue.component('MpvDerivative',require('../../components/mpv/MpvDerivative').default);
//interoperabilidad
let InterDespachos = Vue.component('InterDespachos',require('../../components/interoperabilidad/InterDespachos').default);
let InterRecepciones = Vue.component('InterRecepciones',require('../../components/interoperabilidad/InterRecepciones').default);
Vue.component('validation-provider', ValidationProvider);


//routes
const router =new VueRouter({
  mode:'history',
  base:__dirname,
  linkActiveClass: "",
  linkExactActiveClass: "active",
  routes:[
    {
      path:'/asistencia/rrhh',
      name:'AssistanceRrhh',
      component:Assistance,
      props    : {tipo: 1}
    },
    {
      path:'/asistencia/jefe',
      name:'AssistanceJefe',
      component:Assistance,
      props    : {tipo: 2}
    },
    {
      path:'/mesa-partes-virtual',
      name:'Mpv',
      component:Mpv
    },
    {
      path:'/mesa-partes-virtual/derivados',
      name:'MpvDerivative',
      component:MpvDerivative
    },
    {
      path:'/mesa-partes-virtual/reporte',
      name:'MpvReport',
      component:MpvReport
    },
    {
      path:'/interoperabilidad/despachos',
      name:'InterDespachos',
      component:InterDespachos
    },
    {
      path:'/interoperabilidad/recepciones',
      name:'InterRecepciones',
      component:InterRecepciones
    },
  ]
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const assistance = new Vue({
  el: '#assistance',
  store,
  router
});
