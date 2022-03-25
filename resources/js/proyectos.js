window.Vue = require('vue')

window.axios = require('axios')
import auth                     from '@/js/api/auth'
import CKEditor                 from '@ckeditor/ckeditor5-vue'
import '@mdi/font/css/materialdesignicons.css'
import Vue                      from 'vue'
import Vuetify                  from 'vuetify'
import {router}                 from '@/js/routes.js'
import store                    from '@/js/store'
import VeeValidate, {Validator} from 'vee-validate'
import es                       from 'vee-validate/dist/locale/es'

window.curryear = new Date().getFullYear()


Validator.localize({es: es})
Vue.use(VeeValidate, {locale: 'es'})
Vue.use(CKEditor)
Vue.use(Vuetify)
const moment = require('moment')
require('moment/locale/es')

Vue.use(require('vue-moment'), {
  moment
})
Vue.component('pagination', require('laravel-vue-pagination'))
import Proyectos                from './views/Proyectos'

router.beforeEach((to, from, next) => {
  let route = to.matched.some(record => record.meta.requiresAuth)
  if (route) {
    if (auth.loggedIn()) {
      if (store.getters.userCan(to.meta.can)) {
        next()
      } else {
        next('/unauthorized')
      }
    } else {
      next({
             path : '/login',
             query: {redirect: to.fullPath}
           })
    }
  } else {
    next() // make sure to always call next()!
  }
})
auth.requestUser().then(response => {
  store.dispatch('alterUser', response.data).then(response => {

  })
  store.dispatch('getProyectos')
  store.dispatch('getUbigeo')
  store.dispatch('getOficinas')
  store.dispatch('getFunciones')
  store.dispatch('getEstados')
  store.dispatch('getfuenteFinanciamiento')
  store.dispatch('getEspecificaDetalleGasto')
  store.dispatch('getEspecificaGasto')
  store.dispatch('getDispositivosLegales')
  store.dispatch('getMaestroDocumento')
  store.dispatch('getComponente')
  const app = new Vue({
                        el     : '#app',
                        store,
                        router : router,
                        render : h => h(Proyectos),
                        vuetify: new Vuetify({
                                               icons     : {
                                                 iconfont: 'mdi'
                                               },
                                               breakpoint: {
                                                 scrollBarWidth: 16,
                                                 thresholds    : {
                                                   xs: 600,
                                                   sm: 960,
                                                   md: 1280,
                                                   lg: 1900,
                                                 },
                                                 width         : 1400
                                               }
                                             })
                      })
}).catch(error => {
  reject(error)
})
