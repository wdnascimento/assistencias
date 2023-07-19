<template>
    <div class="col-12">

        <button class="buttonload">
            <i :disabled="statusButton" @click="disableButton" class="fa fa-spinner fa-pulse fa-2x fa-fw" aria-hidden="true"></i>Loading
        </button>

        <div v-if="(Array.isArray(this.$store.getters.getAulas) && this.$store.getters.getAulas.length)" class="row">

            <div v-for="items in this.$store.getters.getAulas" :key="items.id" class="pt-2 col-12 col-md-6 col-lg-6 col-xl-6" >
                <div  id="icons-main" class="d-flex flex-column align-items-center">
                    <div class="p-2 center">
                        <h4 class="w-100 center" ><i class="fa fa-book" aria-hidden="true"></i> {{ items.sala }} </h4>
                    </div>
                    <div id="body" class="w-100 m-0 flex-grow-1">
                        <h5 class="py-1">{{ items.disciplina }}</h5>
                        <h5  class="py-1">Prof(a). {{ items.professor }}</h5>
                        <h5  v-if="(items.status_senha != 0)" class="py-2 bg-light">
                            <button v-on:click="pegarSenha(items.id)" type="button" class="btn btn-dark">PEGAR SENHA</button>
                        </h5>
                        <div v-else>
                            <h5 class="py-2 bg-secondary">
                                <button v-on:click="desistirSenha(items.id)" type="button" class="btn btn-dark">DESISTIR DA SENHA</button>

                                <button v-on:click="verFila(items.id)" type="button" class="btn btn-dark">Ver Fila</button>
                            </h5>
                            <div :id="'collapseFila_'+items.id " class="table-resposive collapse">
                                <table  class="bg-white text-dark table table-striped">
                                    <thead>
                                        <tr>
                                        <th scope="col">Senha</th>
                                        <th scope="col">Nome</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="items_atendimento in items.fila" :key="items_atendimento.id">
                                            <th >{{ items_atendimento.ordem }}</th>
                                            <td :class="isUser( items_atendimento.user_id ) ">{{ items_atendimento.nome }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="text-center font-weight-bold">
                                                Total de Senhas: {{ items.total_senhas }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="col-12 alert alert-danger text-center">
            Nenhuma aula ativa.
        </div>
    </div>
</template>

<script>


import axios from 'axios'

export default {

    props: [
        'user_id',
        'aula_id',
        'root'

    ],

    data(){
       return {
            aulas : [],
            statusButton : false
       }
    },
    mounted(){
        this.$store.commit('setRoot',this.root);
        this.carregarAulas();
        this.listenChannel();
    },

    methods : {
        disableButton() {
            this.statusButton = true;
        },
        isUser(user_id){
            return (user_id == this.user_id) ? 'font-weight-bold text-light bg-dark' : '';
        },
        carregarAulas(){
            axios.get('/assistencias/api/aulasativas',{ assinc : true})
                .then(response => {
                    this.$store.commit('setAulas',response.data) ;
                })
                .catch(error => {
                    console.log(error);
                })

        },



        verFila(id){
            $('#collapseFila_'+id).collapse('toggle');
        },

        listenChannel(){
            window.Echo.channel('aulas')
                .listen('.getAulasAtivas', (e) => {
                    this.$store.commit('setAulas',e.data) ;
                }
            );
        }

    }
}
</script>

<style>
    .cursor-pointer{
        cursor: pointer;
    }

    .buttonload {
        background-color: #04AA6D; /* Green background */
        border: none; /* Remove borders */
        color: white; /* White text */
        padding: 12px 16px; /* Some padding */
        font-size: 16px /* Set a font size */
    }
</style>
