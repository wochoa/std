
import VueRouter from 'vue-router'
Vue.use(VueRouter);

Vue.component('pagination', require('laravel-vue-pagination'));

//componentes unidadesOrganicas
var AdminUnidadOrganicaNuevo    = Vue.component('admin-unidad-nuevo', require('../../components/tramite/administracion/AdminUnidadOrganicaNuevo').default);
var AdminUnidadOrganicaBuscar   = Vue.component('admin-unidad-buscar', require('../../components/tramite/administracion/AdminUnidadOrganicaBuscar').default);

//routes
const router =new VueRouter({
    mode:'history',
    base:__dirname,
    linkActiveClass: "",
    linkExactActiveClass: "active",
    routes:[
        
        {
            path:'/tramite/administrador/unidades',
            name:'AdminUnidadOrganicaBuscar',
            component:AdminUnidadOrganicaBuscar
        },
        {
            path:'/tramite/administrador/unidades/create',
            name:'AdminUnidadOrganicaNuevo',
            component:AdminUnidadOrganicaNuevo
        },
        {
            path:'/tramite/administrador/unidades/:id/edit',
            name:'AdminUnidadOrganicaEdit',
            component:AdminUnidadOrganicaNuevo
        },
        {
            path:'/tramite/administrador/unidadesSedes',
            name:'AdminUnidadOrganicaBuscar2',
            component:AdminUnidadOrganicaBuscar
        },
        {
            path:'/tramite/administrador/unidadesSedes/:id/edit',
            name:'AdminUnidadOrganicaEdit2',
            component:AdminUnidadOrganicaNuevo
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