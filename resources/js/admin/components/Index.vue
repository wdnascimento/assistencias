<template>
    <div v-if="(Array.isArray(this.$store.getters.getAtendimentos) && this.$store.getters.getAtendimentos.length)" class="row p-3 shadow p-3 mb-5 bg-white rounded">
        <div class="col-12">
            <div v-for="(items,index) in this.$store.getters.getAtendimentos.slice(0,1)" :key="items.id" class="col-12 pt-3 "   >
                <div class="d-flex py-2 rounded shadow piscando" >
                    <div class="col-1 d-flex justify-content-center align-content-center" >
                        <h3 class="d-flex">
                            {{ (index + 1) }}
                        </h3>
                    </div>
                    <div class="col-4" >
                        <h4 class="rounded m-0 p-0 bg-white text-center">Senha:
                            <h2 class="p-0 m-0 font-weight-bold">{{ items.senha }}</h2>
                            {{ items.sala }}
                        </h4>
                    </div>
                    <div class="col-7" >
                        <h2>
                            Aluno:
                            <span v-if="(items.cabine )">Cabine {{ items.cabine }} - </span>
                            <!-- <span v-else>{{ items.numero }}</span> -->
                             {{ items.aluno }}
                        </h2>
                        <h4>
                            Prof. {{ items.professor }} - {{ items.disciplina }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="w-100 py-2" >Histórico</h2>

        <div class="row">
            <div v-for="(items,index) in this.$store.getters.getAtendimentos.slice(1,10)" :key="items.id" class="col-12 pt-2" >
                <div  class="d-flex py-2 bg-#3CB371-light rounded">
                    <div class="col-1 d-flex justify-content-center align-content-center" >
                        <h5 class="d-flex">
                            {{ (index + 2) }}
                        </h5>
                    </div>
                    <div class="col-4" >
                        <h4 class="text-center">
                            Senha: <span class="p-0 px-2 m-0 font-weight-bold">{{ items.senha }}</span> - {{ items.sala }}
                        </h4>
                    </div>
                    <div class="col-7" >
                        <h4>
                            Aluno: <span v-if="(items.cabine )">{{ items.cabine }}</span><span v-else>{{ items.numero }}</span> - {{ items.aluno }} / Prof. {{ items.professor }} - {{ items.disciplina }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div v-else class="col-12 alert alert-danger text-center">
        Aguarde...
    </div>

</template>

<script>

import axios from 'axios'

export default {
    props: [
        'turma_id',
    ],

    methods : {
        carregarPainel(){
            axios.get(process.env.MIX_APP_URL+'/api/painelsala/'+this.turma_id,{ assinc : true})
                .then(response => {
                    this.$store.commit('setAtendimentos',response.data) ;
                })
                .catch(error => {
                    if(error.response.status == 401){
                        window.location.href= process.env.MIX_APP_URL;
                    }else{
                        this.$toast.open({
                            message: error.response.data.message,
                            type: 'error',
                            // all of other options may go here
                        });
                    }
                })

        },

        listenChannel(){
            window.Echo.channel('painelsala.'+this.turma_id)
                .listen('.getPainelSala', (e) => {
                    this.$store.commit('setAtendimentos',e.data) ;
            });
        },

    },
    mounted(){
        this.carregarPainel();
        this.listenChannel();
    }
}
</script>

<style>
    .cursor-pointer{
        cursor: pointer;
    }

    .target-atendimento{
        font-size: 10px;
    }

    .piscando {
        background-color:#bcffbc;
        }
        @-webkit-keyframes glowing {
            0% { background-color: #3CB371; -webkit-box-shadow: 0 0 3px #3CB371; }
            50% { background-color: #bcffbc; -webkit-box-shadow: 0 0 3px #bcffbc; }
            100% { background-color: #3CB371; -webkit-box-shadow: 0 0 3px #3CB371; }
        }

        @-moz-keyframes glowing {
            0% { background-color: #3CB371; -moz-box-shadow: 0 0 3px #3CB371; }
            50% { background-color: #bcffbc; -moz-box-shadow: 0 0 3px #bcffbc; }
            100% { background-color: #3CB371; -moz-box-shadow: 0 0 3px #3CB371; }
        }

        @-o-keyframes glowing {
            0% { background-color: #3CB371; box-shadow: 0 0 3px #3CB371; }
            50% { background-color: #bcffbc; box-shadow: 0 0 3px #bcffbc; }
            100% { background-color: #3CB371; box-shadow: 0 0 3px #3CB371; }
        }

        @keyframes glowing {
            0% { background-color: #3CB371; box-shadow: 0 0 3px #3CB371; }
            50% { background-color: #bcffbc; box-shadow: 0 0 3px #bcffbc; }
            100% { background-color: #3CB371; box-shadow: 0 0 3px #3CB371; }
        }

    .piscando {
        -webkit-animation: glowing 1500ms infinite;
        -moz-animation: glowing 1500ms infinite;
        -o-animation: glowing 1500ms infinite;
        animation: glowing 1500ms infinite;
    }
</style>
