require('../bootstrap')
window.Vue = require('vue')
window.axios = require('axios')

import VueMq from 'vue-mq'

Vue.use(VueMq, {
  breakpoints: {
    mobile: 450,
    tablet: 900,
    laptop: 1250,
    desktop: Infinity,
  },
  defaultBreakpoint: 'sm' // customize this for SSR
})

import VeeValidate, { Validator } from 'vee-validate'
import es from 'vee-validate/dist/locale/es'

Validator.localize({ es: es })
Vue.use(VeeValidate, { locale: 'es' })

import { VueReCaptcha } from 'vue-recaptcha-v3'

Vue.use(VueReCaptcha, {
  siteKey: '6LcO77EUAAAAAIrSddk7umFoiw2eq_tLMQurh1rn',
  loaderOptions: { useRecaptchaNet: true }
})

Vue.component('pagination', require('laravel-vue-pagination'))

import VueRouter from 'vue-router'
Vue.use(VueRouter);

window.Vuex = require('vuex')
Vue.use(Vuex)
import expedienteStore from './store/modules/expediente'
window.store = new Vuex.Store({
                                modules: {
                                  expediente: expedienteStore
                                }
                              }
  )

Vue.component('buscar-expediente-gen', require('../components/tramite/buscar-documento/buscarExpedienteGen').default)
//componente buscar expediente modal
Vue.component('buscar-expediente', require('../components/tramite/buscar-documento/buscarExpediente').default)
Vue.component('buscar-digitales', require('../components/tramite/buscar-documento/buscarDigitales').default)
Vue.component('buscar-docexterno', require('../components/tramite/buscar-documento/buscarDocexterno').default)
const ExterMesaPartesVirtual =  Vue.component('exter-mesa-partes-virtual', require('../components/tramite/external/ExterMesaPartesVirtual').default)
Vue.component('docu-expediente', require('../components/tramite/documentos/en-poceso/DocuExpedienteBuscar').default)

//routes
const router =new VueRouter({
  mode:'history',
  base:__dirname,
  linkActiveClass: "",
  linkExactActiveClass: "active",
  routes:[
    {
      path:'/registro/mesa-partes-virtual/:id',
      name:'ExterMesaPartesVirtual',
      component:ExterMesaPartesVirtual,
    },
    {
      path:'/registro/mesa-partes-virtual/:id/:token',
      name:'ExterMesaPartesVirtualEdit',
      component:ExterMesaPartesVirtual,
    }
  ]
});

const expediente = new Vue({
  el: '#expediente',
  router,
  store
})
