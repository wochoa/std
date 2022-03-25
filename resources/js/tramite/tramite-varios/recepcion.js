
//COMPONENTES GENERALES

//componente recepcion doc
Vue.component('docu-expediente', require('../../components/tramite/documentos/en-poceso/DocuExpedienteBuscar').default);

Vue.component('recepcion-documento', require('../../components/tramite/operacion/OperRecepcionDocumento').default);

Vue.component('oper-liberar-doccas',require('../../components/tramite/operacion/OperLiberarDocCas').default);

Vue.component('docu-bloqueo',require('../../components/tramite/documentos/en-poceso/DocuBloqueo').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store
});