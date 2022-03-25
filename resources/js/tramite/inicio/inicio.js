
//import "chart.js"
//import VueCharts from 'vue-chartjs'
//Vue.use(VueCharts)
//import "hchs-vue-charts"
//Vue.use(window.VueCharts)

//componente tramite-inicio

Vue.component('tramite-inicio',require('../../components/tramite/TramInicio').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const inicio = new Vue({
    el: '#inicio',
    store
});
