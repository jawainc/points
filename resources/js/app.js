
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// imports
import Vuetify from 'vuetify';
import VueRouter from 'vue-router';
import routes from './router';
import '@mdi/font/css/materialdesignicons.css';

// injections
Vue.use(Vuetify);
Vue.use(VueRouter);

const router = new VueRouter({
   routes: routes
});

const app = new Vue({
    el: '#app',
    router
});
