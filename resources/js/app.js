window.Vue = require('vue');

import Vue from 'vue';
window.axios = require('axios');
import VueRouter from 'vue-router'
import { routes } from '@/js/routes.js'
import store from '@/js/store'


Vue.use(VueRouter);

Vue.component('pagination', require('laravel-vue-pagination'));

const router = new VueRouter({
    mode:'history',
    base:__dirname,
    linkActiveClass: "",
    linkExactActiveClass: "active",
    routes,
});

const app = new Vue({
    el: '#app',
    store,
    router: router
});