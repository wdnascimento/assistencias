<template>
    <div v-if="(this.sala_id == 1)" class="card-body table-responsive p-0">

        <table v-if="(this.$store.getters.getSala01 != '' && Array.isArray(this.$store.getters.getSala01))"  class="table table-hover">
            <thead>
            <tr>
                <th class="espera text-center">Próximos</th>
            </tr>
            </thead>
            <tbody>
                <tr class="espera" v-for="(item, index) in this.$store.getters.getSala01" v-if="(item.sala_id == sala_id && item.status == 0)">
                    <td class="text-center">{{ item.cabine }}-{{ item.nome }} </td>
                </tr>
                <tr class="em_espera" v-if="(this.$store.getters.getTotalSala01 > 0)">
                    <td class="text-center">
                        Mais {{this.$store.getters.getTotalSala01}} em espera
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-else class="text-center alert alert-success m-2" role="alert">
            Nenhum aluno em espera.
        </div>
    </div>
    <div v-else class="card-body table-responsive p-0">
        <table v-if="(this.$store.getters.getSala02 != '' && Array.isArray(this.$store.getters.getSala02))"  class="table table-hover">
            <thead>
            <tr>
                <th class="espera text-center">Próximos</th>
            </tr>
            </thead>
            <tbody>
                <tr class="espera" v-for="(item, index) in this.$store.getters.getSala02" v-if="(item.sala_id == sala_id && item.status == 0)">
                    <td class="text-center">{{ item.cabine }}-{{ item.nome }} </td>
                </tr>
                <tr class="em_espera" v-if="(this.$store.getters.getTotalSala02 > 0)">
                    <td class="text-center">
                        Mais {{this.$store.getters.getTotalSala02}} em espera
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-else class="text-center alert alert-success m-2" role="alert">
            Nenhum aluno em espera.
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'sala_id'
    ]
}
</script>

<style>

</style>
