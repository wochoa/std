
require('../bootstrap');

window.Vue = require('vue');
window.axios = require('axios');

window.xlsx = require('xlsx');
Vue.use(window.xlsx);

window.Vuex = require('vuex')
Vue.use(Vuex)

window.store = new Vuex.Store({
    state:{
        rutas                   :{},
        dependencias            :[],
        roles                   :[],
        permisos                :[],
        usuario                 :[]
    },
    mutations:{
        llenarRutas(state,rutas){state.rutas = rutas},
        pushRuta(state, d){ state.rutas[d.name]=d.route;},

        llenarDependencias(state, dependencias){
            for(var i = 0; i<dependencias.length; i++) {
                state.dependencias.push({
                    iddependencia       : dependencias[i][0],
                    depe_nombre         : dependencias[i][1],
                    depe_depende        : dependencias[i][2],
                    depe_tipo           : dependencias[i][3],
                    depe_recibetramite  : dependencias[i][4]
                });
            }
        },
        llenarRoles(state,roles){
            state.roles = roles
        },
        llenarPermisos(state,permisos){
            state.permisos = permisos
        },
        llenarUsuario(state, usuario){
            state.usuario = usuario
        }
    },
    actions:{
        obtenerRutas:async function({commit},rutas){commit('llenarRutas',rutas)},

        ddRuta:async function({commit},d ){commit('pushRuta',d)},

        obtenerRoles: async function ({commit, getters, state}){
            if(state.roles.length===0)
                axios.get(getters.getRuta('administrador.rol.obtenerRoles')).then(response=>{
                    commit('llenarRoles', response.data)
                });
        },
        obtenerUsuario: async function ({commit}, user){commit('llenarUsuario', user);},
        obtenerJsonAll: async function ({getters, commit,state}){
            if(state.dependencias.length===0||state.tiposDocumento.length===0)
                await axios.get(getters.getRuta('tramite.documento.jsonAdministrador')+"?user="+state.usuario.id+"&dependencia="+state.usuario.depe_id).then(response=>{
                    commit('llenarDependencias',    response.data.dependencias);
                    commit('llenarPermisos', response.data.permisos);
                });
        }
    },
    getters:{
        getRuta: (state) => (ruta) => {
            if (state.rutas[ruta] !== undefined)
                return state.rutas[ruta].route;
            else
                return null;
        },
        canRuta: (state) => (ruta) => {
            if (state.rutas[ruta] !== undefined)
                return state.rutas[ruta].can;
            else
                return false;
        },
        getUnidadesDependenciaForCorrelativo:state=>(tipo)=>{return (parseInt(tipo)===1)?state.dependencias.filter(d => d.depe_tipo===1):state.dependencias.filter(d => d.depe_depende===state.dependenciaUser.depe_depende)},
        getPermisos                         :state=>{return (state.permisos !== undefined)?state.permisos:null},
        getRoles                            :state=>{return (state.roles !== undefined)?state.roles:null}
    }
});


const moment = require('moment')
require('moment/locale/es')

Vue.use(require('vue-moment'), {
  moment
})
Vue.component('pagination', require('laravel-vue-pagination'));

//componente menu general
Vue.component('menu-general',require('../components/administrador/menuGeneral').default);
Vue.component('menu-administrador',require('../components/administrador/menuAdministrador').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const admin = new Vue({
    el: '#admin',
    store
});
