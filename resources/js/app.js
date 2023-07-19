require('./bootstrap');

import Vue from 'vue';
import store from './js/store';
import router from './js/Router';

Vue.component('painel', require('./components/Painel.vue').default);
Vue.component('fila', require('./components/Fila.vue').default);
Vue.component('menu-component', require('./components/Menu.vue').default);

const app = new Vue({
    store,
    router,
    el: '#app',
});
