<template>
    <div v-if="(this.sala_id == 1)" class="col-6 m-0 px-3">

            <h1 class="w-100 mesa text-center"><strong>{{titulo}}</strong></h1>
            <div class="col-12 bg-white p-3 justify-content-center">
                <div v-if="(this.$store.getters.getPainel01 != '' && typeof this.$store.getters.getPainel01 === 'object' && this.$store.getters.getPainel01.atendimento_id != null   && this.$store.getters.getPainel01.status == 1)" class="d-flex p-2 flex-column bg-success rounded align-items-center">
                    <div class="header border-bottom border-light w-100">
                        <h2 class="text-center"><strong>{{ this.$store.getters.getPainel01.titulo_disciplina }} - {{ this.$store.getters.getPainel01.professor }}</strong></h2>
                    </div>
                    <div class="numero text-center">
                        <h1>Cabine: <strong>{{ this.$store.getters.getPainel01.cabine }}</strong> </h1>
                    </div>
                    <div class="nome text-center">
                        <h3>{{ this.$store.getters.getPainel01.nome }}</h3>
                    </div>
                </div>

                <div v-else-if="(this.$store.getters.getPainel01 != '' && typeof this.$store.getters.getPainel01 === 'object' && this.$store.getters.getPainel01.aula_id != null )" class="d-flex p-2 flex-column bg-primary rounded align-items-center">
                    <div class="header border-bottom border-light w-100">
                        <h2 class="text-center"><strong>{{ this.$store.getters.getPainel01.titulo_disciplina }} - {{ this.$store.getters.getPainel01.professor }}</strong></h2>
                    </div>
                    <div class="numero text-center">
                        <h1>Mesa</h1>
                    </div>
                    <div class="nome text-center">
                        <h3>Em Atendimento</h3>
                    </div>
                </div>

                <div v-else class="d-flex p-2 flex-column bg-danger rounded align-items-center">
                    <div class="header border-bottom border-light w-100">
                        <h3 class="text-center">Atendimento</h3>
                    </div>
                    <div class="numero text-center">
                        <h1>Mesa</h1>
                    </div>
                    <div class="nome text-center">
                        <h3>Inativa</h3>
                    </div>
                </div>
            </div>
            <fila v-bind:sala_id="sala_id" ></fila>
    </div>
    <div v-else class="col-6 m-0 px-3">
            <h1 class="w-100 mesa text-center"><strong>{{titulo}}</strong></h1>
             <div class="col-12 bg-white p-3 justify-content-center">
                <div v-if="(this.$store.getters.getPainel02 != '' && typeof this.$store.getters.getPainel02 === 'object' && this.$store.getters.getPainel02.atendimento_id != null  && this.$store.getters.getPainel02.status == 1)" class="d-flex p-2 flex-column bg-success rounded align-items-center">
                    <div class="header border-bottom border-light w-100">
                        <h2 class="text-center"><strong>{{ this.$store.getters.getPainel02.titulo_disciplina }} - {{ this.$store.getters.getPainel02.professor }}</strong></h2>
                    </div>
                    <div class="numero text-center">
                        <h1>Cabine: <strong>{{ this.$store.getters.getPainel02.cabine }}</strong> </h1>
                    </div>
                    <div class="nome text-center">
                        <h3>{{ this.$store.getters.getPainel02.nome }}</h3>
                    </div>
                </div>

                <div v-else-if="(this.$store.getters.getPainel02 != '' && typeof this.$store.getters.getPainel02 === 'object' && this.$store.getters.getPainel02.aula_id != null )" class="d-flex p-2 flex-column bg-primary rounded align-items-center">
                    <div class="header border-bottom border-light w-100">
                        <h2 class="text-center"><strong>{{ this.$store.getters.getPainel02.titulo_disciplina }} - {{ this.$store.getters.getPainel02.professor }}</strong></h2>
                    </div>
                    <div class="numero text-center">
                        <h1>Mesa</h1>
                    </div>
                    <div class="nome text-center">
                        <h3>Em Atendimento</h3>
                    </div>
                </div>

                <div v-else class="d-flex p-2 flex-column bg-danger rounded align-items-center">
                    <div class="header border-bottom border-light w-100">
                        <h3 class="text-center">Atendimento</h3>
                    </div>
                    <div class="numero text-center">
                        <h1>Mesa</h1>
                    </div>
                    <div class="nome text-center">
                        <h3>Inativa</h3>
                    </div>
                </div>
            </div>
            <fila v-bind:sala_id="sala_id" ></fila>
    </div>
</template>

<script>

import axios from 'axios'

export default {
    mounted(){
        this.carregaSala();
    },
    props: [
        'sala_id','titulo', 'root'

    ],

    data(){
        return {
            aula: 'Próxima Aula',
            disciplina : 'Aguarde',
            n_aluno : '',
            nome_aluno : '',
            timer: null,
            messages: [],
        }
    },

    // get http://nextone.localhost/api/aula/1

    methods: {

        carregaSala() {

            let root = this.root;
            let sala_id = this.sala_id
            const self = this;
            window.Echo.channel('assistencia')
                .listen('.PegarSenha', (e) => {
                    console.log(e);
                    self.$store.commit('resetSala01');
                    self.$store.commit('setSala01',e.data);
                    var total = (e.total - e.per_page < 0) ? 0 : (e.total - e.per_page);
                    self.$store.commit('setTotalSala01',total);
                }
            );

            // window.Echo.channel('salas')
            //     .listen('.getSalasAtivas', (e) => {
            //         console.log(e);
            //     }
            // );
        },

    }

}
</script>

<style>

</style>
