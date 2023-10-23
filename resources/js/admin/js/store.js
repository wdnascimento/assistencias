import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state : {
        atendimentos : {},
        root : '',
    },

    getters: {
        getAtendimentos(state){
            return state.atendimentos;
        },
        getRoot(state){
            return state.root;
        }
    },

    mutations: {
        setAtendimentos(state,payload){
            state.atendimentos = payload;
        },

        setRoot (state, payload) {
          state.root =  payload
        },
    }


})
