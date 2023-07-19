import Vue from 'vue'
import Router from 'vue-router'
// import MarcarAtendimento from '../components/MarcarAtendimento'
// import Atendimentos from '../components/Atendimentos'

Vue.use(Router)

export default new Router({
    mode : 'hash',
    routes: [
        {
            path :'/',
        },
        // {
        //     path :'/marcaratendimento',
        //     component : MarcarAtendimento
        // },
        // {
        //     path: '/buscaratendimentos',
        //     component : Atendimentos
        // }



    ]
});
