import Vue from "vue"
Vue.component('editor', require('@/js/components/tramite/documentos/Editor').default)

const app = new Vue({
    el: '#app'
});
