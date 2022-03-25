import Vue from 'vue'
import Vuex from 'vuex'

import configStore from './store'
import expedienteStore from '@/js/tramite/store/modules/expediente'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  modules: {
    global: configStore
  }
})
