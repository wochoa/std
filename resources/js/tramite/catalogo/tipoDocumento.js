

import VueRouter from 'vue-router'
Vue.use(VueRouter);

//COMPONENTES GENERALES
Vue.component('pagination', require('laravel-vue-pagination'));

//componentes tipoDocumento
var CataTipoDocumentoBuscar = Vue.component('cata-tipo-buscar',require('../../components/tramite/catalogo/CataTipoDocumentoBuscar').default);
var CataTipoDocumentoNuevo = Vue.component('cata-tipo-nuevo',require('../../components/tramite/catalogo/CataTipoDocumentoNuevo').default);

//routes
const router =new VueRouter({
    mode:'history',
    base:__dirname,
    linkActiveClass: "",
    linkExactActiveClass: "active",
    routes:[
        
        {
            path:'/tramite/catalogo/tipoDocumento',
            name:'CataTipoDocumentoBuscar',
            component:CataTipoDocumentoBuscar
        },
        {
            path:'/tramite/catalogo/tipoDocumento/create',
            name:'CataTipoDocumentoNuevo',
            component:CataTipoDocumentoNuevo
        },
        {
            path:'/tramite/catalogo/tipoDocumento/:id/edit',
            name:'CataTipoDocumentoEdit',
            component:CataTipoDocumentoNuevo
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