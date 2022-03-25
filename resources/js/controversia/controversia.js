require('../bootstrap');
window.Vue = require('vue');
window.axios = require('axios');
import VueRouter from 'vue-router'
Vue.use(VueRouter);

var controversiaInicio = Vue.component('controversia-inicio', require('../components/controversia/controversia-inicio/controversiaInicio').default);
var registroExpediente = Vue.component('registro-expediente', require('../components/controversia/controversia-expediente/registroExpediente').default);
var consultaExpedientes = Vue.component('consulta-expedientes', require('../components/controversia/controversia-expediente/consultaExpedientes').default);
var controversiaUsuario = Vue.component('controversia-usuarios', require('../components/controversia/controversia-usuarios/ControversiaUsuario').default);

const router = new VueRouter({
    mode:'history',
    base:__dirname,
    linkActiveClass: "",
    linkExactActiveClass: "active",
    routes:[
        {
            path:'/controversia/controversia',
            name:'controversiaInicio',
            component:controversiaInicio
        },
        {
            path:'/controversia/controversia/registroExpediente',
            name:'registroExpediente',
            component:registroExpediente
        },
        {
            path:'/controversia/controversia/consultaExpedientes',
            name:'consultaExpedientes',
            component:consultaExpedientes
        },
        {
            path:'/controversia/controversia/controversiaUsuario',
            name:'controversiaUsuario',
            component:controversiaUsuario
        }
    ]
});

const app = new Vue({
    el:'#app',
    router
});