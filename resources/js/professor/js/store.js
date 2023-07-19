import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state : {
        aula:   {},
        atendimento:    [],
        root : '',
    },

    getters: {
        getAulas(state){
            return state.aula;
        },
        getRoot(state){
            return state.root;
        }
    },

    mutations: {
        setRoot (state, payload) {
          state.root =  payload
        },

        setAulas(state,payload){
            state.aula = payload;
        },

    }


})
