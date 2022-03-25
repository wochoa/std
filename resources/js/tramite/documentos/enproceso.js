

//COMPONENTES DE DOCUMENTOS EN PROCESO


import VueRouter from 'vue-router'

var DocuBuscar = Vue.component('docu-buscar', require('../../components/tramite/documentos/en-poceso/DocuBuscar').default);
var DocuNuevo = Vue.component('docu-nuevo', require('../../components/tramite/documentos/en-poceso/DocuNuevo').default);

var DocuGeneradoBuscar = Vue.component('docu-generado-buscar', require('../../components/tramite/documentos/DocuGeneradoBuscar').default);
var DocuGeneradoNuevo = Vue.component('docu-generado-nuevo', require('../../components/tramite/documentos/DocuGeneradoNuevo').default);
//var Test = Vue.component('test', require('@/js/components/tramite/documentos/Test').default)

Vue.component('docu-expediente', require('../../components/tramite/documentos/en-poceso/DocuExpedienteBuscar').default);
Vue.component('docu-principal', require('../../components/tramite/documentos/en-poceso/DocuPrincipal').default);
Vue.component('docu-derivar', require('../../components/tramite/documentos/en-poceso/DocuDerivar').default);
Vue.component('docu-invoker', require('../../components/tramite/documentos/en-poceso/DocuInvoker').default);
Vue.component('docu-bloqueo',require('../../components/tramite/documentos/en-poceso/DocuBloqueo').default);

//routes
const router =new VueRouter({
    mode:'history',
    base:__dirname,
    linkActiveClass: "",
    linkExactActiveClass: "active",
    routes:[
        {
            path:'/tramite/enproceso',
            name:'DocuBuscar',
            component:DocuBuscar
        },
        {
            path:'/tramite/enproceso/create',
            name:'DocuNuevo',
            component:DocuNuevo,
        },
        {
            path:'/tramite/enproceso/:id/edit',
            name:'DocuEdit',
            component:DocuNuevo
        },
        {
            path:'/tramite/enproceso/response',
            name:'DocuResponse',
            component:DocuNuevo
        },
        {
            path:'/tramite/docs-gen/:id/edit',
            name:'DocuGeneradoEdit2',
            component:DocuGeneradoNuevo
        },
        {
            path:'/tramite/docs-generados',
            name:'DocuGeneradoBuscar',
            component:DocuGeneradoBuscar
        },
        {
            path:'/tramite/docs-generados/create',
            name:'DocuGeneradoNuevo',
            component:DocuGeneradoNuevo
        },
        {
            path:'/tramite/docs-generados/:id/edit',
            name:'DocuGeneradoEdit',
            component:DocuGeneradoNuevo
        }
    ]
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store
});
