

window.jsPDF = require('jspdf');
Vue.use(window.jsPDF);
import 'jspdf-autotable';
//window.toastr = require('toastr');
//Vue.use(window.toastr);
window.xlsx = require('xlsx');
Vue.use(window.xlsx);

//COMPONENTES GENERALES
//componente reporte
Vue.component('buscar-reporte', require('../../components/tramite/reporte/reporte').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store
});