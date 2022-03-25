
import VueRouter from 'vue-router'
Vue.use(VueRouter);
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

//COMPONENTES GENERALES
Vue.component('pagination', require('laravel-vue-pagination'));

//componente reporte
var buscarPapeleta    = Vue.component('buscar-papeleta',require('../../components/tramite/operacion/OperPapeletaBuscar').default);
var OperPapeletaSolicitar = Vue.component('solicitar-papeleta', require('../../components/tramite/operacion/OperPapeletaSolicitar').default);
Vue.component('docu-derivar', require('../../components/tramite/documentos/en-poceso/DocuDerivar').default);
var autorizarPapeleta = Vue.component('autorizar-papeleta',require('../../components/tramite/operacion/OperPapeletaAutorizar').default);
var papeletasAutorizadas = Vue.component('papeletas-autorizadas',require('../../components/tramite/operacion/OperPapeletaAutorizada').default);

 //routes
const router =new VueRouter({
    mode:'history',
    base:__dirname,
    linkActiveClass: "",
    linkExactActiveClass: "active",
    routes:[
        
        {
            path:'/tramite/papeleta/solicitarPapeleta',
            name:'buscarPapeleta',
            component:buscarPapeleta
        },
        {
            path:'/tramite/papeleta/solicitarPapeleta/create',
            name:'OperPapeletaSolicitar',
            component:OperPapeletaSolicitar
        },
        {
            path:'/tramite/papeleta/solicitarPapeleta/:id/edit',
            name:'OperPapeletaEdit',
            component:OperPapeletaSolicitar
        },
        {
            path:'/tramite/papeleta/papeletaPendiente',
            name:'autorizarPapeleta',
            component:autorizarPapeleta
        },
        {
            path:'/tramite/papeleta/papeletasAutorizadas',
            name:'papeletasAutorizadas',
            component:papeletasAutorizadas
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