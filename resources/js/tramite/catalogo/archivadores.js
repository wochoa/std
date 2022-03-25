

import VueRouter from 'vue-router'
Vue.use(VueRouter);
//COMPONENTES GENERALES
Vue.component('pagination', require('laravel-vue-pagination'));


//componentes archivador
var CataArchivadorBuscar = Vue.component('cata-archivador-buscar',require('../../components/tramite/catalogo/CataArchivadorBuscar').default);
var CataArchivadorNuevo = Vue.component('cata-archivador-nuevo', require('../../components/tramite/catalogo/CataArchivadorNuevo').default);

//routes
const router =new VueRouter({
    mode:'history',
    base:__dirname,
    linkActiveClass: "",
    linkExactActiveClass: "active",
    routes:[
        
        {
            path:'/tramite/catalogo/archivador',
            name:'CataArchivadorBuscar',
            component:CataArchivadorBuscar
        },
        {
            path:'/tramite/catalogo/archivador/create',
            name:'CataArchivadorNuevo',
            component:CataArchivadorNuevo
        },
        {
            path:'/tramite/catalogo/archivador/:id/edit',
            name:'CataArchivadorEdit',
            component:CataArchivadorNuevo
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