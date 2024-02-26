<template>
    <div class="col-12">
        <a class="btn btn-primary" href="window.location.reload();" role="button">Refresh</a>
        <button type="button" v-on:click="sendWhats();" class="btn btn-primary">Enviar</button>
    </div>
</template>

<script>
import axios from 'axios';


export default {

    data() {
        return {
            endpoint : 'enviar_mensagem_assistencia',
            matricula : '25041982',
            primeiroNome : 'Juca da silva',
            mesa : 'Mesa 01',
            professor : 'Joel Santana',
            assistencia : 'Redação',
            celular : '5542999812349',
            emailProfessor : 'joelsantana@positivo.com.br',
            assistencia : 'Redação'
        }

    },

    methods : {

        sendWhats(){
            // ------------------------
                // WHATS
                // ------------------------

                const bodyContent = new FormData();
                bodyContent.append("endpoint", "enviar_mensagem_assistencia");
                bodyContent.append("matricula", this.$data.matricula);
                bodyContent.append("primeiroNome", this.$data.primeiroNome);
                bodyContent.append("mesa", this.$data.mesa);
                bodyContent.append("professor", this.$data.professor);
                bodyContent.append("celular", this.$data.celular);
                bodyContent.append("assistencia", this.$data.assistencia);
                bodyContent.append("emailProfessor",this.$data.emailProfessor);

                axios({
                    method: "POST",
                    url: "https://fqgerenciador.com.br/fila",
                    data: bodyContent,
                })

                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Erro:', error);
                });

                // ------------------------
                // WHATS
                // ------------------------
        }
    }

}
</script>

<style>

</style>
