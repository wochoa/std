

import VueRouter from 'vue-router'
Vue.use(VueRouter);


//COMPONENTES GENERALES
Vue.component('pagination', require('laravel-vue-pagination'));

//componenttes dependencias
var AdminDependenciaNuevo = Vue.component('admin-dependencia-nuevo', require('../../components/tramite/administracion/AdminDependenciaNuevo').default);
var AdminDependenciaBuscar = Vue.component('admin-dependencia-buscar', require('../../components/tramite/administracion/AdminDependenciaBuscar').default);

//routes
const router =new VueRouter({
    mode:'history',
    base:__dirname,
    linkActiveClass: "",
    linkExactActiveClass: "active",
    routes:[
        
        {
            path:'/tramite/administrador/dependencias',
            name:'AdminDependenciaBuscar',
            component:AdminDependenciaBuscar
        },
        {
            path:'/tramite/administrador/dependencias/create',
            name:'AdminDependenciaNuevo',
            component:AdminDependenciaNuevo
        },
        {
            path:'/tramite/administrador/dependencias/:id/edit',
            name:'AdminDependenciaEdit',
            component:AdminDependenciaNuevo
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