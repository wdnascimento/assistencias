<template>
    <div v-if="(Array.isArray(this.$store.getters.getAulas) && this.$store.getters.getAulas.length)" class="row">
        <div v-for="(items, index) in this.$store.getters.getAulas" :key="items.id" class="pt-2 col-12 col-md-6 col-lg-6 col-xl-6" >
            <div  id="icons-main" class="d-flex flex-column align-items-center">
                <div class="w-100 py-2 px-5 h4 d-flex justify-content-between">
                        <p class="mb-0 align-self-start"><i class="fa-solid fa-book" aria-hidden="true"></i> {{ items.sala }}</p>
                        <p v-if="emAtendimento(index)" class="mb-0 align-self-start">Alunos em Fila: {{ items.size_fila }}</p>
                        <p v-else class="mb-0 align-self-start">Sem Fila</p>
                </div>
                <div id="body" :class="'w-100 m-0 flex-grow-1 ' + ((emAtendimento(index)) ? ((userIdEmAtendimento(index) == user_id) ? 'bg-green' : 'bg-yellow' ): 'bg-danger' ) ">
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
        'turma_id',
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
        },

        userIdEmAtendimento: function () {
            return idx => {
                return  (Array.isArray(this.$store.getters.getAulas[idx].em_atendimento) && this.$store.getters.getAulas[idx].em_atendimento.length)
                    ? this.$store.getters.getAulas[idx].em_atendimento[0].user_id
                    : '';
            }
        }

    },
    methods : {
        isUser(user_id){
            return (user_id == this.user_id) ? 'font-weight-bold text-light bg-dark' : '';
        },
        carregarAulas(){
            axios.get(process.env.MIX_APP_URL+'/api/aulasativas/'+this.turma_id,{ assinc : true})
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
            window.Echo.channel('aulas.'+this.turma_id)
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

    .bg-yellow{
        background: #ffd700 !important;
        color:black !important;
    }

    .bg-green{
        background: green !important;
        color:black !important;
    }
</style>
