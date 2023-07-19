import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state : {
        aula:   [],
        atendimento:    [],
        root : '',
    },

    mutations: {
        setRoot (state, payload) {
          state.root =  payload
        }
      }

})
