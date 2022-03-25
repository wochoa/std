


import VueRouter from 'vue-router'
Vue.use(VueRouter);


//COMPONENTES GENERALES
Vue.component('pagination', require('laravel-vue-pagination'));

//componentes usuarios
var AdminUsuarioNuevo = Vue.component('admin-usuario-nuevo', require('../../components/tramite/administracion/AdminUsuarioNuevo').default);
var AdminUsuarioBuscar = Vue.component('admin-usuario-buscar', require('../../components/tramite/administracion/AdminUsuarioBuscar').default);
Vue.component('admin-cambiar-contrasenia',require('../../components/tramite/administracion/AdminUsuarioCambiarContrasenia').default);

//routes
const router =new VueRouter({
    mode:'history',
    base:__dirname,
    linkActiveClass: "",
    linkExactActiveClass: "active",
    routes:[
        
        {
            path:'/tramite/administrador/usuario',
            name:'AdminUsuarioBuscar',
            component:AdminUsuarioBuscar
        },
        {
            path:'/tramite/administrador/usuario/create',
            name:'AdminUsuarioNuevo',
            component:AdminUsuarioNuevo
        },
        {
            path:'/tramite/administrador/usuario/:id/edit',
            name:'AdminUsuarioEdit',
            component:AdminUsuarioNuevo
        },
        {
            path:'/administrador/usuarios',
            name:'AdminUsuarioBuscar2',
            component:AdminUsuarioBuscar
        },
        {
            path:'/administrador/usuarios/create',
            name:'AdminUsuarioNuevo2',
            component:AdminUsuarioNuevo
        },
        {
            path:'/administrador/usuarios/:id/edit',
            name:'AdminUsuarioEdit2',
            component:AdminUsuarioNuevo
        },
        {
            path:'/administrador/usuarios/rrhh',
            name:'AdminUsuarioBuscar3',
            component:AdminUsuarioBuscar
        },
        {
            path:'/administrador/usuarios/rrhh/create',
            name:'AdminUsuarioNuevo3',
            component:AdminUsuarioNuevo
        },
        {
            path:'/administrador/usuarios/rrhh/:id/edit',
            name:'AdminUsuarioEdit3',
            component:AdminUsuarioNuevo
        },
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