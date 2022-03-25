
import VueRouter from 'vue-router'
Vue.use(VueRouter);

//COMPONENTES GENERALES
Vue.component('pagination', require('laravel-vue-pagination'));

//componentes entidadesExternas
var AdminEntidadExternaNuevo = Vue.component('admin-entidad-nuevo', require('../../components/tramite/administracion/AdminEntidadExternaNuevo').default);
var AdminEntidadExternaBuscar = Vue.component('admin-entidad-buscar', require('../../components/tramite/administracion/AdminEntidadExternaBuscar').default);

//routes
const router =new VueRouter({
    mode:'history',
    base:__dirname,
    linkActiveClass: "",
    linkExactActiveClass: "active",
    routes:[
       
        {
            path:'/tramite/administrador/entidades',
            name:'AdminEntidadExternaBuscar',
            component:AdminEntidadExternaBuscar
        },
        {
            path:'/tramite/administrador/entidades/create',
            name:'AdminEntidadExternaNuevo',
            component:AdminEntidadExternaNuevo
        },
        {
            path:'/tramite/administrador/entidades/:id/edit',
            name:'AdminEntidadExternaEdit',
            component:AdminEntidadExternaNuevo
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