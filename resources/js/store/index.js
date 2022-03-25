import Vue  from 'vue'
import Vuex from 'vuex'

import actividades     from './modules/actividades'
import gastos          from './modules/gastos'
import proyectos       from './modules/proyectos'
import presupuesto     from './modules/presupuesto'
import informeProyecto from './modules/informeProyecto'
import herramientas    from './modules/herramientas'
import auth            from './modules/auth'
import global          from "./modules/global"

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
                                modules: {
                                  actividades,
                                  gastos,
                                  proyectos,
                                  presupuesto,
                                  informeProyecto,
                                  herramientas,
                                  auth,
                                  global
                                },
                                strict : debug,
                              })
