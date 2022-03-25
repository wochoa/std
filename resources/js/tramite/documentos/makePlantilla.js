
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

import CKEditor from '@ckeditor/ckeditor5-vue';
Vue.use( CKEditor );

//COMPONENTES GENERALES
Vue.component('pagination', require('laravel-vue-pagination'));

//COMPONENTES DE DOCUMENTOS EN PROCESO
var DocuPlantillaBuscar = Vue.component('buscar-documento', require('../../components/tramite/documentos/DocuPlantillaBuscar').default);
var DocuPlantillaNuevo = Vue.component('nuevo-documento', require('../../components/tramite/documentos/DocuPlantillaNuevo').default);
Vue.component('docu-expediente', require('../../components/tramite/documentos/en-poceso/DocuExpedienteBuscar').default);
Vue.component('docu-principal', require('../../components/tramite/documentos/en-poceso/DocuPrincipal').default);
Vue.component('docu-derivar', require('../../components/tramite/documentos/en-poceso/DocuDerivar').default);
Vue.component('docu-invoker', require('../../components/tramite/documentos/en-poceso/DocuInvoker').default);

//routes
const router =new VueRouter({
    mode:'history',
    base:__dirname,
    linkActiveClass: "",
    linkExactActiveClass: "active",
    routes:[
        {
            path:'/tramite/plantilla',
            name:'DocuPlantillaBuscar',
            component:DocuPlantillaBuscar
        },
        {
            path:'/tramite/plantilla/create',
            name:'DocuPlantillaNuevo',
            component:DocuPlantillaNuevo
        },
        {
            path:'/tramite/plantilla/:id/edit',
            name:'DocuPlantillaEdit',
            component:DocuPlantillaNuevo
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