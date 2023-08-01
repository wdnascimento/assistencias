<template>
    <div>
        <div class="d-flex justify-content-center">
            <div class="w-100 py-2 d-flex justify-content-center" >
                <button @click="verFila(aula_id)" :id="'btn_fila_'+aula_id" type="button" class="btn btn-dark">
                    <i class="fa fa-arrow-down" aria-hidden="true"></i> Próximos
                </button>
            </div>
        </div>

        <div :id="'collapseFila_'+aula_id" class="table-resposive collapse">
            <table v-if="(Array.isArray(this.fila) && this.fila.length)"  class="bg-white text-dark table table-striped">
                <thead>
                    <tr>
                    <th scope="col">Senha</th>
                    <th scope="col">Nome</th>
                    </tr>
                </thead>
                <tbody  >
                    <tr v-for="items_atendimento in this.fila.slice(0,5)" :key="items_atendimento.id">
                        <th :class="(items_atendimento.status == 1 ? 'bg-success' : '' )" >
                            {{ items_atendimento.ordem }}
                            <span v-if="(items_atendimento.status == 1)" class="badge badge-light">Em Atendimento</span>
                        </th>
                        <td >{{ items_atendimento.nome }}</td>

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

            <div v-else  class="alert alert-success m-2" role="alert">
                Nenhum aluno em espera no momento. Clique em <strong>PRÓXIMO</strong> para buscar novamente!
            </div>
        </div>

    </div>
</template>

<script>
import { onMounted } from 'vue';
//import { Bootstrap5Pagination } from 'laravel-vue-pagination';

export default {
    props : [
        'aula_id',
    ],
    data(){
        return {
            fila : []
        }
    },
    methods : {

        verFila(id){
            $('#collapseFila_'+id).on('hidden.bs.collapse', function () {
                $('#btn_fila_'+id).html('<i class="fa fa-arrow-down" aria-hidden="true"></i> Próximos');
            });
            $('#collapseFila_'+id).on('show.bs.collapse', function () {
                $('#btn_fila_'+id).html('<i class="fa fa-arrow-up" aria-hidden="true"></i> Próximos');
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
            axios.post(process.env.MIX_APP_URL+'/api/pegarsenha',
                    {
                        aula_id: id,
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

        desistirSenha(id){
            axios.post(process.env.MIX_APP_URL+'/api/desistirsenha',
                    {
                        aula_id: id,
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

    },
    mounted(){
        this.carregarFila();
        this.listenChannel();
    }


}
</script>

<style>

</style>
