<template>
        <div class="" v-if="(Array.isArray(this.$store.getters.getAulas) && this.$store.getters.getAulas.length)">
            <div v-for="(items, index) in this.$store.getters.getAulas" :key="items.id"  class="col-12" >
                <div v-if="items.sala_id == sala_id">
                    <div class="col-12 d-flex justify-content-between align-items-center border-bottom border-secondary p-2">
                        <h1 class="d-flex"> {{ items.sala }}</h1>
                        <button type="button" class="d-flex btn btn-danger btn-lg py-1" @click="finalizar(items.id)" >
                            <span class="py-1">Finalizar</span>
                        </button>
                    </div>
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
                                <h3 class="text-center py-2 ">Aula Ativa</h3>
                            </div>
                            <div class="numero w-100">
                                <h3 class="text-center w-100 py-2"><strong>Prof.(a): {{ items.professor }}</strong></h3>
                            </div>
                        </div>

                    </div>


                    <div class="col-12 m-0 p-3">
                        <div class="row">
                            <div class="col-6 justify-content-center">
                                <button class="w-100 h-100 p-3 btn btn-primary btn-xs" @click="pausar(items.id)" ><h5>Pausar Atendimento</h5></button>
                            </div>
                            <div class="col-6 justify-content-center">
                                <button :disabled="checkVal" class="w-100 h-100 p-3 btn btn-success btn-xs" @click.prevent="chamar(items.id)" >
                                    <h5 v-if="checkVal"><i class="fas fa-sync fa-spin px-2"></i> <span class="px-2">Aguardando...</span> </h5>
                                    <h5 v-else>Chamar Próximo</h5>
                                </button>
                            </div>
                        </div>
                    </div>
                    <fila :aula_id="items.id" ></fila>
                </div>
                <!-- IF AULA_ID   -->
            </div>
            <!-- IF FOREACH   -->
        </div>
        <div v-else class="row text-center p-3" >
            <div class="col-12 d-flex flex-wrap justify-content-around justify-content-sm-around align-items-center justify-content-md-between justify-content-lg-between justify-content-xl-between  alert alert-success">
                <h5 class="d-flex py-1">Esta mesa está INATIVA no momento</h5>
            </div>
            <div class="col-12">
                <h3>Selecione a disciplina que deseja iniciar atendimento</h3>

                <div class="form-group">
                    <label for="disciplina_id">Disciplina</label>
                        <select  id="disciplina_id" class="form-control" v-model="disciplina_id" name="disciplina_id">
                            <option value="" selected ><strong>--Selecione--</strong></option>
                            <option v-for="(items,index) in JSON.parse(this.disciplinas)" :key="items['id']" :value="index">{{ items }}</option>
                        </select>
                </div>
                <button type="button" class="d-flex btn btn-primary btn-sm py-1" @click="cadastraraula()" >
                    <span class="py-1">Iniciar</span>
                </button>
            </div>
        </div>

</template>
<script>
import axios from 'axios';
export default {
    props: [
        'user_id',
        'sala_id',
        'disciplinas'
    ],

    data(){
        return {
            disciplina_id : "",
            aulas : [],
            base_url : process.env.MIX_APP_URL,
            chamando : false
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

        checkVal: function(){
            return this.chamando;
        }

    },

    methods : {
        isUser(user_id){
            return (user_id == this.user_id) ? 'font-weight-bold text-light bg-dark' : '';
        },
        carregarAulas(){
            axios.get(process.env.MIX_APP_URL+'/api/aulasala/'+this.sala_id,{ assinc : true})
                .then(response => {
                    this.$store.commit('setAulas',response.data);
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

        chamar(aula_id){

            axios.post(process.env.MIX_APP_URL+'/api/chamar',
                    {
                        aula_id: aula_id,
                    }
                )
            .then(response => {

                if(response.status == 201){
                    if((response.data.result == true) && (response.data.aluno != null)){
                        this.chamando = true;
                        setInterval(() => {
                            this.chamando = false;
                        },30000);
                        this.sendSMS(response.data);
                    }
                }
            })
            .catch(error => {
                console.log(error);
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

        cadastraraula(){
            if( this.disciplina_id == "" ){
                this.$swal.fire(
                                'Erro ao Ativar!',
                                'Selecione a Disciplina',
                                'danger')
            }else{
                axios.post(process.env.MIX_APP_URL+'/api/cadastraraula',
                        {
                            sala_id: this.sala_id,
                            professor_id: this.user_id,
                            disciplina_id: this.disciplina_id,
                        }
                    )
                .then(response => {
                    if(response.status == 201){
                        this.$swal.fire(
                                    'OK!',
                                    'Aula Cadastrada',
                                    'success')
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
            }

        },

        pausar(aula_id){
            axios.post(process.env.MIX_APP_URL+'/api/pausar',
                {
                    aula_id: aula_id,
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

        finalizar(aula_id){
            this.$swal.fire(
                {
                    title: 'Deseja finalizar o atendimento?',
                    text: "A fila de alunos será apagada!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, Finalizar'
                }).
                then((result) => {
                    if (result.isConfirmed) {
                        axios.post(process.env.MIX_APP_URL+'/api/finalizar',
                        {
                            aula_id: aula_id,
                        })
                        .then((result) => {
                            this.$swal.fire(
                                'OK!',
                                'Aula Finalizada',
                                'success')
                            window.location.href= process.env.MIX_APP_URL+'/professor';
                        }).
                        catch(error => {
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
                    }
                })

        },

        redirect(url){
            window.location.href = url;
        },

        listenChannel(){
            window.Echo.channel('aulasala.'+this.sala_id)
                .listen('.getAulaSala', (e) => {
                    this.$store.commit('setAulas',e.data) ;
                }
            );
        },

        sendSMS(data){
            if(data.aluno.send_sms == 1 && data.aluno.celular != ''){



                // axios.post('https://api.plataformadesms.com.br/v2/message/single',
                //     {
                //         json: true,
                //         body : sms_data,
                //         headers: {
                //             'Content-Type': 'application/json',
                //             'Accept' : 'application/json',
                //             'Cache-Control' : 'no-cache',
                //             'Key': 'RQ96HSnCByXeddf',
                //             // 'Key': process.env.MIX_YOUR_API_TOKEN,
                //             'crossDomain': true,
                //             'Access-Control-Allow-Origin': '*',
                //         },

                // })
                // .then((response) => {

                //     console.log('Response:', response);
                // })
                // .catch((error) => {
                //     console.log('Error:', error);
                // });


                // -------------------------------------
                // ---              ZENVIA           ---
                // -------------------------------------

                axios.post('https://api.zenvia.com/v2/channels/sms/messages',
                    {
                            from: 'pear-opera',
                            to:    '5542999256361',
                            contents: [{
                                type: 'text',
                                text: 'Bora!! '+data.aluno.name+'. Chegou sua vez '+ data.aula.sala.titulo +' - Professor: ' +data.aula.professor.name +' Disciplina: '+ data.aula.disciplina.titulo,
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

        }
    },

    mounted(){
        this.carregarAulas();
        this.listenChannel();

            const sms_data = {
                    id: '1',
                    phone: '42999812349',
                    message: 'Aqui vai a mensagem'
                }


            const options = {
            method: 'POST',
            url: 'https://api.plataformadesms.com.br/v2/message/single',
            headers: {
                Key: 'RQ96HSnCByXeddf',
                'Content-Type': 'application/json',
            },
            data: sms_data, // Usamos 'data' para passar os dados no Axios
            };

            axios(options)
            .then((response) => {
                console.log(response.data);
            })
            .catch((error) => {
                if (error.response) {
                console.error('Erro de resposta:', error.response.data);
                } else {
                console.error('Erro na requisição:', error.message);
                }
            });


        // axios.patch('https://api.zenvia.com/v2/contacts/ab467242-f929-4d11-8cd6-2050ffa2a27f',
        //     {
        //         "listIds": [
        //             "223150c0-2e44-4b83-bb02-fd03f2a96989",
        //             "e1e19e07-0006-48d4-870e-b407da0fd74e"
        //         ]
        //     }, {
        //         headers: {
        //             'Content-Type': 'application/json',
        //             'Accept' : 'application/json',
        //             'Cache-Control' : 'no-cache',
        //             'X-API-TOKEN': process.env.MIX_YOUR_API_TOKEN,
        //             'crossDomain': true,
        //             'Access-Control-Allow-Origin': '*',
        //             },

        //     })
        // .then((response) => {

        //     console.log('Response:', response);
        // })
        // .catch((error) => {
        //     console.log('Error:', error);
        // });

        // // axios.post('https://api.zenvia.com/v2/contact-lists',
        // //     //e1e19e07-0006-48d4-870e-b407da0fd74e
        // //     {
        // //         "name": "sms_list"
        // //     }, {
        // //         headers: {
        // //             'Content-Type': 'application/json',
        // //             'Accept' : 'application/json',
        // //             'Cache-Control' : 'no-cache',
        // //             'X-API-TOKEN': process.env.MIX_YOUR_API_TOKEN,
        // //             'crossDomain': true,
        // //             'Access-Control-Allow-Origin': '*',
        // //             },

        // //     })
        // // .then((response) => {

        // //     console.log('Response:', response);
        // // })
        // // .catch((error) => {
        // //     console.log('Error:', error);
        // // });

        // axios.get('https://api.zenvia.com/v2/contacts',{
        //     headers: {
        //         'Content-Type': 'application/json',
        //         'Accept' : 'application/json',
        //         'Cache-Control' : 'no-cache',
        //         'X-API-TOKEN': process.env.MIX_YOUR_API_TOKEN,
        //         'crossDomain': true,
        //         'Access-Control-Allow-Origin': '*',
        //     },

        // })
        // .then((response) => {

        //     console.log('Response: LIST CONTACT', response);
        // })
        // .catch((error) => {
        //     console.log('Error: LIST CONTACT', error);
        // });

        // axios.get('https://api.zenvia.com/v2/contact-lists',{
        //     headers: {
        //         'Content-Type': 'application/json',
        //         'Accept' : 'application/json',
        //         'Cache-Control' : 'no-cache',
        //         'X-API-TOKEN': process.env.MIX_YOUR_API_TOKEN,
        //         'crossDomain': true,
        //         'Access-Control-Allow-Origin': '*',
        //     },

        // })
        // .then((response) => {

        //     console.log('Response: LIST CONTACT', response);
        // })
        // .catch((error) => {
        //     console.log('Error: LIST CONTACT', error);
        // });

        // axios.post('https://api.zenvia.com/v2/channels/sms/messages',
        //             {
        //                     from: 'pear-opera',
        //                     to:    '5542984249840',
        //                     contents: [{
        //                         type: 'text',
        //                         text: 'Bora!!  Chegou sua vez - Professor:  Disciplina: ',
        //                     },
        //                     {
        //                         type: 'text',
        //                         text: 'Menhor não demorar',
        //                     }],
        //             }, {
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'Accept' : 'application/json',
        //                 'Cache-Control' : 'no-cache',
        //                 'X-API-TOKEN': process.env.MIX_YOUR_API_TOKEN,
        //                 'crossDomain': true,
        //                 'Access-Control-Allow-Origin': '*',
        //             },

        //         })
        //         .then((response) => {

        //             console.log('Response:', response);
        //         })
        //         .catch((error) => {
        //             console.log('Error:', error);
        //         });

    }
}
</script>

<style>
    .cursor-pointer{
        cursor: pointer;
    }
</style>
