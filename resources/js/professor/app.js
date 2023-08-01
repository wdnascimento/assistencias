require('../bootstrap');

import Vue from 'vue';
import store from './js/store';
import router from './js/Router';

// Notification
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';
Vue.use(VueToast);

// Sweetalert
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
const options = {
    confirmButtonColor: '#41b882',
    cancelButtonColor: '#ff7674',
};
Vue.use(VueSweetalert2, options);

// Components
Vue.component('professor', require('./components/Index.vue').default);
Vue.component('fila', require('./components/Fila.vue').default);

const app = new Vue({
    store,
    router,
    el: '#app',
    toast : VueToast,
});
