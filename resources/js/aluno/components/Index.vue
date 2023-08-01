<template>
    <div v-if="(Array.isArray(this.$store.getters.getAulas) && this.$store.getters.getAulas.length)" class="row">
        <div v-for="(items, index) in this.$store.getters.getAulas" :key="items.id" class="pt-2 col-12 col-md-6 col-lg-6 col-xl-6" >
            <div  id="icons-main" class="d-flex flex-column align-items-center">
                <div class="p-2 center">
                    <h4 class="w-100 center" >
                        <i class="fa fa-book" aria-hidden="true"></i> {{ items.sala }}
                        <span v-if="emAtendimento(index) == 'bg-success'" class="badge badge-light target-atendimento ml-3">Em Atendimento</span>
                    </h4>
                </div>
                <div id="body" :class="'w-100 m-0 flex-grow-1 ' + ((emAtendimento(index)) ? 'bg-success' : 'bg-danger' )">
                    <h5 class="py-1">Disciplina: {{ items.disciplina }}</h5>
                    <h5  class="py-1">Prof(a).: {{ items.professor }}</h5>
                    <h5 v-if="emAtendimento(index)" class="py-2 bg-light text-dark">Aluno(a): {{ alunoEmAtendimento(index) }}</h5>

                    <fila :aula_id="items.id" :user_id="user_id"></fila>

               </div>

            </div>
        </div>
    </div>
    <div v-else class="col-12 alert alert-danger text-center">
        Nenhuma aula ativa.
    </div>

</template>

<script>

import axios from 'axios'


export default {
    props: [
        'sala_id',
        'root',
        'user_id'
    ],

    data(){
        return {
            aulas : [],
        }
    },
    mounted(){
        this.$store.commit('setRoot',this.root);
        this.carregarAulas();
    },
    computed:  {
        emAtendimento: function () {
            return idx => {
                return  (Array.isArray(this.$store.getters.getAulas[idx].em_atendimento) && this.$store.getters.getAulas[idx].em_atendimento.length)
                    ? true
                    : false;
            }
        },

        alunoEmAtendimento: function () {
            return idx => {
                return  (Array.isArray(this.$store.getters.getAulas[idx].em_atendimento) && this.$store.getters.getAulas[idx].em_atendimento.length)
                    ? this.$store.getters.getAulas[idx].em_atendimento[0].nome
                    : '';
            }
        }

    },
    methods : {
        isUser(user_id){
            return (user_id == this.user_id) ? 'font-weight-bold text-light bg-dark' : '';
        },
        carregarAulas(){
            axios.get(process.env.MIX_APP_URL+'/api/aulasativas',{ assinc : true})
                .then(response => {
                    this.$store.commit('setAulas',response.data) ;
                    this.listenChannel();
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

        verFila(id){
            $('#collapseFila_'+id).collapse('toggle');
        },

        listenChannel(){
            window.Echo.channel('aulas')
                .listen('.getAulasAtivas', (e) => {
                    this.$store.commit('setAulas',e.data) ;
                });
        }

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
</style>
