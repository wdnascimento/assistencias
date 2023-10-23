<template>
    <div class="">
        <h5  v-if="(userSenha(this.fila) == true)" class="py-2 bg-light">
            <button @click="pegarSenha(aula_id)" id="btn_pegar_senha" type="button" class="btn btn-dark">PEGAR SENHA</button>
        </h5>
        <div v-else>
            <h5 class="py-2 bg-secondary">
                <span class="mx-2">
                    Posição: <b>{{ this.senhaAluno }}º</b>
                </span>
                <button @click="desistirSenha(aula_id)" id="btn_desistir_senha" type="button" class="btn btn-dark">DESISTIR DA SENHA</button>

                <button @click="verFila(aula_id)" :id="'btn_fila_'+aula_id" type="button" title="Próximos" class="btn btn-dark">
                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                </button>
            </h5>
       </div>

        <div :id="'collapseFila_'+aula_id" class="table-resposive collapse">
            <table  class="bg-white text-dark table table-striped">
                <thead>
                    <tr>
                    <th scope="col">Senha</th>
                    <th scope="col">Nome</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(items_atendimento) in this.fila.slice(0,5)" :key="items_atendimento.id">
                        <th :class="(items_atendimento.status == 1 ? 'bg-success' : '' )" >
                            {{ items_atendimento.ordem }}
                            <span v-if="(items_atendimento.status == 1)" class="badge badge-light">Em Atendimento</span>
                        </th>
                        <td :class="isUser( items_atendimento.user_id ) ">{{ items_atendimento.nome }}</td>

                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-center font-weight-bold">
                            Total de Senhas: {{ this.fila.length }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</template>

<script>

export default {
    props : [
        'aula_id',
        'user_id'
    ],
    data(){
        return {
            fila : [],
            senhausuario : null
        }
    },
    computed:  {
        senhaAluno: function () {
            var tmp = null;
            if(Array.isArray(this.fila) && this.fila.length){
                let i = 0;
                this.fila.forEach(element => {
                    i++;
                    if(( element.user_id == this.user_id) && (element.status == '1' || element.status == '0')){
                        tmp = i;
                        return;
                    }

                });
            }
            return tmp;
        },
    },
    methods : {

        userSenha(fila){
            if((Array.isArray(fila) && fila.length)){
                var result = fila.find((element) => {
                    return (( element.user_id == this.user_id) && (element.status == '1' || element.status == '0'));
                });
                if(result){
                    return false;
                }
                    return true;
            }else{
                return true;
            }

        },

        isUser(user_id){
            return (user_id == this.user_id) ? 'font-weight-bold text-light bg-dark' : '';
        },

        verFila(id){
            $('#collapseFila_'+id).on('hidden.bs.collapse', function () {
                $('#btn_fila_'+id).html('<i class="fa fa-arrow-down" aria-hidden="true"></i>');
            });
            $('#collapseFila_'+id).on('show.bs.collapse', function () {
                $('#btn_fila_'+id).html('<i class="fa fa-arrow-up" aria-hidden="true"></i>');
            });

            $('#collapseFila_'+id).collapse('toggle');
        },

        carregarFila(){
            axios.get(process.env.MIX_APP_URL+'/api/filaaula/'+this.aula_id,{ assinc : true})
                .then(response => {
                    this.fila = response.data;
                })
                .catch(error => {
                    console.log(error);
                })

        },
        listenChannel(){
            window.Echo.channel('filaaula.'+this.aula_id)
                .listen('.getFilasAtivas', (e) => {
                    this.fila = e.data;
                });
        },

        pegarSenha(id){
            $("#btn_pegar_senha").attr('disabled','disabled');
            axios.post(process.env.MIX_APP_URL+'/api/pegarsenha',
                    {
                        aula_id: id,
                    }
                )
                .then(response => {
                    if(response.status == 208){
                        this.$toast.open({
                            message: response.data.message,
                            type: 'warning',
                        // all of other options may go here
                        });
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
                // $("#btn_pegar_senha").removeAttr('disabled');
        },

        desistirSenha(id){
            axios.post(process.env.MIX_APP_URL+'/api/desistirsenha',
                    {
                        aula_id: id,
                    }
                )
            .catch(error => {
                if(error.response.status == 401){
                    window.location.href= process.env.MIX_APP_URL;
                }else if(error.response.status == 422){
                        this.$toast.open({
                            message: error.response.data.message,
                            type: 'error',
                        // all of other options may go here
                        });
                }else{
                    this.$toast.open({
                        message: error.response.data.message,
                        type: 'error',
                    // all of other options may go here
                    });
                }
            })

        },

    },
    mounted(){
        this.carregarFila();
        this.listenChannel();
    }


}
</script>

<style>

</style>
