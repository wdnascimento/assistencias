require('../bootstrap');

import Vue from 'vue';
import store from './js/store';
import router from './js/Router';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';

Vue.component('aluno', require('./components/Index.vue').default);
Vue.component('fila', require('./components/Fila.vue').default);

Vue.use(VueToast);

const app = new Vue({
    store,
    router,
    el: '#app',
    toast : VueToast
});
