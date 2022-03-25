import VueRouter from 'vue-router'
Vue.use(VueRouter);
window.xlsx = require('xlsx');
Vue.use(window.xlsx);
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

var OperPapeletaSolicitada = Vue.component('papeletas-solicitadas',require('../../components/tramite/operacion/OperPapeletaSolicitada').default);
var OperPapeletaUsada = Vue.component('papeletas-usadas',require('../../components/tramite/operacion/OperPapeletaUsada').default);
//routes
const router =new VueRouter({
    mode:'history',
    base:__dirname,
    linkActiveClass: "",
    linkExactActiveClass: "active",
    routes:[        
        
        {
            path:'/tramite/papeleta/papeletasSolicitadas',
            name:'OperPapeletaSolicitada',
            component:OperPapeletaSolicitada
        },
        {
            path:'/tramite/papeleta/papeletasUsadas',
            name:'OperPapeletaUsada',
            component:OperPapeletaUsada
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
    router
});