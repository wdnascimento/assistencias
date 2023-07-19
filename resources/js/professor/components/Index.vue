<template>
        <div class="" v-if="(Array.isArray(this.$store.getters.getAulas) && this.$store.getters.getAulas.length)">
            <div v-for="(items, index) in this.$store.getters.getAulas" :key="items.id"  class="col-12" >
                <div v-if="items.id == aula_id">

                    <h1> {{ items.sala }}</h1>

                    <div  v-if="emAtendimento(index)" class="col-12 p-3">
                        <div v-for="items_fila in items.em_atendimento.slice(0,1)" :key="items_fila.id" class="d-flex p-2 flex-column bg-success rounded align-items-center">
                            <h3 class="text-center py-2 w-100 ">Em Atendimento</h3>
                            <div class="header border-bottom border-light w-100">
                                <h3 class="text-center w-100"><strong>Prof.(a): {{ items.professor }}</strong></h3>
                            </div>
                            <div v-if="(items.cabine != '')" class="numero">
                                <p class="p-0">Cabine: </p>
                                <h1 class="text-center">{{ items.cabine }} </h1>
                            </div>
                            <div class="nome">
                                <h3 class="text-center">{{ items_fila.nome }}</h3>
                            </div>
                        </div>
                    </div>
                    <div v-else class=" col-12 p-3">
                        <div class="bg-danger flex-column rounded align-items-center">
                            <div class="header border-bottom border-light w-100">
                                <h3 class="text-center py-2 ">Atendimento Pausado</h3>
                            </div>
                            <div class="numero w-100">
                                <h3 class="text-center w-100 py-2"><strong>Prof.(a): {{ items.professor }}</strong></h3>
                            </div>
                        </div>

                    </div>


                    <div class="col-12 m-0 p-3">
                        <div class="row">
                            <div class="col-6 justify-content-center">
                                <button class="w-100 h-100 p-3 btn btn-primary btn-xs" @click="pausar()" ><h5>Pausar Atendimento</h5></button>
                            </div>
                            <div class="col-6 justify-content-center">
                                <button class="w-100 h-100 p-3 btn btn-success btn-xs" @click="chamar()" ><h5>Chamar Próximo</h5></button>
                            </div>
                            <div class="col-12 justify-content-center pt-2">
                                    <button class="w-100 p-3 btn btn-danger btn-xs" @click="finalizar()" ><h5>Finalizar Atendimento</h5></button>
                            </div>
                        </div>
                    </div>

                    <fila :aula_id="aula_id" ></fila>

                </div>
                <!-- IF AULA_ID   -->
            </div>
            <!-- IF FOREACH   -->
        </div>
        <div v-else class="row text-center p-3" >
            <div class="col-12 alert alert-success">
                <h5 class="py-3">Nenhuma Aula ativa no momento</h5>
            </div>

            <div  class="col-12 text-center">
                <a :href="this.base_url+'/professor/aula/create'" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Cadastre Sua Mesa</a>
            </div>
        </div>

</template>

<script>


import axios from 'axios';

export default {
    props: [
        'user_id',
        'root' ,
        'aula_id',
    ],

    data(){
        return {
            aulas : [],
            base_url : process.env.MIX_APP_URL
        }
    },

    computed:  {
        emAtendimento: function () {
            return idx => {
                return  (Array.isArray(this.$store.getters.getAulas[idx].em_atendimento) && this.$store.getters.getAulas[idx].em_atendimento.length)
                    ? true
                    : false;
            }
        },
    },

    methods : {
        isUser(user_id){
            return (user_id == this.user_id) ? 'font-weight-bold text-light bg-dark' : '';
        },
        carregarAulas(){
            axios.get(process.env.MIX_APP_URL+'/api/aulasativas',{ assinc : true})
                .then(response => {
                    this.$store.commit('setAulas',response.data) ;

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

        chamar(){
            axios.post(process.env.MIX_APP_URL+'/api/chamar',
                    {
                        aula_id: this.aula_id,
                    }
                )
            .then(response => {
                if(response.status == 201){
                    this.sendSMS();
                }
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


        pausar(){
            axios.post(process.env.MIX_APP_URL+'/api/pausar',
                    {
                        aula_id: this.aula_id,
                    }
                )
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

        finalizar(){
            axios.post(process.env.MIX_APP_URL+'/api/finalizar',
                    {
                        aula_id: this.aula_id,
                    }
                )
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
            try{
                window.Echo.channel('aulas')
                    .listen('.getAulasAtivas', (e) => {
                        this.$store.commit('setAulas',e.data) ;
                    }
                );
            }catch(error){
                console.log(error);
            }

        },

        sendSMS(){
            axios.post('https://api.zenvia.com/v2/channels/sms/messages',
                    {
                            from: 'pear-opera',
                            to: '5542999812349',
                            contents: [{
                                type: 'text',
                                text: 'Bora!! Chegou sua vez Mesa01 - Professor Wagner',
                            },
                            {
                                type: 'text',
                                text: 'Menhor não demorar',
                            }],
                    }, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept' : 'application/json',
                        'Cache-Control' : 'no-cache',
                        'X-API-TOKEN': process.env.MIX_YOUR_API_TOKEN,
                        'crossDomain': true,
                        'Access-Control-Allow-Origin': '*',
                    },

                })

                .then((response) => {

                    console.log('Response:', response);
                })
                .catch((error) => {
                    console.log('Error:', error);
                });

        }

    },

    mounted(){
        this.$store.commit('setRoot',this.root);
        this.carregarAulas();
        this.listenChannel();
    }
}
</script>

<style>
    .cursor-pointer{
        cursor: pointer;
    }
</style>
