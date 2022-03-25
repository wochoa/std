
import VeeValidate, { Validator } from 'vee-validate'
import es from 'vee-validate/dist/locale/es';
Validator.localize({ es: es });
Vue.use(VeeValidate, {locale: 'es'} );

import VueRouter from 'vue-router'
Vue.use(VueRouter);
window.toastr = require('toastr');
Vue.use(window.toastr);


//COMPONENTES GENERALES
Vue.component('pagination', require('laravel-vue-pagination'));

//componentes usuarios
var AdminUsuarioNuevo = Vue.component('admin-usuario-nuevo', require('../../components/tramite/administracion/AdminUsuarioNuevo').default);
var AdminUsuarioBuscar = Vue.component('admin-usuario-buscar', require('../../components/tramite/administracion/AdminUsuarioBuscar').default);

//conponentes ROLES
var buscarRol = Vue.component('buscar-rol',require('../../components/administrador/buscarRol').default);
var nuevoRol = Vue.component('nuevo-rol',require('../../components/administrador/nuevoRol').default);

//componentes comunicacion interna
var nuevoComunicacionInterna = Vue.component('nuevo-comunicacioninterna', require('../../components/administrador/comunicacion-interna/nuevoComunicacionInterna').default);
var buscarComunicacionInterna = Vue.component('buscar-comunicacioninterna', require('../../components/administrador/comunicacion-interna/buscarComunicacionInterna').default);
//correos
Vue.component('administrador-correo', require('../../components/administrador/AdministradorCorreo').default);
//holidays
Vue.component('administrador-holidays', require('../../components/administrador/AdministradorHolidays').default);

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
        //ruotes Roles
        {
            path:'/administrador/roles',
            name:'buscarRol',
            component:buscarRol
        },
        {
            path:'/administrador/roles/create',
            name:'nuevoRol',
            component:nuevoRol
        },
        {
            path:'/administrador/roles/:id/edit',
            name:'editRol',
            component:nuevoRol
        },
        //ruotes comunicacion interna
        {
            path:'/administrador/publicaciones',
            name:'buscarComunicacionInterna',
            component:buscarComunicacionInterna
        },
        {
            path:'/administrador/publicaciones/create',
            name:'nuevoComunicacionInterna',
            component:nuevoComunicacionInterna
        },
        {
            path:'/administrador/publicaciones/:id/edit',
            name:'editComunicacionInterna',
            component:nuevoComunicacionInterna
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
