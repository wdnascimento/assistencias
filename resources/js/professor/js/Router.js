import Vue from 'vue'
import Router from 'vue-router'
import Index from '../components/Index'

Vue.use(Router)

export default new Router({
    mode : 'hash',
    routes: [
        {
            path :'/',
            component : Index
        },
    ]
});
