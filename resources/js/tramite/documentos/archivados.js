
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

Vue.component('pagination', require('laravel-vue-pagination'));

//componente documento archivado
Vue.component('docu-archivado',require('../../components/tramite/documentos/DocuArchivado').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store
});