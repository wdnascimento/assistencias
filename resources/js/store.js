import Vue from 'vue';
import Vuex from 'vuex';

// VUEX

Vue.use(Vuex)

export default new Vuex.Store({
    namespaced: true,
    state:{
        painel_1:'',
        painel_2:'',
        sala_1:'',
        sala_2:'',
        sala_1_total: 0,
        sala_2_total: 0,

    },

    getters: {
        getSala01(state){
            return state.sala_1;
        },
        getSala02(state){
            return state.sala_2;
        },
        getPainel01(state){
            return state.painel_1;
        },
        getPainel02(state){
            return state.painel_2;
        },
        getTotalSala01(state){
            return state.sala_1_total;
        },

        getTotalSala02(state){
            return state.sala_2_total;
        },
    },
    mutations:{
        setSala01(state,payload){
            state.sala_1 = payload;
            if(Array.isArray(payload)){
                var tmp_payload = payload;
                state.painel_1 = tmp_payload[0];
            }
        },

        resetSala01(state){
            state.sala_1 = '';
        },

        setTotalSala01(state, payload){
            state.sala_1_total = payload;
        },

        setSala02(state,payload){
            state.sala_2 = payload;
            if(Array.isArray(payload)){
                var tmp_payload = payload;
                state.painel_2 = tmp_payload[0];
            }

        },

        resetSala02(state){
            state.sala_2 = '';
        },

        setTotalSala02(state, payload){
            state.sala_2_total = payload;
        }

    }
});


